-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 23, 2011 at 05:12 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `PickPocket-BoTneTa`
--

-- --------------------------------------------------------

--
-- Table structure for table `bot`
--

CREATE TABLE IF NOT EXISTS `bot` (
  `nr` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `os` text NOT NULL,
  `ip` text NOT NULL,
  `info` text CHARACTER SET swe7 NOT NULL,
  `uid` text CHARACTER SET swe7 NOT NULL,
  `date` datetime NOT NULL,
  `contry` text NOT NULL,
  PRIMARY KEY (`nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bot`
--


-- --------------------------------------------------------

--
-- Table structure for table `bot_online`
--

CREATE TABLE IF NOT EXISTS `bot_online` (
  `session` char(100) NOT NULL,
  `time` int(11) NOT NULL,
  `contry` text NOT NULL,
  `ip` text NOT NULL,
  `uid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bot_online`
--


-- --------------------------------------------------------

--
-- Table structure for table `ftp`
--

CREATE TABLE IF NOT EXISTS `ftp` (
  `ip` text NOT NULL,
  `uid` text NOT NULL,
  `contry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ftp`
--


-- --------------------------------------------------------

--
-- Table structure for table `graber`
--

CREATE TABLE IF NOT EXISTS `graber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text NOT NULL,
  `contry` text NOT NULL,
  `url` text NOT NULL,
  `site` text NOT NULL,
  `data` text NOT NULL,
  `time` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `graber`
--


-- --------------------------------------------------------

--
-- Table structure for table `rdp`
--

CREATE TABLE IF NOT EXISTS `rdp` (
  `uid` text NOT NULL,
  `to` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rdp`
--


-- --------------------------------------------------------

--
-- Table structure for table `socks5`
--

CREATE TABLE IF NOT EXISTS `socks5` (
  `ip` text NOT NULL,
  `port` text NOT NULL,
  `contry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `socks5`
--

-- 
-- Table structure for table `tblcountry`
-- 

CREATE TABLE `tblcountry` (
  `id` int(5) NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

-- 
-- Dumping data for table `tblcountry`
-- 

INSERT INTO `tblcountry` (`id`, `name`) VALUES 
(1, 'Albania'),
(2, 'Algeria'),
(3, 'Angola'),
(4, 'Anguilla'),
(5, 'Antigua'),
(6, 'Argentina'),
(7, 'Armenia'),
(8, 'Aruba'),
(9, 'Australia'),
(10, 'Austria'),
(11, 'Azerbaijan'),
(12, 'Bahamas'),
(13, 'Bahrain'),
(14, 'Barbados'),
(15, 'Belarus'),
(16, 'Belgium'),
(17, 'Belize'),
(18, 'Benin'),
(19, 'Bermuda'),
(20, 'Bolivia'),
(21, 'Bonaire'),
(22, 'Bosnia'),
(23, 'Botswana'),
(24, 'Brazil'),
(25, 'British Virgin Islands'),
(26, 'Bulgaria'),
(27, 'Burkina Faso'),
(28, 'Burundi'),
(29, 'Cameroon'),
(30, 'Canada'),
(31, 'Cape Verde'),
(32, 'Cayman Islands'),
(33, 'Chad'),
(34, 'Chile'),
(35, 'China'),
(36, 'Colombia'),
(37, 'Congo'),
(38, 'Costa Rica'),
(39, 'Croatia'),
(40, 'Curacao'),
(41, 'Cyprus'),
(42, 'Czech Republic'),
(43, 'Denmark'),
(44, 'Djibouti'),
(45, 'Dominica'),
(46, 'Dominican Republic'),
(47, 'Ecuador'),
(48, 'Egypt'),
(49, 'El Salvador'),
(50, 'Estonia'),
(51, 'Ethiopia'),
(52, 'Finland'),
(53, 'France'),
(54, 'French Guiana'),
(55, 'Gabon'),
(56, 'Gambia'),
(57, 'Georgia'),
(58, 'Germany'),
(59, 'Ghana'),
(60, 'Gibraltar'),
(61, 'Greece'),
(62, 'Grenada'),
(63, 'Guadeloupe'),
(64, 'Guatemala'),
(65, 'Guinea'),
(66, 'Guyana'),
(67, 'Haiti'),
(68, 'Honduras'),
(69, 'Hong Kong'),
(70, 'Hungary'),
(71, 'India'),
(72, 'Indonesia'),
(73, 'Ireland (Republic of)'),
(74, 'Israel'),
(75, 'Italy'),
(76, 'Ivory Coast'),
(77, 'Jamaica'),
(78, 'Japan'),
(79, 'Jordan'),
(80, 'Kazakhstan'),
(81, 'Kenya'),
(82, 'Kuwait'),
(83, 'Latvia'),
(84, 'Lebanon'),
(85, 'Lesotho'),
(86, 'Lithuania'),
(87, 'Macedonia'),
(88, 'Madagascar'),
(89, 'Malawi'),
(90, 'Malaysia'),
(91, 'Mali'),
(92, 'Malta'),
(93, 'Martinique'),
(94, 'Mauritania'),
(95, 'Mauritius'),
(96, 'Mexico'),
(97, 'Moldova'),
(98, 'Montserrat'),
(99, 'Morocco'),
(100, 'Mozambique'),
(101, 'Netherlands'),
(102, 'New Zealand'),
(103, 'Nicaragua'),
(104, 'Niger'),
(105, 'Nigeria'),
(106, 'Norway'),
(107, 'Oman'),
(108, 'Panama'),
(109, 'Paraguay'),
(110, 'Peru'),
(111, 'Philippines'),
(112, 'Poland'),
(113, 'Portugal'),
(114, 'Puerto Rico'),
(115, 'Qatar'),
(116, 'Reunion'),
(117, 'Romania'),
(118, 'Russia'),
(119, 'Rwanda'),
(120, 'Saudi Arabia'),
(121, 'Senegal'),
(122, 'Seychelles'),
(123, 'Singapore'),
(124, 'Slovakia'),
(125, 'Slovenia'),
(126, 'South Africa'),
(127, 'South Korea'),
(128, 'Spain'),
(129, 'St. Barthelemy'),
(130, 'St. Croix'),
(131, 'St. Eustatius'),
(132, 'St. John'),
(133, 'St. Kitts and Nevis'),
(134, 'St. Lucia'),
(135, 'St. Maarten'),
(136, 'St. Thomas'),
(137, 'St. Vincent and the Grenadines'),
(138, 'Suriname'),
(139, 'Swaziland'),
(140, 'Sweden'),
(141, 'Switzerland'),
(142, 'Syria'),
(143, 'Taiwan'),
(144, 'Tanzania'),
(145, 'Thailand'),
(146, 'Togo'),
(147, 'Tortola'),
(148, 'Trinidad and Tobago'),
(149, 'Tunisia'),
(150, 'Turkey'),
(151, 'Turks and Caicos'),
(153, 'Uganda'),
(154, 'Ukraine'),
(155, 'Union Island'),
(156, 'United Arab Emirates'),
(157, 'United Kingdom'),
(158, 'United States'),
(159, 'Uruguay'),
(152, 'US Virgin Islands'),
(160, 'Uzbekistan'),
(161, 'Venezuela'),
(162, 'Virgin Gorda'),
(163, 'Yemen'),
(164, 'Yugoslavia'),
(165, 'Zambia'),
(166, 'Zimbabwe');


