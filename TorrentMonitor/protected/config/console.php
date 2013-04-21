<?php
require_once('_common.inc');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>$appName,	
	'preload'=>$preload,
	'import'=>$import,
	'language'=>$language,
	// application components
	'components'=>array(
		'trackerManager'=>$trackerManager,
		'db'=>$db,
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
	'commandMap'=>array(
	    'migrate'=>array(
		'class'=>'system.cli.commands.MigrateCommand',
		'migrationPath'=>'application.migrations',
		'migrationTable'=>'torrent_monitor_migration',
		'connectionID'=>'db',
		'templateFile'=>'application.migrations.template',
	    ),
	    'cron'=>'ext.PHPDocCrontab.PHPDocCrontab'
    ),
);