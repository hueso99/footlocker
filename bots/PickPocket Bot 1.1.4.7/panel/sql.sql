-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2011 at 01:50 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `alba`
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
  `info` longtext CHARACTER SET swe7 NOT NULL,
  `uid` text CHARACTER SET swe7 NOT NULL,
  `contry` text NOT NULL,
  PRIMARY KEY (`nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

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


