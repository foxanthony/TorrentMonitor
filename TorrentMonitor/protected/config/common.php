<?php
// Application name
$appName = 'Torrent Monitor';

// autoloading model and component classes
$import = array(
    'application.models.*',
    'application.components.*',
    'application.components.trackers.*',
    'application.components.clients.*',
    'ext.yii-mail.YiiMailMessage'
);

// preloading 'log' component
$preload = array('log');

?>