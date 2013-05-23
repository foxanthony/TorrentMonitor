<?php

/**
 * Scheduler based tasks
 */
class UpdateCommand extends CConsoleCommand
{
    /**
     * Perform update action. This function will be run
     * every 20 minutes by crontab or another scheduler.
     * @cron 0,20,40 * * * *
     */
    public function actionUpdate()
    {
	$this->updateTopics();
    }

    /**
     * Perform update topics.
     */
    private function updateTopics()
    {
	$topics = Topic::model()->findAll();
	
	foreach ($topics as $topic)
	{
	    try
	    {
		$this->processTopic($topic);
	    }
	    catch (Exception $e)
	    {
		Yii::log('Cannot process topic: ' . $e->getMessage(),'error', 'Topics update');
		Notifier::modelNotify('updateTopicError', $e, Yii::t('mail', 'Error during topic updation'));
	    }
	}

	// perform logout for trackers
	Yii::app()->trackerManager->logoutTopicSupported();
    }

    private function processTopic($topic)
    {
	// get topic tracker
	$tracker = Yii::app()->trackerManager->getTopicTrackerByName($topic->tracker);

	// is it null?
	if (!isset($tracker))
	{
	    // throw Exception
	    throw new Exception('The returned tracker name is null');
	}

	if (!$tracker->isLoggedIn())
	{
	    $tracker->login();
	}

	// get topic last updated time
	$time = $tracker->getTopicLastUpdated($topic->url);

	if (isset($topic->last_updated) && $topic->last_updated >= $time) 
	{
	    // topic is up to date, skipping
	    return;
	}

	// ok, we need to update the topic

	// download torrent file
	$torrent_content = $tracker->downloadTopicTorrent($topic->url);

	// begin transaction to manipulate with torrents objects
	$transaction = $topic->dbConnection->beginTransaction();

	try
	{
	    // get torrent client
	    $torrent_client = Yii::app()->torrentClient;

	    // is it non first update running?
	    if (isset($topic->torrent_id))
	    {
		$torrent = Torrent::model()->findByPk($topic->torrent_id);
	
		// db may be corrupted
		if (!isset($torrent))
		{
		    // throw Exception
		    throw new Exception('Returned null instead of torrent object');
		}

		// remove old torrent from client
		$torrent_client->remove($torrent->hash);
	    }
	    else
	    {
		// just create new Torrent
		$torrent = new Torrent;
	    }
	
	    // get new torrent hash
	    $torrent_hash = $torrent_client->getTorrentHash($torrent_content);

	    // add new torrent into client
	    $torrent_client->add($torrent_content, $torrent_hash);

	    // store new hash in db
	    $torrent->hash = $torrent_client->getTorrentHash($torrent_content);
	    $torrent->save();

	    // may be torrent is new. Anyway, just store torrent id in topic torrent_id
	    $topic->torrent_id = $torrent->id;
	    $topic->last_updated = $time;
	    $topic->save();

	    // commit transaction
	    $transaction->commit();

	    Notifier::modelNotify('updateTopic', $topic, Yii::t('mail','Topic `{topic}` has been updated',array('{topic}' => $topic->title)));
	}
	catch (Exception $e)
	{
	    try
	    {
		// rollback transacation
		$transaction->rollback();
	    }
	    catch (Exception $e1)
	    {
		Notifier::modelNotify('updateTopicError', $e1, Yii::t('mail','Error during topic updation'));
	    }

	    // and rethrow exception
	    throw $e;
	}
    }
}
?>