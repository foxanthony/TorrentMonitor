<?php

/**
 * Scheduler based tasks
 */
class UpdateCommand extends CConsoleCommand
{
    /**
     * Perform update action. This function will be run
     * every 20 minutes by crontab or another scheduler.
     * @cron * * * * *
     */
    public function actionUpdate()
    {
	$this->updateSubjects();
    }

    /**
     * Perform update subjects.
     */
    public function updateSubjects()
    {
	$subjects = Subject::model()->findAll();
	
	foreach ($subjects as $subject)
	{
	    try
	    {
		$this->processSubject($subject);
	    }
	    catch (Exception $e)
	    {
		Yii::log('Cannot process subject: ' . $e->getMessage(),'error','Subjects update');
	    }
	}

	// perform logout for trackers
	Yii::app()->trackerManager->logoutSubjectSupported();
    }

    private function processSubject($subject)
    {
	// get subject tracker
	$tracker = Yii::app()->trackerManager->getSubjectTrackerByName($subject->tracker);

	// is it null?
	if (!isset($tracker))
        {
	    // log error and skip
	    Yii::log('The returned tracker name is null','error','Subjects update');
	    return;
	}

	if (!$tracker->isLoggedIn())
	{
	    $tracker->login();
	}

	// get subject last updated time
	$time = $tracker->getSubjectLastUpdated($subject->url);

	if (isset($subject->last_updated) && $subject->last_updated >= $time) 
	{
	    // subject is not up to date, skipping
	    return;
	}

	// ok, we need to update the subject

	// download torrent file
	$torrent_content = $tracker->downloadSubjectTorrent($subject->url);

	// begin transaction to manipulate with torrents objects
	$transaction = $subject->dbConnection->beginTransaction();

	try
	{
	    // get torrent client
	    $torrent_client = Yii::app()->torrentClient;

	    // is it non first update running?
	    if (isset($subject->torrent_id))
	    {
		$torrent = Torrent::model()->findByPk($subject->torrent_id);
	
		// db may be corrupted
		if (!isset($torrent))
		{
		    // log error and skip
		    Yii::log('Returned null instead of torrent object','error','Subjects update');
		    $transaction->rollback();
		    return;
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

	    // may be torrent is new. Anyway, just store torrent id in subject torrent_id
	    $subject->torrent_id = $torrent->id;
	    $subject->last_updated = $time;
	    $subject->save();

	    // commit transaction
	    $transaction->commit();
	}
	catch (Exception $e)
	{
	    // rollback transacation
	    $transaction->rollback();

	    // and rethrow exception
	    throw $e;
	}
    }
}
?>