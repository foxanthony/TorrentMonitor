<?php

class TransmissionClient extends AbstractClient
{
    private $rpc = null;

    public function init($params)
    {
	$username = $params['username'];
	$password = $params['password'];
	$url = $params['url'];

	$this->rpc = new TransmissionRPC($url,$username,$password);
    }

    public function add($torrent, $id)
    {
	$result = $this->rpc->add_metainfo($torrent);

	if ($result->result != 'success')
	{
	    throw new CException(Yii::t('components_TransmissionClient','Cannot add torrent: {error}',array('{error}'=>$result->result)));
	}
    }

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