<?php

class m130413_133118_initial extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable(
		'torrent_monitor_torrent',
		array(
		    'id' => 'pk',
		    'hash' =>  'string NOT NULL'
		));

	    $this->createIndex('un_torrent_hash','torrent_monitor_torrent','hash',true);

	    $this->createTable(
		'torrent_monitor_topic',
		array(
		    'id' => 'pk',
		    'url' =>  'string NOT NULL',
		    'title' => 'string NOT NULL',
		    'last_updated' => 'timestamp NULL',
		    'tracker' => 'string NOT NULL',
		    'torrent_id' => 'integer NULL',
		    'CONSTRAINT fk_torrent_monitor_topic_torrent_id FOREIGN KEY (torrent_id) REFERENCES torrent_monitor_torrent (id) ON UPDATE CASCADE ON DELETE CASCADE'
		));

	    $this->createIndex('un_topic_torrent_url','torrent_monitor_topic','url',true);
	    $this->createIndex('un_topic_torrent_id','torrent_monitor_topic','torrent_id',true);
	}

	public function safeDown()
	{
		$this->dropTable('torrent_monitor_topic');
		$this->dropTable('torrent_monitor_torrent');
	}
}