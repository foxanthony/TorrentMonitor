<?php

/**
 * Abstract torrent client
 */
abstract class AbstractClient extends CApplicationComponent
{
    /**
     * Performs client initialization. Do really init there: open connection, send login request, etc.
     * @params array $params Client params.
     */
    abstract public function init($params);

    /**
     * Add torrent into torrent client.
     * @param string $torrent Torrent file content.
     * @param string $id Torrent id. Maybe hash, maybe file name. Doesn't matter.
     */
    abstract public function add($torrent, $id);

    /**
     * Remove torrent from torrent client.
     * @param string $torrent_hash Torrent hash to identify the torrent.
     */
    abstract public function remove($torrent_hash);
}

?>