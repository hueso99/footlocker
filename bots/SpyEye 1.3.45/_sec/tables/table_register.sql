CREATE TABLE IF NOT EXISTS `rep1` ( 
  `id` bigint(20) unsigned NOT NULL auto_increment, 
  `ip` varchar(20) NOT NULL, 
  `bot_guid` varchar(40) NOT NULL, 
  `bot_version` int(10) unsigned NOT NULL, 
  `local_time` datetime NOT NULL, 
  `timezone` varchar(80) character set ucs2 collate ucs2_bin NOT NULL, 
  `tick_time` int(10) unsigned default NULL, 
  `os_version` varchar(20) NOT NULL, 
  `language_id` int(10) unsigned NOT NULL, 
  `date_rep` datetime NOT NULL, 
  PRIMARY KEY  (`id`), 
  UNIQUE KEY `ip` (`ip`,`bot_guid`,`bot_version`,`timezone`,`os_version`,`language_id`) 
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 ;
