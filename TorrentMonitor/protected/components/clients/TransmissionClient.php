<?php

/**
 * Transmission torrent client
 */
class TransmissionClient extends AbstractClient
{
    /**
     * @var TransmissionRPC TransmissionRPC class to interact with Transmission.
     */
    private $rpc = null;

    /**
     * Performs client initialization.
     * @param array $params. Client params.
     * @exception Exception When something goes wrong.
     */
    public function init()
    {
	parent::init();

	$username = $this->params['username'];
	$password = $this->params['password'];
	$url = $this->params['url'];

	$this->rpc = new TransmissionRPC($url,$username,$password);
    }

    /**
     * Add torrent into transmission client.
     * @param string $torrent Torrent file content.
     * @param string $id Not used.
     * @exception Exception When something goes wrong.
     */
    public function add($torrent, $id)
    {
	$result = $this->rpc->add_metainfo($torrent);

	if ($result->result != 'success')
	{
	    throw new CException(Yii::t('components_TransmissionClient','Cannot add torrent: {error}',array('{error}'=>$result->result)));
	}
    }

    /**
     * Remove torrent from transmission client.
     * @param string $torrent_hash Torrent hash to identify the torrent.
     * @exception Exception When something goes wrong.
     */
    public function remove($torrent_hash)
    {
	$result = $this->rpc->remove(array($torrent_hash));

	if ($result->result != 'success')
	{
	    throw new CException(Yii::t('components_TransmissionClient','Cannot remove torrent: {error}',array('{error}'=>$result->result)));
	}
    }
}
?>