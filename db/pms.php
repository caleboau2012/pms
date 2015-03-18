/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.5.30 : Database - pms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `pms`;

/*Table structure for table `admission` */

DROP TABLE IF EXISTS `admission`;

CREATE TABLE `admission` (
`admission_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`bed_id` INT(11) UNSIGNED NOT NULL,
`admitted_by` INT(11) NOT NULL,
`patient_id` INT(11) UNSIGNED NOT NULL,
`entry_date` DATETIME NOT NULL,
`exit_date` DATETIME NOT NULL,
`comments` TEXT,
`created_date` DATETIME NOT NULL,
`modified_date` DATETIME NOT NULL,
`active_fg` TINYINT(1) NOT NULL DEFAULT '1',
`treatment_id` INT(11) UNSIGNED NOT NULL,
PRIMARY KEY (`admission_id`),
KEY `fk_AdmittedBy` (`admitted_by`),
KEY `fk_PatientAdmitted` (`patient_id`),
KEY `fk_AdmissionBed` (`bed_id`),
KEY `fk_TreatmentAdmission` (`treatment_id`),
CONSTRAINT `fk_TreatmentAdmission` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`),
CONSTRAINT `fk_AdmissionBed` FOREIGN KEY (`bed_id`) REFERENCES `bed` (`bed_id`),
CONSTRAINT `fk_AdmittedBy` FOREIGN KEY (`admitted_by`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_PatientAdmitted` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admission` */

/*Table structure for table `admission_req` */

DROP TABLE IF EXISTS `admission_req`;

CREATE TABLE `admission_req` (
`admission_req_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`treatment_id` int(11) unsigned NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`admission_req_id`),
KEY `fk_AdmissionTreatmentId` (`treatment_id`),
CONSTRAINT `fk_AdmissionTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admission_req` */

/*Table structure for table `bed` */

DROP TABLE IF EXISTS `bed`;

CREATE TABLE `bed` (
`bed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`bed_description` text,
`bed_status` int(11) NOT NULL,
`ward_id` int(11) unsigned NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`bed_id`),
KEY `fk_BedWard` (`ward_id`),
CONSTRAINT `fk_BedWard` FOREIGN KEY (`ward_id`) REFERENCES `ward_ref` (`ward_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bed` */

/*Table structure for table `blood_test` */

DROP TABLE IF EXISTS `blood_test`;

CREATE TABLE `blood_test` (
`bloodtest_id` int(11) NOT NULL AUTO_INCREMENT,
`haematology_id` int(11) DEFAULT NULL,
`pcv` float NOT NULL,
`hb` float NOT NULL,
`hchc` float NOT NULL,
`wbc` float NOT NULL,
`eosinophils` float NOT NULL,
`platelets` float NOT NULL,
`rectis` float NOT NULL,
`rectis_index` float NOT NULL,
`e_s_r` float NOT NULL,
`microfilaria` varchar(20) NOT NULL,
`malaria_parasites` varchar(20) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`bloodtest_id`),
KEY `fk_BloodTestHaematologyId` (`haematology_id`),
CONSTRAINT `fk_BloodTestHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `blood_test` */

/*Table structure for table `chemical_pathology_details` */

DROP TABLE IF EXISTS `chemical_pathology_details`;

CREATE TABLE `chemical_pathology_details` (
`cpdetails_id` int(11) NOT NULL AUTO_INCREMENT,
`cpreq_id` int(11) DEFAULT NULL,
`cpref_id` int(11) DEFAULT NULL,
`result` int(11) NOT NULL,
`created_date` datetime DEFAULT NULL,
`modified_date` datetime DEFAULT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`cpdetails_id`),
KEY `FK_chemical_pathology_details` (`cpreq_id`),
KEY `FK_chemical_pathology_details_ref` (`cpref_id`),
CONSTRAINT `FK_chemical_pathology_details` FOREIGN KEY (`cpreq_id`) REFERENCES `chemical_pathology_request` (`cpreq_id`),
CONSTRAINT `FK_chemical_pathology_details_ref` FOREIGN KEY (`cpref_id`) REFERENCES `chemical_pathology_ref` (`cpref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `chemical_pathology_details` */

/*Table structure for table `chemical_pathology_ref` */

DROP TABLE IF EXISTS `chemical_pathology_ref`;

CREATE TABLE `chemical_pathology_ref` (
`cpref_id` int(11) NOT NULL AUTO_INCREMENT,
`status_name` varchar(50) DEFAULT NULL,
`status_type` varchar(35) DEFAULT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`cpref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `chemical_pathology_ref` */

/*Table structure for table `communication` */

DROP TABLE IF EXISTS `communication`;

CREATE TABLE `communication` (
`msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`sender_id` int(10) NOT NULL,
`recipient_id` int(11) NOT NULL,
`msg_subject` varchar(50) NOT NULL,
`msg_body` varchar(140) NOT NULL,
`msg_status` int(10) unsigned NOT NULL,
`active_fg` tinyint(11) NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
PRIMARY KEY (`msg_id`),
KEY `fk_MsgSender` (`sender_id`),
KEY `fk_MsgRecipient` (`recipient_id`),
CONSTRAINT `fk_MsgRecipient` FOREIGN KEY (`recipient_id`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_MsgSender` FOREIGN KEY (`sender_id`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `communication` */

insert  into `communication`(`msg_id`,`sender_id`,`recipient_id`,`msg_subject`,`msg_body`,`msg_status`,`active_fg`,`created_date`,`modified_date`) values (1,1,2,'Lorem ipsum','Bacno ipsum',1,1,'2015-02-17 12:12:00','2015-02-17 12:12:00'),(10,1,2,'Labore jerky swine sausage','Labore jerky swine sausage alcatra leberkas nostrud sint. Consequat po',1,1,'2015-02-17 16:20:04','2015-02-17 16:20:04'),(11,1,2,'Pastrami doner tenderloin','Pastrami doner tenderloin sirloin jerky chuck flank filet mignon shoul',0,1,'2015-02-17 16:49:41','2015-02-17 16:59:11');

/*Table structure for table `department` */

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
`department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`department_name` varchar(50) NOT NULL,
PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `department` */

insert  into `department`(`department_id`,`department_name`) values (1,'doctor'),(2,'pharmacy'),(3,'mro'),(4,'parasitology'),(7,'haematology'),(8,'parasitology');

/*Table structure for table `differential_count` */

DROP TABLE IF EXISTS `differential_count`;

CREATE TABLE `differential_count` (
`differential_count_id` int(11) NOT NULL AUTO_INCREMENT,
`haematology_id` int(11) DEFAULT NULL,
`polymorphs_neutrophils` float NOT NULL,
`lymphocytes` float NOT NULL,
`monocytes` float NOT NULL,
`eosinophils` float NOT NULL,
`basophils` float NOT NULL,
`widals_test` float NOT NULL,
`blood_group` varchar(3) NOT NULL,
`rhesus_factor` varchar(3) NOT NULL,
`genotype` varchar(5) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`differential_count_id`),
KEY `fk_DiffCountHaematologyId` (`haematology_id`),
CONSTRAINT `fk_DiffCountHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `differential_count` */

/*Table structure for table `drug_ref` */

DROP TABLE IF EXISTS `drug_ref`;

CREATE TABLE `drug_ref` (
`drug_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(150) NOT NULL,
`created_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`drug_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `drug_ref` */

/*Table structure for table `encounter` */

DROP TABLE IF EXISTS `encounter`;

CREATE TABLE `encounter` (
`encounter_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`personnel_id` int(11) NOT NULL,
`patient_id` int(11) unsigned NOT NULL,
`admission_id` int(11) unsigned NOT NULL,
`comments` text,
`created_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`encounter_id`),
KEY `fk_PatientEncountered` (`patient_id`),
KEY `fk_PersonnelEncountered` (`personnel_id`),
KEY `fk_AdmissionEncounter` (`admission_id`),
CONSTRAINT `fk_AdmissionEncounter` FOREIGN KEY (`admission_id`) REFERENCES `admission` (`admission_id`),
CONSTRAINT `fk_PatientEncountered` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
CONSTRAINT `fk_PersonnelEncountered` FOREIGN KEY (`personnel_id`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `encounter` */

/*Table structure for table `examination_requested` */

DROP TABLE IF EXISTS `examination_requested`;

CREATE TABLE `examination_requested` (
`examination_requested_id` int(11) NOT NULL AUTO_INCREMENT,
`radiology_id` int(11) NOT NULL,
`clinical_diagnosis_details` varchar(100) DEFAULT NULL,
`previous_operation` varchar(25) NOT NULL,
`any_known_allergies` varchar(25) NOT NULL,
`previous_xray` tinyint(4) NOT NULL,
`xray_number` varchar(7) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`examination_requested_id`),
KEY `fk_ExaminationRequestedRadiologyId` (`radiology_id`),
CONSTRAINT `fk_ExaminationRequestedRadiologyId` FOREIGN KEY (`radiology_id`) REFERENCES `radiology` (`radiology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `examination_requested` */

/*Table structure for table `film_appearance` */

DROP TABLE IF EXISTS `film_appearance`;

CREATE TABLE `film_appearance` (
`film_appearance_id` int(11) NOT NULL AUTO_INCREMENT,
`haematology_id` int(11) DEFAULT NULL,
`aniscocytosis` varchar(35) NOT NULL,
`poikilocytosis` varchar(35) NOT NULL,
`polychromasia` varchar(35) NOT NULL,
`macrocytosis` varchar(35) NOT NULL,
`microcytosis` varchar(35) NOT NULL,
`hypochromia` varchar(35) NOT NULL,
`sickle_cells` varchar(35) NOT NULL,
`target_cells` varchar(35) NOT NULL,
`spherocytes` varchar(35) NOT NULL,
`nucleated_rbc` varchar(35) NOT NULL,
`sickling_test` varchar(35) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`film_appearance_id`),
KEY `fk_FilmAppearanceHaematologyReportId` (`haematology_id`),
CONSTRAINT `fk_FilmAppearanceHaematologyReportId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `film_appearance` */

/*Table structure for table `microscopy` */

DROP TABLE IF EXISTS `microscopy`;

CREATE TABLE `microscopy` (
`microscopy_id` int(11) NOT NULL AUTO_INCREMENT,
`urine_id` int(11) NOT NULL,
`pus_cells` varchar(35) NOT NULL,
`red_cells` varchar(35) NOT NULL,
`epithelial_cells` varchar(35) NOT NULL,
`casts` varchar(35) NOT NULL,
`crystals` varchar(35) NOT NULL,
`others` varchar(35) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`microscopy_id`),
KEY `fk_MicroscopyUrineId` (`urine_id`),
CONSTRAINT `fk_MicroscopyUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `microscopy` */

/*Table structure for table `nok_relationship` */

DROP TABLE IF EXISTS `nok_relationship`;

CREATE TABLE `nok_relationship` (
`nok_relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`relationship` varchar(25) NOT NULL,
PRIMARY KEY (`nok_relationship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `nok_relationship` */

insert  into `nok_relationship`(`nok_relationship_id`,`relationship`) values (1,'father'),(2,'mother'),(3,'son'),(4,'daughter'),(5,'brother'),(6,'sister'),(7,'husband'),(8,'wife'),(9,'others');

/*Table structure for table `outgoing_drugs` */

DROP TABLE IF EXISTS `outgoing_drugs`;

CREATE TABLE `outgoing_drugs` (
`outgoing_drugs_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`drug_id` int(11) unsigned NOT NULL,
`qty` int(11) NOT NULL,
`unit_id` int(11) unsigned NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`outgoing_drugs_id`),
KEY `fk_OutgoingDrugs` (`drug_id`),
KEY `fk_DrugUnits` (`unit_id`),
CONSTRAINT `fk_DrugUnits` FOREIGN KEY (`unit_id`) REFERENCES `unit_ref` (`unit_ref_id`),
CONSTRAINT `fk_OutgoingDrugs` FOREIGN KEY (`drug_id`) REFERENCES `drug_ref` (`drug_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `outgoing_drugs` */

/*Table structure for table `parasitology_details` */

DROP TABLE IF EXISTS `parasitology_details`;

CREATE TABLE `parasitology_details` (
`pdetail_id` int(11) NOT NULL AUTO_INCREMENT,
`preq_id` int(11) DEFAULT NULL,
`pref_id` int(11) DEFAULT NULL,
`created_date` datetime DEFAULT NULL,
`modified_date` datetime DEFAULT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`pdetail_id`),
KEY `FK_parasitology_details_req_id` (`preq_id`),
KEY `FK_parasitology_details_ref_id` (`pref_id`),
CONSTRAINT `FK_parasitology_details_ref_id` FOREIGN KEY (`pref_id`) REFERENCES `parasitology_ref` (`pref_id`),
CONSTRAINT `FK_parasitology_details_req_id` FOREIGN KEY (`preq_id`) REFERENCES `parasitology_req` (`preq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `parasitology_details` */

/*Table structure for table `parasitology_ref` */

DROP TABLE IF EXISTS `parasitology_ref`;

CREATE TABLE `parasitology_ref` (
`pref_id` int(11) NOT NULL AUTO_INCREMENT,
`parasite_name` varchar(50) DEFAULT NULL,
`parasite_type` varchar(50) DEFAULT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`pref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `parasitology_ref` */

/*Table structure for table `patient` */

DROP TABLE IF EXISTS `patient`;

CREATE TABLE `patient` (
`patient_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`surname` varchar(25) NOT NULL,
`firstname` varchar(25) NOT NULL,
`middlename` varchar(25) NOT NULL,
`regNo` varchar(30) NOT NULL,
`home_address` varchar(150) DEFAULT NULL,
`telephone` varchar(25) DEFAULT NULL,
`sex` enum('Male','Female') NOT NULL,
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
`family_position` int(11) NOT NULL,
`mother_status` varchar(25) NOT NULL,
`father_status` varchar(25) NOT NULL,
`marital_status` varchar(25) NOT NULL,
`no_of_children` int(11) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`patient_id`),
KEY `fk_PatientNok` (`nok_relationship`),
CONSTRAINT `fk_PatientNok` FOREIGN KEY (`nok_relationship`) REFERENCES `nok_relationship` (`nok_relationship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `patient` */

insert  into `patient`(`patient_id`,`surname`,`firstname`,`middlename`,`regNo`,`home_address`,`telephone`,`sex`,`height`,`weight`,`birth_date`,`nok_firstname`,`nok_middlename`,`nok_surname`,`nok_address`,`nok_telephone`,`nok_relationship`,`citizenship`,`religion`,`family_position`,`mother_status`,`father_status`,`marital_status`,`no_of_children`,`create_date`,`modified_date`,`active_fg`) values (1,'Adeyinka','Akinlabi','Toluwani','23453534','Bolade close','00809098700','Male',11,65,'2015-02-10','Olaniyi','Moses','Arawande','lagos','07030747331',4,'','',0,'','','',0,'2015-02-18 00:00:00','2015-02-19 00:00:00',1),(2,'Adefemi','Olatunji','Abayomi','56745689','lagos state','88909804889','Male',45,34,'2015-02-17','Gabriel','Adewale','Dada','ibadan','08025641756',3,'','',0,'','','',0,'2015-02-12 00:00:00','2015-02-06 00:00:00',1),(3,'Adefem3','Olatunjirf','Abayomiw','56745689','Ogun state','88909804889','Male',45,34,'2015-02-17','Ibrahim','Olakunle','Uthsman','ile-ife','09156234178',0,'','',0,'','','',0,'2015-02-12 00:00:00','2015-02-06 00:00:00',1),(4,'kunle','ajasin','chikaodi','234','fnfnfnnnn','345668','Male',3,4,'2015-02-17','chika','odi','chukuamaka','ilupeju','3459696999',5,'','',0,'','','',0,'2015-02-10 00:00:00','2015-02-08 00:00:00',1),(5,'kunle','ajasin','chikaodi','234','fnfnfnnnn','345668','Male',3,4,'2015-02-17','chika','odi','chukuamaka','ilupeju','3459696999',5,'','',0,'','','',0,'2015-02-12 16:10:16','2015-02-12 16:10:16',1),(6,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','kunle','james','fatima','ibadan street','4345555',2,'','',0,'','','',0,'2015-02-12 16:21:27','2015-02-12 16:21:27',1),(7,'vgg','vvhv','v','vv','vv','vvv','Male',6,6,'2015-02-11','hjhj','jjh','hjhj','kjkj','jjj',9,'','',0,'','','',0,'2015-02-09 00:00:00','2015-02-11 00:00:00',1),(8,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-13 12:45:53','2015-02-13 12:45:53',1),(9,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-13 12:46:17','2015-02-13 12:46:17',1),(10,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-13 12:47:32','2015-02-13 12:47:32',1),(11,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:20:43','2015-02-19 00:20:43',1),(12,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:20:53','2015-02-19 00:20:53',1),(13,'cmoses','adereti','sannid','4356664','gowon Estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan street','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:21:14','2015-02-19 00:21:14',1),(14,'cmoses','adereti','sannid','4356664','gowon estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan streeet','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:22:06','2015-02-19 00:22:06',1),(15,'cmoses','adereti','sannid','4356664','gowon, estate','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan streeet','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:23:45','2015-02-19 00:23:45',1),(16,'cmoses','adereti','sannid','4356664','gowon, estate. 12, gthyh','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','ibadan streeet','4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:24:06','2015-02-19 00:24:06',1),(17,'cmoses','adereti','sannid','4356664','gowon, estate. 12, gthyh','07045346079','Male',43,45,'2015-02-03','caleb','james','fatima','room 012, space computer buidling., obafemi awolowo university',' 4345555',2,'nigeria','christian',2,'alive','alive','married',5,'2015-02-19 00:26:09','2015-02-19 00:26:09',1),(18,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University',' 234567890','Male',12,12,'2015-03-03','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University',' 2343765832768',1,'Nigeria','ISLAM',1,'ALIVE','ALIVE','SINGLE',1,'2015-02-19 00:26:28','2015-02-19 00:26:28',1),(19,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Female',12,12,'2015-02-11','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',1,'Nigeria','ISLAM',3,'ALIVE','ALIVE','MARRIED',2,'2015-02-19 00:29:43','2015-02-19 00:29:43',1),(20,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-12','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',1,'Nigeria','CHRISTAINITY',4,'ALIVE','ALIVE','SINGLE',9,'2015-02-19 02:15:38','2015-02-19 02:15:38',1),(21,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-12','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',1,'Nigeria','CHRISTAINITY',4,'ALIVE','ALIVE','SINGLE',9,'2015-02-19 02:17:11','2015-02-19 02:17:11',1),(22,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-12','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',1,'Nigeria','CHRISTAINITY',4,'ALIVE','ALIVE','SINGLE',9,'2015-02-19 02:17:57','2015-02-19 02:17:57',1),(23,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-12','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',1,'Nigeria','CHRISTAINITY',4,'ALIVE','ALIVE','SINGLE',9,'2015-02-19 02:18:00','2015-02-19 02:18:00',1),(24,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-04','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',3,'Nigeria','CHRISTAINITY',4,'ALIVE','ALIVE','SINGLE',2,'2015-02-19 02:36:31','2015-02-19 02:36:31',1),(25,'mbakwe','caleb','chukwuezugo','CSC/2008/065','Room 012, computer building, Obafemi Awolowo University','+234567890','Male',12,12,'2015-02-12','Caleb','Chukwuezugo','Mbakwe','Room 012, computer building, Obafemi Awolowo University','+2343765832768',3,'Nigeria','ISLAM',4,'ALIVE','ALIVE','SINGLE',2,'2015-02-19 02:41:35','2015-02-19 02:41:35',1);

/*Table structure for table `patient_queue` */

DROP TABLE IF EXISTS `patient_queue`;

CREATE TABLE `patient_queue` (
`patient_queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`patient_id` int(11) unsigned NOT NULL,
`doctor_id` int(11) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
PRIMARY KEY (`patient_queue_id`),
KEY `fk_patientQueue` (`patient_id`),
KEY `fk_PatientDoctor` (`doctor_id`),
CONSTRAINT `fk_PatientDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_patientQueue` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `patient_queue` */

insert  into `patient_queue`(`patient_queue_id`,`patient_id`,`doctor_id`,`active_fg`,`create_date`,`modified_date`) values (2,2,1,0,'2015-02-10 00:00:00','2015-02-11 16:04:39'),(3,1,1,0,'2015-02-11 15:16:35','2015-02-11 15:16:35'),(4,3,1,1,'2015-02-11 15:16:38','2015-02-11 15:16:38'),(5,2,2,0,'2015-02-11 16:00:03','2015-02-11 16:04:39'),(6,2,2,1,'2015-02-11 16:04:39','2015-02-11 16:04:45');

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
`permission_role_id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) NOT NULL,
`staff_permission_id` int(11) NOT NULL,
`staff_role_id` int(11) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`permission_role_id`),
KEY `fk_PermisionRoleUserId` (`userid`),
KEY `fk_PermissionId` (`staff_permission_id`),
KEY `fk_RoleId` (`staff_role_id`),
CONSTRAINT `fk_permissionRoleUserId` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_staffPermissionRole` FOREIGN KEY (`staff_permission_id`) REFERENCES `staff_permission` (`staff_permission_id`),
CONSTRAINT `fk_staffRole` FOREIGN KEY (`staff_role_id`) REFERENCES `staff_role` (`staff_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `permission_role` */

insert  into `permission_role`(`permission_role_id`,`userid`,`staff_permission_id`,`staff_role_id`,`create_date`,`modified_date`,`active_fg`) values (1,1,2,1,'2015-01-27 16:25:12','2015-02-02 16:29:46',0),(2,1,1,2,'2015-01-27 16:25:35','2015-02-02 15:29:07',0),(3,1,1,3,'2015-01-28 18:02:22','2015-01-28 20:03:38',0),(4,1,2,4,'2015-01-28 18:38:27','2015-01-28 19:45:39',0),(5,1,1,1,'2015-01-30 15:10:20','2015-02-02 15:39:45',0),(6,1,1,1,'2015-01-30 16:07:18','2015-02-02 16:23:49',0),(7,1,1,3,'2015-02-02 14:59:39','2015-02-02 16:24:13',0),(8,1,1,4,'2015-02-02 15:05:44','2015-02-02 16:25:38',0),(9,1,1,5,'2015-02-02 15:05:51','2015-02-02 16:28:13',0),(10,1,1,6,'2015-02-02 15:06:44','2015-02-02 16:28:47',0),(11,1,1,9,'2015-02-02 15:13:44','2015-02-02 16:28:54',0),(12,1,2,7,'2015-02-02 15:14:52','2015-02-02 16:29:45',0),(13,1,1,8,'2015-02-02 15:15:34','2015-02-02 16:28:55',0),(14,1,1,1,'2015-02-02 15:28:44','2015-02-03 16:25:18',0),(15,1,1,2,'2015-02-02 16:24:09','2015-02-11 11:41:17',0),(16,1,1,3,'2015-02-02 16:25:35','2015-02-13 15:39:21',0),(17,1,1,4,'2015-02-02 16:27:41','2015-02-13 15:39:16',0),(18,1,1,10,'2015-02-02 16:28:02','2015-02-02 16:28:02',1),(19,1,1,5,'2015-02-02 16:28:31','2015-02-02 16:30:08',0),(20,1,1,1,'2015-02-10 11:14:09','2015-02-10 11:14:09',1),(21,2,2,1,'2015-02-10 12:33:01','2015-02-10 12:33:01',1),(22,2,2,10,'2015-02-10 12:33:11','2015-02-10 12:33:11',1),(23,2,2,8,'2015-02-10 12:33:24','2015-02-10 12:33:24',1),(24,1,1,2,'2015-02-11 11:41:24','2015-02-13 15:39:26',0),(25,2,2,2,'2015-02-11 15:54:45','2015-02-11 15:54:45',1),(26,1,1,14,'2015-02-13 15:38:05','2015-02-13 15:38:05',1),(27,1,2,2,'2015-02-13 15:39:39','2015-02-13 15:39:39',1),(28,1,1,3,'2015-02-13 15:40:34','2015-02-13 15:40:34',1),(29,1,1,5,'2015-02-13 15:41:09','2015-02-13 15:41:09',1),(30,1,1,11,'2015-02-13 15:41:19','2015-02-13 15:41:19',1),(31,1,1,8,'2015-02-13 15:41:24','2015-02-13 15:41:24',1),(32,1,1,4,'2015-02-13 15:48:29','2015-02-13 15:48:29',1),(33,1,2,15,'2015-02-16 11:16:27','2015-02-16 11:16:27',1),(34,3,2,1,'2015-02-16 14:03:58','2015-02-16 14:04:00',1),(35,3,2,2,'2015-02-16 14:06:22','2015-02-16 14:06:25',1),(36,3,2,3,'2015-02-16 14:06:33','2015-02-16 14:06:35',1),(37,1,2,9,'2015-02-17 17:32:17','2015-02-17 17:32:17',1);

/*Table structure for table `pharmacist_outgoing_drug` */

DROP TABLE IF EXISTS `pharmacist_outgoing_drug`;

CREATE TABLE `pharmacist_outgoing_drug` (
`pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`pharmacist_id` int(11) unsigned NOT NULL,
`outgoing_drug_id` int(11) unsigned NOT NULL,
`created_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`pharmacist_outgoing_drug_id`),
KEY `fk_Outgoing` (`outgoing_drug_id`),
CONSTRAINT `fk_Outgoing` FOREIGN KEY (`outgoing_drug_id`) REFERENCES `outgoing_drugs` (`outgoing_drugs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pharmacist_outgoing_drug` */

/*Table structure for table `prescription` */

DROP TABLE IF EXISTS `prescription`;

CREATE TABLE `prescription` (
`prescription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`prescription` varchar(255) DEFAULT NULL,
`treatment_id` int(11) unsigned NOT NULL,
`status` int(11) NOT NULL,
`modified_by` int(11) unsigned NOT NULL,
`created_date` int(11) unsigned NOT NULL,
`modified_date` int(11) unsigned NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`prescription_id`),
KEY `fk_TreatmentPrescription` (`treatment_id`),
KEY `fk_PrescriptionStatus` (`status`),
CONSTRAINT `fk_PrescriptionStatus` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`),
CONSTRAINT `fk_TreatmentPrescription` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `prescription` */

/*Table structure for table `prescription_outgoing_drug` */

DROP TABLE IF EXISTS `prescription_outgoing_drug`;

CREATE TABLE `prescription_outgoing_drug` (
`prescription_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`prescription_id` int(11) unsigned NOT NULL,
`outgoing_drug_id` int(11) unsigned NOT NULL,
`created_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`prescription_outgoing_drug_id`),
KEY `fk_Prescription` (`prescription_id`),
KEY `fk_OutgoingDrug` (`outgoing_drug_id`),
CONSTRAINT `fk_OutgoingDrug` FOREIGN KEY (`outgoing_drug_id`) REFERENCES `outgoing_drugs` (`outgoing_drugs_id`),
CONSTRAINT `fk_Prescription` FOREIGN KEY (`prescription_id`) REFERENCES `prescription` (`prescription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `prescription_outgoing_drug` */

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
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
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`profile_id`),
KEY `fk_IdentificationUserId` (`userid`),
KEY `fk_DepartmentProfile` (`department_id`),
CONSTRAINT `fk_DepartmentProfile` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
CONSTRAINT `fk_UserProfile` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `profile` */

insert  into `profile`(`profile_id`,`userid`,`surname`,`firstname`,`middlename`,`department_id`,`work_address`,`home_address`,`telephone`,`sex`,`height`,`weight`,`birth_date`,`create_date`,`modified_date`,`active_fg`) values (7,1,'mbakwe','caleb','chukwuezugo',1,'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu','room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu','+2348030420046','MALE',2,80,'2015-02-06','2015-02-06 12:10:49','2015-02-06 12:10:49',1),(9,2,'moses','adebayo','olajuwon',2,'23b ezeagu lane, ajegunle lagos','23b ezeagu lane, ajegunle lagos','+2348162886288','MALE',120,75,'1979-09-15','2015-02-10 12:27:27','2015-02-10 12:27:27',1);

/*Table structure for table `radiology` */

DROP TABLE IF EXISTS `radiology`;

CREATE TABLE `radiology` (
`radiology_id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) NOT NULL,
`doctor_id` int(11) NOT NULL,
`lab_attendant_id` int(11) DEFAULT NULL,
`ward_clinic_id` varchar(25) NOT NULL,
`xray_case_id` int(11) NOT NULL,
`xray_size_id` int(11) NOT NULL,
`treatment_id` int(11) DEFAULT NULL,
`consultant_in_charge` varchar(35) NOT NULL,
`checked_by` varchar(35) NOT NULL,
`radiographers_note` text NOT NULL,
`radiologists_report` text NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`lmp` varchar(50) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
`status_id` int(11) NOT NULL DEFAULT '5',
PRIMARY KEY (`radiology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `radiology` */

/*Table structure for table `roster` */

DROP TABLE IF EXISTS `roster`;

CREATE TABLE `roster` (
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
KEY `fk_ModifiedBy` (`modified_by`),
CONSTRAINT `fk_CreatedBy` FOREIGN KEY (`created_by`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_DutyStatus` FOREIGN KEY (`duty`) REFERENCES `status` (`status_id`),
CONSTRAINT `fk_ModifiedBy` FOREIGN KEY (`modified_by`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_UserDept` FOREIGN KEY (`dept_id`) REFERENCES `department` (`department_id`),
CONSTRAINT `fk_UserRoster` FOREIGN KEY (`user_id`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=armscii8;

/*Data for the table `roster` */

insert  into `roster`(`roster_id`,`user_id`,`created_by`,`dept_id`,`duty`,`duty_date`,`created_date`,`modified_date`,`modified_by`,`active_fg`) values (74,2,2,2,8,'2015-02-08','2015-02-19 00:27:16','2015-02-19 00:27:16',NULL,1),(75,2,2,2,8,'2015-02-02','2015-02-19 00:28:24','2015-02-19 00:28:24',NULL,1),(76,1,2,1,8,'2015-02-02','2015-02-19 00:29:27','2015-02-19 00:29:27',NULL,1),(77,2,2,2,10,'2015-02-01','2015-02-19 01:44:19','2015-02-19 01:44:19',NULL,1),(78,2,1,2,9,'2015-02-09','2015-02-19 01:48:25','2015-02-19 01:48:25',NULL,1),(79,2,1,2,9,'2015-02-03','2015-02-19 01:48:48','2015-02-19 01:48:48',NULL,1);

/*Table structure for table `staff_permission` */

DROP TABLE IF EXISTS `staff_permission`;

CREATE TABLE `staff_permission` (
`staff_permission_id` int(11) NOT NULL AUTO_INCREMENT,
`staff_permission` varchar(100) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`staff_permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `staff_permission` */

insert  into `staff_permission`(`staff_permission_id`,`staff_permission`,`create_date`,`modified_date`,`active_fg`) values (1,'read_only','2015-01-26 12:44:17','2015-01-26 12:44:20',1),(2,'read_write','2015-01-26 12:46:14','2015-01-26 12:46:12',1);

/*Table structure for table `staff_role` */

DROP TABLE IF EXISTS `staff_role`;

CREATE TABLE `staff_role` (
`staff_role_id` int(11) NOT NULL AUTO_INCREMENT,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`staff_role` varchar(100) NOT NULL,
`role_label` varchar(50) DEFAULT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`staff_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `staff_role` */

insert  into `staff_role`(`staff_role_id`,`create_date`,`modified_date`,`staff_role`,`role_label`,`active_fg`) values (1,'2015-01-26 12:24:47','2015-01-26 12:24:54','administrator','adminisrator',1),(2,'0000-00-00 00:00:00','0000-00-00 00:00:00','doctor','doctor',1),(3,'2015-01-26 12:26:48','2015-01-26 12:26:52','pharmacist','pharmacist',1),(4,'2015-01-28 13:00:36','2015-01-28 13:00:42','medical_records','medical records',1),(5,'2015-01-28 13:01:20','2015-01-28 13:01:25','permission','permission_granter',1),(6,'2015-01-28 13:01:58','2015-01-28 13:02:01','urine','urine test conductor',1),(7,'2015-01-28 13:02:40','2015-01-28 13:02:43','visual','visual test conductor',1),(8,'2015-01-28 13:02:59','2015-01-28 13:03:03','xray ','xray test conductor',1),(9,'2015-01-28 13:03:32','2015-01-28 13:03:35','health_scheme','health scheme',1),(10,'2015-01-28 13:04:03','2015-01-28 13:04:06','parasitology','parasitology conductor',1),(11,'2015-01-28 13:04:24','2015-01-28 13:04:26','chemical_pathology','chemical pathology conductor',1),(12,'2015-01-28 13:05:02','2015-01-28 13:05:07','add_staff','staff adding officer',1),(13,'2015-01-28 13:05:30','2015-01-28 13:05:33','staff_reg','staff clearance',1),(14,'2015-01-28 13:05:51','2015-01-28 13:05:54','treatment_recrods','treatment history',1),(15,'2015-02-16 01:04:09','2015-02-16 00:00:00','roster','roster creator',1);

/*Table structure for table `status` */

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
`status_id` int(11) NOT NULL AUTO_INCREMENT,
`status_name` varchar(15) CHARACTER SET utf8 NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `status` */

insert  into `status`(`status_id`,`status_name`,`active_fg`) values (1,'active',1),(2,'inactive',1),(3,'unclear',1),(4,'cleared',1),(5,'pending',1),(6,'processing',1),(7,'completed',1),(8,'morning_duty',1),(9,'afternoon_duty',1),(10,'evening_duty',1);

/*Table structure for table `treatment` */

DROP TABLE IF EXISTS `treatment`;

CREATE TABLE `treatment` (
`treatment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`doctor_id` int(11) NOT NULL,
`patient_id` int(11) NOT NULL,
`consultation` text NOT NULL,
`symptoms` text NOT NULL,
`diagnosis` text NOT NULL,
`comments` text,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`treatment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `treatment` */

/*Table structure for table `unit_ref` */

DROP TABLE IF EXISTS `unit_ref`;

CREATE TABLE `unit_ref` (
`unit_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`unit` varchar(50) NOT NULL,
`created_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`unit_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `unit_ref` */

/*Table structure for table `urinalysis` */

DROP TABLE IF EXISTS `urinalysis`;

CREATE TABLE `urinalysis` (
`urinalysis_id` int(11) NOT NULL AUTO_INCREMENT,
`urine_id` int(11) NOT NULL,
`appearance` varchar(35) NOT NULL,
`ph` varchar(35) NOT NULL,
`glucose` varchar(35) NOT NULL,
`protein` varchar(35) NOT NULL,
`bilirubin` varchar(35) NOT NULL,
`urobillinogen` varchar(35) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`urinalysis_id`),
KEY `fk_UrinalysisUrineId` (`urine_id`),
CONSTRAINT `fk_UrinalysisUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `urinalysis` */

/*Table structure for table `urinary` */

DROP TABLE IF EXISTS `urinary`;

CREATE TABLE `urinary` (
`urinary_id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) NOT NULL,
`urinaryproblem` int(11) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`urinary_id`),
KEY `fk_UrinaryUserId` (`userid`),
KEY `fk_UrinaryProblem` (`urinaryproblem`),
CONSTRAINT `fk_UrinaryProblem` FOREIGN KEY (`urinaryproblem`) REFERENCES `name_of_field` (`name_of_field_id`),
CONSTRAINT `fk_UrinaryUserId` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `urinary` */

/*Table structure for table `urine` */

DROP TABLE IF EXISTS `urine`;

CREATE TABLE `urine` (
`urine_id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) NOT NULL,
`treatment_id` int(11) unsigned NOT NULL,
`lab_attendant_id` int(11) NOT NULL,
`clinical_diagnosis_details` text,
`investigation_required` varchar(100) NOT NULL,
`doctor_id` int(11) NOT NULL,
`laboratory_report` text NOT NULL,
`laboratory_ref` varchar(10) NOT NULL,
`culture_value` text NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`status_id` int(11) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`urine_id`),
KEY `fk_UrineUserId` (`userid`),
KEY `fk_UrineStatusId` (`status_id`),
KEY `fk_UrineTreatmentId` (`treatment_id`),
CONSTRAINT `fk_UrineTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`),
CONSTRAINT `fk_UrineStatusId` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
CONSTRAINT `fk_UrineUserId` FOREIGN KEY (`userid`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `urine` */

/*Table structure for table `urine_sensitivity` */

DROP TABLE IF EXISTS `urine_sensitivity`;

CREATE TABLE `urine_sensitivity` (
`urine_sensitivity_id` int(11) NOT NULL AUTO_INCREMENT,
`urine_id` int(11) NOT NULL,
`isolates` int(11) DEFAULT NULL,
`isolates_degree` int(11) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`urine_sensitivity_id`),
KEY `fk_UrineSensitivityUrineId` (`urine_id`),
KEY `fk_UrineSensitivityRefId` (`isolates`),
CONSTRAINT `fk_UrineSensitivityUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `urine_sensitivity` */

/*Table structure for table `urine_sensitivity_ref` */

DROP TABLE IF EXISTS `urine_sensitivity_ref`;

CREATE TABLE `urine_sensitivity_ref` (
`urine_sensitivity_ref_id` int(11) NOT NULL AUTO_INCREMENT,
`antibiotics` varchar(35) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`urine_sensitivity_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `urine_sensitivity_ref` */

/*Table structure for table `user_auth` */

DROP TABLE IF EXISTS `user_auth`;

CREATE TABLE `user_auth` (
`userid` int(11) NOT NULL AUTO_INCREMENT,
`regNo` varchar(35) NOT NULL,
`passcode` varchar(64) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`status` int(11) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
`online_status` int(1) DEFAULT '0',
PRIMARY KEY (`userid`),
KEY `fk_UserStatus` (`status`),
CONSTRAINT `fk_UserStatus` FOREIGN KEY (`status`) REFERENCES `status` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `user_auth` */

insert  into `user_auth`(`userid`,`regNo`,`passcode`,`create_date`,`modified_date`,`status`,`active_fg`,`online_status`) values (1,'PMS001','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-26 18:30:48','2015-02-13 15:25:18',1,1,0),(2,'PMS002','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-28 18:00:51','2015-02-06 12:05:46',1,1,0),(3,'PMS003','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-29 18:37:49','2015-01-29 18:37:49',2,1,1);

/*Table structure for table `visual_skills_profile` */

DROP TABLE IF EXISTS `visual_skills_profile`;

CREATE TABLE `visual_skills_profile` (
`visual_profile_id` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) unsigned NOT NULL,
`doctor_id` int(11) DEFAULT '1',
`treatment_id` int(11) DEFAULT NULL,
`distance_re` varchar(10) NOT NULL,
`distance_le` varchar(10) NOT NULL,
`distance_be` varchar(10) NOT NULL,
`near_re` varchar(10) NOT NULL,
`near_le` varchar(10) NOT NULL,
`near_be` varchar(10) NOT NULL,
`pinhole_acuity_re` varchar(10) NOT NULL,
`pinhole_acuity_le` varchar(10) NOT NULL,
`pinhole_acuity_be` varchar(10) NOT NULL,
`colour_vision` varchar(30) NOT NULL,
`stereopsis` varchar(30) NOT NULL,
`amplitude_of_accomodation` varchar(30) NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
`lab_attendant_id` int(11) DEFAULT NULL,
`status_id` int(11) NOT NULL DEFAULT '5',
PRIMARY KEY (`visual_profile_id`),
KEY `fk_VisualUserId` (`userid`),
KEY `fk_VisualDoctor` (`doctor_id`),
CONSTRAINT `fk_VisualDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_VisualUserId` FOREIGN KEY (`userid`) REFERENCES `patient` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Data for the table `visual_skills_profile` */

/*Table structure for table `vitals` */

DROP TABLE IF EXISTS `vitals`;

CREATE TABLE `vitals` (
`vitals_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`patient_id` int(11) unsigned NOT NULL,
`encounter_id` int(11) unsigned NOT NULL,
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
KEY `added_by` (`added_by`),
CONSTRAINT `fk_AddedByUserId` FOREIGN KEY (`added_by`) REFERENCES `user_auth` (`userid`),
CONSTRAINT `fk_PatientVitals` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `vitals` */

/*Table structure for table `ward_ref` */

DROP TABLE IF EXISTS `ward_ref`;

CREATE TABLE `ward_ref` (
`ward_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`description` text NOT NULL,
`created_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`ward_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ward_ref` */

/*Table structure for table `xray_case` */

DROP TABLE IF EXISTS `xray_case`;

CREATE TABLE `xray_case` (
`xray_case_id` int(11) NOT NULL AUTO_INCREMENT,
`option` varchar(25) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`xray_case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `xray_case` */

/*Table structure for table `xray_no` */

DROP TABLE IF EXISTS `xray_no`;

CREATE TABLE `xray_no` (
`xray_id` int(11) NOT NULL AUTO_INCREMENT,
`radiology_id` int(11) NOT NULL,
`xray_number` varchar(7) CHARACTER SET latin1 NOT NULL,
`casual_no` varchar(25) CHARACTER SET latin1 NOT NULL,
`gp_no` varchar(25) CHARACTER SET latin1 NOT NULL,
`ante_natal_no` varchar(25) CHARACTER SET latin1 NOT NULL,
`create_date` datetime NOT NULL,
`modified_date` datetime NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`xray_id`),
KEY `fk_XRayNoRadiologyId` (`radiology_id`),
CONSTRAINT `fk_XRayNoRadiologyId` FOREIGN KEY (`radiology_id`) REFERENCES `radiology` (`radiology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `xray_no` */

/*Table structure for table `xray_size` */

DROP TABLE IF EXISTS `xray_size`;

CREATE TABLE `xray_size` (
`xray_size_id` int(11) NOT NULL AUTO_INCREMENT,
`dimension` varchar(10) NOT NULL,
`active_fg` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY (`xray_size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `xray_size` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
