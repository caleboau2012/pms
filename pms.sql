-- phpMyAdmin SQL Dump
-- version 4.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2017 at 09:28 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE IF NOT EXISTS `admission` (
  `admission_id` int(11) unsigned NOT NULL,
  `admitted_by` int(11) DEFAULT NULL,
  `discharged_by` int(11) DEFAULT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `entry_date` datetime DEFAULT NULL,
  `exit_date` datetime DEFAULT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admission_id`, `admitted_by`, `discharged_by`, `patient_id`, `treatment_id`, `entry_date`, `exit_date`, `comments`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 1, 1, 1, '2015-09-03 17:01:04', NULL, NULL, '2015-09-03 17:01:04', '2015-09-14 19:02:20', 0),
(2, 1, 1, 1, 2, '2015-09-14 19:03:42', NULL, NULL, '2015-09-14 19:03:42', '2015-09-14 20:04:38', 0),
(3, 1, 1, 1, 3, '2015-09-18 18:19:49', NULL, NULL, '2015-09-18 18:19:49', '2015-09-20 14:15:35', 0),
(4, 1, 1, 2, 4, '2015-09-20 14:15:21', '2015-10-11 15:16:40', NULL, '2015-09-20 14:15:21', '2015-10-11 15:16:40', 0),
(5, 1, 1, 1, 22, '2015-09-20 17:27:54', NULL, NULL, '2015-09-20 17:27:54', '2015-09-20 17:57:15', 0),
(6, 1, 1, 1, 24, '2015-09-20 19:56:57', NULL, NULL, '2015-09-20 19:56:57', '2015-10-28 00:29:03', 0),
(7, 1, 1, 6, 25, '2015-09-11 15:10:54', '2015-10-11 15:16:40', NULL, '2015-10-11 15:10:54', '2015-10-11 15:11:12', 0),
(8, 1, 1, 5, 21, '2015-11-22 21:49:38', NULL, NULL, '2015-11-22 21:49:38', '2016-04-28 23:12:09', 0),
(9, 1, 1, 1, 27, '2015-11-22 22:33:13', NULL, NULL, '2015-11-22 22:33:13', '2016-05-29 14:25:46', 0),
(10, 1, 1, 4, 29, '2016-04-28 22:55:49', NULL, NULL, '2016-04-28 22:55:49', '2016-05-29 14:28:16', 0),
(11, 1, 1, 1, 28, '2016-01-01 14:28:06', '2016-05-29 23:18:28', NULL, '2016-05-29 14:28:06', '2016-05-29 23:18:28', 0),
(12, 1, 1, 1, 32, '2016-05-30 00:32:16', NULL, NULL, '2016-05-30 00:32:16', '2016-12-22 00:23:47', 0),
(13, 1, 1, 8, 33, '2016-09-18 15:04:16', NULL, NULL, '2016-09-18 15:04:16', '2016-09-18 15:40:40', 0),
(14, 1, 1, 4, 35, '2016-11-26 01:24:04', NULL, NULL, '2016-11-26 01:24:04', '2016-12-08 00:50:02', 0),
(15, 1, 1, 4, 36, '2016-12-12 16:00:07', NULL, NULL, '2016-12-12 16:00:07', '2016-12-22 00:24:09', 0),
(16, 1, NULL, 1, 34, '2016-12-24 18:56:23', NULL, NULL, '2016-12-24 18:56:23', '2016-12-24 18:56:23', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admission_bed`
--

INSERT INTO `admission_bed` (`admission_bed_id`, `admission_id`, `bed_id`, `active_fg`, `created_date`, `modified_date`) VALUES
(1, 1, 1, 0, '2015-09-03 17:01:04', '2015-09-03 17:01:04'),
(2, 2, 1, 0, '2015-09-14 19:03:42', '2015-09-14 19:03:42'),
(3, 3, 1, 0, '2015-09-18 18:19:49', '2015-09-18 18:19:49'),
(4, 4, 2, 0, '2015-09-20 14:15:21', '2015-09-20 14:15:21'),
(5, 5, 1, 0, '2015-09-20 17:27:54', '2015-09-20 17:27:54'),
(6, 6, 1, 0, '2015-09-20 19:56:57', '2015-09-20 19:56:57'),
(7, 7, 3, 0, '2015-10-11 15:10:54', '2015-10-11 15:10:54'),
(8, 8, 1, 0, '2015-11-22 21:49:38', '2015-11-22 21:49:38'),
(9, 9, 2, 0, '2015-11-22 22:33:13', '2015-11-22 22:33:13'),
(10, 10, 3, 0, '2016-04-28 22:55:49', '2016-04-28 22:55:49'),
(11, 8, 4, 0, '2016-04-28 22:57:20', '2016-04-28 22:57:20'),
(12, 11, 1, 0, '2016-05-29 14:28:06', '2016-05-29 14:28:06'),
(13, 12, 1, 0, '2016-05-30 00:32:16', '2016-05-30 00:32:16'),
(14, 13, 3, 0, '2016-09-18 15:04:16', '2016-09-18 15:04:16'),
(15, 14, 2, 0, '2016-11-26 01:24:04', '2016-11-26 01:24:04'),
(16, 15, 2, 0, '2016-12-12 16:00:07', '2016-12-12 16:00:07'),
(17, 16, 1, 1, '2016-12-24 18:56:23', '2016-12-24 18:56:23');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission_req`
--

INSERT INTO `admission_req` (`admission_req_id`, `treatment_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, '2015-09-03 16:41:18', '2015-09-03 16:41:18', 0),
(2, 2, '2015-09-14 18:53:08', '2015-09-14 18:53:08', 0),
(3, 3, '2015-09-18 18:13:48', '2015-09-18 18:13:48', 0),
(4, 4, '2015-09-18 18:42:52', '2015-09-18 18:42:52', 0),
(5, 22, '2015-09-20 17:20:51', '2015-09-20 17:20:51', 0),
(6, 24, '2015-09-20 19:56:43', '2015-09-20 19:56:43', 0),
(7, 25, '2015-10-11 13:51:40', '2015-10-11 13:51:40', 0),
(8, 21, '2015-11-22 21:49:24', '2015-11-22 21:49:24', 0),
(9, 27, '2015-11-22 22:20:14', '2015-11-22 22:20:14', 0),
(10, 29, '2016-04-28 22:55:14', '2016-04-28 22:55:14', 0),
(11, 28, '2016-05-29 14:22:09', '2016-05-29 14:22:09', 0),
(13, 32, '2016-05-30 00:19:47', '2016-05-30 00:19:47', 0),
(14, 33, '2016-05-30 02:11:40', '2016-05-30 02:11:40', 0),
(15, 35, '2016-11-26 01:23:17', '2016-11-26 01:23:17', 0),
(16, 36, '2016-12-12 15:59:16', '2016-12-12 15:59:16', 0),
(17, 34, '2016-12-24 18:53:40', '2016-12-24 18:53:40', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bed`
--

INSERT INTO `bed` (`bed_id`, `bed_description`, `bed_status`, `ward_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'Bed 001', 1, 1, '2015-09-03 17:00:53', '2015-09-03 17:00:53', 1),
(2, 'Bed 002', 0, 1, '2015-09-14 18:54:23', '2015-09-14 18:54:23', 1),
(3, 'Bed 003', 0, 2, '2015-10-11 15:10:43', '2015-10-11 15:10:43', 1),
(4, 'Bed 004', 0, 2, '2016-04-28 22:56:36', '2016-04-28 22:56:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `billables`
--

CREATE TABLE IF NOT EXISTS `billables` (
  `billables_id` int(10) unsigned NOT NULL,
  `bill` varchar(255) NOT NULL,
  `amount` float(8,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billables`
--

INSERT INTO `billables` (`billables_id`, `bill`, `amount`, `status`, `created_date`, `modified_date`) VALUES
(1, 'Consultation', 10000.00, 1, NULL, '0000-00-00 00:00:00'),
(2, 'Treatment', 10000.00, 1, NULL, '2015-09-11 18:18:45'),
(3, 'Consultation', 1000.00, 1, NULL, '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_test`
--

INSERT INTO `blood_test` (`bloodtest_id`, `haematology_id`, `pcv`, `hb`, `hchc`, `wbc`, `eosinophils`, `platelets`, `rectis`, `rectis_index`, `e_s_r`, `microfilaria`, `malaria_parasites`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 1, 2, 3, 4, 5, 6, 7, 8, 9, '0', '9', '2016-12-08 00:44:12', '2016-12-08 00:44:12', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical_pathology_details`
--

INSERT INTO `chemical_pathology_details` (`cpdetails_id`, `cpreq_id`, `cpref_id`, `result`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 1, 10, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(2, 1, 2, 202, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(3, 1, 3, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(4, 1, 4, 303, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(5, 1, 5, 303, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(6, 1, 6, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(7, 1, 7, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(8, 1, 8, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(9, 1, 15, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(10, 1, 16, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(11, 1, 17, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(12, 1, 18, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(13, 1, 19, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(14, 1, 20, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(15, 1, 9, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(16, 1, 10, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(17, 1, 11, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(18, 1, 12, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(19, 1, 13, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(20, 1, 14, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(21, 1, 21, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(22, 1, 22, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(23, 1, 23, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(24, 1, 24, 0, '2015-09-18 18:38:23', '2015-09-18 18:38:51', 1),
(25, 4, 1, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(26, 4, 2, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(27, 4, 3, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(28, 4, 4, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(29, 4, 5, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(30, 4, 6, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(31, 4, 7, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(32, 4, 8, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(33, 4, 15, 99, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(34, 4, 16, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(35, 4, 17, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(36, 4, 18, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(37, 4, 19, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(38, 4, 20, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(39, 4, 9, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(40, 4, 10, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(41, 4, 11, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(42, 4, 12, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(43, 4, 13, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(44, 4, 14, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(45, 4, 21, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(46, 4, 22, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(47, 4, 23, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1),
(48, 4, 24, 9, '2017-01-20 23:18:07', '2017-01-20 23:18:07', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chemical_pathology_request`
--

INSERT INTO `chemical_pathology_request` (`cpreq_id`, `treatment_id`, `encounter_id`, `laboratory_ref`, `laboratory_comment`, `clinical_diagnosis`, `created_date`, `modified_date`, `active_fg`, `doctor_id`, `lab_attendant_id`, `status_id`, `cp_ref_id`) VALUES
(1, 4, 0, '', '', 'check for pregnancy', '2015-09-18 18:35:15', '2015-09-18 18:38:51', 1, 2, 1, 7, NULL),
(2, 24, 0, NULL, NULL, 'A test', '2015-09-20 21:13:39', '2015-09-20 21:13:39', 1, 1, NULL, 5, NULL),
(3, 34, 0, NULL, NULL, 'A chemical pathology test', '2016-09-16 08:34:55', '2016-09-16 08:34:55', 1, 1, NULL, 5, NULL),
(4, 34, 0, '909', 'good', 'Chemical poison', '2017-01-20 23:17:25', '2017-01-20 23:18:07', 1, 1, 1, 7, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `constant_bills`
--

CREATE TABLE IF NOT EXISTS `constant_bills` (
  `constant_bills_id` int(11) unsigned NOT NULL,
  `item` varchar(150) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `constant_bills`
--

INSERT INTO `constant_bills` (`constant_bills_id`, `item`, `amount`, `treatment_id`, `encounter_id`, `created_date`) VALUES
(1, 'Consultation', '100.00', 1, NULL, '2015-09-11 18:53:52'),
(2, 'Consultation', '1000.00', 1, NULL, '2015-09-11 18:55:31'),
(3, 'Treatment', '10000.00', 1, NULL, '2015-09-11 18:55:31'),
(4, 'Consultation', '1000.00', 1, NULL, '2015-09-11 18:57:51'),
(5, 'Treatment', '10000.00', 1, NULL, '2015-09-11 18:57:51'),
(6, 'Consultation', '10000.00', 2, NULL, '2015-09-16 18:17:16'),
(7, 'Treatment', '10000.00', 2, NULL, '2015-09-16 18:17:16'),
(8, 'Consultation', '1000.00', 2, NULL, '2015-09-16 18:17:16'),
(9, 'Consultation', '10000.00', 3, NULL, '2015-09-18 17:23:56'),
(10, 'Treatment', '10000.00', 3, NULL, '2015-09-18 17:23:56'),
(11, 'Consultation', '1000.00', 3, NULL, '2015-09-18 17:23:56'),
(12, 'Admission', '1000.00', 3, NULL, '2015-09-18 17:23:56'),
(13, 'Paracetamol', '100.00', 3, NULL, '2015-09-18 17:23:56'),
(14, 'Consultation', '10000.00', 4, NULL, '2015-09-18 17:45:18'),
(15, 'Treatment', '10000.00', 4, NULL, '2015-09-18 17:45:18'),
(16, 'Consultation', '1000.00', 4, NULL, '2015-09-18 17:45:18'),
(17, 'Consultation', '10000.00', 22, NULL, '2015-09-20 17:03:00'),
(18, 'Treatment', '10000.00', 22, NULL, '2015-09-20 17:03:00'),
(19, 'Consultation', '1000.00', 22, NULL, '2015-09-20 17:03:00'),
(20, 'Consultation', '10000.00', 1, NULL, '2015-09-26 21:38:30'),
(21, 'Treatment', '10000.00', 1, NULL, '2015-09-26 21:38:30'),
(22, 'Consultation', '1000.00', 1, NULL, '2015-09-26 21:38:30'),
(23, 'Consultation', '10000.00', 2, NULL, '2015-09-26 21:38:57'),
(24, 'Treatment', '10000.00', 2, NULL, '2015-09-26 21:38:57'),
(25, 'Consultation', '1000.00', 2, NULL, '2015-09-26 21:38:57'),
(26, 'Consultation', '10000.00', 3, NULL, '2015-10-14 19:10:18'),
(27, 'Treatment', '10000.00', 3, NULL, '2015-10-14 19:10:18'),
(28, 'Consultation', '1000.00', 3, NULL, '2015-10-14 19:10:18'),
(29, 'Shing', '10000.00', 3, NULL, '2015-10-14 19:10:18'),
(30, 'Consultation', '10000.00', 22, NULL, '2015-11-22 21:44:50'),
(31, 'Treatment', '10000.00', 22, NULL, '2015-11-22 21:44:50'),
(32, 'Consultation', '1000.00', 22, NULL, '2015-11-22 21:44:50'),
(33, 'Consultation', '10000.00', 29, NULL, '2016-03-28 22:08:23'),
(34, 'Treatment', '10000.00', 29, NULL, '2016-03-28 22:08:23'),
(35, 'Consultation', '1000.00', 29, NULL, '2016-03-28 22:08:23'),
(36, 'Consultation', '10000.00', 1, NULL, '2016-05-30 01:19:26'),
(37, 'Treatment', '10000.00', 1, NULL, '2016-05-30 01:19:26'),
(38, 'Consultation', '1000.00', 1, NULL, '2016-05-30 01:19:26'),
(39, 'Consultation', '10000.00', 4, NULL, '2016-06-06 20:40:50'),
(40, 'Treatment', '10000.00', 4, NULL, '2016-06-06 20:40:50'),
(41, 'Consultation', '1000.00', 4, NULL, '2016-06-06 20:40:50'),
(42, 'Consultation', '10000.00', 33, NULL, '2016-09-14 23:28:44'),
(43, 'Treatment', '10000.00', 33, NULL, '2016-09-14 23:28:44'),
(44, 'Consultation', '1000.00', 33, NULL, '2016-09-14 23:28:44'),
(45, 'Consultation', '10000.00', 32, NULL, '2016-09-14 23:30:20'),
(46, 'Treatment', '10000.00', 32, NULL, '2016-09-14 23:30:20'),
(47, 'Consultation', '1000.00', 32, NULL, '2016-09-14 23:30:20'),
(48, 'Consultation', '10000.00', 32, NULL, '2016-09-14 23:30:36'),
(49, 'Treatment', '10000.00', 32, NULL, '2016-09-14 23:30:36'),
(50, 'Consultation', '1000.00', 32, NULL, '2016-09-14 23:30:36'),
(51, 'Consultation', '10000.00', 31, NULL, '2016-09-14 23:31:44'),
(52, 'Treatment', '10000.00', 31, NULL, '2016-09-14 23:31:44'),
(53, 'Consultation', '1000.00', 31, NULL, '2016-09-14 23:31:44'),
(54, 'Consultation', '10000.00', 29, NULL, '2016-09-14 23:31:54'),
(55, 'Treatment', '10000.00', 29, NULL, '2016-09-14 23:31:54'),
(56, 'Consultation', '1000.00', 29, NULL, '2016-09-14 23:31:54'),
(57, 'Consultation', '10000.00', 28, NULL, '2016-09-14 23:32:07'),
(58, 'Treatment', '10000.00', 28, NULL, '2016-09-14 23:32:07'),
(59, 'Consultation', '1000.00', 28, NULL, '2016-09-14 23:32:07'),
(60, 'Consultation', '10000.00', 27, NULL, '2016-09-14 23:32:46'),
(61, 'Treatment', '10000.00', 27, NULL, '2016-09-14 23:32:46'),
(62, 'Consultation', '1000.00', 27, NULL, '2016-09-14 23:32:46'),
(63, 'Consultation', '10000.00', 24, NULL, '2016-09-14 23:32:55'),
(64, 'Treatment', '10000.00', 24, NULL, '2016-09-14 23:32:55'),
(65, 'Consultation', '1000.00', 24, NULL, '2016-09-14 23:32:55'),
(66, 'Consultation', '10000.00', 21, NULL, '2016-11-03 21:48:05'),
(67, 'Treatment', '10000.00', 21, NULL, '2016-11-03 21:48:05'),
(68, 'Consultation', '1000.00', 21, NULL, '2016-11-03 21:48:05'),
(69, 'Consultation', '10000.00', 23, NULL, '2016-11-03 22:31:17'),
(70, 'Treatment', '10000.00', 23, NULL, '2016-11-03 22:31:17'),
(71, 'Consultation', '1000.00', 23, NULL, '2016-11-03 22:31:17'),
(72, 'Sing', '2000.00', 23, NULL, '2016-11-03 22:31:17'),
(73, 'Shing', '10000.00', 23, NULL, '2016-11-03 22:31:17'),
(74, 'Consultation', '10000.00', 25, NULL, '2016-11-03 22:31:34'),
(75, 'Treatment', '10000.00', 25, NULL, '2016-11-03 22:31:34'),
(76, 'Consultation', '1000.00', 25, NULL, '2016-11-03 22:31:34'),
(77, 'Consultation', '10000.00', 26, NULL, '2016-11-03 22:34:03'),
(78, 'Treatment', '10000.00', 26, NULL, '2016-11-03 22:34:03'),
(79, 'Consultation', '1000.00', 26, NULL, '2016-11-03 22:34:03'),
(80, 'Shing', '1000.00', 26, NULL, '2016-11-03 22:34:03'),
(81, 'Consultation', '10000.00', 28, NULL, '2016-11-03 22:34:30'),
(82, 'Treatment', '10000.00', 28, NULL, '2016-11-03 22:34:30'),
(83, 'Consultation', '1000.00', 28, NULL, '2016-11-03 22:34:30'),
(84, 'Sing', '1000.00', 28, NULL, '2016-11-03 22:34:30'),
(85, 'Shing', '10000.00', 28, NULL, '2016-11-03 22:34:30'),
(86, 'Consultation', '10000.00', 34, NULL, '2016-11-22 19:31:42'),
(87, 'Treatment', '10000.00', 34, NULL, '2016-11-22 19:31:42'),
(88, 'Consultation', '1000.00', 34, NULL, '2016-11-22 19:31:42'),
(89, 'Consultation', '10000.00', 33, NULL, '2016-11-22 19:31:51'),
(90, 'Treatment', '10000.00', 33, NULL, '2016-11-22 19:31:51'),
(91, 'Consultation', '1000.00', 33, NULL, '2016-11-22 19:31:51'),
(92, 'Consultation', '10000.00', 32, NULL, '2016-11-22 19:32:00'),
(93, 'Treatment', '10000.00', 32, NULL, '2016-11-22 19:32:00'),
(94, 'Consultation', '1000.00', 32, NULL, '2016-11-22 19:32:00'),
(95, 'Consultation', '10000.00', 31, NULL, '2016-11-22 19:32:10'),
(96, 'Treatment', '10000.00', 31, NULL, '2016-11-22 19:32:10'),
(97, 'Consultation', '1000.00', 31, NULL, '2016-11-22 19:32:10'),
(98, 'Consultation', '10000.00', 29, NULL, '2016-11-26 00:22:16'),
(99, 'Treatment', '10000.00', 29, NULL, '2016-11-26 00:22:16'),
(100, 'Consultation', '1000.00', 29, NULL, '2016-11-26 00:22:16'),
(101, 'Consultation', '10000.00', 35, NULL, '2016-11-26 00:24:22'),
(102, 'Treatment', '10000.00', 35, NULL, '2016-11-26 00:24:22'),
(103, 'Consultation', '1000.00', 35, NULL, '2016-11-26 00:24:22'),
(104, 'Consultation', '10000.00', 35, NULL, '2016-12-07 23:48:27'),
(105, 'Treatment', '10000.00', 35, NULL, '2016-12-07 23:48:27'),
(106, 'Consultation', '1000.00', 35, NULL, '2016-12-07 23:48:27'),
(107, 'Consultation', '10000.00', 29, NULL, '2016-12-12 14:23:25'),
(108, 'Treatment', '10000.00', 29, NULL, '2016-12-12 14:23:25'),
(109, 'Consultation', '1000.00', 29, NULL, '2016-12-12 14:23:25'),
(110, 'Consultation', '10000.00', 33, 12, '2016-12-12 14:24:47'),
(111, 'Treatment', '10000.00', 33, 12, '2016-12-12 14:24:47'),
(112, 'Consultation', '1000.00', 33, 12, '2016-12-12 14:24:47'),
(113, 'Consultation', '10000.00', 33, 12, '2016-12-12 14:48:05'),
(114, 'Treatment', '10000.00', 33, 12, '2016-12-12 14:48:05'),
(115, 'Consultation', '1000.00', 33, 12, '2016-12-12 14:48:05'),
(116, 'Consultation', '10000.00', 29, NULL, '2016-12-12 14:48:17'),
(117, 'Treatment', '10000.00', 29, NULL, '2016-12-12 14:48:17'),
(118, 'Consultation', '1000.00', 29, NULL, '2016-12-12 14:48:17'),
(119, 'Consultation', '10000.00', 34, NULL, '2016-12-21 00:31:19'),
(120, 'Treatment', '10000.00', 34, NULL, '2016-12-21 00:31:19'),
(121, 'Consultation', '1000.00', 34, NULL, '2016-12-21 00:31:19'),
(122, 'Consultation', '10000.00', 36, NULL, '2016-12-21 23:34:12'),
(123, 'Treatment', '10000.00', 36, NULL, '2016-12-21 23:34:12'),
(124, 'Consultation', '1000.00', 36, NULL, '2016-12-21 23:34:12'),
(125, 'Consultation', '10000.00', 36, 15, '2016-12-21 23:35:54'),
(126, 'Treatment', '10000.00', 36, 15, '2016-12-21 23:35:54'),
(127, 'Consultation', '1000.00', 36, 15, '2016-12-21 23:35:54'),
(128, 'Consultation', '10000.00', 1, 1, '2016-12-21 23:37:07'),
(129, 'Treatment', '10000.00', 1, 1, '2016-12-21 23:37:07'),
(130, 'Consultation', '1000.00', 1, 1, '2016-12-21 23:37:07'),
(131, 'Consultation', '10000.00', 1, NULL, '2016-12-21 23:38:50'),
(132, 'Treatment', '10000.00', 1, NULL, '2016-12-21 23:38:50'),
(133, 'Consultation', '1000.00', 1, NULL, '2016-12-21 23:38:50'),
(134, 'Consultation', '10000.00', 2, NULL, '2016-12-21 23:39:13'),
(135, 'Treatment', '10000.00', 2, NULL, '2016-12-21 23:39:13'),
(136, 'Consultation', '1000.00', 2, NULL, '2016-12-21 23:39:13');

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
(8, 'pathology');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `differential_count`
--

INSERT INTO `differential_count` (`differential_count_id`, `haematology_id`, `polymorphs_neutrophils`, `lymphocytes`, `monocytes`, `eosinophils`, `basophils`, `widals_test`, `blood_group`, `rhesus_factor`, `genotype`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 3, 4, 56, 6, 7, 8, '9', '0', '9', '2016-12-08 00:44:12', '2016-12-08 00:44:12', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drug_ref`
--

INSERT INTO `drug_ref` (`drug_ref_id`, `name`, `symbol`, `created_date`, `active_fg`) VALUES
(1, 'emzor paracetamol', NULL, '2015-11-22 21:46:46', 1),
(2, 'tetracyclin', NULL, '2015-11-22 21:46:46', 1),
(3, 'paracetamol', NULL, '2015-12-06 16:00:49', 1),
(4, 'panadol extra', NULL, '2016-02-29 01:10:19', 1),
(5, 'antigen complex', NULL, '2016-02-29 01:10:20', 1),
(6, 'pure water', NULL, '2016-04-02 10:20:59', 1),
(7, 'panadol extra', NULL, '2016-04-13 23:26:50', 1),
(8, 'paraza', NULL, '2017-01-20 23:20:46', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emergency`
--

INSERT INTO `emergency` (`emergency_id`, `patient_id`, `emergency_status_id`, `created_date`, `modified_date`) VALUES
(1, 2, 2, '2015-09-03 14:48:52', '2015-09-03 14:48:52'),
(2, 3, 2, '2015-09-11 19:12:37', '2015-09-11 19:12:37'),
(3, 4, 2, '2015-09-18 18:27:17', '2015-09-18 18:27:17'),
(4, 5, 2, '2015-09-18 19:10:34', '2015-09-18 19:10:34'),
(5, 7, 2, '2015-12-06 16:18:49', '2015-12-06 16:18:49'),
(6, 8, 2, '2016-05-30 02:10:35', '2016-05-30 02:10:35');

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
  `personnel_id` int(11) DEFAULT NULL,
  `patient_id` int(11) unsigned DEFAULT NULL,
  `admission_id` int(11) unsigned DEFAULT NULL,
  `comments` text,
  `created_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) DEFAULT '1',
  `treatment_id` int(11) DEFAULT NULL,
  `symptoms` varchar(200) DEFAULT NULL,
  `consultation` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `bill_status` int(11) DEFAULT '1',
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `diagnosis` text
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `encounter`
--

INSERT INTO `encounter` (`encounter_id`, `personnel_id`, `patient_id`, `admission_id`, `comments`, `created_date`, `active_fg`, `treatment_id`, `symptoms`, `consultation`, `status`, `bill_status`, `modified_date`, `diagnosis`) VALUES
(1, 1, 1, 1, 'An encounter comment', '2015-09-03 17:19:37', 1, 1, 'An encounter symptom', 'An encounter consultation', 1, 2, '2015-09-03 16:29:04', 'An encounter diagnosis'),
(2, 1, 1, 3, 'A comment', '2015-09-18 19:27:57', 1, 3, 'A complaint', 'A title', 1, NULL, '2015-09-18 18:28:32', 'A diagnosis'),
(3, 1, 1, 5, 'A comment', '2015-09-20 17:28:21', 1, 22, 'A complaint', 'A title', 1, 2, '2015-09-20 16:48:28', 'A diagnosis'),
(4, 1, 1, 6, NULL, '2015-09-20 19:57:09', 1, 24, NULL, NULL, 1, 2, '2015-09-20 18:57:09', NULL),
(5, 1, 1, 6, '10', '2015-10-28 00:28:25', 1, 24, NULL, NULL, 1, 2, '2015-10-27 23:28:25', NULL),
(6, 1, 1, 9, 'A comment', '2015-11-22 23:13:45', 1, 27, 'A complaint and Examination / Symptom', 'A procedure/consultation', 1, 2, '2016-04-13 22:26:17', 'A fiagnosis'),
(7, 1, 1, 12, 'A comment', '2016-06-01 23:31:13', 1, 32, 'A complaint', 'A procedure', 2, 2, '2016-06-01 23:23:26', 'A diagnosis'),
(8, 1, 1, 12, 'A comment', '2016-06-26 00:11:45', 1, 32, NULL, NULL, 1, 2, '2016-06-25 23:11:45', NULL),
(9, 1, 1, 12, 'A comment', '2016-06-26 00:11:58', 1, 32, NULL, NULL, 1, 2, '2016-06-25 23:11:58', NULL),
(10, 1, 1, 12, 'A comment', '2016-06-26 00:13:34', 1, 32, NULL, NULL, 1, 2, '2016-06-25 23:13:34', NULL),
(11, 1, 1, 12, 'A comment', '2016-06-28 21:41:15', 1, 32, NULL, NULL, 1, 2, '2016-06-28 20:41:15', NULL),
(12, 1, 8, 13, '', '2016-09-18 15:34:34', 1, 33, NULL, NULL, 1, 2, '2016-09-18 14:34:34', NULL),
(13, 1, 4, 14, 'Another comment', '2016-11-26 01:24:12', 1, 35, 'Another Complaint and Examination', 'Another Procedure', 2, 2, '2016-11-26 00:25:10', 'Another Diagnosis'),
(14, 1, 4, 14, 'A comment', '2016-12-08 00:46:44', 1, 35, 'A complaint', 'A procedure', 2, NULL, '2016-12-07 23:49:21', 'A diagnosis'),
(15, 1, 4, 15, 'Comment', '2016-12-12 16:00:42', 1, 36, 'Complaint', 'Procedure', 1, 2, '2016-12-12 15:01:07', 'Diagnosis'),
(16, 1, 1, 16, '', '2016-12-24 18:56:33', 1, 34, NULL, NULL, 1, 1, '2016-12-24 17:56:33', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `film_appearance`
--

INSERT INTO `film_appearance` (`film_appearance_id`, `haematology_id`, `aniscocytosis`, `poikilocytosis`, `polychromasia`, `macrocytosis`, `microcytosis`, `hypochromia`, `sickle_cells`, `target_cells`, `spherocytes`, `nucleated_rbc`, `sickling_test`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, '0', '9', '8', '7', '6', '5', '4', '3', '2', '1', '23', '2016-12-08 00:44:12', '2016-12-08 00:44:12', 1);

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
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `haematology`
--

INSERT INTO `haematology` (`haematology_id`, `clinical_diagnosis_details`, `doctor_id`, `lab_attendant_id`, `laboratory_report`, `laboratory_ref`, `created_date`, `modified_date`, `treatment_id`, `encounter_id`, `active_fg`, `status_id`) VALUES
(1, 'A blood test', 1, 1, '                                        iuhu', 'iuj', '2016-09-15 00:33:20', '2016-12-08 00:44:12', 34, 0, 1, 7),
(2, '', 1, NULL, NULL, NULL, '2016-09-16 01:09:22', '2016-09-16 01:09:22', 32, 0, 1, 5),
(3, 'A test', 1, NULL, NULL, NULL, '2016-09-16 07:57:10', '2016-09-16 07:57:10', 32, 0, 1, 5),
(4, 'A test', 1, NULL, NULL, NULL, '2016-09-16 07:58:22', '2016-09-16 07:58:22', 32, 0, 1, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospital_info`
--

INSERT INTO `hospital_info` (`hospital_info_id`, `name`, `address`, `created_date`, `modified_date`) VALUES
(1, 'Umukoro Hospital', 'Room 012, Computer Building, Obafemi Awolowo University, Ile-Ife, Nigeria.', '2015-09-08 18:02:54', '2015-08-22 00:43:34'),
(2, 'PMS', 'Room 012, Computer Building, Obafemi Awolowo University, Ile-Ife, Nigeria.', '2015-08-19 15:49:14', '2015-08-19 15:49:14'),
(3, 'PMS', 'OAU', '2015-08-19 15:53:20', '2015-08-19 15:53:20'),
(4, 'PMS', 'OAU', '2015-08-19 16:10:59', '2015-08-19 16:10:59'),
(5, 'PMS', 'OAU', '2015-08-19 16:21:13', '2015-08-19 16:21:13'),
(6, 'PMS', 'OAU', '2015-08-19 16:30:47', '2015-08-19 16:30:47'),
(7, 'PMS', 'OAU', '2015-08-19 16:42:59', '2015-08-19 16:42:59'),
(8, 'Light House Hospital', '8, watch tower street, Onipanu, Lagos', '2015-09-18 16:55:59', '2015-09-18 16:55:59');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `microscopy`
--

INSERT INTO `microscopy` (`microscopy_id`, `urine_id`, `pus_cells`, `red_cells`, `epithelial_cells`, `casts`, `crystals`, `others`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 2, '9', '0', '1', '2', '3', '4', '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(2, 1, '', '', '', '', '', '', '2016-04-10 20:38:25', '2016-04-10 20:38:25', 1),
(3, 3, '10', '10', '10', '10', '10', '10', '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `outgoing_drugs`
--

INSERT INTO `outgoing_drugs` (`outgoing_drugs_id`, `drug_id`, `qty`, `unit_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 2, 1, '2015-11-22 21:46:46', '2015-11-22 21:46:46', 1),
(2, 2, 2, 1, '2015-11-22 21:46:46', '2015-11-22 21:46:46', 1),
(3, 3, 2, 1, '2015-12-06 16:00:49', '2015-12-06 16:00:49', 1),
(4, 4, 2, 1, '2016-02-29 01:10:19', '2016-02-29 01:10:19', 1),
(5, 5, 2, 1, '2016-02-29 01:10:20', '2016-02-29 01:10:20', 1),
(6, 1, 2, 1, '2016-04-02 10:20:59', '2016-04-02 10:20:59', 1),
(7, 6, 2, 1, '2016-04-02 10:20:59', '2016-04-02 10:20:59', 1),
(8, 7, 2, 1, '2016-04-13 23:26:50', '2016-04-13 23:26:50', 1),
(9, 7, 2, 1, '2016-05-30 02:09:08', '2016-05-30 02:09:08', 1),
(10, 3, 2, 1, '2016-12-24 18:57:05', '2016-12-24 18:57:05', 1),
(11, 8, 2, 1, '2017-01-20 23:20:46', '2017-01-20 23:20:46', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parasitology_details`
--

INSERT INTO `parasitology_details` (`pdetail_id`, `preq_id`, `pref_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 12, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(2, 1, 13, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(3, 1, 4, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(4, 1, 5, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(5, 1, 6, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(6, 1, 7, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(7, 1, 8, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(8, 1, 9, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(9, 1, 14, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1),
(10, 1, 15, '2016-03-15 21:45:37', '2016-03-15 21:45:40', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parasitology_req`
--

INSERT INTO `parasitology_req` (`preq_id`, `treatment_id`, `encounter_id`, `nature_of_specimen`, `investigation_req`, `diagnosis`, `date_reported`, `created_date`, `modified_date`, `active_fg`, `doctor_id`, `lab_attendant_id`, `status_id`, `pref_id`, `lab_num`, `lab_comment`) VALUES
(1, 24, 0, '1', '2', 'A test', NULL, '2015-09-20 21:14:11', '2016-03-15 21:45:40', 1, 1, 1, 7, NULL, '4', '3'),
(2, 34, 0, NULL, NULL, 'A parasitology test', NULL, '2016-09-16 08:28:40', '2016-09-16 08:28:40', 1, 1, NULL, 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patient_id` int(11) unsigned NOT NULL,
  `surname` varchar(25) DEFAULT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `middlename` varchar(25) DEFAULT NULL,
  `regNo` varchar(30) DEFAULT NULL,
  `home_address` varchar(150) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  `sex` enum('Male','Female','Emer') DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `nok_firstname` varchar(25) DEFAULT NULL,
  `nok_middlename` varchar(25) DEFAULT NULL,
  `nok_surname` varchar(25) DEFAULT NULL,
  `nok_address` varchar(150) DEFAULT NULL,
  `nok_telephone` varchar(20) DEFAULT NULL,
  `nok_relationship` int(10) unsigned DEFAULT '9',
  `citizenship` varchar(25) DEFAULT NULL,
  `religion` varchar(25) DEFAULT NULL,
  `family_position` int(11) DEFAULT NULL,
  `mother_status` varchar(25) DEFAULT NULL,
  `father_status` varchar(25) DEFAULT NULL,
  `marital_status` varchar(25) DEFAULT NULL,
  `no_of_children` int(11) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `surname`, `firstname`, `middlename`, `regNo`, `home_address`, `telephone`, `sex`, `height`, `weight`, `birth_date`, `nok_firstname`, `nok_middlename`, `nok_surname`, `nok_address`, `nok_telephone`, `nok_relationship`, `citizenship`, `religion`, `family_position`, `mother_status`, `father_status`, `marital_status`, `no_of_children`, `occupation`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'mbakwe', 'caleb', 'Chukwuezugo', 'CSC/2008/065', 'Room 012, computer building, Obafemi Awolowo University', '1234567890', 'Male', 10, 10, '1991-07-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '1234567890', 5, 'Nigeria', 'CHRISTAINITY', 4, 'DEAD', 'ALIVE', 'SINGLE', 0, 'Student', '2015-08-22 01:28:28', '2015-08-22 01:42:13', 1),
(2, 'Adeoye', 'Abiodun', 'M', 'OZONE/2015', 'Room 012, computer building, Obafemi Awolowo University', '+23456789', 'Male', 10, 10, '2015-08-03', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '08099358588', 4, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 0, 'Student', '2015-09-03 14:48:52', '2015-10-11 17:58:28', 1),
(3, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'HOME/2', 'Room 012, computer building, Obafemi Awolowo University', '12', 'Male', 12, 12, '2015-08-11', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '123', 8, 'Nigeria', 'ISLAM', 2, 'ALIVE', 'ALIVE', 'SINGLE', 0, 'dev', '2015-09-11 19:12:37', '2015-11-22 19:57:18', 1),
(4, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'HOME/3', 'Room 012, computer building, Obafemi Awolowo University', '08099358588', 'Male', 10, 10, '2015-09-18', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '08099358588', 8, 'Nigeria', 'ISLAM', 2, 'ALIVE', 'ALIVE', 'SINGLE', 0, 'Chilling', '2015-09-18 18:27:17', '2015-11-22 20:01:25', 1),
(5, 'Bull', 'John', 'Chukwuezugo', 'HOME/6', '8, watch tower street, Onipanu', '08099358588', 'Male', 10, 10, '2015-09-18', 'Caleb', 'Chukwuezugo', 'Mbakwe', '8, watch tower street, Onipanu', '08099358588', 9, 'Nigerian', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'EA', '2015-09-18 19:10:34', '2016-04-02 10:25:07', 1),
(6, 'mbakwe', 'caleb', 'chukwuezugo', 'HOME/1', 'Room 012, computer building, Obafemi Awolowo University', '123456789', 'Male', 10, 10, '2015-09-26', 'Caleb', 'Chukwuezugo', 'Mbakwe', 'Room 012, computer building, Obafemi Awolowo University', '1234567890', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 0, 'dev', '2015-09-26 12:37:49', '2015-10-11 17:58:58', 1),
(7, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'HOME/5', '8, watch tower street, Onipanu', '08099358588', 'Male', 10, 10, '2015-12-06', 'Caleb', 'Chukwuezugo', 'Mbakwe', '8, watch tower street, Onipanu', '08099358588', 1, 'Nigeria', 'ISLAM', 1, 'ALIVE', 'ALIVE', 'SINGLE', 2, 'dev', '2015-12-06 16:18:49', '2015-12-06 16:22:36', 1),
(8, 'Mbakwe', 'Caleb', 'Chukwuezugo', 'HOME/7', '8, watch tower street, Onipanu', '08099358588', 'Male', 10, 10, '2016-05-30', 'Caleb', 'Chukwuezugo', 'Mbakwe', '8, watch tower street, Onipanu', '08099358588', 5, 'Nigeria', 'ISLAM', 2, 'ALIVE', 'ALIVE', 'SINGLE', 1, 'EA', '2016-05-30 02:10:35', '2016-05-30 02:12:46', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient_queue`
--

INSERT INTO `patient_queue` (`patient_queue_id`, `patient_id`, `doctor_id`, `active_fg`, `created_date`, `modified_date`) VALUES
(1, 2, NULL, 0, '2015-09-03 14:48:52', '2015-09-03 14:48:59'),
(2, 2, 1, 0, '2015-09-03 14:48:59', '2015-09-03 14:49:03'),
(3, 1, NULL, 0, '2015-09-03 16:05:24', '2015-09-03 16:05:26'),
(4, 1, 1, 0, '2015-09-03 16:05:26', '2015-09-03 16:41:26'),
(5, 1, 1, 0, '2015-09-03 17:17:27', '2015-09-11 16:30:06'),
(6, 1, NULL, 0, '2015-09-11 16:30:06', '2015-09-11 16:30:46'),
(7, 1, 1, 0, '2015-09-11 16:30:46', '2015-09-14 18:54:49'),
(8, 3, NULL, 0, '2015-09-11 19:12:37', '2015-09-11 19:12:39'),
(9, 3, 1, 0, '2015-09-11 19:12:39', '2015-09-11 19:12:48'),
(10, 1, 1, 0, '2015-09-14 18:55:32', '2015-09-18 18:01:26'),
(11, 1, 2, 0, '2015-09-18 18:01:26', '2015-09-18 18:01:36'),
(12, 1, 1, 0, '2015-09-18 18:01:36', '2015-09-18 18:01:50'),
(13, 1, 2, 0, '2015-09-18 18:01:50', '2015-09-18 18:21:37'),
(14, 4, NULL, 0, '2015-09-18 18:27:17', '2015-09-18 18:27:21'),
(15, 4, 2, 0, '2015-09-18 18:27:21', '2015-09-18 18:32:48'),
(16, 2, NULL, 0, '2015-09-18 18:33:00', '2015-09-18 18:33:04'),
(17, 2, 2, 0, '2015-09-18 18:33:04', '2015-09-18 18:42:58'),
(18, 1, 2, 0, '2015-09-18 18:36:02', '2015-09-18 19:38:41'),
(19, 5, NULL, 0, '2015-09-18 19:10:34', '2015-09-18 19:11:00'),
(20, 2, NULL, 0, '2015-09-18 19:10:49', '2015-09-20 14:16:49'),
(21, 5, 1, 0, '2015-09-18 19:11:00', '2015-11-22 22:19:35'),
(22, 1, 1, 0, '2015-09-18 19:38:41', '2015-09-18 19:38:50'),
(23, 1, NULL, 0, '2015-09-18 19:39:02', '2015-09-18 19:39:12'),
(24, 1, 1, 0, '2015-09-18 19:39:12', '2015-09-20 14:14:07'),
(25, 2, 1, 0, '2015-09-20 14:16:49', '2015-09-20 17:56:22'),
(26, 1, 1, 0, '2015-09-20 14:19:52', '2015-09-20 17:56:11'),
(27, 1, NULL, 0, '2015-09-20 17:56:16', '2015-09-20 19:39:52'),
(28, 2, NULL, 0, '2015-09-20 17:56:22', '2015-09-20 17:56:33'),
(29, 2, 1, 0, '2015-09-20 17:56:33', '2015-09-20 18:05:47'),
(30, 1, 1, 0, '2015-09-20 19:39:52', '2015-09-20 20:51:31'),
(31, 1, 2, 0, '2015-09-20 20:51:31', '2015-09-20 21:40:26'),
(32, 6, NULL, 0, '2015-09-26 12:38:10', '2015-10-11 13:50:24'),
(33, 6, 1, 0, '2015-10-11 13:50:24', '2015-10-11 15:08:42'),
(34, 4, NULL, 0, '2015-11-22 19:58:58', '2015-11-22 20:02:04'),
(35, 4, 1, 0, '2015-11-22 20:02:04', '2016-03-28 22:57:41'),
(36, 1, NULL, 0, '2015-11-22 21:56:32', '2015-11-22 21:56:44'),
(37, 1, 1, 0, '2015-11-22 21:56:44', '2015-11-22 22:36:30'),
(38, 1, NULL, 0, '2015-12-06 14:24:02', '2016-05-29 14:15:43'),
(39, 7, NULL, 0, '2015-12-06 16:18:59', '2016-03-28 22:16:08'),
(40, 7, 1, 0, '2016-03-28 22:16:08', '2016-03-28 23:30:56'),
(41, 4, 1, 0, '2016-03-28 22:57:50', '2016-03-28 23:04:44'),
(42, 4, 1, 0, '2016-03-28 23:09:17', '2016-03-28 23:11:14'),
(43, 4, NULL, 0, '2016-04-09 11:34:22', '2016-04-09 11:34:24'),
(44, 4, 1, 0, '2016-04-09 11:34:24', '2016-04-28 22:55:16'),
(45, 1, 1, 0, '2016-05-29 14:15:43', '2016-05-29 14:20:08'),
(46, 1, 1, 0, '2016-05-29 14:20:13', '2016-05-29 14:22:22'),
(47, 1, 1, 0, '2016-05-29 14:22:42', '2016-05-29 14:23:06'),
(48, 1, NULL, 0, '2016-05-29 23:58:23', '2016-05-29 23:58:25'),
(49, 1, 1, 0, '2016-05-29 23:58:25', '2016-05-30 00:19:55'),
(50, 1, 1, 0, '2016-05-30 00:20:16', '2016-05-30 02:02:45'),
(51, 1, 1, 0, '2016-05-30 02:02:54', '2016-05-30 02:04:01'),
(52, 1, 1, 0, '2016-05-30 02:04:47', '2016-05-30 02:04:52'),
(53, 8, NULL, 0, '2016-05-30 02:10:35', '2016-05-30 02:10:38'),
(54, 8, 1, 0, '2016-05-30 02:10:38', '2016-09-18 15:04:06'),
(55, 1, 1, 0, '2016-06-25 21:42:38', '2016-11-02 17:09:17'),
(56, 1, 1, 0, '2016-11-02 17:10:39', '2016-11-03 11:32:11'),
(57, 4, 1, 0, '2016-11-26 01:22:34', '2016-11-26 01:23:40'),
(58, 1, 1, 0, '2016-12-12 15:58:39', '2017-01-23 22:30:51'),
(59, 4, 1, 1, '2016-12-12 15:58:49', '2016-12-12 15:58:49'),
(60, 3, NULL, 1, '2016-12-26 09:08:24', '2016-12-26 09:08:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_role_id`, `userid`, `staff_permission_id`, `staff_role_id`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 2, 1, '2015-08-19 16:47:43', '2015-08-19 16:47:43', 1),
(2, 2, 2, 1, '2015-08-19 16:50:59', '2015-09-18 19:09:50', 0),
(3, 3, 2, 1, '2015-08-19 17:20:46', '2015-08-19 17:20:46', 1),
(4, 4, 2, 1, '2015-08-19 17:30:33', '2015-08-19 17:30:33', 1),
(5, 5, 2, 1, '2015-08-19 17:42:40', '2015-08-19 17:42:40', 1),
(6, 1, 2, 16, '2015-08-22 01:09:08', '2015-08-22 01:09:08', 1),
(7, 1, 2, 3, '2015-08-22 01:10:04', '2015-08-22 01:10:04', 1),
(8, 1, 2, 2, '2015-09-02 19:33:02', '2015-09-02 19:33:02', 1),
(9, 1, 2, 4, '2015-09-02 19:33:03', '2015-09-02 19:33:03', 1),
(10, 1, 2, 5, '2015-09-02 19:33:04', '2015-09-02 19:33:04', 1),
(11, 1, 2, 6, '2015-09-02 19:33:05', '2015-09-02 19:33:05', 1),
(12, 1, 2, 7, '2015-09-02 19:33:05', '2015-09-02 19:33:05', 1),
(13, 1, 2, 8, '2015-09-02 19:33:05', '2015-09-02 19:33:05', 1),
(14, 1, 2, 9, '2015-09-02 19:33:06', '2015-09-02 19:33:06', 1),
(15, 1, 2, 10, '2015-09-02 19:33:06', '2015-09-02 19:33:06', 1),
(16, 1, 2, 11, '2015-09-02 19:33:07', '2015-09-02 19:33:07', 1),
(17, 1, 2, 12, '2015-09-02 19:33:07', '2015-09-02 19:33:07', 1),
(18, 1, 2, 13, '2015-09-02 19:33:08', '2015-09-02 19:33:08', 1),
(19, 1, 2, 14, '2015-09-02 19:33:08', '2015-09-02 19:33:08', 1),
(20, 1, 2, 15, '2015-09-02 19:33:09', '2015-09-02 19:33:09', 1),
(21, 1, 2, 17, '2015-09-02 19:33:09', '2015-09-02 19:33:09', 1),
(22, 1, 2, 18, '2015-09-02 19:33:10', '2015-09-02 19:33:10', 1),
(23, 1, 2, 19, '2015-09-02 19:33:11', '2015-09-02 19:33:11', 1),
(24, 1, 2, 20, '2015-09-02 19:33:11', '2015-09-02 19:33:11', 1),
(25, 2, 2, 4, '2015-09-10 18:40:36', '2015-09-18 19:09:31', 0),
(26, 5, 2, 1, '2015-09-16 19:13:35', '2015-09-16 19:13:35', 1),
(27, 2, 2, 2, '2015-09-18 18:00:05', '2015-09-18 19:10:05', 0),
(28, 2, 2, 4, '2015-09-18 19:09:55', '2015-09-18 19:09:55', 1),
(29, 2, 2, 2, '2015-09-20 20:36:52', '2015-09-20 20:36:52', 1),
(30, 2, 1, 1, '2015-11-19 21:46:42', '2015-11-19 21:46:42', 1),
(31, 2, 2, 15, '2016-09-06 21:31:48', '2016-09-06 21:31:48', 1),
(32, 3, 2, 2, '2016-09-06 22:22:26', '2016-09-06 22:22:26', 1),
(33, 5, 2, 19, '2016-09-06 22:22:43', '2016-09-06 22:22:43', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pharmacist_outgoing_drug`
--

INSERT INTO `pharmacist_outgoing_drug` (`pharmacist_outgoing_drug_id`, `pharmacist_id`, `outgoing_drug_id`, `created_date`, `active_fg`) VALUES
(1, 1, 1, '2015-11-22 21:46:46', 1),
(2, 1, 2, '2015-11-22 21:46:46', 1),
(3, 1, 3, '2015-12-06 16:00:49', 1),
(4, 1, 4, '2016-02-29 01:10:20', 1),
(5, 1, 5, '2016-02-29 01:10:20', 1),
(6, 1, 6, '2016-04-02 10:20:59', 1),
(7, 1, 7, '2016-04-02 10:20:59', 1),
(8, 1, 8, '2016-04-13 23:26:50', 1),
(9, 1, 9, '2016-05-30 02:09:08', 1),
(10, 1, 10, '2016-12-24 18:57:05', 1),
(11, 1, 11, '2017-01-20 23:20:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `prescription_id` int(11) unsigned NOT NULL,
  `prescription` varchar(255) DEFAULT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `modified_by` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`prescription_id`, `prescription`, `treatment_id`, `encounter_id`, `status`, `modified_by`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'paracetamol', 1, 0, 1, 2, '2015-09-03 16:41:18', '2015-09-03 16:41:18', 1),
(2, 'paracetamol', 1, 1, 2, 1, '2015-09-03 17:29:04', '2015-09-03 17:29:04', 1),
(3, 'ampcillin', 1, 1, 2, 1, '2015-09-03 17:29:04', '2015-09-03 17:29:04', 1),
(4, 'paracetamol', 1, 0, 1, 2, '2015-09-14 18:53:08', '2015-09-14 18:53:08', 1),
(5, 'paracetamol', 3, 2, 1, 1, '2015-09-18 19:28:32', '2015-09-18 19:28:32', 1),
(6, 'paracetamol', 22, 0, 1, 2, '2015-09-20 17:20:51', '2015-09-20 17:20:51', 1),
(7, 'paracetamol', 22, 3, 1, 1, '2015-09-20 17:48:28', '2015-09-20 17:48:28', 1),
(8, 'paracetamol', 23, 0, 1, 2, '2015-09-20 18:05:44', '2015-09-20 18:05:44', 1),
(9, 'paracetamol', 24, 0, 2, 2, '2015-09-20 19:56:43', '2015-09-20 19:56:43', 1),
(10, 'antigen A', 24, 0, 2, 2, '2015-09-20 19:56:43', '2015-09-20 19:56:43', 1),
(11, 'paracetamol', 24, 0, 2, 2, '2015-09-20 21:39:58', '2015-09-20 21:39:58', 1),
(12, 'antigen A', 24, 0, 2, 2, '2015-09-20 21:39:58', '2015-09-20 21:39:58', 1),
(13, 'antigen B', 24, 0, 2, 2, '2015-09-20 21:39:58', '2015-09-20 21:39:58', 1),
(14, 'paracetamol', 25, 0, 1, 2, '2015-10-11 13:51:40', '2015-10-11 13:51:40', 1),
(15, 'paracetamol', 21, 0, 1, 2, '2015-11-22 21:43:32', '2015-11-22 21:43:32', 1),
(16, 'panadol extra', 21, 0, 1, 2, '2015-11-22 21:43:32', '2015-11-22 21:43:32', 1),
(17, 'paracetamol', 27, 6, 2, 1, '2015-11-22 23:14:28', '2015-11-22 23:14:28', 1),
(18, 'Paracetamol', 26, 0, 2, 2, '2016-03-13 00:56:26', '2016-03-13 00:56:26', 1),
(19, 'Water', 26, 0, 2, 2, '2016-03-13 00:56:26', '2016-03-13 00:56:26', 1),
(20, 'A prescription', 27, 6, 2, 1, '2016-04-13 23:26:17', '2016-04-13 23:26:17', 1),
(21, 'Panadol', 27, 6, 2, 1, '2016-04-13 23:26:17', '2016-04-13 23:26:17', 1),
(22, 'panadol', 29, 0, 2, 2, '2016-04-13 23:38:08', '2016-04-13 23:38:08', 1),
(23, 'Panadol', 32, 7, 1, 1, '2016-06-02 00:23:26', '2016-06-02 00:23:26', 1),
(24, 'panadol', 35, 13, 1, 1, '2016-11-26 01:25:10', '2016-11-26 01:25:10', 1),
(25, 'paracetamol', 35, 14, 1, 1, '2016-12-08 00:49:21', '2016-12-08 00:49:21', 1),
(26, 'panadol', 36, 0, 1, 2, '2016-12-12 15:59:16', '2016-12-12 15:59:16', 1),
(27, 'panadol', 34, 0, 2, 2, '2016-12-24 18:39:45', '2016-12-24 18:39:45', 1),
(28, 'panadol', 34, 0, 2, 2, '2016-12-24 18:53:40', '2016-12-24 18:53:40', 1),
(29, 'mmm', 37, 0, 2, 2, '2017-01-20 23:20:04', '2017-01-20 23:20:04', 1),
(30, 'kk', 37, 0, 2, 2, '2017-01-20 23:20:04', '2017-01-20 23:20:04', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescription_outgoing_drug`
--

INSERT INTO `prescription_outgoing_drug` (`prescription_outgoing_drug_id`, `prescription_id`, `outgoing_drug_id`, `created_date`, `active_fg`) VALUES
(1, 2, 1, '2015-11-22 21:46:46', 1),
(2, 3, 2, '2015-11-22 21:46:46', 1),
(3, 17, 3, '2015-12-06 16:00:49', 1),
(4, 9, 4, '2016-02-29 01:10:20', 1),
(5, 11, 4, '2016-02-29 01:10:20', 1),
(6, 10, 5, '2016-02-29 01:10:20', 1),
(7, 12, 5, '2016-02-29 01:10:20', 1),
(8, 13, 5, '2016-02-29 01:10:20', 1),
(9, 18, 6, '2016-04-02 10:20:59', 1),
(10, 19, 7, '2016-04-02 10:20:59', 1),
(11, 20, 8, '2016-04-13 23:26:50', 1),
(12, 21, 8, '2016-04-13 23:26:50', 1),
(13, 22, 9, '2016-05-30 02:09:08', 1),
(14, 27, 10, '2016-12-24 18:57:05', 1),
(15, 28, 10, '2016-12-24 18:57:05', 1),
(16, 29, 11, '2017-01-20 23:20:46', 1),
(17, 30, 11, '2017-01-20 23:20:46', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profile_id`, `userid`, `surname`, `firstname`, `middlename`, `department_id`, `work_address`, `home_address`, `telephone`, `sex`, `height`, `weight`, `birth_date`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 'mbakwe', 'caleb', 'c', 2, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '+2348030420046', 'MALE', 10, 100, '1991-07-03', '2015-08-19 18:06:04', '2015-09-04 21:11:48', 1),
(2, 2, 'mbakwe', 'caleb', 'chukwuezugo', 2, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '1234567890', 'MALE', 12, 12, '1991-07-03', '2015-09-07 23:37:11', '2016-09-06 21:34:44', 1),
(3, 3, 'james', 'samuel', 'junior', 2, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '1234567890', 'MALE', 12, 12, '1991-07-03', '2016-09-06 21:30:44', '2016-09-06 21:51:19', 1),
(4, 4, 'mbakwe', 'caleb', 'chukwuebuka', 2, 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', 'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu', '08099358588', 'MALE', 10, 10, '2016-09-13', '2016-09-06 21:52:30', '2016-09-06 21:52:30', 1),
(5, 5, 'mbakwe', 'marcus', 'junior', 2, '8, watch tower street, onipanu\r\nroom 012, computer building, obafemi awolowo university', '8, watch tower street, onipanu', '08099358588', 'MALE', 10, 10, '2016-09-13', '2016-09-06 22:31:35', '2016-09-06 22:31:35', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radiology`
--

INSERT INTO `radiology` (`radiology_id`, `doctor_id`, `lab_attendant_id`, `ward_clinic_id`, `xray_case_id`, `xray_size_id`, `treatment_id`, `encounter_id`, `consultant_in_charge`, `checked_by`, `radiographers_note`, `radiologists_report`, `created_date`, `modified_date`, `lmp`, `active_fg`, `status_id`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 2, 0, NULL, NULL, NULL, NULL, '2015-09-11 19:21:22', '2015-09-11 19:21:22', NULL, 1, 5),
(2, 1, NULL, NULL, NULL, NULL, 22, 0, NULL, NULL, NULL, NULL, '2015-09-20 17:21:49', '2015-09-20 17:21:49', NULL, 1, 5),
(3, 1, NULL, NULL, NULL, NULL, 22, 0, NULL, NULL, NULL, NULL, '2015-09-20 17:48:48', '2015-09-20 17:48:48', NULL, 1, 5),
(4, 1, NULL, NULL, NULL, NULL, 26, 0, NULL, NULL, NULL, NULL, '2016-02-29 00:24:01', '2016-02-29 00:24:01', NULL, 1, 5),
(5, 1, NULL, NULL, NULL, NULL, 33, 0, NULL, NULL, NULL, NULL, '2016-05-30 03:09:14', '2016-05-30 03:09:14', NULL, 1, 5),
(6, 1, NULL, NULL, NULL, NULL, 33, 0, NULL, NULL, NULL, NULL, '2016-09-15 00:41:21', '2016-09-15 00:41:21', NULL, 1, 5),
(7, 1, NULL, NULL, NULL, NULL, 32, 0, NULL, NULL, NULL, NULL, '2016-09-16 08:23:40', '2016-09-16 08:23:40', NULL, 1, 5),
(8, 1, NULL, NULL, NULL, NULL, 32, 0, NULL, NULL, NULL, NULL, '2016-09-16 08:23:56', '2016-09-16 08:23:56', NULL, 1, 5),
(9, 1, NULL, NULL, NULL, NULL, 32, 0, NULL, NULL, NULL, NULL, '2016-11-02 16:53:40', '2016-11-02 16:53:40', NULL, 1, 5),
(10, 1, NULL, NULL, NULL, NULL, 32, 0, NULL, NULL, NULL, NULL, '2016-11-02 16:54:21', '2016-11-02 16:54:21', NULL, 1, 5),
(11, 1, NULL, NULL, NULL, NULL, 32, 0, NULL, NULL, NULL, NULL, '2016-11-16 21:13:50', '2016-11-16 21:13:50', NULL, 1, 5),
(12, 1, 1, '001', 6, 1, 34, 0, '3', '1', '2', 'A report', '2016-11-26 01:25:37', '2016-12-08 00:42:11', '', 1, 7),
(13, 1, NULL, NULL, NULL, NULL, 34, 0, NULL, NULL, NULL, NULL, '2017-01-20 23:10:42', '2017-01-20 23:10:42', NULL, 1, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radiology_request`
--

INSERT INTO `radiology_request` (`radiology_request_id`, `radiology_id`, `clinical_diagnosis_details`, `previous_operation`, `any_known_allergies`, `previous_xray`, `xray_number`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 1, 'A shing test', NULL, NULL, NULL, NULL, '2015-09-11 19:21:22', '2015-09-11 19:21:22', 1),
(2, 2, 'A test request', NULL, NULL, NULL, NULL, '2015-09-20 17:21:49', '2015-09-20 17:21:49', 1),
(3, 3, 'A test', NULL, NULL, NULL, NULL, '2015-09-20 17:48:48', '2015-09-20 17:48:48', 1),
(4, 4, 'To see the client''s issues', NULL, NULL, NULL, NULL, '2016-02-29 00:24:01', '2016-02-29 00:24:01', 1),
(5, 5, '', NULL, NULL, NULL, NULL, '2016-05-30 03:09:14', '2016-05-30 03:09:14', 1),
(6, 6, 'A test', NULL, NULL, NULL, NULL, '2016-09-15 00:41:21', '2016-09-15 00:41:21', 1),
(7, 7, '', NULL, NULL, NULL, NULL, '2016-09-16 08:23:41', '2016-09-16 08:23:41', 1),
(8, 8, '', NULL, NULL, NULL, NULL, '2016-09-16 08:23:56', '2016-09-16 08:23:56', 1),
(9, 9, 'A test description', NULL, NULL, NULL, NULL, '2016-11-02 16:53:40', '2016-11-02 16:53:40', 1),
(10, 10, 'Request Test clear test desctiption.', NULL, NULL, NULL, NULL, '2016-11-02 16:54:21', '2016-11-02 16:54:21', 1),
(11, 11, 'A radiology request', NULL, NULL, NULL, NULL, '2016-11-16 21:13:50', '2016-11-16 21:13:50', 1),
(12, 12, 'A description for radiology', '6', '7', 1, '8', '2016-11-26 01:25:37', '2016-12-08 00:42:11', 1),
(13, 13, 'Let it rain', NULL, NULL, NULL, NULL, '2017-01-20 23:10:42', '2017-01-20 23:10:42', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `roster`
--

INSERT INTO `roster` (`roster_id`, `user_id`, `created_by`, `dept_id`, `duty`, `duty_date`, `created_date`, `modified_date`, `modified_by`, `active_fg`) VALUES
(1, 1, 1, 2, 10, '2016-05-01', '2016-05-26 23:41:57', '2016-05-26 23:42:13', 1, 0),
(2, 1, 1, 2, 10, '2016-05-01', '2016-05-26 23:42:01', '2016-05-26 23:42:08', 1, 0),
(3, 2, 1, 2, 8, '2016-05-01', '2016-05-26 23:42:44', '2016-05-26 23:42:44', NULL, 1),
(4, 2, 1, 2, 9, '2016-05-01', '2016-05-26 23:42:46', '2016-05-26 23:42:46', NULL, 1),
(5, 2, 1, 2, 10, '2016-05-02', '2016-05-26 23:42:51', '2016-05-26 23:42:51', NULL, 1),
(6, 1, 1, 2, 8, '2016-05-03', '2016-05-26 23:42:53', '2016-05-26 23:42:53', NULL, 1),
(7, 1, 1, 2, 9, '2016-05-03', '2016-05-26 23:42:56', '2016-05-26 23:42:56', NULL, 1),
(8, 1, 1, 2, 10, '2016-05-03', '2016-05-26 23:42:59', '2016-05-26 23:42:59', NULL, 1),
(9, 1, 1, 2, 8, '2016-06-07', '2016-06-06 21:18:10', '2016-06-06 21:18:10', NULL, 1),
(10, 1, 1, 2, 8, '2016-06-07', '2016-06-06 21:18:13', '2016-06-06 21:18:13', NULL, 1),
(11, 1, 1, 2, 8, '2016-06-07', '2016-06-06 21:18:30', '2016-06-06 21:18:30', NULL, 1),
(12, 2, 1, 2, 8, '2016-06-07', '2016-06-06 21:18:35', '2016-06-06 21:18:35', NULL, 1),
(13, 1, 1, 2, 8, '2016-09-01', '2016-08-31 21:20:55', '2016-08-31 21:20:55', NULL, 1),
(14, 1, 1, 2, 9, '2016-09-01', '2016-08-31 21:21:01', '2016-08-31 21:21:01', NULL, 1),
(15, 1, 1, 2, 10, '2016-09-02', '2016-08-31 21:21:07', '2016-08-31 21:21:07', NULL, 1),
(16, 1, 1, 2, 8, '2016-09-08', '2016-09-04 22:55:02', '2016-09-04 22:55:02', NULL, 1),
(17, 2, 1, 2, 9, '2016-09-09', '2016-09-04 22:55:08', '2016-09-04 22:55:08', NULL, 1),
(18, 1, 1, 2, 8, '2016-09-06', '2016-09-06 18:41:50', '2016-09-06 18:41:50', NULL, 1),
(19, 1, 1, 2, 8, '2016-12-21', '2016-12-20 23:38:14', '2016-12-20 23:38:14', NULL, 1),
(20, 2, 1, 2, 9, '2016-12-21', '2016-12-20 23:38:18', '2016-12-20 23:38:18', NULL, 1),
(21, 5, 1, 2, 10, '2016-12-21', '2016-12-20 23:38:35', '2016-12-20 23:38:35', NULL, 1);

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
(1, '2015-01-26 12:24:47', '2015-01-26 12:24:54', 'administrator', 'administrator', 1),
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `doctor_id`, `patient_id`, `consultation`, `symptoms`, `diagnosis`, `comments`, `created_date`, `modified_date`, `treatment_status`, `bill_status`, `active_fg`) VALUES
(1, 1, 1, 'A consultation', 'A symptom', 'A diagnosis', 'A comment', '2015-09-03 16:41:18', '2015-09-14 19:02:20', 2, 2, 1),
(2, 1, 1, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-09-14 18:53:08', '2015-09-14 20:04:38', 2, 2, 1),
(3, 2, 1, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-09-18 18:13:48', '2015-09-20 14:15:35', 2, 2, 1),
(4, 2, 2, 'a title', 'head aches', 'pregnant', '', '2015-09-18 18:42:52', '2015-10-11 15:16:40', 2, 2, 1),
(21, 1, 5, 'A title', 'A complaint', 'A dignosis', 'A comment', '2015-11-22 21:49:24', '2016-04-28 23:12:09', 2, 2, 1),
(22, 1, 1, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-09-20 17:20:51', '2015-09-20 17:57:15', 2, 2, 1),
(23, 1, 2, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-09-20 18:05:44', '2015-09-20 18:05:44', 2, 2, 1),
(24, 2, 1, 'A title', 'A complaint', 'A diagnosis', 'A commnt', '2015-09-20 21:39:58', '2015-10-28 00:29:03', 2, 2, 1),
(25, 1, 6, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-10-11 13:51:40', '2015-10-11 15:11:12', 2, 2, 1),
(26, 1, 4, 'Another procedure', 'Another complaint and Examination', 'A Diagnosis', 'Another comment', '2016-03-13 00:56:26', '2016-03-13 00:56:26', 2, 2, 1),
(27, 1, 1, 'A title', 'A complaint', 'A diagnosis', 'A comment', '2015-11-22 22:20:14', '2016-05-29 14:25:46', 2, 2, 1),
(28, 1, 1, ' An admitted procedure', 'An admitted complaint', ' An admitted diagnosis', ' An admitted comment', '2016-05-29 14:23:03', '2016-05-29 23:18:28', 2, 2, 1),
(29, 1, 4, ' A procedure', 'A complaint ', 'A diagnosis', 'A comment', '2016-04-28 22:55:14', '2016-05-29 14:28:16', 2, 2, 1),
(31, 1, 7, ' A procedure', 'A complaint and examination ', 'A diagnosis', 'A comment ', '2016-03-28 23:30:52', '2016-03-28 23:30:52', 1, 2, 1),
(32, 1, 1, ' A procedure', 'A complaint and Examination', ' A dgnosis', ' A comment', '2016-05-30 00:19:47', '2016-12-22 00:23:47', 2, 2, 1),
(33, 1, 8, 'A procedure', 'A Complaint and Examination', 'A diagnosis', 'A comment', '2016-09-18 15:04:02', '2016-09-18 15:40:40', 2, 2, 1),
(34, 1, 1, 'Procedure', 'Complaint and Examination', 'Diagnosis', 'Comment', '2016-12-24 18:53:40', '2016-12-24 18:53:40', 2, 1, 1),
(35, 1, 4, 'A procedure', 'A complaint and Examination', 'A Diagnosis', 'A comment', '2016-11-26 01:23:17', '2016-12-08 00:50:02', 2, 2, 1),
(36, 1, 4, 'Procedure', 'Complaint', 'Diagnosis', 'Comment', '2016-12-12 15:59:16', '2016-12-22 00:24:09', 2, 1, 1),
(37, 1, 4, 'mm', 'chemical guy', 'chenical', 'mm', '2017-01-20 23:20:04', '2017-01-20 23:20:04', 1, 1, 1);

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
  `symbol` char(8) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_ref`
--

INSERT INTO `unit_ref` (`unit_ref_id`, `unit`, `symbol`, `created_date`, `active_fg`) VALUES
(1, 'Kilogramme', 'kg', NULL, 1),
(2, 'Kilogramme', 'kg', NULL, 1),
(3, 'Killogramme', 'kg', NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urinalysis`
--

INSERT INTO `urinalysis` (`urinalysis_id`, `urine_id`, `appearance`, `ph`, `glucose`, `protein`, `bilirubin`, `urobillinogen`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 2, '3', '4', '5', '6', '7', '8', '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(2, 1, '', '', '', '', '', '', '2016-04-10 20:38:25', '2016-04-10 20:38:25', 1),
(3, 3, '10', '10', '10', '10', '10', '10', '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urine`
--

INSERT INTO `urine` (`urine_id`, `treatment_id`, `encounter_id`, `lab_attendant_id`, `clinical_diagnosis_details`, `investigation_required`, `doctor_id`, `laboratory_report`, `laboratory_ref`, `culture_value`, `created_date`, `modified_date`, `status_id`, `active_fg`) VALUES
(1, 24, 0, 1, 'A test', '', 1, '                                        ', '', '', '2015-09-20 21:13:33', '2016-04-10 20:38:25', 7, 1),
(2, 26, 0, 1, 'A description of a test request', '2', 1, 'A Repot                            ', '1', '50', '2016-03-13 00:54:08', '2016-03-15 21:38:43', 7, 1),
(3, 34, 0, 1, 'A microscopy test', '10', 1, 'A report                                                                        ', '10', 'Culture', '2016-09-16 08:34:19', '2016-11-16 21:36:05', 7, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urine_sensitivity`
--

INSERT INTO `urine_sensitivity` (`urine_sensitivity_id`, `urine_id`, `isolates`, `isolates_degree`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 2, 1, 1, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(2, 2, 2, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(3, 2, 3, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(4, 2, 4, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(5, 2, 5, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(6, 2, 6, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(7, 2, 7, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(8, 2, 8, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(9, 2, 9, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(10, 2, 10, 0, '2016-03-15 21:38:43', '2016-03-15 21:38:43', 1),
(11, 3, 1, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(12, 3, 2, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(13, 3, 3, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(14, 3, 4, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(15, 3, 5, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(16, 3, 6, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(17, 3, 7, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(18, 3, 8, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(19, 3, 9, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1),
(20, 3, 10, 0, '2016-11-16 21:35:45', '2016-11-16 21:36:05', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`userid`, `regNo`, `passcode`, `created_date`, `modified_date`, `status`, `active_fg`, `online_status`) VALUES
(1, 'PMS001', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-08-25 00:00:00', '2015-09-08 08:55:25', 1, 1, 1),
(2, 'PMS002', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-08-22 00:23:37', '2016-09-06 22:43:52', 1, 1, 0),
(3, 'PMS003', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2015-08-22 00:58:48', '2016-11-03 12:01:37', 2, 1, 0),
(4, 'PMS004', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2015-08-22 01:06:36', '2016-11-03 12:01:35', 2, 1, 0),
(5, 'pms001', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2015-09-16 19:13:35', '2016-09-06 21:49:41', 1, 0, 0),
(6, 'PMS005', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', '2016-09-06 19:19:59', '2016-09-06 22:50:38', 1, 1, 0);

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
  `others` varchar(30) DEFAULT NULL,
  `stereopsis` varchar(30) DEFAULT NULL,
  `amplitude_of_accomodation` varchar(30) DEFAULT NULL,
  `laboratory_report` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  `intra_ocular_pressure` varchar(30) DEFAULT NULL,
  `central_visual_field` varchar(30) DEFAULT NULL,
  `description` varchar(1025) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visual_skills_profile`
--

INSERT INTO `visual_skills_profile` (`visual_profile_id`, `doctor_id`, `treatment_id`, `encounter_id`, `distance_re`, `distance_le`, `distance_be`, `near_re`, `near_le`, `near_be`, `pinhole_acuity_re`, `pinhole_acuity_le`, `pinhole_acuity_be`, `colour_vision`, `others`, `stereopsis`, `amplitude_of_accomodation`, `laboratory_report`, `created_date`, `modified_date`, `active_fg`, `lab_attendant_id`, `status_id`, `intra_ocular_pressure`, `central_visual_field`, `description`) VALUES
(1, 1, 2, 0, '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', NULL, '10', '10', NULL, '2015-09-11 19:32:53', '2015-10-11 15:56:57', 1, 1, 7, NULL, NULL, 'Description'),
(2, 1, 24, 0, '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '', '', '', NULL, '2015-10-19 23:03:07', '2015-10-28 00:30:49', 1, 1, 7, '', '', 'Description'),
(3, 1, 32, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-09-16 08:34:26', '2016-09-16 08:34:26', 1, NULL, 5, NULL, NULL, 'Description'),
(4, 1, 32, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-09-16 08:35:53', '2016-09-16 08:35:53', 1, NULL, 5, NULL, NULL, 'Description'),
(5, 1, 36, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-12 16:50:38', '2016-12-12 16:50:38', 1, NULL, 5, NULL, NULL, 'Testing to see if recent edit worked'),
(6, 1, 34, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-12-13 00:50:11', '2016-12-13 00:50:11', 1, NULL, 5, NULL, NULL, 'Description');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vitals`
--

INSERT INTO `vitals` (`vitals_id`, `patient_id`, `encounter_id`, `added_by`, `temp`, `pulse`, `respiratory_rate`, `blood_pressure`, `height`, `weight`, `bmi`, `active_fg`, `created_date`) VALUES
(1, 1, NULL, 1, 90, 9, 9, '9', 9, 9, 9, 1, '2015-09-18 18:15:11'),
(2, 1, 5, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-10-28 00:28:25'),
(3, 1, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-12-06 14:24:21'),
(4, 1, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2015-12-06 14:25:21'),
(5, 1, 8, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-06-26 00:11:45'),
(6, 1, 9, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-06-26 00:11:58'),
(7, 1, 10, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-06-26 00:13:34'),
(8, 1, 11, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-06-28 21:41:15'),
(9, 1, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-12-21 01:06:31'),
(10, 4, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-12-21 01:24:21'),
(11, 1, NULL, 1, 10, 10, 10, '10', 10, 10, 10, 1, '2016-12-22 00:31:34');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ward_ref`
--

INSERT INTO `ward_ref` (`ward_ref_id`, `description`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'Ward 001', '2015-09-03 17:00:44', '2015-09-03 17:00:44', 1),
(2, 'Ward 002', '2015-10-11 15:10:27', '2015-10-11 15:10:27', 1),
(3, 'Ward 003', '2016-04-28 22:56:55', '2016-04-28 22:56:55', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `xray_no`
--

INSERT INTO `xray_no` (`xray_id`, `radiology_id`, `xray_number`, `casual_no`, `gp_no`, `ante_natal_no`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 12, '1', '2', '3', '4', '2016-12-08 00:42:11', '2016-12-08 00:42:11', 1);

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
  ADD PRIMARY KEY (`admission_id`),
  ADD KEY `fk_AdmittedBy` (`admitted_by`),
  ADD KEY `fk_PatientAdmitted` (`patient_id`),
  ADD KEY `fk_TreatmentAdmission` (`treatment_id`),
  ADD KEY `discharged_by` (`discharged_by`);

--
-- Indexes for table `admission_bed`
--
ALTER TABLE `admission_bed`
  ADD PRIMARY KEY (`admission_bed_id`),
  ADD KEY `bed_id` (`bed_id`),
  ADD KEY `admission_id` (`admission_id`);

--
-- Indexes for table `admission_req`
--
ALTER TABLE `admission_req`
  ADD PRIMARY KEY (`admission_req_id`),
  ADD UNIQUE KEY `treatment_id` (`treatment_id`);

--
-- Indexes for table `bed`
--
ALTER TABLE `bed`
  ADD PRIMARY KEY (`bed_id`),
  ADD KEY `fk_BedWard` (`ward_id`);

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
  ADD PRIMARY KEY (`bloodtest_id`),
  ADD UNIQUE KEY `haematology_id` (`haematology_id`),
  ADD KEY `fk_BloodTestHaematologyId` (`haematology_id`);

--
-- Indexes for table `chemical_pathology_details`
--
ALTER TABLE `chemical_pathology_details`
  ADD PRIMARY KEY (`cpdetails_id`),
  ADD KEY `FK_chemical_pathology_details` (`cpreq_id`),
  ADD KEY `FK_chemical_pathology_details_ref` (`cpref_id`);

--
-- Indexes for table `chemical_pathology_ref`
--
ALTER TABLE `chemical_pathology_ref`
  ADD PRIMARY KEY (`cpref_id`);

--
-- Indexes for table `chemical_pathology_request`
--
ALTER TABLE `chemical_pathology_request`
  ADD PRIMARY KEY (`cpreq_id`),
  ADD UNIQUE KEY `NewIndex1` (`laboratory_ref`),
  ADD KEY `fk_ChemicalTreatment` (`treatment_id`),
  ADD KEY `fk_ChemicalDoctor` (`doctor_id`),
  ADD KEY `fk_ChemicalStatus` (`status_id`);

--
-- Indexes for table `communication`
--
ALTER TABLE `communication`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `fk_MsgSender` (`sender_id`),
  ADD KEY `fk_MsgRecipient` (`recipient_id`);

--
-- Indexes for table `constant_bills`
--
ALTER TABLE `constant_bills`
  ADD PRIMARY KEY (`constant_bills_id`),
  ADD KEY `fk_treatment_bills` (`treatment_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `differential_count`
--
ALTER TABLE `differential_count`
  ADD PRIMARY KEY (`differential_count_id`),
  ADD UNIQUE KEY `haematology_id` (`haematology_id`),
  ADD KEY `fk_DiffCountHaematologyId` (`haematology_id`);

--
-- Indexes for table `drug_ref`
--
ALTER TABLE `drug_ref`
  ADD PRIMARY KEY (`drug_ref_id`);

--
-- Indexes for table `emergency`
--
ALTER TABLE `emergency`
  ADD PRIMARY KEY (`emergency_id`),
  ADD UNIQUE KEY `emergency_id` (`emergency_id`);

--
-- Indexes for table `emergency_detail`
--
ALTER TABLE `emergency_detail`
  ADD PRIMARY KEY (`emergency_status_id`),
  ADD UNIQUE KEY `emergency_status_id` (`emergency_status_id`);

--
-- Indexes for table `encounter`
--
ALTER TABLE `encounter`
  ADD PRIMARY KEY (`encounter_id`),
  ADD KEY `fk_PatientEncountered` (`patient_id`),
  ADD KEY `fk_PersonnelEncountered` (`personnel_id`),
  ADD KEY `fk_AdmissionEncounter` (`admission_id`);

--
-- Indexes for table `film_appearance`
--
ALTER TABLE `film_appearance`
  ADD PRIMARY KEY (`film_appearance_id`),
  ADD UNIQUE KEY `haematology_id` (`haematology_id`),
  ADD KEY `fk_FilmAppearanceHaematologyReportId` (`haematology_id`);

--
-- Indexes for table `haematology`
--
ALTER TABLE `haematology`
  ADD PRIMARY KEY (`haematology_id`),
  ADD KEY `fk_DoctorId` (`doctor_id`),
  ADD KEY `fk_TreatmentId` (`treatment_id`),
  ADD KEY `fk_HaematologyStatus` (`status_id`);

--
-- Indexes for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD PRIMARY KEY (`hospital_info_id`);

--
-- Indexes for table `microscopy`
--
ALTER TABLE `microscopy`
  ADD PRIMARY KEY (`microscopy_id`),
  ADD UNIQUE KEY `urine_id` (`urine_id`),
  ADD KEY `fk_MicroscopyUrineId` (`urine_id`);

--
-- Indexes for table `nok_relationship`
--
ALTER TABLE `nok_relationship`
  ADD PRIMARY KEY (`nok_relationship_id`);

--
-- Indexes for table `outgoing_drugs`
--
ALTER TABLE `outgoing_drugs`
  ADD PRIMARY KEY (`outgoing_drugs_id`),
  ADD KEY `fk_OutgoingDrugs` (`drug_id`),
  ADD KEY `fk_DrugUnits` (`unit_id`);

--
-- Indexes for table `parasitology_details`
--
ALTER TABLE `parasitology_details`
  ADD PRIMARY KEY (`pdetail_id`),
  ADD KEY `FK_parasitology_details_req_id` (`preq_id`),
  ADD KEY `FK_parasitology_details_ref_id` (`pref_id`);

--
-- Indexes for table `parasitology_ref`
--
ALTER TABLE `parasitology_ref`
  ADD PRIMARY KEY (`pref_id`);

--
-- Indexes for table `parasitology_req`
--
ALTER TABLE `parasitology_req`
  ADD PRIMARY KEY (`preq_id`),
  ADD KEY `fk_ParasitologyTreatmentId` (`treatment_id`),
  ADD KEY `fk_ParasitologyDoctorId` (`doctor_id`),
  ADD KEY `fk_ParasitologyStatusId` (`status_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `fk_PatientNok` (`nok_relationship`);

--
-- Indexes for table `patient_queue`
--
ALTER TABLE `patient_queue`
  ADD PRIMARY KEY (`patient_queue_id`),
  ADD KEY `fk_patientQueue` (`patient_id`),
  ADD KEY `fk_PatientDoctor` (`doctor_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_role_id`),
  ADD KEY `fk_PermisionRoleUserId` (`userid`),
  ADD KEY `fk_PermissionId` (`staff_permission_id`),
  ADD KEY `fk_RoleId` (`staff_role_id`);

--
-- Indexes for table `pharmacist_outgoing_drug`
--
ALTER TABLE `pharmacist_outgoing_drug`
  ADD PRIMARY KEY (`pharmacist_outgoing_drug_id`),
  ADD KEY `fk_Outgoing` (`outgoing_drug_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`prescription_id`),
  ADD KEY `fk_TreatmentPrescription` (`treatment_id`),
  ADD KEY `fk_PrescriptionStatus` (`status`);

--
-- Indexes for table `prescription_outgoing_drug`
--
ALTER TABLE `prescription_outgoing_drug`
  ADD PRIMARY KEY (`prescription_outgoing_drug_id`),
  ADD KEY `fk_Prescription` (`prescription_id`),
  ADD KEY `fk_OutgoingDrug` (`outgoing_drug_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `fk_IdentificationUserId` (`userid`),
  ADD KEY `fk_DepartmentProfile` (`department_id`);

--
-- Indexes for table `radiology`
--
ALTER TABLE `radiology`
  ADD PRIMARY KEY (`radiology_id`),
  ADD KEY `fk_RadiologyDoctor` (`doctor_id`),
  ADD KEY `fk_RadiologyTreatment` (`treatment_id`),
  ADD KEY `fk_RadiologyStatus` (`status_id`);

--
-- Indexes for table `radiology_request`
--
ALTER TABLE `radiology_request`
  ADD PRIMARY KEY (`radiology_request_id`),
  ADD UNIQUE KEY `radiology_id` (`radiology_id`),
  ADD KEY `fk_ExaminationRequestedRadiologyId` (`radiology_id`);

--
-- Indexes for table `roster`
--
ALTER TABLE `roster`
  ADD PRIMARY KEY (`roster_id`),
  ADD KEY `fk_DutyRoster` (`user_id`),
  ADD KEY `fk_UserDept` (`dept_id`),
  ADD KEY `fk_DutyStatus` (`duty`),
  ADD KEY `fk_CreatedBy` (`created_by`),
  ADD KEY `fk_ModifiedBy` (`modified_by`);

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
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `fk_treatment_status` (`treatment_status`),
  ADD KEY `fk_billing_status` (`bill_status`);

--
-- Indexes for table `treatment_status`
--
ALTER TABLE `treatment_status`
  ADD PRIMARY KEY (`treatment_status_id`),
  ADD UNIQUE KEY `treatment_status_id` (`treatment_status_id`);

--
-- Indexes for table `unit_ref`
--
ALTER TABLE `unit_ref`
  ADD PRIMARY KEY (`unit_ref_id`);

--
-- Indexes for table `urinalysis`
--
ALTER TABLE `urinalysis`
  ADD PRIMARY KEY (`urinalysis_id`),
  ADD UNIQUE KEY `urine_id` (`urine_id`),
  ADD KEY `fk_UrinalysisUrineId` (`urine_id`);

--
-- Indexes for table `urinary`
--
ALTER TABLE `urinary`
  ADD PRIMARY KEY (`urinary_id`),
  ADD KEY `fk_UrinaryUserId` (`patient_id`),
  ADD KEY `fk_UrinaryProblem` (`urinaryproblem`);

--
-- Indexes for table `urine`
--
ALTER TABLE `urine`
  ADD PRIMARY KEY (`urine_id`),
  ADD KEY `fk_UrineStatusId` (`status_id`),
  ADD KEY `fk_UrineTreatmentId` (`treatment_id`),
  ADD KEY `fk_UrineDoctorId` (`doctor_id`);

--
-- Indexes for table `urine_sensitivity`
--
ALTER TABLE `urine_sensitivity`
  ADD PRIMARY KEY (`urine_sensitivity_id`),
  ADD KEY `fk_UrineSensitivityUrineId` (`urine_id`),
  ADD KEY `fk_UrineSensitivityRefId` (`isolates`);

--
-- Indexes for table `urine_sensitivity_ref`
--
ALTER TABLE `urine_sensitivity_ref`
  ADD PRIMARY KEY (`urine_sensitivity_ref_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `fk_UserStatus` (`status`);

--
-- Indexes for table `visual_skills_profile`
--
ALTER TABLE `visual_skills_profile`
  ADD PRIMARY KEY (`visual_profile_id`),
  ADD KEY `fk_VisualDoctor` (`doctor_id`),
  ADD KEY `fk_VisualTreatment` (`treatment_id`),
  ADD KEY `fk_VisualStatus` (`status_id`);

--
-- Indexes for table `vitals`
--
ALTER TABLE `vitals`
  ADD PRIMARY KEY (`vitals_id`),
  ADD KEY `encounter_id` (`encounter_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `added_by` (`added_by`);

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
  ADD PRIMARY KEY (`xray_id`),
  ADD UNIQUE KEY `radiology_id` (`radiology_id`),
  ADD KEY `fk_XRayNoRadiologyId` (`radiology_id`);

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
  MODIFY `admission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `admission_bed`
--
ALTER TABLE `admission_bed`
  MODIFY `admission_bed_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `admission_req`
--
ALTER TABLE `admission_req`
  MODIFY `admission_req_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `bed`
--
ALTER TABLE `bed`
  MODIFY `bed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `billables`
--
ALTER TABLE `billables`
  MODIFY `billables_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bill_status`
--
ALTER TABLE `bill_status`
  MODIFY `bill_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `blood_test`
--
ALTER TABLE `blood_test`
  MODIFY `bloodtest_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `chemical_pathology_details`
--
ALTER TABLE `chemical_pathology_details`
  MODIFY `cpdetails_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `chemical_pathology_ref`
--
ALTER TABLE `chemical_pathology_ref`
  MODIFY `cpref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `chemical_pathology_request`
--
ALTER TABLE `chemical_pathology_request`
  MODIFY `cpreq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `communication`
--
ALTER TABLE `communication`
  MODIFY `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `constant_bills`
--
ALTER TABLE `constant_bills`
  MODIFY `constant_bills_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `differential_count`
--
ALTER TABLE `differential_count`
  MODIFY `differential_count_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `drug_ref`
--
ALTER TABLE `drug_ref`
  MODIFY `drug_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `emergency`
--
ALTER TABLE `emergency`
  MODIFY `emergency_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `emergency_detail`
--
ALTER TABLE `emergency_detail`
  MODIFY `emergency_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `encounter`
--
ALTER TABLE `encounter`
  MODIFY `encounter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `film_appearance`
--
ALTER TABLE `film_appearance`
  MODIFY `film_appearance_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `haematology`
--
ALTER TABLE `haematology`
  MODIFY `haematology_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hospital_info`
--
ALTER TABLE `hospital_info`
  MODIFY `hospital_info_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `microscopy`
--
ALTER TABLE `microscopy`
  MODIFY `microscopy_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `nok_relationship`
--
ALTER TABLE `nok_relationship`
  MODIFY `nok_relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `outgoing_drugs`
--
ALTER TABLE `outgoing_drugs`
  MODIFY `outgoing_drugs_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `parasitology_details`
--
ALTER TABLE `parasitology_details`
  MODIFY `pdetail_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `parasitology_ref`
--
ALTER TABLE `parasitology_ref`
  MODIFY `pref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `parasitology_req`
--
ALTER TABLE `parasitology_req`
  MODIFY `preq_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `patient_queue`
--
ALTER TABLE `patient_queue`
  MODIFY `patient_queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `permission_role_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `pharmacist_outgoing_drug`
--
ALTER TABLE `pharmacist_outgoing_drug`
  MODIFY `pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `prescription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `prescription_outgoing_drug`
--
ALTER TABLE `prescription_outgoing_drug`
  MODIFY `prescription_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `radiology`
--
ALTER TABLE `radiology`
  MODIFY `radiology_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `radiology_request`
--
ALTER TABLE `radiology_request`
  MODIFY `radiology_request_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `roster`
--
ALTER TABLE `roster`
  MODIFY `roster_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
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
  MODIFY `treatment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `treatment_status`
--
ALTER TABLE `treatment_status`
  MODIFY `treatment_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `unit_ref`
--
ALTER TABLE `unit_ref`
  MODIFY `unit_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `urinalysis`
--
ALTER TABLE `urinalysis`
  MODIFY `urinalysis_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `urinary`
--
ALTER TABLE `urinary`
  MODIFY `urinary_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `urine`
--
ALTER TABLE `urine`
  MODIFY `urine_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `urine_sensitivity`
--
ALTER TABLE `urine_sensitivity`
  MODIFY `urine_sensitivity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `urine_sensitivity_ref`
--
ALTER TABLE `urine_sensitivity_ref`
  MODIFY `urine_sensitivity_ref_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `visual_skills_profile`
--
ALTER TABLE `visual_skills_profile`
  MODIFY `visual_profile_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `vitals`
--
ALTER TABLE `vitals`
  MODIFY `vitals_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ward_ref`
--
ALTER TABLE `ward_ref`
  MODIFY `ward_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `xray_case`
--
ALTER TABLE `xray_case`
  MODIFY `xray_case_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `xray_no`
--
ALTER TABLE `xray_no`
  MODIFY `xray_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
