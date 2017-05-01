-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2015 at 05:44 PM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
  `admission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `admitted_by` int(11) NOT NULL,
  `discharged_by` int(11) DEFAULT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `entry_date` datetime NOT NULL,
  `exit_date` datetime DEFAULT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admission_id`),
  KEY `fk_AdmittedBy` (`admitted_by`),
  KEY `fk_PatientAdmitted` (`patient_id`),
  KEY `fk_TreatmentAdmission` (`treatment_id`),
  KEY `discharged_by` (`discharged_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admission_bed`
--

CREATE TABLE IF NOT EXISTS `admission_bed` (
  `admission_bed_id` int(11) NOT NULL AUTO_INCREMENT,
  `admission_id` int(11) unsigned NOT NULL,
  `bed_id` int(11) unsigned NOT NULL,
  `active_fg` int(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`admission_bed_id`),
  KEY `bed_id` (`bed_id`),
  KEY `admission_id` (`admission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admission_req`
--

CREATE TABLE IF NOT EXISTS `admission_req` (
  `admission_req_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `treatment_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admission_req_id`),
  UNIQUE KEY `treatment_id` (`treatment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bed`
--

CREATE TABLE IF NOT EXISTS `bed` (
  `bed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bed_description` text,
  `bed_status` int(11) NOT NULL,
  `ward_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bed_id`),
  KEY `fk_BedWard` (`ward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_status`
--

CREATE TABLE IF NOT EXISTS `bill_status` (
  `bill_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(25) NOT NULL,
  PRIMARY KEY (`bill_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `billables`
--

CREATE TABLE IF NOT EXISTS `billables` (
  `billables_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill` varchar(255) NOT NULL,
  `amount` float(8,2) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`billables_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blood_test`
--

CREATE TABLE IF NOT EXISTS `blood_test` (
  `bloodtest_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bloodtest_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_BloodTestHaematologyId` (`haematology_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_details`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_details` (
  `cpdetails_id` int(11) NOT NULL AUTO_INCREMENT,
  `cpreq_id` int(11) DEFAULT NULL,
  `cpref_id` int(11) DEFAULT NULL,
  `result` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cpdetails_id`),
  KEY `FK_chemical_pathology_details` (`cpreq_id`),
  KEY `FK_chemical_pathology_details_ref` (`cpref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_ref`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_ref` (
  `cpref_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) DEFAULT NULL,
  `status_type` varchar(35) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cpref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chemical_pathology_request`
--

CREATE TABLE IF NOT EXISTS `chemical_pathology_request` (
  `cpreq_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `cp_ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cpreq_id`),
  UNIQUE KEY `NewIndex1` (`laboratory_ref`),
  KEY `fk_ChemicalTreatment` (`treatment_id`),
  KEY `fk_ChemicalDoctor` (`doctor_id`),
  KEY `fk_ChemicalStatus` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `communication`
--

CREATE TABLE IF NOT EXISTS `communication` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `msg_subject` varchar(50) NOT NULL,
  `msg_body` varchar(200) NOT NULL,
  `msg_status` int(10) unsigned NOT NULL,
  `active_fg` tinyint(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `fk_MsgSender` (`sender_id`),
  KEY `fk_MsgRecipient` (`recipient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `constant_bills`
--

CREATE TABLE IF NOT EXISTS `constant_bills` (
  `constant_bills_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(150) NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) unsigned DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`constant_bills_id`),
  KEY `fk_treatment_bills` (`treatment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `differential_count`
--

CREATE TABLE IF NOT EXISTS `differential_count` (
  `differential_count_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`differential_count_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_DiffCountHaematologyId` (`haematology_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drug_ref`
--

CREATE TABLE IF NOT EXISTS `drug_ref` (
  `drug_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `symbol` char(8) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`drug_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emergency`
--

CREATE TABLE IF NOT EXISTS `emergency` (
  `emergency_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) NOT NULL,
  `emergency_status_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`emergency_id`),
  UNIQUE KEY `emergency_id` (`emergency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_detail`
--

CREATE TABLE IF NOT EXISTS `emergency_detail` (
  `emergency_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `emergency_status` varchar(20) NOT NULL,
  PRIMARY KEY (`emergency_status_id`),
  UNIQUE KEY `emergency_status_id` (`emergency_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `encounter`
--

CREATE TABLE IF NOT EXISTS `encounter` (
  `encounter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `personnel_id` int(11) NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `admission_id` int(11) unsigned NOT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `treatment_id` int(11) DEFAULT NULL,
  `symptoms` varchar(200) DEFAULT NULL,
  `consultation` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `bill_status` int(11) NOT NULL DEFAULT '1',
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `diagnosis` text,
  PRIMARY KEY (`encounter_id`),
  KEY `fk_PatientEncountered` (`patient_id`),
  KEY `fk_PersonnelEncountered` (`personnel_id`),
  KEY `fk_AdmissionEncounter` (`admission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `film_appearance`
--

CREATE TABLE IF NOT EXISTS `film_appearance` (
  `film_appearance_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`film_appearance_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_FilmAppearanceHaematologyReportId` (`haematology_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `haematology`
--

CREATE TABLE IF NOT EXISTS `haematology` (
  `haematology_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`haematology_id`),
  KEY `fk_DoctorId` (`doctor_id`),
  KEY `fk_TreatmentId` (`treatment_id`),
  KEY `fk_HaematologyStatus` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE IF NOT EXISTS `hospital_info` (
  `hospital_info_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`hospital_info_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `microscopy`
--

CREATE TABLE IF NOT EXISTS `microscopy` (
  `microscopy_id` int(11) NOT NULL AUTO_INCREMENT,
  `urine_id` int(11) NOT NULL,
  `pus_cells` varchar(35) NOT NULL,
  `red_cells` varchar(35) NOT NULL,
  `epithelial_cells` varchar(35) NOT NULL,
  `casts` varchar(35) NOT NULL,
  `crystals` varchar(35) NOT NULL,
  `others` varchar(35) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`microscopy_id`),
  UNIQUE KEY `urine_id` (`urine_id`),
  KEY `fk_MicroscopyUrineId` (`urine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nok_relationship`
--

CREATE TABLE IF NOT EXISTS `nok_relationship` (
  `nok_relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relationship` varchar(25) NOT NULL,
  PRIMARY KEY (`nok_relationship_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_drugs`
--

CREATE TABLE IF NOT EXISTS `outgoing_drugs` (
  `outgoing_drugs_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `drug_id` int(11) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`outgoing_drugs_id`),
  KEY `fk_OutgoingDrugs` (`drug_id`),
  KEY `fk_DrugUnits` (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_details`
--

CREATE TABLE IF NOT EXISTS `parasitology_details` (
  `pdetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `preq_id` int(11) DEFAULT NULL,
  `pref_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pdetail_id`),
  KEY `FK_parasitology_details_req_id` (`preq_id`),
  KEY `FK_parasitology_details_ref_id` (`pref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_ref`
--

CREATE TABLE IF NOT EXISTS `parasitology_ref` (
  `pref_id` int(11) NOT NULL AUTO_INCREMENT,
  `parasite_name` varchar(50) DEFAULT NULL,
  `parasite_type` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `parasitology_req`
--

CREATE TABLE IF NOT EXISTS `parasitology_req` (
  `preq_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `lab_comment` text,
  PRIMARY KEY (`preq_id`),
  KEY `fk_ParasitologyTreatmentId` (`treatment_id`),
  KEY `fk_ParasitologyDoctorId` (`doctor_id`),
  KEY `fk_ParasitologyStatusId` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patient_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`patient_id`),
  KEY `fk_PatientNok` (`nok_relationship`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `patient_queue`
--

CREATE TABLE IF NOT EXISTS `patient_queue` (
  `patient_queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`patient_queue_id`),
  KEY `fk_patientQueue` (`patient_id`),
  KEY `fk_PatientDoctor` (`doctor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `staff_permission_id` int(11) NOT NULL,
  `staff_role_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`permission_role_id`),
  KEY `fk_PermisionRoleUserId` (`userid`),
  KEY `fk_PermissionId` (`staff_permission_id`),
  KEY `fk_RoleId` (`staff_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist_outgoing_drug`
--

CREATE TABLE IF NOT EXISTS `pharmacist_outgoing_drug` (
  `pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pharmacist_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pharmacist_outgoing_drug_id`),
  KEY `fk_Outgoing` (`outgoing_drug_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE IF NOT EXISTS `prescription` (
  `prescription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prescription` varchar(255) DEFAULT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `encounter_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `modified_by` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`prescription_id`),
  KEY `fk_TreatmentPrescription` (`treatment_id`),
  KEY `fk_PrescriptionStatus` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_outgoing_drug`
--

CREATE TABLE IF NOT EXISTS `prescription_outgoing_drug` (
  `prescription_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`prescription_outgoing_drug_id`),
  KEY `fk_Prescription` (`prescription_id`),
  KEY `fk_OutgoingDrug` (`outgoing_drug_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`profile_id`),
  KEY `fk_IdentificationUserId` (`userid`),
  KEY `fk_DepartmentProfile` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiology`
--

CREATE TABLE IF NOT EXISTS `radiology` (
  `radiology_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`radiology_id`),
  KEY `fk_RadiologyDoctor` (`doctor_id`),
  KEY `fk_RadiologyTreatment` (`treatment_id`),
  KEY `fk_RadiologyStatus` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radiology_request`
--

CREATE TABLE IF NOT EXISTS `radiology_request` (
  `radiology_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `radiology_id` int(11) NOT NULL,
  `clinical_diagnosis_details` varchar(100) DEFAULT NULL,
  `previous_operation` varchar(25) DEFAULT NULL,
  `any_known_allergies` varchar(25) DEFAULT NULL,
  `previous_xray` tinyint(4) DEFAULT NULL,
  `xray_number` varchar(7) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`radiology_request_id`),
  UNIQUE KEY `radiology_id` (`radiology_id`),
  KEY `fk_ExaminationRequestedRadiologyId` (`radiology_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
  `roster_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `dept_id` int(11) unsigned NOT NULL,
  `duty` int(11) NOT NULL,
  `duty_date` date NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `active_fg` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`roster_id`),
  KEY `fk_DutyRoster` (`user_id`),
  KEY `fk_UserDept` (`dept_id`),
  KEY `fk_DutyStatus` (`duty`),
  KEY `fk_CreatedBy` (`created_by`),
  KEY `fk_ModifiedBy` (`modified_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Table structure for table `staff_permission`
--

CREATE TABLE IF NOT EXISTS `staff_permission` (
  `staff_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_permission` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staff_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_role`
--

CREATE TABLE IF NOT EXISTS `staff_role` (
  `staff_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `staff_role` varchar(100) NOT NULL,
  `role_label` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staff_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(15) CHARACTER SET utf8 NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `treatment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`treatment_id`),
  KEY `fk_treatment_status` (`treatment_status`),
  KEY `fk_billing_status` (`bill_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `treatment_status`
--

CREATE TABLE IF NOT EXISTS `treatment_status` (
  `treatment_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`treatment_status_id`),
  UNIQUE KEY `treatment_status_id` (`treatment_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unit_ref`
--

CREATE TABLE IF NOT EXISTS `unit_ref` (
  `unit_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(50) NOT NULL,
  `symbol` char(8) DEFAULT '',
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`unit_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urinalysis`
--

CREATE TABLE IF NOT EXISTS `urinalysis` (
  `urinalysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `urine_id` int(11) NOT NULL,
  `appearance` varchar(35) NOT NULL,
  `ph` varchar(35) NOT NULL,
  `glucose` varchar(35) NOT NULL,
  `protein` varchar(35) NOT NULL,
  `bilirubin` varchar(35) NOT NULL,
  `urobillinogen` varchar(35) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urinalysis_id`),
  UNIQUE KEY `urine_id` (`urine_id`),
  KEY `fk_UrinalysisUrineId` (`urine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urinary`
--

CREATE TABLE IF NOT EXISTS `urinary` (
  `urinary_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `urinaryproblem` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urinary_id`),
  KEY `fk_UrinaryUserId` (`patient_id`),
  KEY `fk_UrinaryProblem` (`urinaryproblem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urine`
--

CREATE TABLE IF NOT EXISTS `urine` (
  `urine_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urine_id`),
  KEY `fk_UrineStatusId` (`status_id`),
  KEY `fk_UrineTreatmentId` (`treatment_id`),
  KEY `fk_UrineDoctorId` (`doctor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urine_sensitivity`
--

CREATE TABLE IF NOT EXISTS `urine_sensitivity` (
  `urine_sensitivity_id` int(11) NOT NULL AUTO_INCREMENT,
  `urine_id` int(11) NOT NULL,
  `isolates` int(11) DEFAULT NULL,
  `isolates_degree` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urine_sensitivity_id`),
  KEY `fk_UrineSensitivityUrineId` (`urine_id`),
  KEY `fk_UrineSensitivityRefId` (`isolates`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `urine_sensitivity_ref`
--

CREATE TABLE IF NOT EXISTS `urine_sensitivity_ref` (
  `urine_sensitivity_ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `antibiotics` varchar(35) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urine_sensitivity_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `regNo` varchar(35) NOT NULL,
  `passcode` varchar(64) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `online_status` int(1) DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `fk_UserStatus` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `visual_skills_profile`
--

CREATE TABLE IF NOT EXISTS `visual_skills_profile` (
  `visual_profile_id` int(11) NOT NULL AUTO_INCREMENT,
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
  'intra_ocular_pressure' varchar(30) DEFAULT NULL,
  'central_visual_field' varchar(30) DEFAULT NULL,
  'others' varchar(30) DEFAULT NULL,
  `stereopsis` varchar(30) DEFAULT NULL,
  `amplitude_of_accomodation` varchar(30) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`visual_profile_id`),
  KEY `fk_VisualDoctor` (`doctor_id`),
  KEY `fk_VisualTreatment` (`treatment_id`),
  KEY `fk_VisualStatus` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vitals`
--

CREATE TABLE IF NOT EXISTS `vitals` (
  `vitals_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`vitals_id`),
  KEY `encounter_id` (`encounter_id`),
  KEY `patient_id` (`patient_id`),
  KEY `added_by` (`added_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ward_ref`
--

CREATE TABLE IF NOT EXISTS `ward_ref` (
  `ward_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ward_ref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xray_case`
--

CREATE TABLE IF NOT EXISTS `xray_case` (
  `xray_case_id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(25) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_case_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `xray_no`
--

CREATE TABLE IF NOT EXISTS `xray_no` (
  `xray_id` int(11) NOT NULL AUTO_INCREMENT,
  `radiology_id` int(11) NOT NULL,
  `xray_number` varchar(7) CHARACTER SET latin1 DEFAULT NULL,
  `casual_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `gp_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `ante_natal_no` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_id`),
  UNIQUE KEY `radiology_id` (`radiology_id`),
  KEY `fk_XRayNoRadiologyId` (`radiology_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `xray_size`
--

CREATE TABLE IF NOT EXISTS `xray_size` (
  `xray_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `dimension` varchar(10) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_size_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

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

--
--  Insert default values
--
INSERT INTO `bill_status` (`bill_status_id`, `status`) VALUES
(1, 'unbilled'),
(2, 'billed');

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

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'doctor'),
(2, 'pharmacy'),
(3, 'mro'),
(4, 'parasitology'),
(7, 'haematology'),
(8, 'parasitology');

INSERT INTO `emergency_detail` (`emergency_status_id`, `emergency_status`) VALUES
(1, 'active'),
(2, 'upgraded'),
(3, 'intreatment');

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

INSERT INTO `staff_permission` (`staff_permission_id`, `staff_permission`, `created_date`, `modified_date`, `active_fg`) VALUES
(1, 'read_only', '2015-01-26 12:44:17', '2015-01-26 12:44:20', 1),
(2, 'read_write', '2015-01-26 12:46:14', '2015-01-26 12:46:12', 1);

INSERT INTO `staff_role` (`staff_role_id`, `created_date`, `modified_date`, `staff_role`, `role_label`, `active_fg`) VALUES
(1, '2015-01-26 12:24:47', '2015-01-26 12:24:54', 'administrator', 'administrator', 1),
(2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'doctor', 'doctor', 1),
(3, '2015-01-26 12:26:48', '2015-01-26 12:26:52', 'pharmacist', 'pharmacist', 1),
(4, '2015-01-28 13:00:36', '2015-01-28 13:00:42', 'medical_records', 'medical records', 1),
(5, '2015-01-28 13:01:20', '2015-01-28 13:01:25', 'permission', 'permission_granter', 1),
(6, '2015-01-28 13:01:58', '2015-01-28 13:02:01', 'urine', 'urine test conductor', 1),
(7, '2015-01-28 13:02:40', '2015-01-28 13:02:43', 'visual', 'visual test conductor', 1),
(8, '2015-01-28 13:02:59', '2015-01-28 13:03:03', 'xray ', 'radiology test conductor', 1),
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

INSERT INTO `treatment_status` (`treatment_status_id`, `status`) VALUES
(1, 'intreatment'),
(2, 'treatmentComplete');

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

INSERT INTO `xray_case` (`xray_case_id`, `option`, `active_fg`) VALUES
(1, 'WALKING CASE', 1),
(2, 'W.C.HAIR', 1),
(3, 'TROLLEY', 1),
(4, 'THEATRE', 1),
(5, 'PORTABLE', 1),
(6, 'L.M.P', 1);

INSERT INTO `xray_size` (`xray_size_id`, `dimension`, `active_fg`) VALUES
(1, '17X14', 1),
(2, '14X4', 1),
(3, '15X12', 1),
(4, '12X10', 1),
(5, '10X8', 1),
(6, '15X6', 1),
(7, '8X6', 1);