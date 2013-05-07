# TorrentMonitor
The application watches changes on the popular torrent trackers and automatically updates downloads (series, reuploaded torrent files, etc) on your favorite client.

###Supported trackers:

* Watches topics on rutracker.org

###Supported torrent clients:
* Transmission

###Prerequisites:

* Web-server (Apache, nginx, lighttpd)
* PHP (5.2 or above) with cURL and PDO
* MySQL, PostgreSQL, SQLite
* Yii framework 1.1.13 (optional, can be cloned with TorrentMonitor)

###Installing:

You may choose the standalone Yii installation or embedded.

# Using standalone Yii instalation

Clone TorrentMonitor into temporary folder (for example: /tmp/TorrentMonitor)

```
# git clone https://github.com/foxanthony/TorrentMonitor.git /tmp/TorrentMonitor

```

Go to the /tmp/TorrentMonitor/TorrentMonitor.

```
# cd /tmp/TorrentMonitor/TorrentMonitor
```

Open index.php file with your favorite text editor and set valid path where Yii was installed.
Save the file.

Copy all files into your server www folder.

```
# cp * /path/to/www -R
```

Remove all /tmp/TorrentMonitor files. Be careful! Double check the command you are going to run.

```
# rm -rf /tmp/TorrentMonitor
```

# Using embedded Yii installation

Clone TorrentMonitor into temporary folder (for example: /tmp/TorrentMonitor).

```
# git clone --recursive https://github.com/foxanthony/TorrentMonitor.git /tmp/TorrentMonitor
```

Go to the /tmp/TorrentMonitor/TorrentMonitor.

```
# cd /tmp/TorrentMonitor/TorrentMonitor
```

Copy all TorrentMonitor files into /path/to/www.

```
# cp * /path/to/www -R
```

Go to the /tmp/TorrentMonitor/yii.

```
# cd ../yii
```

Copy Yii files into /path/to/yii.

```
# cp * /path/to/yii -R
```

Make sure that yii and www folders are in the same directory.

Remove all /tmp/TorrentMonitor files. Be careful! Double check the command you are going to run.

```
# rm -rf /tmp/TorrentMonitor
```

###Configuration:

Go to the TorrentMonitor folder (where index.php is located).

```
# cd /path/to/www
```

Copy config.php.example file into config.php.

```
# cp protected/config/config.php.example protected/config/config.php
```

Open config.php with you favorite text editor. Fill language, torrent trackers credentials, client parameters.
Choose database type and its connection options. If you don't want to use some trackers you should comment them.
Set up your config and save.

###Database initialization

Just run the following command:

```
/path/to/protected/yiic migrate up
```

###Configurate cron

Add into cron the following string:

```
* * * * *	/path/to/www/protected/yiic cron run
```

###PHP settings:

You need to change the following parameters in php.ini (in CLI as well as in www-server):

```
; Increase maximum execution time of each script, in seconds
max_execution_time = 300

; Define the default timezone
date.timezone = Europe/Moscow

; Allow the treatment of URLs (like http:// or ftp://) as files
allow_url_fopen = on
```

Install PHP modules using your packet manager: CURL, MySQL client, PDO-MySQL, Sqlite client, PDO-Sqlite, PostgreSQL client, PDO-PostgreSQL.
You need to install just one database client which you really want to use with TorrentMonitor.

###Updating:

Backup your config.php. Remove all files related to TorrentMonitor (you can keep Yii framework files if you want).
Reinstall TorrentMonitor (skip database migration and config.php changing). Restore config.php.
Consult config.php.example for new features and alter changes into the old config.php file.
After that just run database migration invoking the following command:

```
/path/to/protected/yiic migrate up
```