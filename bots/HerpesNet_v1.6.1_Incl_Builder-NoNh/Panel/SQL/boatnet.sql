SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `cc` varchar(3) NOT NULL,
  `time` int(255) NOT NULL,
  `userandpc` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL,
  `os` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `hwid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

CREATE TABLE IF NOT EXISTS `commands` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `botid` int(255) NOT NULL,
  `cmd` varchar(255) NOT NULL,
  `variable` varchar(255) NOT NULL,
  `viewed` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

