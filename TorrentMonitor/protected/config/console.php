<?php
require_once('config.php');
require_once('common.php');

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
		'torrentClient'=>$torrentClient,
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
		'mail' => array(
		    'class' => 'ext.yii-mail.YiiMail',
		    'transportType' => 'smtp',
		    'transportOptions' => $mail,
		    'viewPath' => 'application.views.mail',
		    'logging' => true,
		    'dryRun' => false
		),
	),
	'commandMap'=>array(
	    'migrate'=>array(
		'class'=>'system.cli.commands.MigrateCommand',
		'migrationPath'=>'application.migrations',
		'migrationTable'=>'torrent_monitor_migration',
		'connectionID'=>'db',
	    ),
	    'cron'=>'ext.PHPDocCrontab.PHPDocCrontab'
	),
	'params'=>array(
	    'notifyEmail'=>$notifyEmail,
	    'senderEmail'=>$senderEmail
	)
);