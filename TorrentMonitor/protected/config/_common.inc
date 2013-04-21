<?php
// -- User parameters --

// Language
$language= 'ru';

// Trackers
$trackerManager = array(
    'class'=>'TrackerManager',
    'trackers'=>array(
	array('class' => 'RutrackerTracker', 'params' => array('username'=>'','password'=>'')),
    )
);

// MySQL
$db = array(
	'connectionString' => 'mysql:host=localhost;dbname=torrent_monitor',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => 'password',
	'charset' => 'utf8'
);
/*
// Sqlite
$db = array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/torrent_monitor.db',
);
*/

$adminEmail = 'webmaster@example.com';

// -- Internal parameters --

// Application name
$appName = 'Torrent Monitor';
// autoloading model and component classes
$import = array(
	'application.models.*',
	'application.components.*',
);
// preloading 'log' component
$preload = array('log');

?>