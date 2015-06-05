-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2015 at 03:36 PM
-- Server version: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pms`
--
CREATE DATABASE IF NOT EXISTS `pms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pms`;

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE IF NOT EXISTS `admission` (
`admission_id` int(11) unsigned NOT NULL,
  `admitted_by` int(11) NOT NULL,
  `discharged_by` int(11) DEFAULT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `entry_date` datetime NOT NULL,
  `exit_date` datetime DEFAULT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admission_id`, `admitted_by`, `discharged_by`, `patient_id`, `treatment_id`, `entry_date`, `exit_date`, `comments`, `created_date`, `modified_date`, `active_fg`) VALUES
(17, 1, NULL, 1, 1, '2015-03-17 11:50:45', NULL, 'Why the comment', '2015-03-17 11:50:45', '2015-03-17 11:50:45', 1),
(18, 1, 1, 2, 2, '2015-04-08 17:56:52', NULL, NULL, '2015-04-08 17:56:52', '2015-05-13 19:02:35', 0),
(19, 1, 1, 14, 203, '2015-05-12 17:16:35', NULL, NULL, '2015-05-12 17:16:35', '2015-05-13 19:00:46', 0),
(20, 1, 1, 39, 202, '2015-05-13 18:08:50', NULL, NULL, '2015-05-13 18:08:50', '2015-05-13 18:59:29', 0),
(21, 1, 1, 4, 99, '2015-05-13 19:04:59', NULL, NULL, '2015-05-13 19:04:59', '2015-05-13 19:06:25', 0),
(22, 1, 2, 13, 199, '2015-05-13 19:06:39', '2015-05-30 14:17:29', NULL, '2015-05-13 19:06:39', '2015-05-13 19:06:39', 1),
(23, 1, 1, 4, 47, '2015-05-15 12:46:38', '2015-05-18 14:06:06', NULL, '2015-05-15 12:46:38', '2015-05-18 11:49:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admission_bed`
--

CREATE TABLE IF NOT EXISTS `admission_bed` (
`admission_bed_id` int(11) NOT NULL,
  `admission_id` int(11) unsigned NOT NULL,
  `bed_id` int(11) unsigned NOT NULL,
  `active_fg` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admission_bed`
--

INSERT INTO `admission_bed` (`admission_bed_id`, `admission_id`, `bed_id`, `active_fg`, `created_date`, `modified_date`) VALUES
(18, 17, 1, 0, '2015-03-17 11:50:45', '2015-03-17 11:50:45'),
(19, 18, 2, 0, '2015-04-08 17:56:52', '2015-04-08 17:56:52'),
(20, 19, 4, 0, '2015-05-12 17:16:35', '2015-05-12 17:16:35'),
(21, 17, 3, 1, '2015-05-12 20:39:26', '2015-05-12 20:39:26'),
(22, 19, 1, 0, '2015-05-12 20:41:34', '2015-05-12 20:41:34'),
(23, 19, 4, 0, '2015-05-13 11:30:50', '2015-05-13 11:30:50'),
(24, 18, 1, 0, '2015-05-13 11:35:04', '2015-05-13 11:35:04'),
(25, 19, 2, 0, '2015-05-13 11:40:47', '2015-05-13 11:40:47'),
(26, 19, 4, 0, '2015-05-13 11:42:41', '2015-05-13 11:42:41'),
(27, 19, 2, 0, '2015-05-13 11:58:48', '2015-05-13 11:58:48'),
(28, 19, 4, 0, '2015-05-13 12:02:08', '2015-05-13 12:02:08'),
(29, 19, 2, 0, '2015-05-13 12:02:18', '2015-05-13 12:02:18'),
(30, 19, 4, 0, '2015-05-13 14:59:33', '2015-05-13 14:59:33'),
(31, 19, 2, 0, '2015-05-13 14:59:45', '2015-05-13 14:59:45'),
(32, 19, 4, 0, '2015-05-13 15:13:21', '2015-05-13 15:13:21'),
(33, 19, 2, 0, '2015-05-13 15:14:41', '2015-05-13 15:14:41'),
(34, 19, 4, 0, '2015-05-13 15:16:08', '2015-05-13 15:16:08'),
(35, 19, 2, 0, '2015-05-13 15:23:40', '2015-05-13 15:23:40'),
(36, 19, 4, 0, '2015-05-13 15:25:09', '2015-05-13 15:25:09'),
(37, 19, 2, 0, '2015-05-13 15:27:47', '2015-05-13 15:27:47'),
(38, 19, 4, 0, '2015-05-13 15:28:37', '2015-05-13 15:28:37'),
(39, 19, 2, 0, '2015-05-13 15:29:41', '2015-05-13 15:29:41'),
(40, 19, 4, 0, '2015-05-13 15:29:45', '2015-05-13 15:29:45'),
(41, 19, 2, 0, '2015-05-13 15:29:49', '2015-05-13 15:29:49'),
(42, 19, 4, 0, '2015-05-13 15:29:53', '2015-05-13 15:29:53'),
(43, 19, 2, 0, '2015-05-13 15:29:58', '2015-05-13 15:29:58'),
(44, 19, 4, 0, '2015-05-13 15:31:48', '2015-05-13 15:31:48'),
(45, 19, 2, 0, '2015-05-13 15:32:49', '2015-05-13 15:32:49'),
(46, 19, 4, 0, '2015-05-13 15:33:35', '2015-05-13 15:33:35'),
(47, 19, 2, 0, '2015-05-13 15:34:32', '2015-05-13 15:34:32'),
(48, 19, 4, 0, '2015-05-13 15:35:29', '2015-05-13 15:35:29'),
(49, 19, 2, 0, '2015-05-13 15:37:27', '2015-05-13 15:37:27'),
(50, 19, 4, 0, '2015-05-13 15:38:01', '2015-05-13 15:38:01'),
(51, 19, 2, 0, '2015-05-13 15:39:15', '2015-05-13 15:39:15'),
(52, 19, 4, 0, '2015-05-13 15:39:54', '2015-05-13 15:39:54'),
(53, 19, 2, 0, '2015-05-13 15:41:10', '2015-05-13 15:41:10'),
(54, 19, 4, 0, '2015-05-13 15:41:20', '2015-05-13 15:41:20'),
(55, 19, 2, 0, '2015-05-13 15:41:26', '2015-05-13 15:41:26'),
(56, 20, 4, 0, '2015-05-13 18:08:50', '2015-05-13 18:08:50'),
(57, 21, 1, 0, '2015-05-13 19:04:59', '2015-05-13 19:04:59'),
(58, 22, 2, 1, '2015-05-13 19:06:39', '2015-05-13 19:06:39'),
(59, 23, 1, 0, '2015-05-15 12:46:38', '2015-05-15 12:46:38');

-- --------------------------------------------------------

--
-- Table structure for table `admission_req`
--

CREATE TABLE IF NOT EXISTS `admission_req` (
`admission_req_id` int(11) unsigned NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission_req`
--

INSERT INTO `admission_req` (`admission_req_id`, `treatment_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, '2015-03-17 00:00:00', '2015-03-18 00:00:00', 0),
(2, 2, '2015-03-13 00:00:00', '2015-03-13 00:00:00', 0),
(3, 196, '2015-04-21 12:39:59', '2015-04-21 12:39:59', 1),
(4, 173, '2015-04-27 19:48:41', '2015-04-27 19:48:41', 1),
(6, 47, '2015-04-29 14:30:47', '2015-04-29 14:30:47', 0),
(7, 199, '2015-04-29 15:16:05', '2015-04-29 15:16:05', 0),
(9, 99, '2015-04-29 18:19:25', '2015-04-29 18:19:25', 0),
(10, 202, '2015-05-05 18:01:32', '2015-05-05 18:01:32', 0),
(12, 203, '2015-05-05 18:19:14', '2015-05-05 18:19:14', 0),
(13, 124, '2015-05-26 12:09:41', '2015-05-26 12:09:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bed`
--

CREATE TABLE IF NOT EXISTS `bed` (
`bed_id` int(11) unsigned NOT NULL,
  `bed_description` text,
  `bed_status` int(11) NOT NULL,
  `ward_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bed`
--

INSERT INTO `bed` (`bed_id`, `bed_description`, `bed_status`, `ward_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'Bed 1', 0, 1, '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1),
(2, 'Bed B', 1, 1, '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1),
(3, 'bed 31', 1, 2, '2015-05-06 15:23:16', '2015-05-06 15:23:16', 1),
(4, 'bed 40', 0, 1, '2015-05-06 15:24:37', '2015-05-06 15:24:37', 0),
(5, 'Bed P', 0, 1, '2015-05-15 12:43:27', '2015-05-15 12:43:27', 0),
(6, 'dfdf', 0, 1, '2015-05-15 15:17:33', '2015-05-15 15:17:33', 0),
(7, 'dsdsd', 0, 4, '2015-05-15 15:23:19', '2015-05-15 15:23:19', 0),
(8, 'xmnxc', 0, 4, '2015-05-15 15:30:53', '2015-05-15 15:30:53', 0),
(9, 'asas', 0, 4, '2015-05-15 15:51:25', '2015-05-15 15:51:25', 0),
(10, '\\z\\z', 0, 4, '2015-05-15 15:52:13', '2015-05-15 15:52:13', 0),
(11, 'asas', 0, 4, '2015-05-18 12:10:27', '2015-05-18 12:10:27', 0),
(12, 'zxzx', 0, 3, '2015-05-18 12:11:08', '2015-05-18 12:11:08', 1),
(13, 'xcxc', 0, 3, '2015-05-18 12:13:30', '2015-05-18 12:13:30', 0),
(14, 'zxzxzxzx', 0, 1, '2015-05-18 12:14:33', '2015-05-18 12:14:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `billables`
--

CREATE TABLE IF NOT EXISTS `billables` (
`billables_id` int(10) unsigned NOT NULL,
  `bill` varchar(255) NOT NULL,
  `amount` float(8,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billables`
--

INSERT INTO `billables` (`billables_id`, `bill`, `amount`, `status`, `created_date`, `modified_date`) VALUES
(1, 'para', 200.00, 1, '2015-05-22 17:22:18', '2015-05-22 16:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `bill_status`
--

CREATE TABLE IF NOT EXISTS `bill_status` (
`bill_status_id` int(11) unsigned NOT NULL,
  `status` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_status`
--

INSERT INTO `bill_status` (`bill_status_id`, `status`) VALUES
(1, 'unbilled'),
(2, 'billed');

-- --------------------------------------------------------

--
-- Table structure for table `blood_test`
--

CREATE TABLE IF NOT EXISTS `blood_test` (
`bloodtest_id` int(11) NOT NULL,
  `haematology_id` int(11) DEFAULT NULL,
  `pcv` float DEFAULT NULL,
  `hb` float DEFAULT NULL,
  `hchc` float DEFAULT NULL,
  `wbc` float DEFAULT NULL,
  `eosinophils` float DEFAULT NULL,
  `platelets` float DEFAULT NULL,
  `rectis` float DEFAULT NULL,
  `rectis_index` float DEFAULT NULL,
  `e_s_r` float DEFAULT NULL,
  `microfilaria` varchar(20) DEFAULT NULL,
  `malaria_parasites` varchar(20) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_test`
--

INSERT INTO `blood_test` (`bloodtest_id`, `haematology_id`, `pcv`, `hb`, `hchc`, `wbc`, `eosinophils`, `platelets`, `rectis`, `rectis_index`, `e_s_r`, `microfilaria`, `malaria_parasites`, `created_date`, `modified_date`, `active_fg`) VALUES
(2, 1, 3.8, 4.5, 2.3, 3.5, 6.8, 0.87, 3.2, 3.2, 7.4, 'plenty', 'super plenty', '2015-04-04 00:18:09', '2015-04-16 12:32:02', 1),
(11, 2, 10, 100, 10, 10, 90, 90, 100, 90, 100, '90', '90', '2015-04-15 11:31:25', '2015-04-16 13:41:39', 1),
(13, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '2015-04-15 19:47:26', '2015-04-16 17:15:26', 1),
(14, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '2015-04-16 11:09:51', '2015-04-16 17:12:56', 1),
(17, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '2015-04-16 12:33:12', '2015-04-20 12:27:58', 1),
(18, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '2015-05-06 13:34:44', '2015-05-06 13:34:44', 1),
(21, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '2015-05-06 13:35:14', '2015-05-06 13:35:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_details`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_details` (
`cpdetails_id` int(11) NOT NULL,
  `cpreq_id` int(11) DEFAULT NULL,
  `cpref_id` int(11) DEFAULT NULL,
  `result` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical_pathology_details`
--

INSERT INTO `chemical_pathology_details` (`cpdetails_id`, `cpreq_id`, `cpref_id`, `result`, `created_date`, `modified_date`, `active_fg`) VALUES
(128, 1, 1, 1, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(129, 1, 2, 30, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(130, 1, 3, 40, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(131, 1, 4, 50, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(132, 1, 5, 60, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(133, 1, 6, 70, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(134, 1, 7, 20, '2015-04-04 01:38:29', '2015-04-16 13:55:07', 1),
(135, 1, 8, 25, '2015-04-04 01:52:53', '2015-04-16 13:55:07', 1),
(136, 1, 9, 4, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(137, 1, 10, 3, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(138, 1, 11, 4, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(139, 1, 12, 5, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(140, 1, 13, 2, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(141, 1, 14, 3, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(142, 1, 21, 34, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(143, 1, 22, 43, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(144, 1, 23, 232, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1),
(145, 1, 24, 67, '2015-04-16 13:54:23', '2015-04-16 13:55:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_ref`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_ref` (
`cpref_id` int(11) NOT NULL,
  `status_name` varchar(50) DEFAULT NULL,
  `status_type` varchar(35) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical_pathology_ref`
--

INSERT INTO `chemical_pathology_ref` (`cpref_id`, `status_name`, `status_type`, `active_fg`) VALUES
(1, 'Na(120-140)', 'ELECTROLYTES', 1),
(2, 'K(3-5)', 'ELECTROLYTES', 1),
(3, 'Cl(95-110)', 'ELECTROLYTES', 1),
(4, 'HCO3(20-30)', 'ELECTROLYTES', 1),
(5, 'Ca(2.25-2.75)', 'ELECTROLYTES', 1),
(6, 'Creatinnie(50-132)', 'ELECTROLYTES', 1),
(7, 'Urea(2.5-5.8)', 'ELECTROLYTES', 1),
(8, 'Uric Acid(0.12-0.36)', 'ELECTROLYTES', 1),
(9, 'Total Chol(2.5-5.17)', 'Fasting Lipids Profile', 1),
(10, 'TG < 2.3', 'Fasting Lipids Profile', 1),
(11, 'HDL > 1.04', 'Fasting Lipids Profile', 1),
(12, 'LDL > 3.9', 'Fasting Lipids Profile', 1),
(13, 'Glucose(Fatsing) 2.8-5.0', 'Fasting Lipids Profile', 1),
(14, 'Glucose(2HPP) 3.0-6.0', 'Fasting Lipids Profile', 1),
(15, 'Bilirubin(Total)', 'LFT', 1),
(16, 'Bilirubin(Conj.)', 'LFT', 1),
(17, 'Alk Phos', 'LFT', 1),
(18, 'Acid Phos', 'LFT', 1),
(19, 'ALT(SGPT)', 'LFT', 1),
(20, 'AST(SGOT)', 'LFT', 1),
(21, 'Total protein', 'PROTEINS', 1),
(22, 'Albumin', 'PROTEINS', 1),
(23, 'Globulin', 'PROTEINS', 1),
(24, 'Others', 'PROTEINS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_request`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_request` (
`cpreq_id` int(11) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `laboratory_ref` varchar(15) DEFAULT NULL,
  `laboratory_comment` text,
  `clinical_diagnosis` text,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `doctor_id` int(11) DEFAULT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  `cp_ref_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical_pathology_request`
--

INSERT INTO `chemical_pathology_request` (`cpreq_id`, `treatment_id`, `encounter_id`, `laboratory_ref`, `laboratory_comment`, `clinical_diagnosis`, `created_date`, `modified_date`, `active_fg`, `doctor_id`, `lab_attendant_id`, `status_id`, `cp_ref_id`) VALUES
(1, 1, 0, 'CP101', 'dont know oo', NULL, '2015-04-04 00:00:00', '2015-04-16 13:55:07', 1, 1, 3, 7, NULL),
(2, 4, 0, 'Cp108', 'need blood test', 'headache', '2015-04-08 16:52:06', '2015-04-16 12:27:55', 1, 3, 3, 5, NULL),
(3, 2, 0, '', '', 'something', '2015-04-08 19:47:31', '2015-04-16 12:28:19', 1, 1, 3, 5, NULL),
(4, 2, 0, NULL, NULL, 'something', '2015-04-10 14:08:21', '2015-04-10 14:08:21', 1, 1, NULL, 5, NULL),
(5, 2, 0, NULL, NULL, 'something', '2015-04-10 14:14:34', '2015-04-10 14:14:34', 1, 1, NULL, 5, NULL),
(6, 2, 0, NULL, NULL, 'something', '2015-04-10 14:14:36', '2015-04-10 14:14:36', 1, 1, NULL, 5, NULL),
(8, 60, 0, NULL, NULL, '', '2015-04-10 15:14:35', '2015-04-10 15:14:35', 1, 1, NULL, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `communication`
--

CREATE TABLE IF NOT EXISTS `communication` (
`msg_id` int(10) unsigned NOT NULL,
  `sender_id` int(10) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `msg_subject` varchar(50) NOT NULL,
  `msg_body` varchar(200) NOT NULL,
  `msg_status` int(10) unsigned NOT NULL,
  `active_fg` tinyint(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `communication`
--

INSERT INTO `communication` (`msg_id`, `sender_id`, `recipient_id`, `msg_subject`, `msg_body`, `msg_status`, `active_fg`, `created_date`, `modified_date`) VALUES
(1, 1, 2, 'Lorem ipsum', 'Bacno ipsum', 0, 1, '2015-02-17 12:12:00', '2015-04-10 20:06:57'),
(10, 1, 2, 'Labore jerky swine sausage', 'Labore jerky swine sausage alcatra leberkas nostrud sint. Consequat po', 0, 1, '2015-02-17 16:20:04', '2015-04-10 20:06:55'),
(11, 2, 1, 'Pastrami doner tenderloin', 'Pastrami doner tenderloin sirloin jerky chuck flank filet mignon shoul', 0, 1, '2015-02-17 16:49:41', '2015-02-23 12:19:40'),
(12, 1, 2, 'Pastrami tenderloin', 'Bacon ipsum dolor amet bresaola spare ribs pig, picanha tail turducken bacon chicken jerky tri-tip leberkas. Spare ribs shank t-bone, venison tenderloin ham hock hamburger leberkas. Kielbasa pork bell', 0, 1, '2015-02-23 11:48:58', '2015-04-10 20:08:28'),
(14, 3, 1, 'tri-tip prosciutto', 'icanha tri-tip prosciutto landjaeger flank porchetta turducken pork. Shank drumstick pork chop picanha swine tenderloin porchetta doner sausage pork ball tip ground round jerky. Andouille prosciutto b', 0, 1, '2015-02-23 13:33:37', '2015-02-23 16:21:40'),
(15, 3, 2, 'turkey jowl salami tongue', 'Salami tongue cupim jowl, turkey venison beef ribs shankle swine frankfurter tenderloin. Drumstick hamburger ham turducken tri-tip alcatra short loin pastrami. Jerky cupim porchetta corned beef, tri-t', 0, 1, '2015-02-23 13:35:32', '2015-04-10 20:08:27'),
(16, 3, 1, 'Cupim alcatra drumstick', 'Shankle cow ball tip jerky tongue rump jowl filet mignon pig tri-tip shank spare ribs chicken. Venison biltong tri-tip, pork loin leberkas hamburger tail t-bone. Bacon frankfurter tenderloin shoulder,', 0, 1, '2015-02-23 13:48:39', '2015-02-23 16:21:38'),
(17, 3, 2, 'pastrami rump chicken', 'andjaeger corned beef turkey, filet mignon tail pork ham hock pork chop short loin leberkas bacon strip steak ribeye pork loin alcatra. Fatback sausage bacon short ribs jerky brisket. Drumstick landja', 0, 1, '2015-02-23 13:52:17', '2015-04-29 13:43:46'),
(18, 3, 2, 'Cupim alcatra drumstick', 'Andouille ham hock biltong, shoulder bacon flank strip steak frankfurter ball tip salami porchetta capicola. Pork andouille strip steak jerky pork loin ball tip. Meatloaf tail jowl, pig ham bresaola p', 0, 1, '2015-02-23 14:12:41', '2015-04-29 13:43:44'),
(19, 3, 1, 'Cupim alcatra drumstick', 'Cupim alcatra drumstick', 0, 1, '2015-02-23 14:18:42', '2015-04-29 17:18:04'),
(20, 3, 1, 'drumstick', 'Cupim alcatra drumstick', 0, 1, '2015-02-23 14:19:32', '2015-04-29 17:18:03'),
(21, 3, 2, 'alcatra', 'Cupim alcatra drumstick\nCupim alcatra drumstick\nCupim alcatra drumstick', 0, 1, '2014-02-23 14:22:11', '2015-04-10 20:06:59'),
(22, 2, 1, 'Fwd: turkey jowl salami tongue', '\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 1:35:32 PM\nSubject: turkey jowl salami tongue\nTo: moses olajuwon adebayo\n\nSalami tongue cupim jowl, turke', 0, 1, '2015-02-24 15:30:40', '2015-04-17 12:19:15'),
(29, 2, 3, 'Fwd: Fwd: turkey jowl salami tongue', 'Bacon ipsum dolor amet bacon tri-tip pancetta shoulder brisket. Ground round brisket chuck, tri-tip filet mignon bacon pork belly jowl rump salami spare ribs pancetta. Prosciutto cow tongue shankle po', 0, 1, '2015-02-24 17:42:38', '2015-05-06 13:32:41'),
(30, 2, 1, 'Fwd: Cupim alcatra drumstick', '\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 2:12:41 PM\nSubject: Cupim alcatra drumstick\nTo: moses olajuwon adebayo\n\nAndouille ham hock biltong, shoul', 0, 1, '2015-02-24 17:43:58', '2015-04-29 17:17:59'),
(31, 2, 1, 'Fwd: alcatra', '\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 2:22:11 PM\nSubject: alcatra\nTo: moses olajuwon adebayo\n\nCupim alcatra drumstick\nCupim alcatra drumstick\nC', 0, 1, '2015-02-24 17:44:14', '2015-04-29 17:17:56'),
(32, 2, 3, 'erdfdf', 'gffbn', 0, 1, '2015-04-10 20:07:50', '2015-05-06 13:32:38'),
(33, 3, 1, 'hi', 'hello', 0, 1, '2015-04-29 17:35:22', '2015-04-29 18:00:38'),
(34, 3, 1, 'Hello', 'How are you?', 0, 1, '2015-04-29 18:00:37', '2015-05-26 15:41:26'),
(35, 1, 2, 'Bomb', 'This system is too slow.', 0, 1, '2015-04-29 18:01:18', '2015-04-29 18:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `constant_bills`
--

CREATE TABLE IF NOT EXISTS `constant_bills` (
`constant_bills_id` int(11) unsigned NOT NULL,
  `item` varchar(150) NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `constant_bills`
--

INSERT INTO `constant_bills` (`constant_bills_id`, `item`, `amount`, `treatment_id`, `created_date`) VALUES
(11, 'panadol', 500.00, 4, '2015-05-20 14:24:15'),
(12, 'paracetamol', 600.00, 4, '2015-05-20 14:24:15'),
(13, 'panadol', 500.00, 4, '2015-05-20 14:24:29'),
(14, 'paracetamol', 600.00, 4, '2015-05-20 14:24:29'),
(15, '1000', 100.00, 4, '2015-05-20 14:26:44'),
(16, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 07:38:57'),
(17, '{{Constant Item 1}}', 20.00, 3, '2015-05-22 07:38:57'),
(18, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 07:56:49'),
(19, '{{Constant Item 1}}', 100.00, 3, '2015-05-22 07:56:49'),
(20, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 07:57:32'),
(21, '{{Constant Item 1}}', 100.00, 3, '2015-05-22 07:57:32'),
(22, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 07:57:32'),
(23, '{{Constant Item 1}}', 100.00, 3, '2015-05-22 07:57:32'),
(24, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 07:57:39'),
(25, '{{Constant Item 1}}', 100.00, 3, '2015-05-22 07:57:39'),
(26, '{{Constant Item 0}}', 10.00, 4, '2015-05-22 07:58:06'),
(27, '{{Constant Item 1}}', 10.00, 4, '2015-05-22 07:58:06'),
(28, '{{Constant Item 0}}', 10.00, 203, '2015-05-22 08:00:26'),
(29, '{{Constant Item 1}}', 10.00, 203, '2015-05-22 08:00:26'),
(30, 'pharmacy', 100.00, 203, '2015-05-22 08:00:26'),
(31, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 08:06:40'),
(32, '{{Constant Item 1}}', 20.00, 3, '2015-05-22 08:06:40'),
(33, '{{Constant Item 0}}', 10.00, 5, '2015-05-22 08:08:19'),
(34, '{{Constant Item 1}}', 10.00, 5, '2015-05-22 08:08:19'),
(37, '{{Constant Item 0}}', 10.00, 3, '2015-05-22 08:18:57'),
(38, '{{Constant Item 1}}', 20.00, 3, '2015-05-22 08:18:57'),
(39, '{{Constant Item 0}}', 10.00, 5, '2015-05-22 08:20:36'),
(40, '{{Constant Item 1}}', 20.00, 5, '2015-05-22 08:20:36'),
(41, 'panadol', 500.00, 35, '2015-05-26 12:48:16'),
(42, 'paracetamol', 600.00, 35, '2015-05-26 12:48:16'),
(43, 'para', 200.00, 3, '2015-05-26 12:55:28'),
(44, 'para', 200.00, 5, '2015-05-26 12:56:25'),
(45, 'para', 200.00, 6, '2015-05-26 12:56:47'),
(46, 'para', 200.00, 8, '2015-05-26 12:58:38'),
(47, 'para', 200.00, 47, '2015-05-26 12:58:44'),
(48, '{{Constant Item 0}}', 18.00, 3, '2015-05-26 13:01:06'),
(49, '{{Constant Item 1}}', 234.00, 3, '2015-05-26 13:01:06'),
(50, '{{Constant Item 0}}', 10.00, 7, '2015-05-26 13:02:49'),
(51, '{{Constant Item 1}}', 10.00, 7, '2015-05-26 13:02:49'),
(52, 'para', 200.00, 5, '2015-05-26 14:21:01'),
(53, 'para', 200.00, 5, '2015-05-26 14:21:40'),
(54, 'para', 200.00, 6, '2015-05-26 14:21:45'),
(55, 'para', 200.00, 5, '2015-05-26 14:26:57'),
(56, 'para', 200.00, 5, '2015-05-26 14:27:23'),
(57, 'para', 200.00, 5, '2015-05-26 14:28:09'),
(58, 'para', 200.00, 5, '2015-05-26 14:28:40'),
(59, 'para', 200.00, 5, '2015-05-26 14:28:42'),
(60, 'para', 200.00, 5, '2015-05-26 14:29:15'),
(61, '1000', 100.00, 4, '2015-05-26 14:29:39'),
(62, 'para', 200.00, 5, '2015-05-26 14:30:30'),
(63, 'panadol', 500.00, 35, '2015-05-26 14:31:37'),
(64, 'paracetamol', 600.00, 35, '2015-05-26 14:31:37'),
(65, 'panadol', 500.00, 35, '2015-05-26 14:38:32'),
(66, 'paracetamol', 600.00, 35, '2015-05-26 14:38:32'),
(67, '{{Constant Item 0}}', 120.00, 6, '2015-05-26 14:40:59'),
(68, '{{Constant Item 1}}', 150.00, 6, '2015-05-26 14:40:59'),
(69, 'para', 200.00, 5, '2015-05-26 15:05:20');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
`department_id` int(11) unsigned NOT NULL,
  `department_name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'doctor'),
(2, 'pharmacy'),
(3, 'mro'),
(4, 'parasitology'),
(7, 'haematology'),
(8, 'parasitology');

-- --------------------------------------------------------

--
-- Table structure for table `differential_count`
--

CREATE TABLE IF NOT EXISTS `differential_count` (
`differential_count_id` int(11) NOT NULL,
  `haematology_id` int(11) DEFAULT NULL,
  `polymorphs_neutrophils` float DEFAULT NULL,
  `lymphocytes` float DEFAULT NULL,
  `monocytes` float DEFAULT NULL,
  `eosinophils` float DEFAULT NULL,
  `basophils` float DEFAULT NULL,
  `widals_test` float DEFAULT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `rhesus_factor` varchar(3) DEFAULT NULL,
  `genotype` varchar(5) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `differential_count`
--

INSERT INTO `differential_count` (`differential_count_id`, `haematology_id`, `polymorphs_neutrophils`, `lymphocytes`, `monocytes`, `eosinophils`, `basophils`, `widals_test`, `blood_group`, `rhesus_factor`, `genotype`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 0, 0, 0, 0, 0, 0, '', '', '', '2015-04-04 00:18:09', '2015-04-16 12:32:02', 1),
(8, 2, 100, 100, 100, 100, 100, 100, '100', '12', '12', '2015-04-15 11:31:25', '2015-04-16 13:41:39', 1),
(10, 4, 0, 0, 0, 0, 0, 0, '', '', '', '2015-04-15 19:47:26', '2015-04-16 17:15:26', 1),
(11, 3, 0, 0, 0, 0, 0, 0, '', '', '', '2015-04-16 11:09:51', '2015-04-16 17:12:56', 1),
(14, 8, 0, 0, 0, 0, 0, 0, '', '', '', '2015-04-16 12:33:12', '2015-04-20 12:27:58', 1),
(15, 10, 0, 0, 0, 0, 0, 0, '', '', '', '2015-05-06 13:34:44', '2015-05-06 13:34:44', 1),
(18, 9, 0, 0, 0, 0, 0, 0, '', '', '', '2015-05-06 13:35:14', '2015-05-06 13:35:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `drug_ref`
--

CREATE TABLE IF NOT EXISTS `drug_ref` (
`drug_ref_id` int(11) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `symbol` char(8) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drug_ref`
--

INSERT INTO `drug_ref` (`drug_ref_id`, `name`, `symbol`, `created_date`, `active_fg`) VALUES
(1, 'paracetamol', NULL, '2015-02-20 00:00:00', 1),
(2, 'panadol', NULL, '2015-02-20 00:00:00', 1),
(3, 'ampiclox', NULL, '2015-02-25 00:00:00', 1),
(4, 'tetracycline', NULL, '2015-02-25 00:00:00', 1),
(5, 'as', NULL, '2015-03-02 15:00:13', 1),
(6, 'df', NULL, '2015-03-02 15:12:13', 1),
(7, 'der', NULL, '2015-03-02 15:26:54', 1),
(8, 'zx', NULL, '2015-03-02 16:24:51', 1),
(9, 'add', NULL, '2015-03-02 16:30:50', 1),
(10, 'dss', NULL, '2015-03-02 16:31:45', 1),
(11, 'ad', NULL, '2015-03-02 16:33:45', 1),
(12, 'ade', NULL, '2015-03-02 16:41:03', 1),
(13, 'cxc', NULL, '2015-03-04 15:07:00', 1),
(14, 'cxzc', NULL, '2015-03-04 15:08:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE IF NOT EXISTS `emergency` (
`emergency_id` int(11) unsigned NOT NULL,
  `patient_id` int(11) NOT NULL,
  `emergency_status_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`emergency_id`, `patient_id`, `emergency_status_id`, `created_date`, `modified_date`) VALUES
(1, 67, 2, '2015-04-08 00:00:00', '2015-04-16 00:00:00'),
(2, 19, 1, '2015-04-20 12:39:02', '2015-04-20 12:39:02'),
(3, 20, 2, '2015-04-20 12:39:47', '2015-04-20 12:39:47'),
(4, 21, 1, '2015-04-20 12:42:31', '2015-04-20 12:42:31'),
(5, 22, 1, '2015-04-20 12:42:58', '2015-04-20 12:42:58'),
(6, 23, 2, '2015-04-20 13:11:12', '2015-04-20 13:11:12'),
(7, 24, 1, '2015-04-20 13:15:38', '2015-04-20 13:15:38'),
(8, 25, 1, '2015-04-20 13:16:21', '2015-04-20 13:16:21'),
(9, 26, 1, '2015-04-20 15:18:23', '2015-04-20 15:18:23'),
(10, 27, 1, '2015-04-20 15:19:05', '2015-04-20 15:19:05'),
(11, 28, 1, '2015-04-20 15:20:23', '2015-04-20 15:20:23'),
(12, 29, 1, '2015-04-20 15:21:37', '2015-04-20 15:21:37'),
(13, 36, 2, '2015-04-27 19:09:35', '2015-04-27 19:09:35'),
(14, 37, 2, '2015-04-27 19:18:17', '2015-04-27 19:18:17'),
(15, 38, 1, '2015-04-29 12:13:14', '2015-04-29 12:13:14'),
(16, 40, 1, '2015-04-29 12:34:48', '2015-04-29 12:34:48'),
(17, 41, 1, '2015-04-29 12:35:40', '2015-04-29 12:35:40'),
(18, 42, 1, '2015-04-29 12:36:05', '2015-04-29 12:36:05'),
(19, 43, 1, '2015-04-29 12:36:49', '2015-04-29 12:36:49'),
(20, 44, 1, '2015-04-29 12:38:37', '2015-04-29 12:38:37'),
(21, 49, 2, '2015-05-06 11:39:58', '2015-05-06 11:39:58'),
(22, 52, 1, '2015-05-13 10:46:02', '2015-05-13 10:46:02'),
(23, 53, 1, '2015-05-13 10:46:13', '2015-05-13 10:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_detail`
--

CREATE TABLE IF NOT EXISTS `emergency_detail` (
`emergency_status_id` int(11) unsigned NOT NULL,
  `emergency_status` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emergency_detail`
--

INSERT INTO `emergency_detail` (`emergency_status_id`, `emergency_status`) VALUES
(1, 'active'),
(2, 'upgraded'),
(3, 'intreatment');

-- --------------------------------------------------------

--
-- Table structure for table `encounter`
--

CREATE TABLE IF NOT EXISTS `encounter` (
`encounter_id` int(11) unsigned NOT NULL,
  `personnel_id` int(11) NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `admission_id` int(11) unsigned NOT NULL,
  `treatment_id` int(11) DEFAULT NULL,
  `diagnosis` text,
  `consultation` varchar(200) DEFAULT NULL,
  `symptoms` varchar(200) DEFAULT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `encounter`
--

INSERT INTO `encounter` (`encounter_id`, `personnel_id`, `patient_id`, `admission_id`, `treatment_id`, `diagnosis`, `consultation`, `symptoms`, `comments`, `created_date`, `modified_date`, `status`, `active_fg`) VALUES
(1, 1, 14, 19, 1, 'Ebola', 'He is not well oo', 'Headache and catarrh', '', '2015-05-13 11:40:12', '2015-06-03 15:37:03', 2, 1),
(2, 1, 14, 19, 1, NULL, '0', '0', 'Good progress upon administering panadol 240', '2015-05-13 11:40:42', '2015-06-03 15:37:03', 1, 1),
(5, 1, 4, 23, 0, NULL, '0', '0', 'xcxc', '2015-05-18 11:31:35', '2015-06-03 15:37:03', 1, 1),
(49, 1, 13, 22, 0, NULL, '0', '0', 'yes', '2015-05-18 11:53:00', '2015-06-03 15:37:03', 1, 1),
(50, 1, 13, 22, 0, NULL, '0', '0', 'dfdfdf', '2015-05-18 11:53:17', '2015-06-03 15:37:03', 1, 1),
(58, 1, 13, 22, 0, NULL, '0', '0', 'yes', '2015-05-18 11:53:45', '2015-06-03 15:37:03', 1, 1),
(60, 1, 13, 22, 0, NULL, '0', '0', 'ddfdf', '2015-05-18 12:15:25', '2015-06-03 15:37:03', 1, 1),
(64, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:22:41', '2015-06-03 15:37:03', 1, 1),
(65, 1, 13, 22, 0, NULL, '0', '0', '11', '2015-05-18 12:24:20', '2015-06-03 15:37:03', 1, 1),
(66, 1, 13, 22, 0, NULL, '0', '0', 'hello', '2015-05-18 12:27:13', '2015-06-03 15:37:03', 1, 1),
(67, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:27:24', '2015-06-03 15:37:03', 1, 1),
(68, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:27:29', '2015-06-03 15:37:03', 1, 1),
(69, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:27:33', '2015-06-03 15:37:03', 1, 1),
(70, 1, 13, 22, 0, NULL, '0', '0', 'dfdf', '2015-05-18 12:44:02', '2015-06-03 15:37:03', 1, 1),
(74, 1, 13, 22, 0, NULL, '0', '0', 'xcxc', '2015-05-18 12:48:53', '2015-06-03 15:37:03', 1, 1),
(75, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:50:08', '2015-06-03 15:37:03', 1, 1),
(76, 1, 13, 22, 0, NULL, '0', '0', '', '2015-05-18 12:50:35', '2015-06-03 15:37:03', 1, 1),
(77, 2, 14, 17, 1, NULL, 'sdfg', 'jhg', 'bb', '2015-05-13 00:00:00', '2015-06-03 15:37:03', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `film_appearance`
--

CREATE TABLE IF NOT EXISTS `film_appearance` (
`film_appearance_id` int(11) NOT NULL,
  `haematology_id` int(11) DEFAULT NULL,
  `aniscocytosis` varchar(35) DEFAULT NULL,
  `poikilocytosis` varchar(35) DEFAULT NULL,
  `polychromasia` varchar(35) DEFAULT NULL,
  `macrocytosis` varchar(35) DEFAULT NULL,
  `microcytosis` varchar(35) DEFAULT NULL,
  `hypochromia` varchar(35) DEFAULT NULL,
  `sickle_cells` varchar(35) DEFAULT NULL,
  `target_cells` varchar(35) DEFAULT NULL,
  `spherocytes` varchar(35) DEFAULT NULL,
  `nucleated_rbc` varchar(35) DEFAULT NULL,
  `sickling_test` varchar(35) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `film_appearance`
--

INSERT INTO `film_appearance` (`film_appearance_id`, `haematology_id`, `aniscocytosis`, `poikilocytosis`, `polychromasia`, `macrocytosis`, `microcytosis`, `hypochromia`, `sickle_cells`, `target_cells`, `spherocytes`, `nucleated_rbc`, `sickling_test`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, '', '', '', '', '', '', '', '', '', '', '', '2015-04-04 00:18:09', '2015-04-16 12:32:02', 1),
(3, 2, '12', '12', '100', '12', '12', '12', '100', '12', '100', '12', '12', '2015-04-15 11:31:25', '2015-04-16 13:41:39', 1),
(5, 4, '', '', '', '', '', '', '', '', '', '', '', '2015-04-15 19:47:26', '2015-04-16 17:15:26', 1),
(6, 3, '', '', '', '', '', '', '', '', '', '', '', '2015-04-16 11:09:51', '2015-04-16 17:12:56', 1),
(9, 8, '', '', '', '', '', '', '', '', '', '', '', '2015-04-16 12:33:12', '2015-04-20 12:27:58', 1),
(10, 10, '', '', '', '', '', '', '', '', '', '', '', '2015-05-06 13:34:44', '2015-05-06 13:34:44', 1),
(13, 9, '', '', '', '', '', '', '', '', '', '', '', '2015-05-06 13:35:14', '2015-05-06 13:35:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `haematology`
--

CREATE TABLE IF NOT EXISTS `haematology` (
`haematology_id` int(11) NOT NULL,
  `clinical_diagnosis_details` text,
  `doctor_id` int(11) NOT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `laboratory_report` text,
  `laboratory_ref` varchar(10) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) DEFAULT '0',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `haematology`
--

INSERT INTO `haematology` (`haematology_id`, `clinical_diagnosis_details`, `doctor_id`, `lab_attendant_id`, `laboratory_report`, `laboratory_ref`, `created_date`, `modified_date`, `treatment_id`, `encounter_id`, `active_fg`, `status_id`) VALUES
(1, 'something sth', 1, 3, 'somthing too sha                                                                                                                                                                                                                                                                                                                                                                                                                ', 'H101', '2015-04-04 00:00:00', '2015-04-16 12:32:02', 1, 0, 1, 5),
(2, 'clicnical details\r\n', 2, 3, 'good                                                                                                                                                                                                        ', 'H102', '2015-04-08 16:34:27', '2015-04-16 13:41:39', 3, 0, 1, 5),
(3, 'not known', 3, 3, 'something sha                                                                                                                                                                                                                                                                                                                                                                                                                ', 'H103', '2015-04-08 16:35:50', '2015-04-16 17:12:56', 10, 0, 1, 5),
(4, 'something', 1, 3, '                                                                                                                        ', '', '2015-04-08 20:07:26', '2015-04-16 17:15:26', 2, 0, 1, 5),
(5, 'something', 1, NULL, NULL, NULL, '2015-04-08 20:16:17', '2015-04-08 20:16:17', 1, 0, 1, 5),
(6, 'something', 1, NULL, NULL, NULL, '2015-04-10 14:13:51', '2015-04-10 14:13:51', 2, 0, 1, 5),
(7, 'something', 1, NULL, NULL, NULL, '2015-04-10 14:13:55', '2015-04-10 14:13:55', 2, 0, 1, 5),
(8, 'Shingaling', 1, 1, '                                                                                                                                                                                                        ', '', '2015-04-10 15:09:16', '2015-04-20 12:27:58', 59, 0, 1, 6),
(9, 'God please', 1, 1, '                                        ', '', '2015-04-29 14:23:20', '2015-05-06 13:35:14', 47, 0, 1, 6),
(10, 'blood', 1, 1, '                                        ', '', '2015-04-29 18:12:11', '2015-05-06 13:34:44', 200, 0, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE IF NOT EXISTS `hospital_info` (
`hospital_info_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `microscopy`
--

CREATE TABLE IF NOT EXISTS `microscopy` (
`microscopy_id` int(11) NOT NULL,
  `urine_id` int(11) NOT NULL,
  `pus_cells` varchar(35) NOT NULL,
  `red_cells` varchar(35) NOT NULL,
  `epithelial_cells` varchar(35) NOT NULL,
  `casts` varchar(35) NOT NULL,
  `crystals` varchar(35) NOT NULL,
  `others` varchar(35) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `microscopy`
--

INSERT INTO `microscopy` (`microscopy_id`, `urine_id`, `pus_cells`, `red_cells`, `epithelial_cells`, `casts`, `crystals`, `others`, `created_date`, `modified_date`, `active_fg`) VALUES
(52, 1, 'yes', 'too much', 'much', 'nil', 'little', 'nil', '2015-04-03 23:57:22', '2015-04-17 12:34:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nok_relationship`
--

CREATE TABLE IF NOT EXISTS `nok_relationship` (
`nok_relationship_id` int(10) unsigned NOT NULL,
  `relationship` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nok_relationship`
--

INSERT INTO `nok_relationship` (`nok_relationship_id`, `relationship`) VALUES
(1, 'father'),
(2, 'mother'),
(3, 'son'),
(4, 'daughter'),
(5, 'brother'),
(6, 'sister'),
(7, 'husband'),
(8, 'wife'),
(9, 'others');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_drugs`
--

CREATE TABLE IF NOT EXISTS `outgoing_drugs` (
`outgoing_drugs_id` int(11) unsigned NOT NULL,
  `drug_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outgoing_drugs`
--

INSERT INTO `outgoing_drugs` (`outgoing_drugs_id`, `drug_id`, `qty`, `unit_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(66, 1, 20, 1, '2015-02-25 13:00:43', '2015-02-25 13:00:43', 1),
(67, 3, 20, 1, '2015-02-25 13:00:43', '2015-02-25 13:00:43', 1),
(68, 1, 20, 1, '2015-02-25 13:02:05', '2015-02-25 13:02:05', 1),
(69, 3, 20, 1, '2015-02-25 13:02:05', '2015-02-25 13:02:05', 1),
(70, 1, 20, 1, '2015-02-25 13:02:11', '2015-02-25 13:02:11', 1),
(71, 3, 20, 1, '2015-02-25 13:02:11', '2015-02-25 13:02:11', 1),
(72, 1, 20, 1, '2015-02-25 13:10:55', '2015-02-25 13:10:55', 1),
(73, 3, 20, 1, '2015-02-25 13:10:55', '2015-02-25 13:10:55', 1),
(74, 1, 20, 1, '2015-02-25 13:10:58', '2015-02-25 13:10:58', 1),
(75, 3, 20, 1, '2015-02-25 13:10:58', '2015-02-25 13:10:58', 1),
(76, 1, 20, 1, '2015-02-25 13:10:59', '2015-02-25 13:10:59', 1),
(77, 3, 20, 1, '2015-02-25 13:10:59', '2015-02-25 13:10:59', 1),
(78, 1, 20, 1, '2015-02-25 13:25:26', '2015-02-25 13:25:26', 1),
(79, 3, 20, 1, '2015-02-25 13:25:26', '2015-02-25 13:25:26', 1),
(80, 1, 20, 1, '2015-02-25 13:43:24', '2015-02-25 13:43:24', 1),
(81, 3, 20, 1, '2015-02-25 13:43:24', '2015-02-25 13:43:24', 1),
(82, 1, 20, 1, '2015-02-25 16:30:09', '2015-02-25 16:30:09', 1),
(83, 3, 20, 1, '2015-02-25 16:30:09', '2015-02-25 16:30:09', 1),
(84, 1, 20, 1, '2015-02-25 17:40:21', '2015-02-25 17:40:21', 1),
(85, 3, 20, 1, '2015-02-25 17:40:21', '2015-02-25 17:40:21', 1),
(89, 3, 2, 1, '2015-03-02 14:17:17', '2015-03-02 14:17:17', 1),
(90, 3, 2, 1, '2015-03-02 14:20:50', '2015-03-02 14:20:50', 1),
(91, 3, 2, 1, '2015-03-02 14:55:19', '2015-03-02 14:55:19', 1),
(92, 5, 2, 1, '2015-03-02 15:00:13', '2015-03-02 15:00:13', 1),
(93, 6, 2, 1, '2015-03-02 15:12:13', '2015-03-02 15:12:13', 1),
(94, 7, 2, 1, '2015-03-02 15:26:54', '2015-03-02 15:26:54', 1),
(95, 3, 2, 1, '2015-03-02 16:23:16', '2015-03-02 16:23:16', 1),
(96, 8, 2, 1, '2015-03-02 16:24:51', '2015-03-02 16:24:51', 1),
(97, 5, 2, 1, '2015-03-02 16:30:07', '2015-03-02 16:30:07', 1),
(98, 9, 2, 1, '2015-03-02 16:30:50', '2015-03-02 16:30:50', 1),
(99, 10, 2, 1, '2015-03-02 16:31:45', '2015-03-02 16:31:45', 1),
(100, 11, 2, 1, '2015-03-02 16:33:45', '2015-03-02 16:33:45', 1),
(101, 12, 2, 1, '2015-03-02 16:41:03', '2015-03-02 16:41:03', 1),
(102, 12, 2, 1, '2015-03-02 16:42:40', '2015-03-02 16:42:40', 1),
(103, 10, 2, 1, '2015-03-04 14:54:32', '2015-03-04 14:54:32', 1),
(104, 13, 2, 1, '2015-03-04 15:07:00', '2015-03-04 15:07:00', 1),
(105, 14, 2, 1, '2015-03-04 15:08:33', '2015-03-04 15:08:33', 1),
(106, 3, 2, 1, '2015-04-12 18:22:30', '2015-04-12 18:22:30', 1),
(107, 2, 2, 1, '2015-04-12 18:22:30', '2015-04-12 18:22:30', 1),
(108, 1, 2, 1, '2015-04-29 18:05:15', '2015-04-29 18:05:15', 1),
(109, 1, 2, 1, '2015-05-26 13:47:40', '2015-05-26 13:47:40', 1),
(110, 1, 2, 1, '2015-05-26 13:52:47', '2015-05-26 13:52:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_details`
--

CREATE TABLE IF NOT EXISTS `parasitology_details` (
`pdetail_id` int(11) NOT NULL,
  `preq_id` int(11) DEFAULT NULL,
  `pref_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parasitology_details`
--

INSERT INTO `parasitology_details` (`pdetail_id`, `preq_id`, `pref_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(37, 1, 11, '2015-04-04 02:20:42', '2015-04-16 18:14:27', 0),
(38, 1, 13, '2015-04-04 02:20:42', '2015-04-16 18:14:27', 0),
(39, 1, 15, '2015-04-04 02:20:42', '2015-04-16 18:14:27', 1),
(40, 1, 8, '2015-04-04 02:21:55', '2015-04-16 18:14:27', 1),
(41, 1, 3, '2015-04-07 11:27:54', '2015-04-16 18:14:27', 1),
(42, 1, 5, '2015-04-07 11:27:54', '2015-04-16 18:14:27', 0),
(43, 1, 1, '2015-04-07 11:27:54', '2015-04-16 18:14:27', 1),
(44, 1, 14, '2015-04-16 17:11:47', '2015-04-16 18:14:27', 0),
(45, 2, 14, '2015-04-16 17:13:54', '2015-04-16 17:13:54', 1),
(46, 2, 15, '2015-04-16 17:13:54', '2015-04-16 17:13:54', 1),
(47, 1, 2, '2015-04-16 17:27:13', '2015-04-16 18:14:27', 1),
(48, 1, 9, '2015-04-16 17:27:13', '2015-04-16 18:14:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_ref`
--

CREATE TABLE IF NOT EXISTS `parasitology_ref` (
`pref_id` int(11) NOT NULL,
  `parasite_name` varchar(50) DEFAULT NULL,
  `parasite_type` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parasitology_ref`
--

INSERT INTO `parasitology_ref` (`pref_id`, `parasite_name`, `parasite_type`, `active_fg`) VALUES
(1, 'Hook worm', 'Ova of', 1),
(2, 'A. lumbricoides', 'Ova of', 1),
(3, 'T. Trichuris', 'Ova of', 1),
(4, 'E. vemicularis', 'Ova of', 1),
(5, 'S. haematobium', 'Ova of', 1),
(6, 'No cysts. ova', 'Ova of', 1),
(7, 'E. coli', 'Trophozoites/cyts of', 1),
(8, 'E. hysto', 'Trophozoites/cyts of', 1),
(9, 'G. lamblia', 'Trophozoites/cyts of', 1),
(10, 'Hook worm', 'Larvae of', 1),
(11, 'S. stercoralis', 'Larvae of', 1),
(12, 'RBC''s', 'Cells', 1),
(13, 'WBC''s', 'Cells', 1),
(14, 'Positive', 'Occult Blood', 1),
(15, 'Negative', 'Occult Blood', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_req`
--

CREATE TABLE IF NOT EXISTS `parasitology_req` (
`preq_id` int(11) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `nature_of_specimen` varchar(50) DEFAULT NULL,
  `investigation_req` varchar(100) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `date_reported` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `doctor_id` int(11) DEFAULT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  `pref_id` int(11) DEFAULT NULL,
  `lab_num` varchar(15) DEFAULT NULL,
  `lab_comment` text
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parasitology_req`
--

INSERT INTO `parasitology_req` (`preq_id`, `treatment_id`, `encounter_id`, `nature_of_specimen`, `investigation_req`, `diagnosis`, `date_reported`, `created_date`, `modified_date`, `active_fg`, `doctor_id`, `lab_attendant_id`, `status_id`, `pref_id`, `lab_num`, `lab_comment`) VALUES
(1, 1, 0, 'Dont know', 'general checkup', NULL, NULL, '2015-04-04 00:00:00', '2015-04-16 18:14:27', 1, NULL, 4, 6, NULL, '1', 'It is okay'),
(2, 2, 0, '', '', 'something', NULL, '2015-04-08 19:22:21', '2015-04-16 17:13:54', 1, 1, 4, 6, NULL, '', ''),
(3, 2, 0, NULL, NULL, 'something', NULL, '2015-04-08 19:22:22', '2015-04-08 19:22:22', 1, 1, NULL, 5, NULL, NULL, NULL),
(4, 2, 0, NULL, NULL, 'something', NULL, '2015-04-08 19:49:34', '2015-04-08 19:49:34', 1, 1, NULL, 5, NULL, NULL, NULL),
(11, 2, 0, NULL, NULL, 'something', NULL, '2015-04-10 14:06:57', '2015-04-10 14:06:57', 1, 1, NULL, 5, NULL, NULL, NULL),
(12, 2, 0, NULL, NULL, 'something', NULL, '2015-04-10 14:07:00', '2015-04-10 14:07:00', 1, 1, NULL, 5, NULL, NULL, NULL),
(13, 2, 0, NULL, NULL, 'something', NULL, '2015-04-10 14:07:03', '2015-04-10 14:07:03', 1, 1, NULL, 5, NULL, NULL, NULL),
(14, 2, 0, NULL, NULL, 'something', NULL, '2015-04-10 14:14:54', '2015-04-10 14:14:54', 1, 1, NULL, 5, NULL, NULL, NULL),
(15, 59, 0, '', '', 'Shingaling', NULL, '2015-04-10 15:10:23', '2015-04-29 13:43:14', 1, 1, 2, 6, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
`patient_id` int(11) unsigned NOT NULL,
  `surname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middlename` varchar(25) NOT NULL,
  `regNo` varchar(30) NOT NULL,
  `home_address` varchar(150) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `sex` enum('Male','Female','Emer') DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `nok_firstname` varchar(25) DEFAULT NULL,
  `nok_middlename` varchar(25) DEFAULT NULL,
  `nok_surname` varchar(25) DEFAULT NULL,
  `nok_address` varchar(150) DEFAULT NULL,
  `nok_telephone` varchar(20) DEFAULT NULL,
  `nok_relationship` int(10) unsigned NOT NULL DEFAULT '9',
  `citizenship` varchar(25) NOT NULL,
  `religion` varchar(25) NOT NULL,
  `family_position` int(11) DEFAULT NULL,
  `mother_status` varchar(25) NOT NULL,
  `father_status` varchar(25) NOT NULL,
  `marital_status` varchar(25) NOT NULL,
  `no_of_children` int(11) DEFAULT NULL,
  `occupation` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `surname`, `firstname`, `middlename`, `regNo`, `home_address`, `telephone`, `sex`, `height`, `weight`, `birth_date`, `nok_firstname`, `nok_middlename`, `nok_surname`, `nok_address`, `nok_telephone`, `nok_relationship`, `citizenship`, `religion`, `family_position`, `mother_status`, `father_status`, `marital_status`, `no_of_children`, `occupation`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2000-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-02-18 00:00:00', '2015-05-11 14:13:17', 1),
(2, 'Adefemi', 'Olatunji', 'Abayomi', '56745689', 'lagos state', '88909804889', 'Male', 45, 34, '2015-02-17', 'Gabriel', 'Adewale', 'Dada', 'ibadan', '08025641756', 3, '', '', 0, '', '', '', 0, '', '2015-02-12 00:00:00', '2015-02-06 00:00:00', 1),
(3, 'Adefem3', 'Olatunjirff', 'Abayomiw', '56745689', 'Ogun state', '88909804889', 'Male', 45, 34, '2015-02-17', 'Ibrahim', 'Olakunle', 'Uthsman', 'ile-ife', '09156234178', 3, '', '', 0, '', '', '', 0, '', '2015-02-12 00:00:00', '2015-02-06 00:00:00', 1),
(4, 'kunle', 'ajasin', 'chikaodi', '234', 'fnfnfnnnn', '345668', 'Male', 3, 4, '2015-02-17', 'chika', 'odi', 'chukuamaka', 'ilupeju', '3459696999', 5, '', '', 0, '', '', '', 0, '', '2015-02-10 00:00:00', '2015-02-08 00:00:00', 1),
(5, 'mbakwe', 'caleb', 'chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Male', 12, 12, '1999-04-01', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, '', '2015-04-01 10:13:05', '2015-04-01 10:13:05', 1),
(8, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-01 10:47:56', '2015-05-11 14:13:45', 1),
(9, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-12 16:12:41', '2015-05-06 18:40:03', 1),
(10, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-12 16:13:43', '2015-05-06 18:42:13', 1),
(11, 'mbakwe', 'caleb', 'chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Male', 12, 12, '2015-04-12', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2343765832768', 1, 'Nigeria', 'ISLAM', 3, 'DEAD', 'DEAD', 'MARRIED', 2, '', '2015-04-12 16:17:30', '2015-04-12 16:17:30', 1),
(12, 'mbakwe', 'caleb', 'chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Male', 12, 12, '2015-04-13', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2343765832768', 1, 'Nigeria', 'ISLAM', 2, 'ALIVE', 'ALIVE', 'SINGLE', 1, '', '2015-04-13 12:35:23', '2015-04-13 12:35:23', 1),
(13, 'mbakwe', 'caleb', 'chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Male', 12, 12, '2015-04-13', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2343765832768', 2, 'Nigeria', 'CHRISTAINITY', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, '', '2015-04-13 12:38:24', '2015-04-13 12:38:24', 1),
(14, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-13 12:39:05', '2015-05-06 18:36:48', 1),
(15, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-13 13:04:03', '2015-05-06 18:37:05', 1),
(16, 'emer', 'emer', 'emer', 'EMER', 'EMER', 'EMER', 'Emer', 0, 0, '0000-00-00', 'EMER', 'EMER', 'EMER', 'EMER', 'EMER', 9, 'EMER', 'EMER', 0, 'EMER', 'EMER', 'EMER', 0, '', '2015-04-13 13:05:29', '2015-04-13 13:05:29', 1),
(17, 'emer', 'emer', 'emer', 'EMER', 'EMER', 'EMER', 'Emer', 0, 0, '0000-00-00', 'EMER', 'EMER', 'EMER', 'EMER', 'EMER', 9, 'EMER', 'EMER', 0, 'EMER', 'EMER', 'EMER', 0, '', '2015-04-13 13:06:03', '2015-04-13 13:06:03', 1),
(18, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-16', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-28 00:00:00', '2015-04-22 00:00:00', 1),
(19, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 12:39:02', '2015-04-20 12:39:02', 1),
(20, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-20 12:39:47', '2015-05-06 18:41:37', 1),
(21, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 12:42:31', '2015-04-20 12:42:31', 1),
(22, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 12:42:58', '2015-04-20 12:42:58', 1),
(23, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-20 13:11:12', '2015-05-06 19:32:19', 1),
(24, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 13:15:38', '2015-04-20 13:15:38', 1),
(25, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 13:16:21', '2015-04-20 13:16:21', 1),
(26, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:18:23', '2015-04-20 15:18:23', 1),
(27, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:19:05', '2015-04-20 15:19:05', 1),
(28, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:20:23', '2015-04-20 15:20:23', 1),
(29, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:21:37', '2015-04-20 15:21:37', 1),
(30, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:54:47', '2015-04-20 15:54:47', 1),
(31, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:55:02', '2015-04-20 15:55:02', 1),
(32, '', '', '', '', NULL, NULL, NULL, NULL, NULL, '2015-04-20', NULL, NULL, NULL, NULL, NULL, 9, '', '', NULL, '', '', '', NULL, '', '2015-04-20 15:55:58', '2015-04-20 15:55:58', 1),
(33, 'oduguwa', 'ademola', 's', 'EEE/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Male', 12, 12, '2015-04-21', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2341567890', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'MARRIED', 0, '', '2015-04-21 13:41:29', '2015-04-21 13:41:29', 1),
(34, 'emer', 'emer', 'emer', 'EMER', 'EMER', 'EMER', 'Emer', 0, 0, '0000-00-00', 'EMER', 'EMER', 'EMER', 'EMER', 'EMER', 9, 'EMER', 'EMER', 0, 'EMER', 'EMER', 'EMER', 0, '', '2015-04-21 14:38:45', '2015-04-21 14:38:45', 1),
(35, 'emer', 'emer', 'emer', 'EMER', 'EMER', 'EMER', 'Emer', 0, 0, '0000-00-00', 'EMER', 'EMER', 'EMER', 'EMER', 'EMER', 9, 'EMER', 'EMER', 0, 'EMER', 'EMER', 'EMER', 0, '', '2015-04-21 14:39:24', '2015-04-21 14:39:24', 1),
(36, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-27 19:09:35', '2015-05-06 19:18:35', 1),
(37, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-04-27 19:18:17', '2015-05-06 19:20:14', 1),
(38, '', '', '', 'EMER38', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:13:14', '2015-04-29 12:13:14', 1),
(39, 'mbakwe', 'caleb', 'chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '+2345678901', 'Male', 10, 11, '2015-04-29', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2345678901', 1, 'Nigeria', 'ISLAM', 4, 'ALIVE', 'ALIVE', 'MARRIED', 1, '', '2015-04-29 12:24:17', '2015-04-29 12:24:17', 1),
(40, '', '', '', 'EMER40', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:34:48', '2015-04-29 12:34:48', 1),
(41, '', '', '', 'EMER41', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:35:40', '2015-04-29 12:35:40', 1),
(42, '', '', '', 'EMER42', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:36:05', '2015-04-29 12:36:05', 1),
(43, '', '', '', 'EMER43', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:36:49', '2015-04-29 12:36:49', 1),
(44, '', '', '', 'EMER44', NULL, NULL, NULL, NULL, NULL, '2015-04-29', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-04-29 12:38:37', '2015-04-29 12:38:37', 1),
(45, 'bmoses', 'adereti', 'sannid', '4356664', 'gowon, estate. 12, gthyh', '07045346079', 'Male', 43, 45, '2015-02-03', 'caleb', 'james', 'fatima', 'room 012, space computer buidling., obafemi awolowo university', ' 4345555', 2, 'nigeria', 'christian', 2, 'alive', 'alive', 'married', 5, 'selling', '2015-05-05 20:10:15', '2015-05-05 20:10:15', 1),
(46, 'mbakwe', 'caleb', 'chukwuezugo', 'COEX/2015/001', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Female', 12, 12, '2015-05-06', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 1, 'Nigeria', 'ISLAM', 2, 'DEAD', 'ALIVE', 'SINGLE', 0, 'Teacher', '2015-05-06 11:31:12', '2015-05-06 11:31:12', 1),
(47, 'mbakwe', 'caleb', 'chukwuezugo', 'COEX/2015/002', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Female', 12, 12, '2015-05-06', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+2345676890', 1, 'Nigeria', 'ISLAM', 1, 'DEAD', 'ALIVE', 'SINGLE', 0, 'Brother', '2015-05-06 11:32:31', '2015-05-06 11:32:31', 1),
(48, 'mbakwe', 'caleb', 'chukwuezugo', 'COEX/2015/003', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Female', 12, 12, '2015-05-06', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 2, 'Nigeria', 'ISLAM', 2, 'DEAD', 'DEAD', 'SINGLE', 1, 'Newbie', '2015-05-06 11:38:45', '2015-05-06 11:38:45', 1),
(49, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-05-06 11:39:58', '2015-05-06 18:23:55', 1),
(50, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', ' 234567890', 'Male', 12, 12, '2015-03-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', ' 2343765832768', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'dueind', '2015-05-06 17:12:44', '2015-05-06 19:22:16', 1),
(51, 'mbakwe', 'caleb', 'chukwuezugo', 'COEX/2015/005', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 'Female', 12, 12, '2015-05-06', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '+234567890', 2, 'Nigeria', 'ISLAM', 2, 'DEAD', 'DEAD', 'SINGLE', 1, 'boss', '2015-05-06 17:14:02', '2015-05-06 17:14:02', 1),
(52, '', '', '', 'EMER52', NULL, NULL, NULL, NULL, NULL, '2015-05-13', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-05-13 10:46:02', '2015-05-13 10:46:02', 1),
(53, '', '', '', 'EMER53', NULL, NULL, NULL, NULL, NULL, '2015-05-13', NULL, NULL, NULL, NULL, NULL, 9, '', '', 1, '', '', '', 1, '', '2015-05-13 10:46:13', '2015-05-13 10:46:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `patient_queue`
--

CREATE TABLE IF NOT EXISTS `patient_queue` (
`patient_queue_id` int(11) unsigned NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_queue`
--

INSERT INTO `patient_queue` (`patient_queue_id`, `patient_id`, `doctor_id`, `active_fg`, `created_date`, `modified_date`) VALUES
(1, 1, NULL, 0, '2015-02-23 15:31:11', '2015-04-20 10:34:33'),
(2, 2, 2, 0, '2015-02-23 15:45:59', '2015-04-01 10:45:55'),
(3, 3, NULL, 0, '2015-02-27 10:50:48', '2015-02-27 10:50:48'),
(4, 2, 2, 0, '2015-04-01 10:45:55', '2015-04-01 10:46:00'),
(5, 2, 2, 0, '2015-04-01 10:46:00', '2015-04-01 10:53:30'),
(6, 8, 2, 0, '2015-04-01 10:53:35', '2015-04-01 10:55:58'),
(7, 8, 2, 0, '2015-04-01 10:55:58', '2015-04-01 13:46:47'),
(8, 2, 2, 0, '2015-04-01 10:57:33', '2015-04-01 13:46:48'),
(9, 8, 1, 0, '2015-04-01 13:46:47', '2015-04-01 13:46:50'),
(10, 2, 2, 0, '2015-04-01 13:46:49', '2015-04-02 17:02:24'),
(11, 2, 1, 0, '2015-04-02 17:02:24', '2015-04-02 18:10:30'),
(12, 2, 2, 0, '2015-04-02 18:10:30', '2015-04-02 18:10:31'),
(13, 2, 1, 0, '2015-04-02 18:10:31', '2015-04-13 13:06:19'),
(14, 4, 1, 0, '2015-04-12 13:45:16', '2015-04-12 13:54:29'),
(15, 4, 1, 0, '2015-04-12 13:54:37', '2015-04-12 16:03:55'),
(16, 4, 1, 0, '2015-04-12 16:03:55', '2015-04-12 16:04:15'),
(17, 4, 1, 0, '2015-04-12 16:04:15', '2015-04-12 16:04:55'),
(19, 4, 1, 0, '2015-04-12 16:05:15', '2015-04-12 16:05:21'),
(20, 4, 1, 0, '2015-04-12 16:18:43', '2015-04-13 14:28:21'),
(22, 5, 1, 0, '2015-04-13 13:20:54', '2015-04-13 15:08:15'),
(24, 2, 1, 0, '2015-04-13 13:21:12', '2015-04-20 10:00:19'),
(25, 4, NULL, 0, '2015-04-13 14:28:30', '2015-04-20 10:15:56'),
(28, 4, NULL, 0, '2015-04-20 10:22:43', '2015-04-20 10:22:48'),
(29, 4, 1, 0, '2015-04-20 10:22:48', '2015-04-20 10:23:02'),
(30, 2, NULL, 0, '2015-04-20 10:22:57', '2015-04-20 10:22:59'),
(31, 2, 1, 0, '2015-04-20 10:22:59', '2015-04-20 10:35:47'),
(32, 2, NULL, 0, '2015-04-20 10:25:38', '2015-04-20 10:35:47'),
(33, 1, 1, 0, '2015-04-20 10:34:33', '2015-04-20 10:34:33'),
(34, 2, NULL, 0, '2015-04-20 10:35:47', '2015-04-20 10:37:08'),
(35, 2, NULL, 0, '2015-04-20 10:37:08', '2015-04-20 10:37:13'),
(36, 2, 1, 0, '2015-04-20 10:37:13', '2015-04-20 10:40:01'),
(37, 4, NULL, 0, '2015-04-20 10:37:33', '2015-04-20 10:37:44'),
(38, 4, 1, 0, '2015-04-20 10:37:44', '2015-04-20 10:37:52'),
(39, 4, NULL, 0, '2015-04-20 10:37:52', '2015-04-20 10:38:06'),
(40, 4, 1, 0, '2015-04-20 10:38:06', '2015-04-20 10:38:12'),
(41, 4, NULL, 0, '2015-04-20 10:38:12', '2015-04-20 10:38:25'),
(42, 4, 1, 0, '2015-04-20 10:38:25', '2015-04-20 10:38:54'),
(43, 4, NULL, 0, '2015-04-20 10:38:54', '2015-04-20 10:39:07'),
(44, 4, 1, 0, '2015-04-20 10:39:07', '2015-04-20 10:39:23'),
(45, 4, 1, 0, '2015-04-20 10:39:23', '2015-04-20 10:39:28'),
(46, 4, 1, 0, '2015-04-20 10:39:28', '2015-04-20 10:39:32'),
(47, 4, NULL, 0, '2015-04-20 10:39:32', '2015-04-20 10:39:39'),
(48, 4, NULL, 0, '2015-04-20 10:39:39', '2015-04-20 10:40:07'),
(49, 2, NULL, 0, '2015-04-20 10:40:01', '2015-04-20 11:02:08'),
(50, 4, 1, 0, '2015-04-20 10:40:07', '2015-04-20 11:02:06'),
(51, 4, NULL, 0, '2015-04-20 11:02:06', '2015-04-20 16:53:48'),
(52, 2, 1, 0, '2015-04-20 11:02:08', '2015-04-20 11:02:10'),
(53, 2, NULL, 0, '2015-04-20 11:02:10', '2015-04-20 12:41:08'),
(54, 1, NULL, 0, '2015-04-20 12:40:57', '2015-04-20 12:41:09'),
(55, 3, NULL, 0, '2015-04-20 12:41:05', '2015-04-20 16:53:57'),
(56, 2, 1, 0, '2015-04-20 12:41:08', '2015-04-20 12:41:08'),
(57, 1, 1, 0, '2015-04-20 12:41:09', '2015-04-20 12:41:09'),
(58, 24, NULL, 0, '2015-04-20 13:15:38', '2015-04-20 16:53:53'),
(59, 25, NULL, 0, '2015-04-20 13:16:21', '2015-04-20 13:16:21'),
(60, 26, NULL, 0, '2015-04-20 15:18:23', '2015-04-20 15:18:23'),
(61, 27, NULL, 0, '2015-04-20 15:19:05', '2015-04-20 15:19:05'),
(62, 28, NULL, 0, '2015-04-20 15:20:23', '2015-04-20 15:20:23'),
(63, 29, NULL, 0, '2015-04-20 15:21:37', '2015-04-20 15:21:37'),
(64, 4, 1, 0, '2015-04-20 16:53:48', '2015-04-20 16:53:48'),
(65, 24, 1, 0, '2015-04-20 16:53:53', '2015-04-20 17:13:28'),
(66, 3, 1, 0, '2015-04-20 16:53:57', '2015-04-20 16:53:57'),
(67, 24, NULL, 0, '2015-04-20 17:13:28', '2015-04-20 17:13:28'),
(68, 4, NULL, 0, '2015-04-20 17:24:33', '2015-04-20 17:24:57'),
(69, 1, NULL, 0, '2015-04-20 17:24:47', '2015-04-20 17:25:58'),
(70, 4, 1, 0, '2015-04-20 17:24:57', '2015-04-20 17:25:30'),
(71, 4, NULL, 0, '2015-04-20 17:25:30', '2015-04-21 09:42:41'),
(72, 1, 1, 0, '2015-04-20 17:25:58', '2015-04-21 09:44:00'),
(73, 4, 1, 0, '2015-04-21 09:42:41', '2015-04-21 09:42:48'),
(74, 4, NULL, 0, '2015-04-21 09:42:48', '2015-04-21 10:25:06'),
(75, 1, NULL, 0, '2015-04-21 09:44:00', '2015-04-21 09:51:08'),
(76, 1, 1, 0, '2015-04-21 09:51:08', '2015-04-29 14:16:52'),
(77, 4, 2, 0, '2015-04-21 10:25:06', '2015-04-28 12:15:17'),
(78, 37, NULL, 0, '2015-04-27 19:18:17', '2015-04-29 12:43:27'),
(79, 4, 1, 0, '2015-04-28 12:15:17', '2015-04-29 14:36:09'),
(80, 38, NULL, 0, '2015-04-29 12:13:14', '2015-04-29 12:55:44'),
(81, 40, NULL, 0, '2015-04-29 12:34:48', '2015-05-05 16:25:17'),
(82, 44, NULL, 0, '2015-04-29 12:38:37', '2015-05-12 17:57:16'),
(83, 37, 1, 0, '2015-04-29 12:43:27', '2015-04-29 12:43:28'),
(84, 37, NULL, 1, '2015-04-29 12:43:28', '2015-04-29 12:43:28'),
(85, 38, 1, 0, '2015-04-29 12:55:45', '2015-04-29 17:56:50'),
(86, 1, 2, 1, '2015-04-29 14:16:52', '2015-04-29 14:16:52'),
(87, 5, 1, 0, '2015-04-29 14:37:51', '2015-04-29 17:56:50'),
(88, 4, 1, 0, '2015-04-29 14:38:28', '2015-04-29 18:15:10'),
(89, 9, 1, 0, '2015-04-29 14:41:56', '2015-04-29 17:56:58'),
(90, 11, 1, 0, '2015-04-29 14:42:06', '2015-04-29 18:12:16'),
(91, 12, 1, 0, '2015-04-29 14:42:24', '2015-05-05 16:27:54'),
(92, 13, 1, 0, '2015-04-29 14:42:38', '2015-05-05 16:28:02'),
(93, 5, 1, 0, '2015-04-29 17:56:50', '2015-05-13 13:07:50'),
(94, 38, 1, 0, '2015-04-29 17:56:50', '2015-05-12 17:58:06'),
(95, 9, 3, 1, '2015-04-29 17:56:58', '2015-04-29 17:56:58'),
(96, 39, 1, 0, '2015-04-29 18:13:10', '2015-05-13 13:13:52'),
(97, 11, 1, 0, '2015-04-29 18:14:18', '2015-05-13 10:42:13'),
(98, 14, 1, 0, '2015-04-29 18:14:23', '2015-05-13 13:09:44'),
(99, 4, 1, 0, '2015-04-29 18:15:16', '2015-05-13 10:40:54'),
(100, 48, NULL, 0, '2015-05-06 11:38:45', '2015-05-06 11:39:51'),
(101, 47, NULL, 0, '2015-05-06 11:39:18', '2015-05-06 11:39:39'),
(102, 46, NULL, 0, '2015-05-06 11:39:35', '2015-05-06 11:39:37'),
(103, 46, 2, 0, '2015-05-06 11:39:37', '2015-05-14 03:27:12'),
(104, 47, 1, 0, '2015-05-06 11:39:39', '2015-05-12 17:58:16'),
(105, 48, 3, 0, '2015-05-06 11:39:51', '2015-05-14 03:27:24'),
(106, 49, NULL, 0, '2015-05-06 11:39:58', '2015-05-12 17:57:36'),
(107, 44, NULL, 0, '2015-05-12 17:57:16', '2015-05-12 17:57:16'),
(108, 44, NULL, 1, '2015-05-12 17:57:16', '2015-05-12 17:57:16'),
(109, 49, 1, 0, '2015-05-12 17:57:36', '2015-05-12 17:58:06'),
(110, 49, 1, 0, '2015-05-12 17:58:06', '2015-05-13 13:15:45'),
(111, 38, NULL, 1, '2015-05-12 17:58:06', '2015-05-12 17:58:06'),
(112, 47, NULL, 0, '2015-05-12 17:58:16', '2015-05-14 03:27:15'),
(113, 4, 2, 0, '2015-05-13 10:40:54', '2015-05-14 03:27:20'),
(114, 11, 2, 1, '2015-05-13 10:42:13', '2015-05-13 10:42:13'),
(115, 52, NULL, 0, '2015-05-13 10:46:02', '2015-05-13 10:46:22'),
(116, 53, NULL, 0, '2015-05-13 10:46:13', '2015-05-13 10:46:19'),
(117, 5, 1, 1, '2015-05-13 13:24:14', '2015-05-13 13:24:14'),
(118, 46, 1, 1, '2015-05-14 03:27:12', '2015-05-14 03:27:12'),
(119, 47, 1, 1, '2015-05-14 03:27:15', '2015-05-14 03:27:15'),
(120, 4, 1, 1, '2015-05-14 03:27:20', '2015-05-14 03:27:20'),
(121, 48, 1, 1, '2015-05-14 03:27:24', '2015-05-14 03:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
`permission_role_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `staff_permission_id` int(11) NOT NULL,
  `staff_role_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_role_id`, `userid`, `staff_permission_id`, `staff_role_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 2, 1, '2015-01-27 16:25:12', '2015-02-02 16:29:46', 0),
(2, 1, 1, 2, '2015-01-27 16:25:35', '2015-02-02 15:29:07', 0),
(3, 1, 1, 3, '2015-01-28 18:02:22', '2015-01-28 20:03:38', 0),
(4, 1, 2, 4, '2015-01-28 18:38:27', '2015-01-28 19:45:39', 0),
(5, 1, 1, 1, '2015-01-30 15:10:20', '2015-02-02 15:39:45', 0),
(6, 1, 1, 1, '2015-01-30 16:07:18', '2015-02-02 16:23:49', 0),
(7, 1, 1, 3, '2015-02-02 14:59:39', '2015-02-02 16:24:13', 0),
(8, 1, 1, 4, '2015-02-02 15:05:44', '2015-02-02 16:25:38', 0),
(9, 1, 1, 5, '2015-02-02 15:05:51', '2015-02-02 16:28:13', 0),
(10, 1, 1, 6, '2015-02-02 15:06:44', '2015-02-02 16:28:47', 0),
(11, 1, 1, 9, '2015-02-02 15:13:44', '2015-02-02 16:28:54', 0),
(12, 1, 2, 7, '2015-02-02 15:14:52', '2015-02-02 16:29:45', 0),
(13, 1, 2, 8, '2015-02-02 15:15:34', '2015-02-02 16:28:55', 1),
(14, 1, 1, 1, '2015-02-02 15:28:44', '2015-02-03 16:25:18', 0),
(15, 1, 1, 2, '2015-02-02 16:24:09', '2015-02-11 11:41:17', 0),
(16, 1, 1, 3, '2015-02-02 16:25:35', '2015-02-13 15:39:21', 0),
(17, 1, 1, 4, '2015-02-02 16:27:41', '2015-02-13 15:39:16', 0),
(18, 1, 1, 10, '2015-02-02 16:28:02', '2015-02-02 16:28:02', 1),
(19, 1, 1, 5, '2015-02-02 16:28:31', '2015-02-02 16:30:08', 0),
(20, 1, 1, 1, '2015-02-10 11:14:09', '2015-02-10 11:14:09', 1),
(21, 2, 2, 1, '2015-02-10 12:33:01', '2015-02-10 12:33:01', 1),
(22, 2, 2, 10, '2015-02-10 12:33:11', '2015-02-10 12:33:11', 1),
(23, 2, 2, 8, '2015-02-10 12:33:24', '2015-02-10 12:33:24', 1),
(24, 1, 1, 2, '2015-02-11 11:41:24', '2015-02-13 15:39:26', 0),
(25, 2, 2, 2, '2015-02-11 15:54:45', '2015-02-11 15:54:45', 1),
(26, 1, 1, 14, '2015-02-13 15:38:05', '2015-02-13 15:38:05', 1),
(27, 1, 2, 2, '2015-02-13 15:39:39', '2015-02-13 15:39:39', 1),
(28, 1, 1, 3, '2015-02-13 15:40:34', '2015-02-13 15:40:34', 1),
(29, 1, 1, 5, '2015-02-13 15:41:09', '2015-02-13 15:41:09', 1),
(30, 1, 1, 11, '2015-02-13 15:41:19', '2015-02-13 15:41:19', 1),
(31, 1, 1, 8, '2015-02-13 15:41:24', '2015-02-13 15:41:24', 1),
(32, 1, 1, 4, '2015-02-13 15:48:29', '2015-02-13 15:48:29', 1),
(33, 1, 2, 15, '2015-02-16 11:16:27', '2015-02-16 11:16:27', 1),
(34, 3, 2, 1, '2015-02-16 14:03:58', '2015-02-19 16:50:13', 0),
(35, 3, 2, 2, '2015-02-16 14:06:22', '2015-02-16 14:06:25', 1),
(36, 3, 2, 3, '2015-02-16 14:06:33', '2015-02-16 14:06:35', 1),
(37, 1, 2, 9, '2015-02-17 17:32:17', '2015-02-17 17:32:17', 1),
(38, 1, 2, 16, '2015-03-12 10:59:32', '2015-03-12 10:59:32', 1),
(39, 4, 2, 1, '2015-04-13 09:59:05', '2015-04-13 09:59:05', 1),
(40, 5, 2, 1, '2015-04-13 12:21:59', '2015-04-13 12:22:35', 0),
(41, 5, 1, 2, '2015-04-13 12:22:10', '2015-04-13 12:22:10', 1),
(42, 2, 1, 17, '2015-04-17 14:46:53', '2015-04-17 14:46:53', 1),
(43, 1, 2, 17, '2015-04-17 15:09:16', '2015-04-17 15:09:16', 1),
(44, 1, 2, 18, '2015-04-29 13:42:01', '2015-04-29 13:42:01', 1),
(45, 2, 2, 18, '2015-04-29 13:51:48', '2015-04-29 13:51:48', 1),
(46, 3, 2, 18, '2015-04-29 13:51:56', '2015-04-29 13:51:56', 1),
(47, 4, 2, 18, '2015-04-29 13:52:07', '2015-04-29 13:52:07', 1),
(48, 2, 2, 4, '2015-04-29 17:52:06', '2015-04-29 17:52:06', 1),
(49, 2, 2, 7, '2015-04-29 17:52:34', '2015-04-29 17:52:34', 1),
(50, 1, 2, 19, '2015-05-06 14:04:17', '2015-05-06 14:04:17', 1),
(51, 2, 2, 19, '2015-05-15 11:20:59', '2015-05-15 11:20:59', 1),
(52, 1, 2, 20, '2015-05-18 13:24:23', '2015-05-18 13:24:23', 1),
(53, 2, 2, 20, '2015-05-18 13:25:08', '2015-05-18 13:25:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist_outgoing_drug`
--

CREATE TABLE IF NOT EXISTS `pharmacist_outgoing_drug` (
`pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL,
  `pharmacist_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pharmacist_outgoing_drug`
--

INSERT INTO `pharmacist_outgoing_drug` (`pharmacist_outgoing_drug_id`, `pharmacist_id`, `outgoing_drug_id`, `created_date`, `active_fg`) VALUES
(32, 1, 66, '2015-02-25 13:00:43', 1),
(33, 1, 67, '2015-02-25 13:00:43', 1),
(34, 1, 68, '2015-02-25 13:02:05', 1),
(35, 1, 69, '2015-02-25 13:02:05', 1),
(36, 1, 70, '2015-02-25 13:02:11', 1),
(37, 1, 71, '2015-02-25 13:02:11', 1),
(38, 1, 72, '2015-02-25 13:10:55', 1),
(39, 1, 73, '2015-02-25 13:10:55', 1),
(40, 1, 74, '2015-02-25 13:10:58', 1),
(41, 1, 75, '2015-02-25 13:10:58', 1),
(42, 1, 76, '2015-02-25 13:10:59', 1),
(43, 1, 77, '2015-02-25 13:10:59', 1),
(44, 1, 78, '2015-02-25 13:25:26', 1),
(45, 1, 79, '2015-02-25 13:25:26', 1),
(46, 1, 80, '2015-02-25 13:43:24', 1),
(47, 1, 81, '2015-02-25 13:43:24', 1),
(48, 1, 82, '2015-02-25 16:30:09', 1),
(49, 1, 83, '2015-02-25 16:30:09', 1),
(50, 1, 84, '2015-02-25 17:40:21', 1),
(51, 1, 85, '2015-02-25 17:40:21', 1),
(55, 1, 89, '2015-03-02 14:17:17', 1),
(56, 1, 90, '2015-03-02 14:20:50', 1),
(57, 1, 91, '2015-03-02 14:55:19', 1),
(58, 1, 92, '2015-03-02 15:00:13', 1),
(59, 1, 93, '2015-03-02 15:12:13', 1),
(60, 1, 94, '2015-03-02 15:26:54', 1),
(61, 1, 95, '2015-03-02 16:23:16', 1),
(62, 1, 96, '2015-03-02 16:24:51', 1),
(63, 1, 97, '2015-03-02 16:30:07', 1),
(64, 1, 98, '2015-03-02 16:30:50', 1),
(65, 1, 99, '2015-03-02 16:31:45', 1),
(66, 1, 100, '2015-03-02 16:33:45', 1),
(67, 1, 101, '2015-03-02 16:41:03', 1),
(68, 1, 102, '2015-03-02 16:42:40', 1),
(69, 1, 103, '2015-03-04 14:54:32', 1),
(70, 1, 104, '2015-03-04 15:07:00', 1),
(71, 1, 105, '2015-03-04 15:08:33', 1),
(72, 1, 106, '2015-04-12 18:22:30', 1),
(73, 1, 107, '2015-04-12 18:22:30', 1),
(74, 3, 108, '2015-04-29 18:05:15', 1),
(75, 1, 109, '2015-05-26 13:47:40', 1),
(76, 1, 110, '2015-05-26 13:52:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
`prescription_id` int(11) unsigned NOT NULL,
  `prescription` varchar(255) DEFAULT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) DEFAULT '0',
  `status` int(11) NOT NULL,
  `modified_by` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescription_id`, `prescription`, `treatment_id`, `encounter_id`, `status`, `modified_by`, `created_date`, `modified_date`, `active_fg`) VALUES
(5, 'Quinine', 1, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(6, 'Paracetamol', 1, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(7, 'aaskas', 1, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(8, 'xdsfdfs', 1, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(9, 'gg', 2, 0, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(10, 'errr', 4, 0, 2, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(11, 'errr', 4, 0, 2, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(12, 'errr', 4, 0, 3, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(13, 'gghghgh', 3, 0, 2, 1, '2015-04-08 00:00:00', '2015-04-02 00:00:00', 1),
(14, 'gghghgh', 3, 0, 3, 1, '2015-04-10 18:35:19', '2015-04-10 18:35:19', 1),
(15, 'gghghgh', 3, 0, 3, 1, '2015-04-10 18:37:09', '2015-04-10 18:37:09', 1),
(16, ':prescription', 5, 0, 1, 3, '2015-04-10 18:38:04', '2015-04-10 18:38:04', 1),
(17, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(18, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(19, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(20, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(21, 'good', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(22, 'good', 31, 0, 1, 2, '2015-04-10 19:29:26', '2015-04-10 19:29:26', 1),
(23, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(24, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(25, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(26, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(27, 'good', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(28, 'good', 31, 0, 1, 2, '2015-04-10 19:29:27', '2015-04-10 19:29:27', 1),
(29, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:51', '2015-04-10 19:29:51', 1),
(30, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:51', '2015-04-10 19:29:51', 1),
(31, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:52', '2015-04-10 19:29:52', 1),
(32, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:52', '2015-04-10 19:29:52', 1),
(33, 'good', 31, 0, 1, 2, '2015-04-10 19:29:52', '2015-04-10 19:29:52', 1),
(34, 'good', 31, 0, 1, 2, '2015-04-10 19:29:52', '2015-04-10 19:29:52', 1),
(35, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(36, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(37, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(38, 'gggh', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(39, 'good', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(40, 'good', 31, 0, 1, 2, '2015-04-10 19:29:53', '2015-04-10 19:29:53', 1),
(41, 'gggh', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(42, 'gggh', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(43, 'gggh', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(44, 'gggh', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(45, 'good', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(46, 'good', 31, 0, 1, 2, '2015-04-10 19:31:01', '2015-04-10 19:31:01', 1),
(47, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(48, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(49, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(50, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(51, 'good', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(52, 'good', 31, 0, 1, 2, '2015-04-10 19:34:02', '2015-04-10 19:34:02', 1),
(53, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:58', '2015-04-10 19:34:58', 1),
(54, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:58', '2015-04-10 19:34:58', 1),
(55, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:58', '2015-04-10 19:34:58', 1),
(56, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(57, 'good', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(58, 'good', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(59, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(60, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(61, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(62, 'gggh', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(63, 'good', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(64, 'good', 31, 0, 1, 2, '2015-04-10 19:34:59', '2015-04-10 19:34:59', 1),
(65, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(66, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(67, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(68, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(69, 'good', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(70, 'good', 31, 0, 1, 2, '2015-04-10 19:35:03', '2015-04-10 19:35:03', 1),
(71, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(72, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(73, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(74, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(75, 'good', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(76, 'good', 31, 0, 1, 2, '2015-04-10 19:35:34', '2015-04-10 19:35:34', 1),
(77, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(78, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(79, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(80, 'gggh', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(81, 'good', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(82, 'good', 31, 0, 1, 2, '2015-04-10 19:35:51', '2015-04-10 19:35:51', 1),
(83, 'gggh', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(84, 'gggh', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(85, 'gggh', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(86, 'gggh', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(87, 'good', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(88, 'good', 31, 0, 1, 2, '2015-04-10 19:36:43', '2015-04-10 19:36:43', 1),
(89, 'great', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(90, 'great', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(91, 'great', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(92, 'not', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(93, 'not', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(94, 'not', 82, 0, 1, 2, '2015-04-10 19:41:35', '2015-04-10 19:41:35', 1),
(95, 'great', 82, 0, 1, 2, '2015-04-10 19:41:42', '2015-04-10 19:41:42', 1),
(96, 'great', 82, 0, 1, 2, '2015-04-10 19:41:42', '2015-04-10 19:41:42', 1),
(97, 'great', 82, 0, 1, 2, '2015-04-10 19:41:42', '2015-04-10 19:41:42', 1),
(98, 'not', 82, 0, 1, 2, '2015-04-10 19:41:42', '2015-04-10 19:41:42', 1),
(99, 'not', 82, 0, 1, 2, '2015-04-10 19:41:43', '2015-04-10 19:41:43', 1),
(100, 'not', 82, 0, 1, 2, '2015-04-10 19:41:43', '2015-04-10 19:41:43', 1),
(101, 'great', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(102, 'great', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(103, 'great', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(104, 'not', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(105, 'not', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(106, 'not', 82, 0, 1, 2, '2015-04-10 19:43:22', '2015-04-10 19:43:22', 1),
(107, 'great', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(108, 'great', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(109, 'great', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(110, 'not', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(111, 'not', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(112, 'not', 82, 0, 1, 2, '2015-04-10 19:43:25', '2015-04-10 19:43:25', 1),
(113, 'great', 82, 0, 1, 2, '2015-04-10 19:43:56', '2015-04-10 19:43:56', 1),
(114, 'great', 82, 0, 1, 2, '2015-04-10 19:43:56', '2015-04-10 19:43:56', 1),
(115, 'great', 82, 0, 1, 2, '2015-04-10 19:43:56', '2015-04-10 19:43:56', 1),
(116, 'not', 82, 0, 1, 2, '2015-04-10 19:43:56', '2015-04-10 19:43:56', 1),
(117, 'not', 82, 0, 1, 2, '2015-04-10 19:43:57', '2015-04-10 19:43:57', 1),
(118, 'not', 82, 0, 1, 2, '2015-04-10 19:43:57', '2015-04-10 19:43:57', 1),
(119, 'great', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(120, 'great', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(121, 'great', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(122, 'not', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(123, 'not', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(124, 'not', 82, 0, 1, 2, '2015-04-10 19:45:23', '2015-04-10 19:45:23', 1),
(125, 'great', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(126, 'great', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(127, 'great', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(128, 'not', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(129, 'not', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(130, 'not', 82, 0, 1, 2, '2015-04-10 19:46:02', '2015-04-10 19:46:02', 1),
(131, 'great', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(132, 'great', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(133, 'great', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(134, 'not', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(135, 'not', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(136, 'not', 82, 0, 1, 2, '2015-04-10 19:46:37', '2015-04-10 19:46:37', 1),
(137, 'great', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(138, 'great', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(139, 'great', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(140, 'not', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(141, 'not', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(142, 'not', 82, 0, 1, 2, '2015-04-10 19:46:43', '2015-04-10 19:46:43', 1),
(143, 'great', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(144, 'great', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(145, 'great', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(146, 'not', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(147, 'not', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(148, 'not', 82, 0, 1, 2, '2015-04-10 19:47:11', '2015-04-10 19:47:11', 1),
(149, 'great', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(150, 'great', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(151, 'great', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(152, 'not', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(153, 'not', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(154, 'not', 82, 0, 1, 2, '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1),
(155, 'cheif', 83, 0, 1, 2, '2015-04-10 19:50:12', '2015-04-10 19:50:12', 1),
(156, 'staff', 83, 0, 1, 2, '2015-04-10 19:50:12', '2015-04-10 19:50:12', 1),
(157, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:32', '2015-04-10 20:05:32', 1),
(158, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:32', '2015-04-10 20:05:32', 1),
(159, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:38', '2015-04-10 20:05:38', 1),
(160, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:38', '2015-04-10 20:05:38', 1),
(161, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:39', '2015-04-10 20:05:39', 1),
(162, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:39', '2015-04-10 20:05:39', 1),
(163, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:40', '2015-04-10 20:05:40', 1),
(164, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:40', '2015-04-10 20:05:40', 1),
(165, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:41', '2015-04-10 20:05:41', 1),
(166, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:41', '2015-04-10 20:05:41', 1),
(167, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:42', '2015-04-10 20:05:42', 1),
(168, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:42', '2015-04-10 20:05:42', 1),
(169, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:43', '2015-04-10 20:05:43', 1),
(170, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:43', '2015-04-10 20:05:43', 1),
(171, 'cheif', 83, 0, 1, 2, '2015-04-10 20:05:44', '2015-04-10 20:05:44', 1),
(172, 'staff', 83, 0, 1, 2, '2015-04-10 20:05:44', '2015-04-10 20:05:44', 1),
(173, 'tgh', 3, 0, 3, 1, '2015-04-16 00:00:00', '2015-04-09 00:00:00', 1),
(174, 'Panadol', 199, 0, 1, 2, '2015-04-29 15:16:05', '2015-04-29 15:16:05', 1),
(175, 'Paracetamol', 199, 0, 1, 2, '2015-04-29 15:16:05', '2015-04-29 15:16:05', 1),
(176, 'Shing drug', 199, 0, 1, 2, '2015-04-29 15:20:39', '2015-04-29 15:20:39', 1),
(177, 'Panadol', 199, 0, 1, 2, '2015-04-29 15:20:39', '2015-04-29 15:20:39', 1),
(178, 'Paracetamol', 199, 0, 1, 2, '2015-04-29 15:20:39', '2015-04-29 15:20:39', 1),
(179, 'paracetamol', 197, 0, 1, 2, '2015-04-29 15:28:15', '2015-04-29 15:28:15', 1),
(180, 'para', 123, 0, 1, 2, '2015-04-29 15:28:53', '2015-04-29 15:28:53', 1),
(181, 'a', 49, 0, 1, 2, '2015-04-29 15:30:49', '2015-04-29 15:30:49', 1),
(182, 'para', 201, 0, 1, 2, '2015-04-29 15:38:11', '2015-04-29 15:38:11', 1),
(183, 'paracetamol', 201, 0, 1, 2, '2015-04-29 15:38:11', '2015-04-29 15:38:11', 1),
(184, 'work', 201, 0, 1, 2, '2015-04-29 15:39:50', '2015-04-29 15:39:50', 1),
(185, 'must', 123, 0, 1, 2, '2015-04-29 15:40:38', '2015-04-29 15:40:38', 1),
(186, 'yemi', 123, 0, 1, 2, '2015-04-29 15:42:12', '2015-04-29 15:42:12', 1),
(187, 'Insulin', 201, 0, 1, 2, '2015-04-29 15:46:37', '2015-04-29 15:46:37', 1),
(188, 'panadol', 99, 0, 1, 2, '2015-04-29 18:19:25', '2015-04-29 18:19:25', 1),
(189, 'Panadol', 202, 0, 1, 2, '2015-05-05 18:01:58', '2015-05-05 18:01:58', 1),
(190, 'Panadol', 203, 0, 1, 2, '2015-05-05 18:19:34', '2015-05-05 18:19:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prescription_outgoing_drug`
--

CREATE TABLE IF NOT EXISTS `prescription_outgoing_drug` (
`prescription_outgoing_drug_id` int(11) unsigned NOT NULL,
  `prescription_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription_outgoing_drug`
--

INSERT INTO `prescription_outgoing_drug` (`prescription_outgoing_drug_id`, `prescription_id`, `outgoing_drug_id`, `created_date`, `active_fg`) VALUES
(51, 5, 66, '2015-02-25 13:00:43', 1),
(52, 6, 66, '2015-02-25 13:00:43', 1),
(53, 7, 67, '2015-02-25 13:00:43', 1),
(54, 5, 68, '2015-02-25 13:02:05', 1),
(55, 6, 68, '2015-02-25 13:02:05', 1),
(56, 7, 69, '2015-02-25 13:02:05', 1),
(57, 5, 70, '2015-02-25 13:02:11', 1),
(58, 6, 70, '2015-02-25 13:02:11', 1),
(59, 7, 71, '2015-02-25 13:02:11', 1),
(60, 5, 72, '2015-02-25 13:10:55', 1),
(61, 6, 72, '2015-02-25 13:10:55', 1),
(62, 7, 73, '2015-02-25 13:10:55', 1),
(63, 5, 74, '2015-02-25 13:10:58', 1),
(64, 6, 74, '2015-02-25 13:10:58', 1),
(65, 7, 75, '2015-02-25 13:10:58', 1),
(66, 5, 76, '2015-02-25 13:10:59', 1),
(67, 6, 76, '2015-02-25 13:10:59', 1),
(68, 7, 77, '2015-02-25 13:10:59', 1),
(69, 5, 78, '2015-02-25 13:25:26', 1),
(70, 6, 78, '2015-02-25 13:25:26', 1),
(71, 7, 79, '2015-02-25 13:25:26', 1),
(72, 5, 80, '2015-02-25 13:43:24', 1),
(73, 6, 80, '2015-02-25 13:43:24', 1),
(74, 7, 81, '2015-02-25 13:43:24', 1),
(75, 5, 82, '2015-02-25 16:30:09', 1),
(76, 6, 82, '2015-02-25 16:30:09', 1),
(77, 7, 83, '2015-02-25 16:30:09', 1),
(78, 5, 84, '2015-02-25 17:40:21', 1),
(79, 6, 84, '2015-02-25 17:40:21', 1),
(80, 7, 85, '2015-02-25 17:40:21', 1),
(84, 5, 89, '2015-03-02 14:17:17', 1),
(85, 6, 89, '2015-03-02 14:17:17', 1),
(86, 7, 89, '2015-03-02 14:17:17', 1),
(87, 8, 89, '2015-03-02 14:17:17', 1),
(88, 5, 90, '2015-03-02 14:20:50', 1),
(89, 6, 90, '2015-03-02 14:20:50', 1),
(90, 5, 91, '2015-03-02 14:55:19', 1),
(91, 6, 91, '2015-03-02 14:55:19', 1),
(92, 7, 91, '2015-03-02 14:55:19', 1),
(93, 5, 92, '2015-03-02 15:00:13', 1),
(94, 6, 92, '2015-03-02 15:00:13', 1),
(95, 5, 93, '2015-03-02 15:12:13', 1),
(96, 6, 93, '2015-03-02 15:12:13', 1),
(97, 5, 94, '2015-03-02 15:26:54', 1),
(98, 6, 94, '2015-03-02 15:26:54', 1),
(99, 5, 95, '2015-03-02 16:23:16', 1),
(100, 6, 95, '2015-03-02 16:23:16', 1),
(101, 5, 96, '2015-03-02 16:24:51', 1),
(102, 6, 96, '2015-03-02 16:24:51', 1),
(103, 5, 97, '2015-03-02 16:30:07', 1),
(104, 6, 97, '2015-03-02 16:30:07', 1),
(105, 5, 98, '2015-03-02 16:30:50', 1),
(106, 6, 98, '2015-03-02 16:30:50', 1),
(107, 5, 99, '2015-03-02 16:31:45', 1),
(108, 6, 99, '2015-03-02 16:31:45', 1),
(109, 5, 100, '2015-03-02 16:33:45', 1),
(110, 6, 100, '2015-03-02 16:33:45', 1),
(111, 5, 101, '2015-03-02 16:41:03', 1),
(112, 6, 101, '2015-03-02 16:41:03', 1),
(113, 5, 102, '2015-03-02 16:42:40', 1),
(114, 6, 102, '2015-03-02 16:42:40', 1),
(115, 7, 102, '2015-03-02 16:42:40', 1),
(116, 7, 103, '2015-03-04 14:54:32', 1),
(117, 6, 104, '2015-03-04 15:07:00', 1),
(118, 5, 105, '2015-03-04 15:08:33', 1),
(119, 6, 105, '2015-03-04 15:08:33', 1),
(120, 7, 105, '2015-03-04 15:08:33', 1),
(121, 8, 105, '2015-03-04 15:08:33', 1),
(122, 5, 106, '2015-04-12 18:22:30', 1),
(123, 6, 106, '2015-04-12 18:22:30', 1),
(124, 7, 107, '2015-04-12 18:22:30', 1),
(125, 9, 108, '2015-04-29 18:05:15', 1),
(126, 13, 109, '2015-05-26 13:47:40', 1),
(127, 11, 110, '2015-05-26 13:52:47', 1),
(128, 10, 110, '2015-05-26 13:52:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
`profile_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middlename` varchar(25) NOT NULL,
  `department_id` int(11) unsigned NOT NULL,
  `work_address` varchar(150) NOT NULL,
  `home_address` varchar(150) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `sex` enum('MALE','FEMALE') NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `userid`, `surname`, `firstname`, `middlename`, `department_id`, `work_address`, `home_address`, `telephone`, `sex`, `height`, `weight`, `birth_date`, `created_date`, `modified_date`, `active_fg`) VALUES
(7, 1, 'mbakwe', 'caleb', 'chukwuezugo', 1, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '+2348030420046', 'MALE', 2, 80, '2015-02-06', '2015-02-06 12:10:49', '2015-02-06 12:10:49', 1),
(9, 2, 'moses', 'adebayo', 'olajuwon', 2, '23b ezeagu lane, ajegunle lagos', '23b ezeagu lane, ajegunle lagos', '+2348162886288', 'MALE', 120, 75, '1979-09-15', '2015-02-10 12:27:27', '2015-02-10 12:27:27', 1),
(10, 3, 'adewoye', 'abiodun', 'adeola', 4, '23b ezeagu lane, ajegunle lagos', '23b ezeagu lane, ajegunle lagos', '+2348162886288', 'MALE', 12, 123, '2015-02-20', '2015-02-19 16:47:22', '2015-02-19 16:47:22', 1),
(11, 4, 'okobia', 'joshua', 'o', 2, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '+2345678990', 'MALE', 2, 75, '2015-05-18', '2015-04-12 17:16:32', '2015-04-12 17:16:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `radiology`
--

CREATE TABLE IF NOT EXISTS `radiology` (
`radiology_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `ward_clinic_id` varchar(25) DEFAULT NULL,
  `xray_case_id` int(11) DEFAULT NULL,
  `xray_size_id` int(11) DEFAULT NULL,
  `treatment_id` int(11) unsigned DEFAULT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `consultant_in_charge` varchar(35) DEFAULT NULL,
  `checked_by` varchar(35) DEFAULT NULL,
  `radiographers_note` text,
  `radiologists_report` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `lmp` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radiology`
--

INSERT INTO `radiology` (`radiology_id`, `doctor_id`, `lab_attendant_id`, `ward_clinic_id`, `xray_case_id`, `xray_size_id`, `treatment_id`, `encounter_id`, `consultant_in_charge`, `checked_by`, `radiographers_note`, `radiologists_report`, `created_date`, `modified_date`, `lmp`, `active_fg`, `status_id`) VALUES
(1, 1, 4, '', 1, 1, 2, 0, '', '', '', '', '2015-04-10 14:43:57', '2015-04-16 15:34:43', '', 1, 6),
(2, 1, 1, '1', 2, 2, 1, 0, 'Die', 'Caleb', 'E', 'Sure', '2015-04-10 14:47:34', '2015-04-29 13:59:17', 'LMP1', 1, 7),
(3, 1, 2, '', 3, 3, 3, 0, '', '', '', '', '2015-04-10 14:47:43', '2015-04-29 13:43:32', '', 1, 6),
(4, 1, 1, '1', 2, 4, 59, 0, 'No', 'Kay Lee', 'This ', 'Thing', '2015-04-10 15:08:55', '2015-04-29 14:06:31', '', 1, 7),
(5, 1, 1, '', 0, 0, 47, 0, '', '', '', '', '2015-04-29 14:26:34', '2015-04-29 17:17:18', '', 1, 6),
(6, 1, NULL, NULL, NULL, NULL, 200, 0, NULL, NULL, NULL, NULL, '2015-04-29 18:09:20', '2015-04-29 18:09:20', NULL, 1, 5),
(7, 1, 1, '12', 2, 0, 49, 0, 'Mbakwe Caleb', 'Mbakwe Caleb', '2 days to heal', 'Ligamentolisis', '2015-04-29 18:15:04', '2015-04-29 18:17:35', '', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `radiology_request`
--

CREATE TABLE IF NOT EXISTS `radiology_request` (
`radiology_request_id` int(11) NOT NULL,
  `radiology_id` int(11) NOT NULL,
  `clinical_diagnosis_details` varchar(100) DEFAULT NULL,
  `previous_operation` varchar(25) DEFAULT NULL,
  `any_known_allergies` varchar(25) DEFAULT NULL,
  `previous_xray` tinyint(4) DEFAULT NULL,
  `xray_number` varchar(7) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radiology_request`
--

INSERT INTO `radiology_request` (`radiology_request_id`, `radiology_id`, `clinical_diagnosis_details`, `previous_operation`, `any_known_allergies`, `previous_xray`, `xray_number`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 'something', '', '', 0, '0', '2015-04-10 14:43:57', '2015-04-16 15:34:43', 1),
(2, 2, 'tintin', 'None', 'None', 1, '12345', '2015-04-10 14:47:34', '2015-04-29 13:59:17', 1),
(3, 3, 'tintin', '', '', 0, '0', '2015-04-10 14:47:43', '2015-04-29 13:43:32', 1),
(4, 4, 'Shingaling', 'None', 'None', 0, '0', '2015-04-10 15:08:55', '2015-04-29 14:06:31', 1),
(5, 5, 'God', '', '', 0, '0', '2015-04-29 14:26:34', '2015-04-29 17:17:18', 1),
(6, 6, 'test', NULL, NULL, NULL, NULL, '2015-04-29 18:09:20', '2015-04-29 18:09:20', 1),
(7, 7, 'test', 'None', 'None', 0, '0', '2015-04-29 18:15:04', '2015-04-29 18:17:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
`roster_id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `dept_id` int(11) unsigned NOT NULL,
  `duty` int(11) NOT NULL,
  `duty_date` date NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `active_fg` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `roster`
--

INSERT INTO `roster` (`roster_id`, `user_id`, `created_by`, `dept_id`, `duty`, `duty_date`, `created_date`, `modified_date`, `modified_by`, `active_fg`) VALUES
(74, 2, 2, 2, 8, '2015-02-09', '2015-02-19 00:27:16', '2015-02-20 16:22:42', 1, 0),
(75, 2, 2, 2, 8, '2015-02-02', '2015-02-19 00:28:24', '2015-02-20 16:22:26', 1, 0),
(76, 1, 2, 1, 8, '2015-02-03', '2015-02-19 00:29:27', '2015-02-20 16:22:32', 1, 0),
(77, 2, 2, 2, 10, '2015-02-02', '2015-02-19 01:44:19', '2015-02-20 16:22:28', 1, 0),
(78, 2, 1, 2, 9, '2015-02-09', '2015-02-19 01:48:25', '2015-02-20 16:22:46', 1, 0),
(79, 2, 1, 2, 9, '2015-02-03', '2015-02-19 01:48:48', '2015-02-20 16:22:30', 1, 0),
(80, 1, 1, 1, 8, '2015-02-19', '2015-02-19 15:27:00', '2015-02-20 16:23:01', 1, 0),
(81, 1, 1, 1, 10, '2015-02-20', '2015-02-19 15:27:03', '2015-02-20 16:23:03', 1, 0),
(82, 1, 1, 1, 9, '2015-02-21', '2015-02-19 15:27:06', '2015-02-20 16:23:06', 1, 0),
(83, 1, 1, 1, 8, '2015-02-04', '2015-02-19 15:42:25', '2015-02-20 16:22:36', 1, 0),
(84, 1, 1, 1, 9, '2015-03-02', '2015-02-19 15:42:50', '2015-02-20 16:23:22', 1, 0),
(85, 1, 1, 1, 10, '2015-02-10', '2015-02-19 15:44:45', '2015-02-20 16:22:53', 1, 0),
(86, 1, 1, 1, 10, '2015-03-03', '2015-02-19 15:45:09', '2015-02-20 16:23:29', 1, 0),
(87, 1, 1, 1, 10, '2015-02-12', '2015-02-19 15:45:36', '2015-02-20 16:22:55', 1, 0),
(88, 1, 1, 1, 10, '2015-02-05', '2015-02-19 15:45:51', '2015-02-20 16:22:38', 1, 0),
(89, 1, 1, 1, 10, '2015-03-04', '2015-02-19 15:46:35', '2015-02-20 16:23:37', 1, 0),
(90, 3, 1, 4, 10, '2015-02-02', '2015-02-19 16:50:32', '2015-02-20 16:22:25', 1, 0),
(91, 3, 1, 4, 10, '2015-02-10', '2015-02-19 16:50:35', '2015-02-20 16:22:51', 1, 0),
(92, 3, 1, 4, 10, '2015-02-19', '2015-02-19 16:50:38', '2015-02-20 16:22:59', 1, 0),
(93, 3, 1, 4, 10, '2015-02-13', '2015-02-19 16:50:41', '2015-02-20 16:22:57', 1, 0),
(94, 2, 1, 2, 9, '2015-02-04', '2015-02-19 16:50:44', '2015-02-20 16:22:34', 1, 0),
(95, 2, 1, 2, 9, '2015-02-06', '2015-02-19 16:50:47', '2015-02-20 16:22:40', 1, 0),
(96, 2, 1, 2, 9, '2015-02-27', '2015-02-19 16:50:50', '2015-02-20 16:23:09', 1, 0),
(97, 1, 1, 1, 8, '2015-01-25', '2015-02-20 16:17:19', '2015-02-20 16:24:56', 1, 0),
(98, 1, 1, 1, 8, '2015-01-25', '2015-02-20 16:17:23', '2015-02-20 16:17:23', NULL, 1),
(99, 1, 1, 1, 9, '2015-01-25', '2015-02-20 16:17:32', '2015-02-20 16:17:32', NULL, 1),
(100, 1, 1, 1, 10, '2015-01-25', '2015-02-20 16:17:34', '2015-02-20 16:17:34', NULL, 1),
(101, 2, 1, 2, 8, '2015-01-26', '2015-02-20 16:17:42', '2015-02-20 16:17:42', NULL, 1),
(102, 2, 1, 2, 8, '2015-01-26', '2015-02-20 16:17:44', '2015-02-20 16:25:00', 1, 0),
(103, 2, 1, 2, 8, '2015-01-26', '2015-02-20 16:17:46', '2015-02-20 16:17:46', NULL, 1),
(104, 2, 1, 2, 8, '2015-01-26', '2015-02-20 16:17:48', '2015-02-20 16:17:48', NULL, 1),
(105, 2, 1, 2, 8, '2015-01-26', '2015-02-20 16:17:50', '2015-02-20 16:17:50', NULL, 1),
(106, 2, 1, 2, 9, '2015-01-26', '2015-02-20 16:17:52', '2015-02-20 16:17:52', NULL, 1),
(107, 2, 1, 2, 9, '2015-01-26', '2015-02-20 16:17:54', '2015-02-20 16:17:54', NULL, 1),
(108, 2, 1, 2, 10, '2015-01-26', '2015-02-20 16:17:56', '2015-02-20 16:24:58', 1, 0),
(109, 2, 1, 2, 10, '2015-01-26', '2015-02-20 16:18:05', '2015-02-20 16:18:05', NULL, 1),
(110, 2, 1, 2, 10, '2015-01-26', '2015-02-20 16:18:12', '2015-02-20 16:18:12', NULL, 1),
(111, 1, 1, 1, 8, '2015-01-25', '2015-02-20 16:19:11', '2015-02-20 16:19:11', NULL, 1),
(112, 1, 1, 1, 9, '2015-01-25', '2015-02-20 16:19:13', '2015-02-20 16:19:13', NULL, 1),
(113, 1, 1, 1, 10, '2015-01-25', '2015-02-20 16:19:15', '2015-02-20 16:19:15', NULL, 1),
(114, 1, 1, 1, 10, '2015-01-26', '2015-02-20 16:19:17', '2015-02-20 16:19:17', NULL, 1),
(115, 1, 1, 1, 9, '2015-01-26', '2015-02-20 16:19:19', '2015-02-20 16:19:19', NULL, 1),
(116, 1, 1, 1, 8, '2015-01-26', '2015-02-20 16:19:23', '2015-02-20 16:19:23', NULL, 1),
(117, 1, 1, 1, 9, '2015-03-02', '2015-02-20 16:20:45', '2015-02-20 16:23:25', 1, 0),
(118, 1, 1, 1, 10, '2015-03-03', '2015-02-20 16:21:05', '2015-02-20 16:23:32', 1, 0),
(119, 2, 1, 2, 10, '2015-03-04', '2015-02-20 16:21:10', '2015-02-20 16:23:35', 1, 0),
(120, 3, 1, 4, 8, '2015-03-01', '2015-02-20 16:21:18', '2015-02-20 16:23:15', 1, 0),
(121, 2, 1, 2, 9, '2015-03-01', '2015-02-20 16:21:21', '2015-02-20 16:23:18', 1, 0),
(122, 2, 1, 2, 10, '2015-03-01', '2015-02-20 16:21:23', '2015-02-20 16:23:20', 1, 0),
(123, 1, 1, 1, 10, '2015-03-02', '2015-02-20 16:21:56', '2015-02-20 16:23:27', 1, 0),
(124, 1, 1, 1, 8, '2015-02-01', '2015-02-23 12:13:01', '2015-02-23 12:13:01', NULL, 1),
(125, 1, 1, 1, 8, '2015-02-03', '2015-02-23 12:13:06', '2015-02-27 10:52:13', 1, 0),
(126, 2, 1, 2, 8, '2015-02-17', '2015-02-23 12:13:10', '2015-02-23 12:13:10', NULL, 1),
(127, 3, 1, 4, 10, '2015-02-19', '2015-02-23 12:13:21', '2015-02-23 12:13:21', NULL, 1),
(128, 1, 1, 1, 8, '2015-02-03', '2015-02-27 10:52:21', '2015-02-27 10:52:21', NULL, 1),
(129, 2, 1, 2, 9, '2015-02-09', '2015-03-03 11:50:46', '2015-03-03 11:50:46', NULL, 1),
(130, 2, 1, 2, 9, '2015-02-01', '2015-03-23 11:25:01', '2015-03-23 11:25:01', NULL, 1),
(131, 3, 1, 4, 10, '2015-02-08', '2015-03-23 11:25:07', '2015-03-23 11:25:07', NULL, 1),
(132, 1, 1, 1, 9, '2015-02-04', '2015-04-29 17:59:30', '2015-04-29 17:59:50', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_permission`
--

CREATE TABLE IF NOT EXISTS `staff_permission` (
`staff_permission_id` int(11) NOT NULL,
  `staff_permission` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_permission`
--

INSERT INTO `staff_permission` (`staff_permission_id`, `staff_permission`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'read_only', '2015-01-26 12:44:17', '2015-01-26 12:44:20', 1),
(2, 'read_write', '2015-01-26 12:46:14', '2015-01-26 12:46:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_role`
--

CREATE TABLE IF NOT EXISTS `staff_role` (
`staff_role_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `staff_role` varchar(100) NOT NULL,
  `role_label` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_role`
--

INSERT INTO `staff_role` (`staff_role_id`, `created_date`, `modified_date`, `staff_role`, `role_label`, `active_fg`) VALUES
(1, '2015-01-26 12:24:47', '2015-01-26 12:24:54', 'administrator', 'adminisrator', 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'doctor', 'doctor', 1),
(3, '2015-01-26 12:26:48', '2015-01-26 12:26:52', 'pharmacist', 'pharmacist', 1),
(4, '2015-01-28 13:00:36', '2015-01-28 13:00:42', 'medical_records', 'medical records', 1),
(5, '2015-01-28 13:01:20', '2015-01-28 13:01:25', 'permission', 'permission_granter', 1),
(6, '2015-01-28 13:01:58', '2015-01-28 13:02:01', 'urine', 'urine test conductor', 1),
(7, '2015-01-28 13:02:40', '2015-01-28 13:02:43', 'visual', 'visual test conductor', 1),
(8, '2015-01-28 13:02:59', '2015-01-28 13:03:03', 'xray ', 'xray test conductor', 1),
(9, '2015-01-28 13:03:32', '2015-01-28 13:03:35', 'health_scheme', 'health scheme', 1),
(10, '2015-01-28 13:04:03', '2015-01-28 13:04:06', 'parasitology', 'parasitology conductor', 1),
(11, '2015-01-28 13:04:24', '2015-01-28 13:04:26', 'chemical_pathology', 'chemical pathology conductor', 1),
(12, '2015-01-28 13:05:02', '2015-01-28 13:05:07', 'add_staff', 'staff adding officer', 1),
(13, '2015-01-28 13:05:30', '2015-01-28 13:05:33', 'staff_reg', 'staff clearance', 1),
(14, '2015-01-28 13:05:51', '2015-01-28 13:05:54', 'treatment_recrods', 'treatment history', 1),
(15, '2015-02-16 01:04:09', '2015-02-16 00:00:00', 'roster', 'roster creator', 1),
(16, '2015-03-12 10:56:06', '2015-03-12 10:56:10', 'admission_officer', 'admission officer', 1),
(17, '2015-04-17 13:22:07', '2015-04-17 13:22:11', 'haematology', 'haematology conductor', 1),
(18, '2015-04-29 13:41:44', '2015-04-29 13:41:47', 'laboratory', 'laboratory conductor', 1),
(19, '2015-05-06 13:53:29', '2015-05-06 13:53:32', 'backup', 'backup officer', 1),
(20, '2015-05-18 13:22:04', '2015-05-18 13:22:06', 'billing', 'billing officer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`status_id` int(11) NOT NULL,
  `status_name` varchar(15) CHARACTER SET utf8 NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`, `active_fg`) VALUES
(1, 'active', 1),
(2, 'inactive', 1),
(3, 'unclear', 1),
(4, 'cleared', 1),
(5, 'pending', 1),
(6, 'processing', 1),
(7, 'completed', 1),
(8, 'morning_duty', 1),
(9, 'afternoon_duty', 1),
(10, 'evening_duty', 1);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
`treatment_id` int(11) unsigned NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `consultation` text NOT NULL,
  `symptoms` text NOT NULL,
  `diagnosis` text NOT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `treatment_status` int(11) unsigned NOT NULL DEFAULT '1',
  `bill_status` int(11) unsigned NOT NULL DEFAULT '1',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `doctor_id`, `patient_id`, `consultation`, `symptoms`, `diagnosis`, `comments`, `created_date`, `modified_date`, `treatment_status`, `bill_status`, `active_fg`) VALUES
(1, 1, 14, '', 'Head ache and body ache', 'Fever', NULL, '2015-02-20 00:00:00', '2015-02-20 00:00:00', 1, 1, 1),
(2, 1, 2, 'Lorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior d', 'Lorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior d', 'Lorem ipsum vi et sallum in jior d', 'Lorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior dLorem ipsum vi et sallum in jior d', '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1, 1, 1),
(3, 2, 2, '', '', '', NULL, '2015-03-26 00:00:00', '2015-03-26 00:00:00', 2, 2, 1),
(4, 2, 2, '', '', '', '', '2015-04-01 12:27:49', '2015-04-01 12:27:49', 2, 2, 1),
(5, 2, 8, '', '', '', '', '2015-04-01 12:30:04', '2015-04-01 12:30:04', 2, 2, 1),
(6, 2, 2, '', '', '', '', '2015-04-01 12:30:09', '2015-04-01 12:30:09', 2, 2, 1),
(7, 2, 8, '', '', '', '', '2015-04-01 12:30:58', '2015-04-01 12:30:58', 2, 2, 1),
(8, 2, 2, '', '', '', '', '2015-04-01 12:31:04', '2015-04-01 12:31:04', 2, 1, 1),
(9, 2, 2, '', '', '', '', '2015-04-01 12:32:33', '2015-04-01 12:32:33', 1, 1, 1),
(10, 2, 2, '', '', '', '', '2015-04-01 12:39:07', '2015-04-01 12:39:07', 1, 1, 1),
(11, 2, 2, '', '', '', '', '2015-04-01 12:39:55', '2015-04-01 12:39:55', 1, 1, 1),
(12, 2, 2, '', '', '', '', '2015-04-01 12:45:05', '2015-04-01 12:45:05', 1, 1, 1),
(13, 2, 2, '', '', '', '', '2015-04-01 12:45:41', '2015-04-01 12:45:41', 1, 1, 1),
(14, 2, 2, '', '', '', '', '2015-04-01 12:46:06', '2015-04-01 12:46:06', 1, 1, 1),
(15, 2, 8, '', '', '', '', '2015-04-01 12:46:09', '2015-04-01 12:46:09', 1, 1, 1),
(16, 2, 2, '', '', '', '', '2015-04-01 12:47:50', '2015-04-01 12:47:50', 1, 1, 1),
(17, 2, 2, '', '', '', '', '2015-04-01 12:52:47', '2015-04-01 12:52:47', 1, 1, 1),
(18, 2, 2, '', '', '', '', '2015-04-01 13:04:03', '2015-04-01 13:04:03', 1, 1, 1),
(19, 2, 2, '', '', '', '', '2015-04-01 13:11:12', '2015-04-01 13:11:12', 1, 1, 1),
(20, 2, 8, '', '', '', '', '2015-04-01 13:16:36', '2015-04-01 13:16:36', 1, 1, 1),
(21, 2, 8, '', '', '', '', '2015-04-01 13:18:52', '2015-04-01 13:18:52', 1, 1, 1),
(22, 2, 8, '', '', '', '', '2015-04-01 13:22:13', '2015-04-01 13:22:13', 1, 1, 1),
(23, 2, 8, '', '', '', '', '2015-04-01 13:23:43', '2015-04-01 13:23:43', 1, 1, 1),
(24, 2, 8, '', '', '', '', '2015-04-01 13:26:19', '2015-04-01 13:26:19', 1, 1, 1),
(25, 2, 8, '', '', '', '', '2015-04-01 13:28:32', '2015-04-01 13:28:32', 1, 1, 1),
(26, 2, 2, '', '', '', '', '2015-04-01 14:32:47', '2015-04-01 14:32:47', 1, 1, 1),
(27, 2, 2, '', '', '', '', '2015-04-01 15:23:49', '2015-04-01 15:23:49', 1, 1, 1),
(28, 2, 2, 'rgregr', 'drgrdg', 'rdgrg', 'dgrdg', '2015-04-01 15:27:47', '2015-04-01 15:27:47', 1, 1, 1),
(29, 2, 2, '', '', '', '', '2015-04-01 15:39:45', '2015-04-01 15:39:45', 1, 1, 1),
(30, 2, 2, 'v nuui9v hd', 'iughiuofbfd', 'ibfgibhfiobhfd', 'buifdvubhi', '2015-04-01 15:39:53', '2015-04-01 15:39:53', 1, 1, 1),
(31, 2, 2, 'great', 'nice', 'fine', 'cool', '2015-04-10 19:38:20', '2015-04-10 19:38:20', 1, 1, 1),
(32, 2, 2, 'bfgbfbf', 'fbdfbfd', 'bfdbdf', 'fbdfbfd', '2015-04-01 15:41:46', '2015-04-01 15:41:46', 1, 1, 1),
(33, 2, 2, '', '', '', '', '2015-04-02 13:10:35', '2015-04-02 13:10:35', 1, 1, 1),
(34, 2, 2, 'bfgbfbf', 'fbdfbfd', 'bfdbdf', 'fbdfbfd', '2015-04-02 13:18:46', '2015-04-02 13:18:46', 1, 1, 1),
(35, 2, 2, 'bfgbfbf', 'fbdfbfd', 'bfdbdf', 'fbdfbfd', '2015-04-02 13:19:26', '2015-04-02 13:19:26', 1, 2, 1),
(36, 2, 2, 'cxjhbcuyhds', 'ifvhuv', 'cdiuchd', 'udbhsui', '2015-04-02 13:49:31', '2015-04-02 13:49:31', 1, 1, 1),
(37, 2, 2, 'cxjhbcuyhds', 'ifvhuv', 'cdiuchd', 'udbhsui', '2015-04-02 13:21:27', '2015-04-02 13:21:27', 1, 1, 1),
(38, 2, 2, 'Oduguwa', 'rgrg', 'rghrgrg', 'hgreger', '2015-04-02 13:51:10', '2015-04-02 13:51:10', 1, 1, 1),
(39, 2, 2, '', '', '', '', '2015-04-02 13:56:05', '2015-04-02 13:56:05', 1, 1, 1),
(40, 2, 2, '', '', '', '', '2015-04-02 13:57:22', '2015-04-02 13:57:22', 1, 1, 1),
(41, 2, 2, '', '', '', '', '2015-04-02 13:57:54', '2015-04-02 13:57:54', 1, 1, 1),
(42, 2, 2, '', '', '', '', '2015-04-02 13:58:09', '2015-04-02 13:58:09', 1, 1, 1),
(43, 2, 2, '', '', '', '', '2015-04-02 14:07:20', '2015-04-02 14:07:20', 1, 1, 1),
(44, 2, 2, '', '', '', '', '2015-04-02 14:07:48', '2015-04-02 14:07:48', 1, 1, 1),
(45, 2, 2, '', '', '', '', '2015-04-02 14:08:24', '2015-04-02 14:08:24', 1, 1, 1),
(46, 1, 2, '', '', '', '', '2015-04-02 17:02:29', '2015-04-02 17:02:29', 1, 1, 1),
(47, 1, 4, 'Jisos', 'O ga o', 'Jisos', 'Christ', '2015-04-29 14:30:47', '2015-04-29 14:30:47', 2, 1, 1),
(48, 1, 2, '', '', '', '', '2015-04-02 17:12:24', '2015-04-02 17:12:24', 1, 1, 1),
(49, 1, 4, 'This ', 'test', 'jisos', 'is ', '2015-04-29 15:30:49', '2015-04-29 15:30:49', 2, 1, 1),
(50, 1, 2, '', '', '', '', '2015-04-02 17:18:26', '2015-04-02 17:18:26', 1, 1, 1),
(51, 1, 2, '', '', '', '', '2015-04-02 18:10:55', '2015-04-02 18:10:55', 1, 1, 1),
(52, 1, 2, '', '', '', '', '2015-04-02 18:12:15', '2015-04-02 18:12:15', 1, 1, 1),
(53, 1, 2, '', '', '', '', '2015-04-02 18:14:11', '2015-04-02 18:14:11', 1, 1, 1),
(54, 1, 2, '', '', '', '', '2015-04-02 18:21:39', '2015-04-02 18:21:39', 1, 1, 1),
(55, 1, 2, '', '', '', '', '2015-04-02 18:22:41', '2015-04-02 18:22:41', 1, 1, 1),
(56, 1, 2, '', '', '', '', '2015-04-02 18:23:22', '2015-04-02 18:23:22', 1, 1, 1),
(57, 1, 2, '', '', '', '', '2015-04-02 18:45:09', '2015-04-02 18:45:09', 1, 1, 1),
(58, 1, 2, '', '', '', '', '2015-04-10 15:00:32', '2015-04-10 15:00:32', 1, 1, 1),
(59, 1, 2, '', '', '', '', '2015-04-10 15:08:43', '2015-04-10 15:08:43', 1, 1, 1),
(60, 1, 2, '', '', '', '', '2015-04-10 15:14:32', '2015-04-10 15:14:32', 1, 1, 1),
(61, 1, 2, '', '', '', '', '2015-04-10 15:18:07', '2015-04-10 15:18:07', 1, 1, 1),
(62, 1, 2, '', '', '', '', '2015-04-10 15:51:39', '2015-04-10 15:51:39', 1, 1, 1),
(63, 1, 2, '', '', '', '', '2015-04-10 16:02:27', '2015-04-10 16:02:27', 1, 1, 1),
(64, 1, 2, '', '', '', '', '2015-04-10 16:04:35', '2015-04-10 16:04:35', 1, 1, 1),
(65, 1, 2, '', '', '', '', '2015-04-10 16:05:42', '2015-04-10 16:05:42', 1, 1, 1),
(66, 1, 2, '', '', '', '', '2015-04-10 16:06:37', '2015-04-10 16:06:37', 1, 1, 1),
(67, 1, 2, '', '', '', '', '2015-04-10 16:07:01', '2015-04-10 16:07:01', 1, 1, 1),
(68, 1, 2, '', '', '', '', '2015-04-10 16:09:25', '2015-04-10 16:09:25', 1, 1, 1),
(69, 1, 2, '', '', '', '', '2015-04-10 16:10:07', '2015-04-10 16:10:07', 1, 1, 1),
(70, 1, 2, '', '', '', '', '2015-04-10 16:11:08', '2015-04-10 16:11:08', 1, 1, 1),
(71, 1, 2, '', '', '', '', '2015-04-10 16:11:13', '2015-04-10 16:11:13', 1, 1, 1),
(72, 1, 2, '', '', '', '', '2015-04-10 16:12:56', '2015-04-10 16:12:56', 1, 1, 1),
(73, 1, 2, '', '', '', '', '2015-04-10 16:13:54', '2015-04-10 16:13:54', 1, 1, 1),
(74, 1, 2, '', '', '', '', '2015-04-10 16:20:32', '2015-04-10 16:20:32', 1, 1, 1),
(75, 1, 2, '', '', '', '', '2015-04-10 16:20:42', '2015-04-10 16:20:42', 1, 1, 1),
(76, 1, 2, '', '', '', '', '2015-04-10 16:24:41', '2015-04-10 16:24:41', 1, 1, 1),
(77, 1, 2, '', '', '', '', '2015-04-10 16:25:30', '2015-04-10 16:25:30', 1, 1, 1),
(78, 1, 2, '', '', '', '', '2015-04-10 16:27:56', '2015-04-10 16:27:56', 1, 1, 1),
(79, 1, 2, '', '', '', '', '2015-04-10 16:28:18', '2015-04-10 16:28:18', 1, 1, 1),
(80, 1, 2, '', '', '', '', '2015-04-10 16:28:39', '2015-04-10 16:28:39', 1, 1, 1),
(81, 1, 2, '', '', '', '', '2015-04-10 17:13:37', '2015-04-10 17:13:37', 1, 1, 1),
(82, 2, 6, 'nice', 'not', 'fine', 'not', '2015-04-10 19:47:15', '2015-04-10 19:47:15', 1, 1, 1),
(83, 2, 8, 'babay', 'child', 'parent', 'junior', '2015-04-10 20:05:44', '2015-04-10 20:05:44', 1, 1, 1),
(84, 1, 2, '', '', '', '', '2015-04-12 13:10:18', '2015-04-12 13:10:18', 1, 1, 1),
(85, 1, 2, '', '', '', '', '2015-04-12 13:14:29', '2015-04-12 13:14:29', 1, 1, 1),
(86, 1, 2, '', '', '', '', '2015-04-12 13:17:17', '2015-04-12 13:17:17', 1, 1, 1),
(87, 1, 2, '', '', '', '', '2015-04-12 13:17:54', '2015-04-12 13:17:54', 1, 1, 1),
(88, 1, 2, '', '', '', '', '2015-04-12 13:18:22', '2015-04-12 13:18:22', 1, 1, 1),
(89, 1, 2, '', '', '', '', '2015-04-12 13:19:20', '2015-04-12 13:19:20', 1, 1, 1),
(90, 1, 2, '', '', '', '', '2015-04-12 13:22:30', '2015-04-12 13:22:30', 1, 1, 1),
(91, 1, 2, '', '', '', '', '2015-04-12 13:22:55', '2015-04-12 13:22:55', 1, 1, 1),
(92, 1, 2, '', '', '', '', '2015-04-12 13:23:16', '2015-04-12 13:23:16', 1, 1, 1),
(93, 1, 2, '', '', '', '', '2015-04-12 13:23:58', '2015-04-12 13:23:58', 1, 1, 1),
(94, 1, 2, '', '', '', '', '2015-04-12 13:24:28', '2015-04-12 13:24:28', 1, 1, 1),
(95, 1, 2, '', '', '', '', '2015-04-12 13:25:04', '2015-04-12 13:25:04', 1, 1, 1),
(96, 1, 2, 'Hoping that everyhing is now fine', 'For 3 weeks now', 'Bomb', 'Al ham du li lahi', '2015-04-12 13:28:07', '2015-04-12 13:28:07', 1, 1, 1),
(97, 1, 2, '', '', '', '', '2015-04-12 13:52:02', '2015-04-12 13:52:02', 1, 1, 1),
(98, 1, 2, '', '', '', '', '2015-04-12 13:54:00', '2015-04-12 13:54:00', 1, 1, 1),
(99, 1, 4, 'asdf', 'symptom', 'malaria', 'fssdshg', '2015-04-29 18:19:25', '2015-04-29 18:19:25', 1, 1, 1),
(100, 1, 4, '', '', '', '', '2015-04-12 13:55:00', '2015-04-12 13:55:00', 1, 1, 1),
(101, 1, 2, '', '', '', '', '2015-04-12 13:55:16', '2015-04-12 13:55:16', 1, 1, 1),
(102, 1, 2, '', '', '', '', '2015-04-12 13:56:55', '2015-04-12 13:56:55', 1, 1, 1),
(103, 1, 2, '', '', '', '', '2015-04-12 13:57:55', '2015-04-12 13:57:55', 1, 1, 1),
(104, 1, 2, '', '', '', '', '2015-04-12 14:01:17', '2015-04-12 14:01:17', 1, 1, 1),
(105, 1, 2, '', '', '', '', '2015-04-12 14:02:44', '2015-04-12 14:02:44', 1, 1, 1),
(106, 1, 4, '', '', '', '', '2015-04-12 15:26:00', '2015-04-12 15:26:00', 1, 1, 1),
(107, 1, 2, '', '', '', '', '2015-04-12 15:26:06', '2015-04-12 15:26:06', 1, 1, 1),
(108, 1, 2, '', '', '', '', '2015-04-12 15:37:27', '2015-04-12 15:37:27', 1, 1, 1),
(109, 1, 4, '', '', '', '', '2015-04-12 16:23:50', '2015-04-12 16:23:50', 1, 1, 1),
(110, 1, 2, '', '', '', '', '2015-04-12 16:24:15', '2015-04-12 16:24:15', 1, 1, 1),
(111, 1, 4, '', '', '', '', '2015-04-12 16:25:32', '2015-04-12 16:25:32', 1, 1, 1),
(112, 1, 4, '', '', '', '', '2015-04-12 16:25:52', '2015-04-12 16:25:52', 1, 1, 1),
(113, 1, 2, '', '', '', '', '2015-04-12 16:26:18', '2015-04-12 16:26:18', 1, 1, 1),
(114, 1, 4, '', '', '', '', '2015-04-12 16:28:29', '2015-04-12 16:28:29', 1, 1, 1),
(115, 1, 4, '', '', '', '', '2015-04-13 13:18:07', '2015-04-13 13:18:07', 1, 1, 1),
(116, 1, 4, '', '', '', '', '2015-04-13 13:19:10', '2015-04-13 13:19:10', 1, 1, 1),
(117, 1, 4, '', '', '', '', '2015-04-13 13:19:31', '2015-04-13 13:19:31', 1, 1, 1),
(118, 1, 4, '', '', '', '', '2015-04-13 13:19:34', '2015-04-13 13:19:34', 1, 1, 1),
(119, 1, 4, '', '', '', '', '2015-04-13 13:19:34', '2015-04-13 13:19:34', 1, 1, 1),
(120, 1, 4, '', '', '', '', '2015-04-13 13:19:38', '2015-04-13 13:19:38', 1, 1, 1),
(121, 1, 4, '', '', '', '', '2015-04-13 13:21:41', '2015-04-13 13:21:41', 1, 1, 1),
(122, 1, 4, '', '', '', '', '2015-04-13 13:21:43', '2015-04-13 13:21:43', 1, 1, 1),
(123, 1, 5, 'According', 'And', 'Goke', 'to', '2015-04-29 15:42:12', '2015-04-29 15:42:12', 2, 1, 1),
(124, 1, 5, '', '', '', '', '2015-04-13 13:21:45', '2015-04-13 13:21:45', 1, 1, 1),
(125, 1, 4, '', '', '', '', '2015-04-13 13:23:09', '2015-04-13 13:23:09', 1, 1, 1),
(126, 1, 5, '', '', '', '', '2015-04-13 13:23:11', '2015-04-13 13:23:11', 1, 1, 1),
(127, 1, 4, '', '', '', '', '2015-04-13 13:23:12', '2015-04-13 13:23:12', 1, 1, 1),
(128, 1, 5, '', '', '', '', '2015-04-13 13:23:23', '2015-04-13 13:23:23', 1, 1, 1),
(129, 1, 5, '', '', '', '', '2015-04-13 13:23:25', '2015-04-13 13:23:25', 1, 1, 1),
(130, 1, 4, '', '', '', '', '2015-04-13 13:28:19', '2015-04-13 13:28:19', 1, 1, 1),
(131, 1, 5, '', '', '', '', '2015-04-13 13:28:31', '2015-04-13 13:28:31', 1, 1, 1),
(132, 1, 5, '', '', '', '', '2015-04-13 13:28:32', '2015-04-13 13:28:32', 1, 1, 1),
(133, 1, 4, '', '', '', '', '2015-04-13 13:29:29', '2015-04-13 13:29:29', 1, 1, 1),
(134, 1, 4, '', '', '', '', '2015-04-13 13:29:41', '2015-04-13 13:29:41', 1, 1, 1),
(135, 1, 4, '', '', '', '', '2015-04-13 13:29:44', '2015-04-13 13:29:44', 1, 1, 1),
(136, 1, 4, '', '', '', '', '2015-04-13 13:31:09', '2015-04-13 13:31:09', 1, 1, 1),
(137, 1, 4, '', '', '', '', '2015-04-13 13:31:13', '2015-04-13 13:31:13', 1, 1, 1),
(138, 1, 4, '', '', '', '', '2015-04-13 13:31:32', '2015-04-13 13:31:32', 1, 1, 1),
(139, 1, 4, '', '', '', '', '2015-04-13 13:33:14', '2015-04-13 13:33:14', 1, 1, 1),
(140, 1, 4, '', '', '', '', '2015-04-13 13:35:32', '2015-04-13 13:35:32', 1, 1, 1),
(141, 1, 5, '', '', '', '', '2015-04-13 13:35:34', '2015-04-13 13:35:34', 1, 1, 1),
(142, 1, 4, '', '', '', '', '2015-04-13 13:35:42', '2015-04-13 13:35:42', 1, 1, 1),
(143, 1, 2, '', '', '', '', '2015-04-13 13:35:44', '2015-04-13 13:35:44', 1, 1, 1),
(144, 1, 5, '', '', '', '', '2015-04-13 13:35:47', '2015-04-13 13:35:47', 1, 1, 1),
(145, 1, 5, '', '', '', '', '2015-04-13 13:35:47', '2015-04-13 13:35:47', 1, 1, 1),
(146, 1, 2, '', '', '', '', '2015-04-13 13:35:48', '2015-04-13 13:35:48', 1, 1, 1),
(147, 1, 4, '', '', '', '', '2015-04-13 13:43:55', '2015-04-13 13:43:55', 1, 1, 1),
(148, 1, 5, '', '', '', '', '2015-04-13 13:43:56', '2015-04-13 13:43:56', 1, 1, 1),
(149, 1, 4, '', '', '', '', '2015-04-13 13:44:06', '2015-04-13 13:44:06', 1, 1, 1),
(150, 1, 5, '', '', '', '', '2015-04-13 13:44:09', '2015-04-13 13:44:09', 1, 1, 1),
(151, 1, 4, '', '', '', '', '2015-04-13 13:44:11', '2015-04-13 13:44:11', 1, 1, 1),
(152, 1, 5, '', '', '', '', '2015-04-13 13:44:12', '2015-04-13 13:44:12', 1, 1, 1),
(153, 1, 4, '', '', '', '', '2015-04-13 13:44:14', '2015-04-13 13:44:14', 1, 1, 1),
(154, 1, 5, '', '', '', '', '2015-04-13 13:44:17', '2015-04-13 13:44:17', 1, 1, 1),
(155, 1, 4, '', '', '', '', '2015-04-13 13:44:18', '2015-04-13 13:44:18', 1, 1, 1),
(156, 1, 4, '', '', '', '', '2015-04-13 13:44:20', '2015-04-13 13:44:20', 1, 1, 1),
(157, 1, 4, '', '', '', '', '2015-04-13 13:45:26', '2015-04-13 13:45:26', 1, 1, 1),
(158, 1, 5, '', '', '', '', '2015-04-13 13:45:27', '2015-04-13 13:45:27', 1, 1, 1),
(159, 1, 4, '', '', '', '', '2015-04-13 13:46:16', '2015-04-13 13:46:16', 1, 1, 1),
(160, 1, 5, '', '', '', '', '2015-04-13 13:46:17', '2015-04-13 13:46:17', 1, 1, 1),
(161, 1, 4, '', '', '', '', '2015-04-13 14:27:19', '2015-04-13 14:27:19', 1, 1, 1),
(162, 1, 4, '', '', '', '', '2015-04-13 14:28:17', '2015-04-13 14:28:17', 1, 1, 1),
(163, 1, 4, '', '', '', '', '2015-04-13 14:28:34', '2015-04-13 14:28:34', 1, 1, 1),
(164, 1, 5, '', '', '', '', '2015-04-13 14:28:47', '2015-04-13 14:28:47', 1, 1, 1),
(165, 1, 4, '', '', '', '', '2015-04-13 14:28:49', '2015-04-13 14:28:49', 1, 1, 1),
(166, 1, 2, '', '', '', '', '2015-04-13 14:28:51', '2015-04-13 14:28:51', 1, 1, 1),
(167, 1, 2, '', '', '', '', '2015-04-13 14:28:53', '2015-04-13 14:28:53', 1, 1, 1),
(168, 1, 5, '', '', '', '', '2015-04-13 14:28:54', '2015-04-13 14:28:54', 1, 1, 1),
(169, 1, 2, '', '', '', '', '2015-04-13 14:28:56', '2015-04-13 14:28:56', 1, 1, 1),
(170, 1, 5, '', '', '', '', '2015-04-13 14:28:58', '2015-04-13 14:28:58', 1, 1, 1),
(171, 1, 4, '', '', '', '', '2015-04-13 14:29:00', '2015-04-13 14:29:00', 1, 1, 1),
(172, 1, 5, '', '', '', '', '2015-04-13 15:08:09', '2015-04-13 15:08:09', 1, 1, 1),
(173, 1, 1, 'E sure die,', 'Working', 'At all', 'It''s', '2015-04-29 13:47:39', '2015-04-29 13:47:39', 1, 1, 1),
(174, 1, 1, '', '', '', '', '2015-04-20 17:18:20', '2015-04-20 17:18:20', 1, 1, 1),
(175, 1, 1, '', '', '', '', '2015-04-20 17:19:28', '2015-04-20 17:19:28', 1, 1, 1),
(176, 1, 28, '', '', '', '', '2015-04-20 17:26:25', '2015-04-20 17:26:25', 1, 1, 1),
(177, 1, 1, '', '', '', '', '2015-04-21 11:13:13', '2015-04-21 11:13:13', 1, 1, 1),
(178, 1, 1, '', '', '', '', '2015-04-21 11:13:18', '2015-04-21 11:13:18', 1, 1, 1),
(179, 1, 1, '', '', '', '', '2015-04-21 11:16:22', '2015-04-21 11:16:22', 1, 1, 1),
(180, 1, 1, '', '', '', '', '2015-04-21 12:20:28', '2015-04-21 12:20:28', 1, 1, 1),
(181, 1, 1, '', '', '', '', '2015-04-21 12:21:28', '2015-04-21 12:21:28', 1, 1, 1),
(182, 1, 1, '', '', '', '', '2015-04-21 12:22:51', '2015-04-21 12:22:51', 1, 1, 1),
(183, 1, 1, '', '', '', '', '2015-04-21 12:23:14', '2015-04-21 12:23:14', 1, 1, 1),
(184, 1, 1, '', '', '', '', '2015-04-21 12:23:27', '2015-04-21 12:23:27', 1, 1, 1),
(185, 1, 1, '', '', '', '', '2015-04-21 12:23:43', '2015-04-21 12:23:43', 1, 1, 1),
(186, 1, 1, '', '', '', '', '2015-04-21 12:24:57', '2015-04-21 12:24:57', 1, 1, 1),
(187, 1, 1, '', '', '', '', '2015-04-21 12:25:15', '2015-04-21 12:25:15', 1, 1, 1),
(188, 1, 1, '', '', '', '', '2015-04-21 12:25:40', '2015-04-21 12:25:40', 1, 1, 1),
(189, 1, 1, '', '', '', '', '2015-04-21 12:27:26', '2015-04-21 12:27:26', 1, 1, 1),
(190, 1, 1, '', '', '', '', '2015-04-21 12:28:30', '2015-04-21 12:28:30', 1, 1, 1),
(191, 1, 1, '', '', '', '', '2015-04-21 12:29:54', '2015-04-21 12:29:54', 1, 1, 1),
(192, 1, 1, '', '', '', '', '2015-04-21 12:30:06', '2015-04-21 12:30:06', 1, 1, 1),
(193, 1, 1, '', '', '', '', '2015-04-21 12:30:33', '2015-04-21 12:30:33', 1, 1, 1),
(194, 1, 1, '', '', '', '', '2015-04-21 12:30:52', '2015-04-21 12:30:52', 1, 1, 1),
(195, 1, 1, '', '', '', '', '2015-04-21 12:39:13', '2015-04-21 12:39:13', 1, 1, 1),
(196, 1, 1, '', '', '', '', '2015-04-21 12:39:56', '2015-04-21 12:39:56', 1, 1, 1),
(197, 1, 38, 'Test', 'I hope', 'Well', 'Detail', '2015-04-29 15:28:15', '2015-04-29 15:28:15', 1, 1, 1),
(198, 1, 12, ' ', ' ', ' ', ' ', '2015-04-29 14:42:28', '2015-04-29 14:42:28', 1, 1, 1),
(199, 1, 13, 'This is to test animation and prescription', 'Wept', 'Wept o', 'Jisos', '2015-04-29 15:20:39', '2015-04-29 15:20:39', 1, 1, 1),
(200, 1, 11, ' ', ' ', ' ', ' ', '2015-04-29 14:42:43', '2015-04-29 14:42:43', 2, 1, 1),
(201, 1, 9, 'I''m confused', 'I don''t know', 'Well', 'Well', '2015-04-29 15:46:37', '2015-04-29 15:46:37', 1, 1, 1),
(202, 1, 39, 'Admit this Dude', 'Cold', 'Nothing', 'I don''t think this patient has an issue but he should be monitored', '2015-05-05 18:01:58', '2015-05-05 18:01:58', 2, 1, 1),
(203, 1, 14, 'Testing admission', 'Cold', 'Idiot', 'I think there is a bug in this code', '2015-05-05 18:19:34', '2015-05-05 18:19:34', 2, 1, 1),
(204, 1, 11, ' ', ' ', ' ', ' ', '2015-04-29 18:14:44', '2015-04-29 18:14:44', 1, 1, 1),
(205, 1, 49, ' ', ' ', ' ', ' ', '2015-05-13 13:15:10', '2015-05-13 13:15:10', 2, 1, 1),
(206, 1, 46, ' ', ' ', ' ', ' ', '2015-05-14 03:34:49', '2015-05-14 03:34:49', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `treatment_status`
--

CREATE TABLE IF NOT EXISTS `treatment_status` (
`treatment_status_id` int(10) unsigned NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `treatment_status`
--

INSERT INTO `treatment_status` (`treatment_status_id`, `status`) VALUES
(1, 'intreatment'),
(2, 'treatmentComplete');

-- --------------------------------------------------------

--
-- Table structure for table `unit_ref`
--

CREATE TABLE IF NOT EXISTS `unit_ref` (
`unit_ref_id` int(11) unsigned NOT NULL,
  `unit` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_ref`
--

INSERT INTO `unit_ref` (`unit_ref_id`, `unit`, `created_date`, `active_fg`) VALUES
(1, 'milligramme', '2015-02-25 00:00:00', 1),
(2, 'millilitre', '2015-02-25 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `urinalysis`
--

CREATE TABLE IF NOT EXISTS `urinalysis` (
`urinalysis_id` int(11) NOT NULL,
  `urine_id` int(11) NOT NULL,
  `appearance` varchar(35) NOT NULL,
  `ph` varchar(35) NOT NULL,
  `glucose` varchar(35) NOT NULL,
  `protein` varchar(35) NOT NULL,
  `bilirubin` varchar(35) NOT NULL,
  `urobillinogen` varchar(35) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urinalysis`
--

INSERT INTO `urinalysis` (`urinalysis_id`, `urine_id`, `appearance`, `ph`, `glucose`, `protein`, `bilirubin`, `urobillinogen`, `created_date`, `modified_date`, `active_fg`) VALUES
(52, 1, 'greenish', 'neutral', 'too much', 'average', 'normal', 'okay', '2015-04-03 23:57:22', '2015-04-17 12:34:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `urinary`
--

CREATE TABLE IF NOT EXISTS `urinary` (
`urinary_id` int(11) NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `urinaryproblem` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urine`
--

CREATE TABLE IF NOT EXISTS `urine` (
`urine_id` int(11) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `lab_attendant_id` int(11) DEFAULT NULL,
  `clinical_diagnosis_details` text,
  `investigation_required` varchar(100) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `laboratory_report` text,
  `laboratory_ref` varchar(10) DEFAULT NULL,
  `culture_value` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urine`
--

INSERT INTO `urine` (`urine_id`, `treatment_id`, `encounter_id`, `lab_attendant_id`, `clinical_diagnosis_details`, `investigation_required`, `doctor_id`, `laboratory_report`, `laboratory_ref`, `culture_value`, `created_date`, `modified_date`, `status_id`, `active_fg`) VALUES
(1, 1, 0, 1, 'testing', 'general info', 1, 'He is okay dude                                                                                ', 'M101', 'nice bacteria tinz', '2015-04-03 00:00:00', '2015-04-17 12:34:02', 6, 1),
(2, 2, 0, NULL, 'something', NULL, 1, NULL, NULL, NULL, '2015-04-10 14:22:01', '2015-04-10 14:22:01', 5, 1),
(3, 2, 0, NULL, 'something', NULL, 1, NULL, NULL, NULL, '2015-04-10 14:22:03', '2015-04-10 14:22:03', 5, 1),
(4, 2, 0, NULL, 'something', NULL, 1, NULL, NULL, NULL, '2015-04-10 14:22:04', '2015-04-10 14:22:04', 5, 1),
(5, 59, 0, NULL, 'Shingaling', NULL, 1, NULL, NULL, NULL, '2015-04-10 15:09:18', '2015-04-10 15:09:18', 5, 1),
(6, 47, 0, NULL, 'Jisos', NULL, 1, NULL, NULL, NULL, '2015-04-29 14:27:12', '2015-04-29 14:27:12', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `urine_sensitivity`
--

CREATE TABLE IF NOT EXISTS `urine_sensitivity` (
`urine_sensitivity_id` int(11) NOT NULL,
  `urine_id` int(11) NOT NULL,
  `isolates` int(11) DEFAULT NULL,
  `isolates_degree` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urine_sensitivity`
--

INSERT INTO `urine_sensitivity` (`urine_sensitivity_id`, `urine_id`, `isolates`, `isolates_degree`, `created_date`, `modified_date`, `active_fg`) VALUES
(104, 1, 1, 0, '2015-04-03 23:57:17', '2015-04-17 12:34:02', 1),
(105, 1, 2, 0, '2015-04-03 23:57:17', '2015-04-17 12:34:02', 1),
(106, 1, 5, 1, '2015-04-03 23:57:17', '2015-04-17 12:34:02', 1),
(107, 1, 8, 1, '2015-04-17 11:38:44', '2015-04-17 12:34:02', 1),
(108, 1, 9, 1, '2015-04-17 11:38:44', '2015-04-17 12:34:02', 1),
(109, 1, 10, 0, '2015-04-17 11:38:44', '2015-04-17 12:34:02', 1),
(110, 1, 3, 0, '2015-04-17 12:34:02', '2015-04-17 12:34:02', 1),
(111, 1, 4, 0, '2015-04-17 12:34:02', '2015-04-17 12:34:02', 1),
(112, 1, 7, 0, '2015-04-17 12:34:02', '2015-04-17 12:34:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `urine_sensitivity_ref`
--

CREATE TABLE IF NOT EXISTS `urine_sensitivity_ref` (
`urine_sensitivity_ref_id` int(11) NOT NULL,
  `antibiotics` varchar(35) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urine_sensitivity_ref`
--

INSERT INTO `urine_sensitivity_ref` (`urine_sensitivity_ref_id`, `antibiotics`, `active_fg`) VALUES
(1, 'Ampicillin', 1),
(2, 'Mechicillin/Clox', 1),
(3, 'Erythromycin', 1),
(4, 'Tetracycline', 1),
(5, 'Septrin', 1),
(6, 'Streptomycin', 1),
(7, 'Nitrofurantoin', 1),
(8, 'Cefotaxime', 1),
(9, 'Tarivid', 1),
(10, 'Ciprofloxacin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
`userid` int(11) NOT NULL,
  `regNo` varchar(35) NOT NULL,
  `passcode` varchar(64) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `online_status` int(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`userid`, `regNo`, `passcode`, `created_date`, `modified_date`, `status`, `active_fg`, `online_status`) VALUES
(1, 'PMS001', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-01-26 18:30:48', '2015-02-13 15:25:18', 1, 1, 1),
(2, 'PMS002', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-01-28 18:00:51', '2015-02-06 12:05:46', 1, 1, 0),
(3, 'PMS003', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-01-29 18:37:49', '2015-02-19 16:45:59', 1, 1, 0),
(4, 'PMS004', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-04-12 16:38:34', '2015-04-12 17:08:54', 1, 1, 0),
(5, 'PMS005', '054fcea2b14434441d3b592556f8cdd72370d635', '2015-04-13 09:59:36', '2015-04-13 09:59:36', 2, 1, 0),
(6, 'PMS006', '2ba2006f44db7780762d4c7606cf8113adfc7c34', '2015-04-13 11:05:38', '2015-04-13 11:05:38', 2, 1, 0),
(7, 'PMS007', 'ca1ba96926d9f91d9fccfc88945bf7fd4420897b', '2015-04-13 11:05:54', '2015-04-13 11:05:54', 2, 1, 0),
(8, 'PMS008', 'd788036995c1bc29af45bf73d3188e19468e7278', '2015-04-13 11:11:14', '2015-04-13 11:11:14', 2, 1, 0),
(9, 'PMS009', 'b3360944e204ce0caabb2083e6c52c7ad3dd6ff1', '2015-04-13 11:11:32', '2015-04-13 11:11:32', 2, 1, 0),
(10, 'PMS010', '45cae6bb0bb071a489162e065dd4ff79f57850d6', '2015-04-13 11:14:40', '2015-04-13 11:14:40', 2, 1, 0),
(11, 'PMS011', 'fb1822d7ee2d7d8741ef7ca3313b9888beb4456a', '2015-04-13 11:15:48', '2015-04-13 11:15:48', 2, 1, 0),
(12, 'PMS012', '50924adc199bf0bd9fb4f00f4c817b716b1295d2', '2015-04-13 11:17:01', '2015-04-13 11:17:01', 2, 1, 0),
(13, 'PMS013', 'f23d9db8595a9d5074eda7ce99dc2e4fdc17c84b', '2015-04-13 11:33:33', '2015-04-13 11:33:33', 2, 1, 0),
(14, 'PMS014', 'af7a2b1ec83b0ddad924147d3bc0973c1b4e247b', '2015-04-13 11:35:46', '2015-04-13 11:35:46', 2, 1, 0),
(15, 'PMS015', '94ba751a76d906207b6b5dd949536696e3ae1fe0', '2015-04-13 11:38:09', '2015-04-13 11:38:09', 2, 1, 0),
(16, 'PMS016', 'db9a8df0bbb1f2ee5b91cecb55fdeaa0755eb33c', '2015-04-13 11:39:02', '2015-04-13 11:39:02', 2, 1, 0),
(17, 'PMS017', '02d7fcb2717850ff04b0a82645f42749cc33309c', '2015-04-13 11:39:46', '2015-04-13 11:39:46', 2, 1, 0),
(18, 'PMS018', '859620914c9620700e2be65ed46da793c5c6cc29', '2015-04-13 11:40:24', '2015-04-13 11:40:24', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visual_skills_profile`
--

CREATE TABLE IF NOT EXISTS `visual_skills_profile` (
`visual_profile_id` int(11) NOT NULL,
  `doctor_id` int(11) DEFAULT '1',
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `distance_re` varchar(10) DEFAULT NULL,
  `distance_le` varchar(10) DEFAULT NULL,
  `distance_be` varchar(10) DEFAULT NULL,
  `near_re` varchar(10) DEFAULT NULL,
  `near_le` varchar(10) DEFAULT NULL,
  `near_be` varchar(10) DEFAULT NULL,
  `pinhole_acuity_re` varchar(10) DEFAULT NULL,
  `pinhole_acuity_le` varchar(10) DEFAULT NULL,
  `pinhole_acuity_be` varchar(10) DEFAULT NULL,
  `colour_vision` varchar(30) DEFAULT NULL,
  `stereopsis` varchar(30) DEFAULT NULL,
  `amplitude_of_accomodation` varchar(30) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visual_skills_profile`
--

INSERT INTO `visual_skills_profile` (`visual_profile_id`, `doctor_id`, `treatment_id`, `encounter_id`, `distance_re`, `distance_le`, `distance_be`, `near_re`, `near_le`, `near_be`, `pinhole_acuity_re`, `pinhole_acuity_le`, `pinhole_acuity_be`, `colour_vision`, `stereopsis`, `amplitude_of_accomodation`, `created_date`, `modified_date`, `active_fg`, `lab_attendant_id`, `status_id`) VALUES
(1, 1, 1, 0, 'distance', 'distance', 'distance', 'distance', 'distance', 'distance', 'distance', 'distance', 'distance', NULL, NULL, NULL, '2015-04-08 20:11:24', '2015-04-08 20:11:24', 1, NULL, 7),
(4, 1, 2, 0, '', '', '', '', '', '', '', '', '', '', '', '', '2015-04-10 14:07:17', '2015-04-16 16:15:06', 1, 4, 6),
(5, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 14:07:22', '2015-04-10 14:07:22', 1, NULL, 6),
(6, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 14:07:23', '2015-04-10 14:07:23', 1, NULL, 5),
(7, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 14:07:25', '2015-04-10 14:07:25', 1, NULL, 5),
(8, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 14:14:15', '2015-04-10 14:14:15', 1, NULL, 5),
(9, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 14:16:39', '2015-04-10 14:16:39', 1, NULL, 5),
(10, 1, 59, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-10 15:09:20', '2015-04-10 15:09:20', 1, NULL, 5),
(11, 1, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-04-20 16:24:59', '2015-04-20 16:24:59', 1, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE IF NOT EXISTS `vitals` (
`vitals_id` int(11) unsigned NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) unsigned DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `temp` float DEFAULT NULL,
  `pulse` float DEFAULT NULL,
  `respiratory_rate` float DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `bmi` float DEFAULT NULL,
  `active_fg` tinyint(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vitals`
--

INSERT INTO `vitals` (`vitals_id`, `patient_id`, `encounter_id`, `added_by`, `temp`, `pulse`, `respiratory_rate`, `blood_pressure`, `height`, `weight`, `bmi`, `active_fg`, `created_date`) VALUES
(1, 1, NULL, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-13 11:11:22'),
(2, 1, NULL, 1, 100, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-13 11:12:51'),
(3, 1, NULL, 1, 103, NULL, NULL, '100/180', NULL, NULL, NULL, 1, '2015-05-13 11:17:10'),
(5, 12, NULL, 1, 103, NULL, NULL, '100/180', NULL, NULL, NULL, 1, '2015-05-13 11:28:43'),
(6, 14, 2, 1, 27, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-13 11:40:42'),
(7, 37, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-05-14 03:04:06'),
(8, 37, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-05-14 03:17:01'),
(9, 37, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-05-14 03:17:54'),
(10, 37, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-05-14 03:18:13'),
(11, 37, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-05-14 03:19:39'),
(12, 4, 5, 1, 12, 12, 12, '12', 12, 12, 12, 1, '2015-05-18 11:31:35'),
(13, 13, 49, 1, 12, 123, 12, '12', 12, 12, 123, 1, '2015-05-18 11:53:00'),
(14, 13, 50, 1, 12, 12, 12, '12', 12, 2, 12, 1, '2015-05-18 11:53:17'),
(15, 13, 58, 1, 12, 12, 12, '12', 12, 12, 12, 1, '2015-05-18 11:53:45'),
(16, 13, 60, 1, 12, 12, 12, '12', 12, 12, 12, 1, '2015-05-18 12:15:25'),
(17, 13, 64, 1, 12, 12, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:22:41'),
(18, 13, 65, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:24:20'),
(19, 13, 66, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:27:13'),
(20, 13, 67, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:27:24'),
(21, 13, 68, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:27:29'),
(22, 13, 69, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:27:33'),
(23, 13, 70, 1, 12, 12, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:44:02'),
(24, 13, 74, 1, 12, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2015-05-18 12:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `ward_ref`
--

CREATE TABLE IF NOT EXISTS `ward_ref` (
`ward_ref_id` int(11) unsigned NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ward_ref`
--

INSERT INTO `ward_ref` (`ward_ref_id`, `description`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'Ward A', '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1),
(2, 'Ward B', '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1),
(3, 'Ward C', '2015-03-13 00:00:00', '2015-03-13 00:00:00', 1),
(4, 'ward 3', '2015-05-15 15:20:55', '2015-05-15 15:20:55', 1),
(5, 'sd', '2015-05-18 12:04:55', '2015-05-18 12:04:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xray_case`
--

CREATE TABLE IF NOT EXISTS `xray_case` (
`xray_case_id` int(11) NOT NULL,
  `option` varchar(25) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xray_case`
--

INSERT INTO `xray_case` (`xray_case_id`, `option`, `active_fg`) VALUES
(1, 'WALKING CASE', 1),
(2, 'W.C.HAIR', 1),
(3, 'TROLLEY', 1),
(4, 'THEATRE', 1),
(5, 'PORTABLE', 1),
(6, 'L.M.P', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xray_no`
--

CREATE TABLE IF NOT EXISTS `xray_no` (
`xray_id` int(11) NOT NULL,
  `radiology_id` int(11) NOT NULL,
  `xray_number` varchar(7) CHARACTER SET latin1 DEFAULT NULL,
  `casual_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `gp_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `ante_natal_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `xray_no`
--

INSERT INTO `xray_no` (`xray_id`, `radiology_id`, `xray_number`, `casual_no`, `gp_no`, `ante_natal_no`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, '', '', '', '', '2015-04-16 15:34:43', '2015-04-16 15:34:43', 1),
(2, 4, '12', '123', '12324', '12345', '2015-04-16 15:35:05', '2015-04-29 14:06:31', 1),
(5, 2, '12', '123', '1234', '12345', '2015-04-16 16:11:21', '2015-04-29 13:59:17', 1),
(6, 3, '', '', '', '', '2015-04-29 13:43:32', '2015-04-29 13:43:32', 1),
(7, 5, '', '', '', '', '2015-04-29 17:16:58', '2015-04-29 17:17:18', 1),
(9, 7, '123', '1234', '12', '1234', '2015-04-29 18:17:35', '2015-04-29 18:17:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xray_size`
--

CREATE TABLE IF NOT EXISTS `xray_size` (
`xray_size_id` int(11) NOT NULL,
  `dimension` varchar(10) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xray_size`
--

INSERT INTO `xray_size` (`xray_size_id`, `dimension`, `active_fg`) VALUES
(1, '17X14', 1),
(2, '14X4', 1),
(3, '15X12', 1),
(4, '12X10', 1),
(5, '10X8', 1),
(6, '15X6', 1),
(7, '8X6', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
 ADD PRIMARY KEY (`admission_id`), ADD KEY `fk_AdmittedBy` (`admitted_by`), ADD KEY `fk_PatientAdmitted` (`patient_id`), ADD KEY `fk_TreatmentAdmission` (`treatment_id`), ADD KEY `discharged_by` (`discharged_by`);

--
-- Indexes for table `admission_bed`
--
ALTER TABLE `admission_bed`
 ADD PRIMARY KEY (`admission_bed_id`), ADD KEY `bed_id` (`bed_id`), ADD KEY `admission_id` (`admission_id`);

--
-- Indexes for table `admission_req`
--
ALTER TABLE `admission_req`
 ADD PRIMARY KEY (`admission_req_id`), ADD UNIQUE KEY `treatment_id` (`treatment_id`);

--
-- Indexes for table `bed`
--
ALTER TABLE `bed`
 ADD PRIMARY KEY (`bed_id`), ADD KEY `fk_BedWard` (`ward_id`);

--
-- Indexes for table `billables`
--
ALTER TABLE `billables`
 ADD PRIMARY KEY (`billables_id`);

--
-- Indexes for table `bill_status`
--
ALTER TABLE `bill_status`
 ADD PRIMARY KEY (`bill_status_id`);

--
-- Indexes for table `blood_test`
--
ALTER TABLE `blood_test`
 ADD PRIMARY KEY (`bloodtest_id`), ADD UNIQUE KEY `haematology_id` (`haematology_id`), ADD KEY `fk_BloodTestHaematologyId` (`haematology_id`);

--
-- Indexes for table `chemical_pathology_details`
--
ALTER TABLE `chemical_pathology_details`
 ADD PRIMARY KEY (`cpdetails_id`), ADD KEY `FK_chemical_pathology_details` (`cpreq_id`), ADD KEY `FK_chemical_pathology_details_ref` (`cpref_id`);

--
-- Indexes for table `chemical_pathology_ref`
--
ALTER TABLE `chemical_pathology_ref`
 ADD PRIMARY KEY (`cpref_id`);

--
-- Indexes for table `chemical_pathology_request`
--
ALTER TABLE `chemical_pathology_request`
 ADD PRIMARY KEY (`cpreq_id`), ADD UNIQUE KEY `NewIndex1` (`laboratory_ref`), ADD KEY `fk_ChemicalTreatment` (`treatment_id`), ADD KEY `fk_ChemicalDoctor` (`doctor_id`), ADD KEY `fk_ChemicalStatus` (`status_id`);

--
-- Indexes for table `communication`
--
ALTER TABLE `communication`
 ADD PRIMARY KEY (`msg_id`), ADD KEY `fk_MsgSender` (`sender_id`), ADD KEY `fk_MsgRecipient` (`recipient_id`);

--
-- Indexes for table `constant_bills`
--
ALTER TABLE `constant_bills`
 ADD PRIMARY KEY (`constant_bills_id`), ADD KEY `fk_treatment_bills` (`treatment_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
 ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `differential_count`
--
ALTER TABLE `differential_count`
 ADD PRIMARY KEY (`differential_count_id`), ADD UNIQUE KEY `haematology_id` (`haematology_id`), ADD KEY `fk_DiffCountHaematologyId` (`haematology_id`);

--
-- Indexes for table `drug_ref`
--
ALTER TABLE `drug_ref`
 ADD PRIMARY KEY (`drug_ref_id`);

--
-- Indexes for table `emergency`
--
ALTER TABLE `emergency`
 ADD PRIMARY KEY (`emergency_id`), ADD UNIQUE KEY `emergency_id` (`emergency_id`);

--
-- Indexes for table `emergency_detail`
--
ALTER TABLE `emergency_detail`
 ADD PRIMARY KEY (`emergency_status_id`), ADD UNIQUE KEY `emergency_status_id` (`emergency_status_id`);

--
-- Indexes for table `encounter`
--
ALTER TABLE `encounter`
 ADD PRIMARY KEY (`encounter_id`), ADD KEY `fk_PatientEncountered` (`patient_id`), ADD KEY `fk_PersonnelEncountered` (`personnel_id`), ADD KEY `fk_AdmissionEncounter` (`admission_id`);

--
-- Indexes for table `film_appearance`
--
ALTER TABLE `film_appearance`
 ADD PRIMARY KEY (`film_appearance_id`), ADD UNIQUE KEY `haematology_id` (`haematology_id`), ADD KEY `fk_FilmAppearanceHaematologyReportId` (`haematology_id`);

--
-- Indexes for table `haematology`
--
ALTER TABLE `haematology`
 ADD PRIMARY KEY (`haematology_id`), ADD KEY `fk_DoctorId` (`doctor_id`), ADD KEY `fk_TreatmentId` (`treatment_id`), ADD KEY `fk_HaematologyStatus` (`status_id`);

--
-- Indexes for table `hospital_info`
--
ALTER TABLE `hospital_info`
 ADD PRIMARY KEY (`hospital_info_id`);

--
-- Indexes for table `microscopy`
--
ALTER TABLE `microscopy`
 ADD PRIMARY KEY (`microscopy_id`), ADD UNIQUE KEY `urine_id` (`urine_id`), ADD KEY `fk_MicroscopyUrineId` (`urine_id`);

--
-- Indexes for table `nok_relationship`
--
ALTER TABLE `nok_relationship`
 ADD PRIMARY KEY (`nok_relationship_id`);

--
-- Indexes for table `outgoing_drugs`
--
ALTER TABLE `outgoing_drugs`
 ADD PRIMARY KEY (`outgoing_drugs_id`), ADD KEY `fk_OutgoingDrugs` (`drug_id`), ADD KEY `fk_DrugUnits` (`unit_id`);

--
-- Indexes for table `parasitology_details`
--
ALTER TABLE `parasitology_details`
 ADD PRIMARY KEY (`pdetail_id`), ADD KEY `FK_parasitology_details_req_id` (`preq_id`), ADD KEY `FK_parasitology_details_ref_id` (`pref_id`);

--
-- Indexes for table `parasitology_ref`
--
ALTER TABLE `parasitology_ref`
 ADD PRIMARY KEY (`pref_id`);

--
-- Indexes for table `parasitology_req`
--
ALTER TABLE `parasitology_req`
 ADD PRIMARY KEY (`preq_id`), ADD KEY `fk_ParasitologyTreatmentId` (`treatment_id`), ADD KEY `fk_ParasitologyDoctorId` (`doctor_id`), ADD KEY `fk_ParasitologyStatusId` (`status_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
 ADD PRIMARY KEY (`patient_id`), ADD KEY `fk_PatientNok` (`nok_relationship`);

--
-- Indexes for table `patient_queue`
--
ALTER TABLE `patient_queue`
 ADD PRIMARY KEY (`patient_queue_id`), ADD KEY `fk_patientQueue` (`patient_id`), ADD KEY `fk_PatientDoctor` (`doctor_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
 ADD PRIMARY KEY (`permission_role_id`), ADD KEY `fk_PermisionRoleUserId` (`userid`), ADD KEY `fk_PermissionId` (`staff_permission_id`), ADD KEY `fk_RoleId` (`staff_role_id`);

--
-- Indexes for table `pharmacist_outgoing_drug`
--
ALTER TABLE `pharmacist_outgoing_drug`
 ADD PRIMARY KEY (`pharmacist_outgoing_drug_id`), ADD KEY `fk_Outgoing` (`outgoing_drug_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
 ADD PRIMARY KEY (`prescription_id`), ADD KEY `fk_TreatmentPrescription` (`treatment_id`), ADD KEY `fk_PrescriptionStatus` (`status`);

--
-- Indexes for table `prescription_outgoing_drug`
--
ALTER TABLE `prescription_outgoing_drug`
 ADD PRIMARY KEY (`prescription_outgoing_drug_id`), ADD KEY `fk_Prescription` (`prescription_id`), ADD KEY `fk_OutgoingDrug` (`outgoing_drug_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
 ADD PRIMARY KEY (`profile_id`), ADD KEY `fk_IdentificationUserId` (`userid`), ADD KEY `fk_DepartmentProfile` (`department_id`);

--
-- Indexes for table `radiology`
--
ALTER TABLE `radiology`
 ADD PRIMARY KEY (`radiology_id`), ADD KEY `fk_RadiologyDoctor` (`doctor_id`), ADD KEY `fk_RadiologyTreatment` (`treatment_id`), ADD KEY `fk_RadiologyStatus` (`status_id`);

--
-- Indexes for table `radiology_request`
--
ALTER TABLE `radiology_request`
 ADD PRIMARY KEY (`radiology_request_id`), ADD UNIQUE KEY `radiology_id` (`radiology_id`), ADD KEY `fk_ExaminationRequestedRadiologyId` (`radiology_id`);

--
-- Indexes for table `roster`
--
ALTER TABLE `roster`
 ADD PRIMARY KEY (`roster_id`), ADD KEY `fk_DutyRoster` (`user_id`), ADD KEY `fk_UserDept` (`dept_id`), ADD KEY `fk_DutyStatus` (`duty`), ADD KEY `fk_CreatedBy` (`created_by`), ADD KEY `fk_ModifiedBy` (`modified_by`);

--
-- Indexes for table `staff_permission`
--
ALTER TABLE `staff_permission`
 ADD PRIMARY KEY (`staff_permission_id`);

--
-- Indexes for table `staff_role`
--
ALTER TABLE `staff_role`
 ADD PRIMARY KEY (`staff_role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
 ADD PRIMARY KEY (`treatment_id`), ADD KEY `fk_treatment_status` (`treatment_status`), ADD KEY `fk_billing_status` (`bill_status`);

--
-- Indexes for table `treatment_status`
--
ALTER TABLE `treatment_status`
 ADD PRIMARY KEY (`treatment_status_id`), ADD UNIQUE KEY `treatment_status_id` (`treatment_status_id`);

--
-- Indexes for table `unit_ref`
--
ALTER TABLE `unit_ref`
 ADD PRIMARY KEY (`unit_ref_id`);

--
-- Indexes for table `urinalysis`
--
ALTER TABLE `urinalysis`
 ADD PRIMARY KEY (`urinalysis_id`), ADD UNIQUE KEY `urine_id` (`urine_id`), ADD KEY `fk_UrinalysisUrineId` (`urine_id`);

--
-- Indexes for table `urinary`
--
ALTER TABLE `urinary`
 ADD PRIMARY KEY (`urinary_id`), ADD KEY `fk_UrinaryUserId` (`patient_id`), ADD KEY `fk_UrinaryProblem` (`urinaryproblem`);

--
-- Indexes for table `urine`
--
ALTER TABLE `urine`
 ADD PRIMARY KEY (`urine_id`), ADD KEY `fk_UrineStatusId` (`status_id`), ADD KEY `fk_UrineTreatmentId` (`treatment_id`), ADD KEY `fk_UrineDoctorId` (`doctor_id`);

--
-- Indexes for table `urine_sensitivity`
--
ALTER TABLE `urine_sensitivity`
 ADD PRIMARY KEY (`urine_sensitivity_id`), ADD KEY `fk_UrineSensitivityUrineId` (`urine_id`), ADD KEY `fk_UrineSensitivityRefId` (`isolates`);

--
-- Indexes for table `urine_sensitivity_ref`
--
ALTER TABLE `urine_sensitivity_ref`
 ADD PRIMARY KEY (`urine_sensitivity_ref_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
 ADD PRIMARY KEY (`userid`), ADD KEY `fk_UserStatus` (`status`);

--
-- Indexes for table `visual_skills_profile`
--
ALTER TABLE `visual_skills_profile`
 ADD PRIMARY KEY (`visual_profile_id`), ADD KEY `fk_VisualDoctor` (`doctor_id`), ADD KEY `fk_VisualTreatment` (`treatment_id`), ADD KEY `fk_VisualStatus` (`status_id`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
 ADD PRIMARY KEY (`vitals_id`), ADD KEY `encounter_id` (`encounter_id`), ADD KEY `patient_id` (`patient_id`), ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `ward_ref`
--
ALTER TABLE `ward_ref`
 ADD PRIMARY KEY (`ward_ref_id`);

--
-- Indexes for table `xray_case`
--
ALTER TABLE `xray_case`
 ADD PRIMARY KEY (`xray_case_id`);

--
-- Indexes for table `xray_no`
--
ALTER TABLE `xray_no`
 ADD PRIMARY KEY (`xray_id`), ADD UNIQUE KEY `radiology_id` (`radiology_id`), ADD KEY `fk_XRayNoRadiologyId` (`radiology_id`);

--
-- Indexes for table `xray_size`
--
ALTER TABLE `xray_size`
 ADD PRIMARY KEY (`xray_size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
MODIFY `admission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `admission_bed`
--
ALTER TABLE `admission_bed`
MODIFY `admission_bed_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `admission_req`
--
ALTER TABLE `admission_req`
MODIFY `admission_req_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `bed`
--
ALTER TABLE `bed`
MODIFY `bed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `billables`
--
ALTER TABLE `billables`
MODIFY `billables_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bill_status`
--
ALTER TABLE `bill_status`
MODIFY `bill_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `blood_test`
--
ALTER TABLE `blood_test`
MODIFY `bloodtest_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `chemical_pathology_details`
--
ALTER TABLE `chemical_pathology_details`
MODIFY `cpdetails_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT for table `chemical_pathology_ref`
--
ALTER TABLE `chemical_pathology_ref`
MODIFY `cpref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `chemical_pathology_request`
--
ALTER TABLE `chemical_pathology_request`
MODIFY `cpreq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `communication`
--
ALTER TABLE `communication`
MODIFY `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `constant_bills`
--
ALTER TABLE `constant_bills`
MODIFY `constant_bills_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
MODIFY `department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `differential_count`
--
ALTER TABLE `differential_count`
MODIFY `differential_count_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `drug_ref`
--
ALTER TABLE `drug_ref`
MODIFY `drug_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `emergency`
--
ALTER TABLE `emergency`
MODIFY `emergency_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `emergency_detail`
--
ALTER TABLE `emergency_detail`
MODIFY `emergency_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `encounter`
--
ALTER TABLE `encounter`
MODIFY `encounter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `film_appearance`
--
ALTER TABLE `film_appearance`
MODIFY `film_appearance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `haematology`
--
ALTER TABLE `haematology`
MODIFY `haematology_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `hospital_info`
--
ALTER TABLE `hospital_info`
MODIFY `hospital_info_id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `microscopy`
--
ALTER TABLE `microscopy`
MODIFY `microscopy_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `nok_relationship`
--
ALTER TABLE `nok_relationship`
MODIFY `nok_relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `outgoing_drugs`
--
ALTER TABLE `outgoing_drugs`
MODIFY `outgoing_drugs_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `parasitology_details`
--
ALTER TABLE `parasitology_details`
MODIFY `pdetail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `parasitology_ref`
--
ALTER TABLE `parasitology_ref`
MODIFY `pref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `parasitology_req`
--
ALTER TABLE `parasitology_req`
MODIFY `preq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
MODIFY `patient_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `patient_queue`
--
ALTER TABLE `patient_queue`
MODIFY `patient_queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=122;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
MODIFY `permission_role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `pharmacist_outgoing_drug`
--
ALTER TABLE `pharmacist_outgoing_drug`
MODIFY `pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
MODIFY `prescription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=191;
--
-- AUTO_INCREMENT for table `prescription_outgoing_drug`
--
ALTER TABLE `prescription_outgoing_drug`
MODIFY `prescription_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `radiology`
--
ALTER TABLE `radiology`
MODIFY `radiology_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `radiology_request`
--
ALTER TABLE `radiology_request`
MODIFY `radiology_request_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `roster`
--
ALTER TABLE `roster`
MODIFY `roster_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `staff_permission`
--
ALTER TABLE `staff_permission`
MODIFY `staff_permission_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff_role`
--
ALTER TABLE `staff_role`
MODIFY `staff_role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
MODIFY `treatment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=207;
--
-- AUTO_INCREMENT for table `treatment_status`
--
ALTER TABLE `treatment_status`
MODIFY `treatment_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `unit_ref`
--
ALTER TABLE `unit_ref`
MODIFY `unit_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `urinalysis`
--
ALTER TABLE `urinalysis`
MODIFY `urinalysis_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `urinary`
--
ALTER TABLE `urinary`
MODIFY `urinary_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `urine`
--
ALTER TABLE `urine`
MODIFY `urine_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `urine_sensitivity`
--
ALTER TABLE `urine_sensitivity`
MODIFY `urine_sensitivity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `urine_sensitivity_ref`
--
ALTER TABLE `urine_sensitivity_ref`
MODIFY `urine_sensitivity_ref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `visual_skills_profile`
--
ALTER TABLE `visual_skills_profile`
MODIFY `visual_profile_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
MODIFY `vitals_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `ward_ref`
--
ALTER TABLE `ward_ref`
MODIFY `ward_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `xray_case`
--
ALTER TABLE `xray_case`
MODIFY `xray_case_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `xray_no`
--
ALTER TABLE `xray_no`
MODIFY `xray_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `xray_size`
--
ALTER TABLE `xray_size`
MODIFY `xray_size_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission`
--
ALTER TABLE `admission`
ADD CONSTRAINT `fk_AdmittedBy` FOREIGN KEY (`admitted_by`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_DischargedBy` FOREIGN KEY (`discharged_by`) REFERENCES `user_auth` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_PatientAdmitted` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
ADD CONSTRAINT `fk_TreatmentAdmission` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `admission_bed`
--
ALTER TABLE `admission_bed`
ADD CONSTRAINT `admission_bed_ibfk_1` FOREIGN KEY (`admission_id`) REFERENCES `admission` (`admission_id`),
ADD CONSTRAINT `admission_bed_ibfk_2` FOREIGN KEY (`bed_id`) REFERENCES `bed` (`bed_id`);

--
-- Constraints for table `admission_req`
--
ALTER TABLE `admission_req`
ADD CONSTRAINT `fk_AdmissionTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `bed`
--
ALTER TABLE `bed`
ADD CONSTRAINT `fk_BedWard` FOREIGN KEY (`ward_id`) REFERENCES `ward_ref` (`ward_ref_id`);

--
-- Constraints for table `blood_test`
--
ALTER TABLE `blood_test`
ADD CONSTRAINT `fk_BloodTestHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`);

--
-- Constraints for table `chemical_pathology_details`
--
ALTER TABLE `chemical_pathology_details`
ADD CONSTRAINT `FK_chemical_pathology_details` FOREIGN KEY (`cpreq_id`) REFERENCES `chemical_pathology_request` (`cpreq_id`),
ADD CONSTRAINT `FK_chemical_pathology_details_ref` FOREIGN KEY (`cpref_id`) REFERENCES `chemical_pathology_ref` (`cpref_id`);

--
-- Constraints for table `chemical_pathology_request`
--
ALTER TABLE `chemical_pathology_request`
ADD CONSTRAINT `fk_ChemicalDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_ChemicalStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_ChemicalTreatment` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `communication`
--
ALTER TABLE `communication`
ADD CONSTRAINT `fk_MsgRecipient` FOREIGN KEY (`recipient_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_MsgSender` FOREIGN KEY (`sender_id`) REFERENCES `user_auth` (`userid`);

--
-- Constraints for table `constant_bills`
--
ALTER TABLE `constant_bills`
ADD CONSTRAINT `fk_treatment_bills` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `differential_count`
--
ALTER TABLE `differential_count`
ADD CONSTRAINT `fk_DiffCountHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`);

--
-- Constraints for table `encounter`
--
ALTER TABLE `encounter`
ADD CONSTRAINT `fk_AdmissionEncounter` FOREIGN KEY (`admission_id`) REFERENCES `admission` (`admission_id`),
ADD CONSTRAINT `fk_PatientEncountered` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
ADD CONSTRAINT `fk_PersonnelEncountered` FOREIGN KEY (`personnel_id`) REFERENCES `user_auth` (`userid`);

--
-- Constraints for table `film_appearance`
--
ALTER TABLE `film_appearance`
ADD CONSTRAINT `fk_FilmAppearanceHaematologyReportId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`);

--
-- Constraints for table `haematology`
--
ALTER TABLE `haematology`
ADD CONSTRAINT `fk_DoctorId` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_HaematologyStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_TreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `microscopy`
--
ALTER TABLE `microscopy`
ADD CONSTRAINT `fk_MicroscopyUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`);

--
-- Constraints for table `outgoing_drugs`
--
ALTER TABLE `outgoing_drugs`
ADD CONSTRAINT `fk_DrugUnits` FOREIGN KEY (`unit_id`) REFERENCES `unit_ref` (`unit_ref_id`),
ADD CONSTRAINT `fk_OutgoingDrugs` FOREIGN KEY (`drug_id`) REFERENCES `drug_ref` (`drug_ref_id`);

--
-- Constraints for table `parasitology_details`
--
ALTER TABLE `parasitology_details`
ADD CONSTRAINT `FK_parasitology_details_ref_id` FOREIGN KEY (`pref_id`) REFERENCES `parasitology_ref` (`pref_id`),
ADD CONSTRAINT `FK_parasitology_details_req_id` FOREIGN KEY (`preq_id`) REFERENCES `parasitology_req` (`preq_id`);

--
-- Constraints for table `parasitology_req`
--
ALTER TABLE `parasitology_req`
ADD CONSTRAINT `fk_ParasitologyDoctorId` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_ParasitologyStatusId` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_ParasitologyTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
ADD CONSTRAINT `fk_PatientNok` FOREIGN KEY (`nok_relationship`) REFERENCES `nok_relationship` (`nok_relationship_id`);

--
-- Constraints for table `patient_queue`
--
ALTER TABLE `patient_queue`
ADD CONSTRAINT `fk_PatientDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_patientQueue` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
ADD CONSTRAINT `fk_permissionRoleUserId` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_staffPermissionRole` FOREIGN KEY (`staff_permission_id`) REFERENCES `staff_permission` (`staff_permission_id`),
ADD CONSTRAINT `fk_staffRole` FOREIGN KEY (`staff_role_id`) REFERENCES `staff_role` (`staff_role_id`);

--
-- Constraints for table `pharmacist_outgoing_drug`
--
ALTER TABLE `pharmacist_outgoing_drug`
ADD CONSTRAINT `fk_Outgoing` FOREIGN KEY (`outgoing_drug_id`) REFERENCES `outgoing_drugs` (`outgoing_drugs_id`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
ADD CONSTRAINT `fk_PrescriptionStatus` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_TreatmentPrescription` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `prescription_outgoing_drug`
--
ALTER TABLE `prescription_outgoing_drug`
ADD CONSTRAINT `fk_OutgoingDrug` FOREIGN KEY (`outgoing_drug_id`) REFERENCES `outgoing_drugs` (`outgoing_drugs_id`),
ADD CONSTRAINT `fk_Prescription` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`prescription_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
ADD CONSTRAINT `fk_DepartmentProfile` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
ADD CONSTRAINT `fk_UserProfile` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`);

--
-- Constraints for table `radiology`
--
ALTER TABLE `radiology`
ADD CONSTRAINT `fk_RadiologyDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_RadiologyStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_RadiologyTreatment` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `radiology_request`
--
ALTER TABLE `radiology_request`
ADD CONSTRAINT `fk_ExaminationRequestedRadiologyId` FOREIGN KEY (`radiology_id`) REFERENCES `radiology` (`radiology_id`);

--
-- Constraints for table `roster`
--
ALTER TABLE `roster`
ADD CONSTRAINT `fk_CreatedBy` FOREIGN KEY (`created_by`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_DutyStatus` FOREIGN KEY (`duty`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_ModifiedBy` FOREIGN KEY (`modified_by`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_UserDept` FOREIGN KEY (`dept_id`) REFERENCES `department` (`department_id`),
ADD CONSTRAINT `fk_UserRoster` FOREIGN KEY (`user_id`) REFERENCES `user_auth` (`userid`);

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
ADD CONSTRAINT `fk_billing_status` FOREIGN KEY (`bill_status`) REFERENCES `bill_status` (`bill_status_id`),
ADD CONSTRAINT `fk_treatment_status` FOREIGN KEY (`treatment_status`) REFERENCES `treatment_status` (`treatment_status_id`);

--
-- Constraints for table `urinalysis`
--
ALTER TABLE `urinalysis`
ADD CONSTRAINT `fk_UrinalysisUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`);

--
-- Constraints for table `urinary`
--
ALTER TABLE `urinary`
ADD CONSTRAINT `fk_UrinaryPatientId` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `urine`
--
ALTER TABLE `urine`
ADD CONSTRAINT `fk_UrineDoctorId` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_UrineStatusId` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_UrineTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `urine_sensitivity`
--
ALTER TABLE `urine_sensitivity`
ADD CONSTRAINT `fk_UrineSensitivityUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`);

--
-- Constraints for table `user_auth`
--
ALTER TABLE `user_auth`
ADD CONSTRAINT `fk_UserStatus` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`);

--
-- Constraints for table `visual_skills_profile`
--
ALTER TABLE `visual_skills_profile`
ADD CONSTRAINT `fk_VisualDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_VisualStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
ADD CONSTRAINT `fk_VisualTreatment` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`);

--
-- Constraints for table `vitals`
--
ALTER TABLE `vitals`
ADD CONSTRAINT `fk_AddedByUserId` FOREIGN KEY (`added_by`) REFERENCES `user_auth` (`userid`),
ADD CONSTRAINT `fk_PatientVitals` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`);

--
-- Constraints for table `xray_no`
--
ALTER TABLE `xray_no`
ADD CONSTRAINT `fk_XRayNoRadiologyId` FOREIGN KEY (`radiology_id`) REFERENCES `radiology` (`radiology_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
