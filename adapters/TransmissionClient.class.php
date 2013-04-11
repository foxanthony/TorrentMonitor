<?php
require_once 'ClientAdapter.interface.php';
require_once 'TransmissionRPC.class.php';

class TransmissionClient implements ClientAdapter
{
    public function store($torrent, $old_torrent_hash, $id, $tracker, $name, $torrent_id, $timestamp, array $context = array())
    {
    	try 
		{
			$rpc = new TransmissionRPC();
			
			$rpc->url = 'http://192.168.1.108:9091/transmission/rpc';
			
			$result = $rpc.remove(array($old_torrent_hash));
			
			if ($result->result != "success")
			{
				return array(false, $result->result);
			}
			
			$result = $rpc.add_metainfo($torrent);
			
			if ($result->result != "success")
			{
				return array(false, $result->result);
			}	
			
			return array(true, "success");			
		}
		catch (Exception $e)
		{
			return array(false,$e.getMessage());			 
		}
    }
}
?>