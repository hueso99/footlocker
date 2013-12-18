/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 60010
Source Host           : localhost:3306
Source Database       : nope

Target Server Type    : MYSQL
Target Server Version : 60010
File Encoding         : 65001

Date: 2010-06-04 19:52:15
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `bots`
-- ----------------------------
DROP TABLE IF EXISTS `bots`;
CREATE TABLE `bots` (
  `ID` bigint(12) NOT NULL AUTO_INCREMENT,
  `HWID` varchar(32) NOT NULL,
  `PCName` varchar(32) NOT NULL DEFAULT 'Unknown',
  `IP` varchar(16) NOT NULL DEFAULT '000.000.000.000',
  `Flag` varchar(2) NOT NULL DEFAULT '00',
  `Country` varchar(32) NOT NULL DEFAULT 'Unknown',
  `System` varchar(64) NOT NULL DEFAULT 'Unknown',
  `Version` varchar(11) NOT NULL,
  `Request` int(11) NOT NULL,
  `taskID` bigint(11) DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bots
-- ----------------------------

-- ----------------------------
-- Table structure for `tasks`
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `taskID` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `elapsed` int(11) NOT NULL,
  `command` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bots` int(11) NOT NULL,
  PRIMARY KEY (`taskID`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tasks
-- ----------------------------

-- ----------------------------
-- Table structure for `tasks_done`
-- ----------------------------
DROP TABLE IF EXISTS `tasks_done`;
CREATE TABLE `tasks_done` (
  `taskID` bigint(11) NOT NULL,
  `vicID` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tasks_done
-- ----------------------------
