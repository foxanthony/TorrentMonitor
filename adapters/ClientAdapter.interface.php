<?php
interface ClientAdapter 
{
    public function store($torrent, $old_torrent_hash, $id, $tracker, $name, $torrent_id, $timestamp, array $context = array());
}
?>