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
		'torrent_monitor_subject',
		array(
		    'id' => 'pk',
		    'url' =>  'string NOT NULL',
		    'title' => 'string NOT NULL',
		    'last_updated' => 'timestamp NULL',
		    'tracker' => 'string NOT NULL',
		    'torrent_id' => 'integer NULL'
		));

	    $this->addForeignKey('fk_torrent_monitor_torrent_id', 'torrent_monitor_subject', 'torrent_id',
		'torrent_monitor_torrent', 'id', 'CASCADE', 'CASCADE');

	    $this->createIndex('un_subject_torrent_url','torrent_monitor_subject','url',true);
	    $this->createIndex('un_subject_torrent_id','torrent_monitor_subject','torrent_id',true);
	}

	public function safeDown()
	{
		$this->dropTable('torrent_monitor_subject');
		$this->dropTable('torrent_monitor_torrent');
	}
}