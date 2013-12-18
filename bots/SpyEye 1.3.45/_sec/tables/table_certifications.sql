CREATE TABLE IF NOT EXISTS `cert` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bot_guid` varchar(40) NOT NULL,
  `name` varchar(200) NOT NULL,
  `data` longblob NOT NULL,
  `crc32` int(10) unsigned NOT NULL,
  `date_rep` datetime NOT NULL,
  `notbefore` date NOT NULL default '1970-00-00',
  `notafter` date NOT NULL default '1970-00-00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `bot_guid` (`bot_guid`,`name`,`notbefore`,`notafter`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;
