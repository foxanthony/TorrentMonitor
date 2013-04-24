<?php

abstract class AbstractClient extends CApplicationComponent
{
    abstract public function init($params);

    abstract public function add($torrent);

    abstract public function remove($torrent_hash);
}

?>