-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2014 at 10:12 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iptestapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ee_iprecord`
--

CREATE TABLE IF NOT EXISTS `ee_iprecord` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `ip_host` varchar(256) DEFAULT NULL,
  `status_is` int(2) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_by` int(12) DEFAULT NULL,
  `updated_by` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `ee_iprecord`
--

INSERT INTO `ee_iprecord` (`id`, `ip_host`, `status_is`, `create_date`, `update_date`, `created_by`, `updated_by`) VALUES
(10, 'google.com', NULL, NULL, NULL, NULL, NULL),
(13, 'hotmail.com', NULL, NULL, NULL, NULL, NULL),
(15, 'yahoo.com', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ee_ipstatus`
--

CREATE TABLE IF NOT EXISTS `ee_ipstatus` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `response_time` int(100) DEFAULT NULL,
  `iprecord_id` int(12) DEFAULT NULL,
  `source` varchar(45) DEFAULT NULL,
  `status_is` int(2) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `created_by` int(12) DEFAULT NULL,
  `updated_by` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
