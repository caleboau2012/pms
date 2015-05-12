-- MySQL dump 10.13  Distrib 5.6.24, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: pms
-- ------------------------------------------------------
-- Server version	5.6.24-0ubuntu2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `pms`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `pms`;

--
-- Table structure for table `admission`
--

DROP TABLE IF EXISTS `admission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admission` (
  `admission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bed_id` int(11) unsigned NOT NULL,
  `admitted_by` int(11) NOT NULL,
  `patient_id` int(11) unsigned NOT NULL,
  `entry_date` datetime NOT NULL,
  `exit_date` datetime NOT NULL,
  `comments` text,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `treatment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`admission_id`),
  KEY `fk_AdmittedBy` (`admitted_by`),
  KEY `fk_PatientAdmitted` (`patient_id`),
  KEY `fk_AdmissionBed` (`bed_id`),
  KEY `fk_TreatmentAdmission` (`treatment_id`),
  CONSTRAINT `fk_AdmissionBed` FOREIGN KEY (`bed_id`) REFERENCES `bed` (`bed_id`),
  CONSTRAINT `fk_AdmittedBy` FOREIGN KEY (`admitted_by`) REFERENCES `user_auth` (`userid`),
  CONSTRAINT `fk_PatientAdmitted` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`patient_id`),
  CONSTRAINT `fk_TreatmentAdmission` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admission`
--

LOCK TABLES `admission` WRITE;
/*!40000 ALTER TABLE `admission` DISABLE KEYS */;
/*!40000 ALTER TABLE `admission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admission_req`
--

DROP TABLE IF EXISTS `admission_req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admission_req`
--

LOCK TABLES `admission_req` WRITE;
/*!40000 ALTER TABLE `admission_req` DISABLE KEYS */;
/*!40000 ALTER TABLE `admission_req` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bed`
--

DROP TABLE IF EXISTS `bed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bed`
--

LOCK TABLES `bed` WRITE;
/*!40000 ALTER TABLE `bed` DISABLE KEYS */;
/*!40000 ALTER TABLE `bed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blood_test`
--

DROP TABLE IF EXISTS `blood_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bloodtest_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_BloodTestHaematologyId` (`haematology_id`),
  CONSTRAINT `fk_BloodTestHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blood_test`
--

LOCK TABLES `blood_test` WRITE;
/*!40000 ALTER TABLE `blood_test` DISABLE KEYS */;
INSERT INTO `blood_test` VALUES (1,1,3.8,4.5,2.3,3.5,6.8,0.87,3.2,3.2,7.4,'plenty','super plenty','2015-03-11 10:43:48','2015-04-17 10:52:36',1);
/*!40000 ALTER TABLE `blood_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_pathology_details`
--

DROP TABLE IF EXISTS `chemical_pathology_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_pathology_details`
--

LOCK TABLES `chemical_pathology_details` WRITE;
/*!40000 ALTER TABLE `chemical_pathology_details` DISABLE KEYS */;
INSERT INTO `chemical_pathology_details` VALUES (2,1,1,20,'2015-03-11 00:00:00','2015-03-12 16:12:06',1),(3,1,2,30,'2015-03-11 00:00:00','2015-03-12 16:12:06',1),(19,1,3,40,'2015-03-12 15:36:51','2015-03-12 16:12:06',1),(20,1,4,50,'2015-03-12 15:36:51','2015-03-12 16:12:06',1),(21,1,5,60,'2015-03-12 15:36:51','2015-03-12 16:12:06',1),(22,1,6,70,'2015-03-12 15:36:51','2015-03-12 16:12:06',1),(23,1,7,20,'2015-03-12 15:36:51','2015-03-12 16:12:06',1);
/*!40000 ALTER TABLE `chemical_pathology_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_pathology_ref`
--

DROP TABLE IF EXISTS `chemical_pathology_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chemical_pathology_ref` (
  `cpref_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) DEFAULT NULL,
  `status_type` varchar(35) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cpref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_pathology_ref`
--

LOCK TABLES `chemical_pathology_ref` WRITE;
/*!40000 ALTER TABLE `chemical_pathology_ref` DISABLE KEYS */;
INSERT INTO `chemical_pathology_ref` VALUES (1,'Na(120-140)','ELECTROLYTES',1),(2,'K(3-5)','ELECTROLYTES',1),(3,'Cl(95-110)','ELECTROLYTES',1),(4,'HCO3(20-30)','ELECTROLYTES',1),(5,'Ca(2.25-2.75)','ELECTROLYTES',1),(6,'Creatinnie(50-132)','ELECTROLYTES',1),(7,'Urea(2.5-5.8)','ELECTROLYTES',1),(8,'Uric Acid(0.12-0.36)','ELECTROLYTES',1),(9,'Total Chol(2.5-5.17)','Fasting Lipids Profile',1),(10,'TG < 2.3','Fasting Lipids Profile',1),(11,'HDL > 1.04','Fasting Lipids Profile',1),(12,'LDL > 3.9','Fasting Lipids Profile',1),(13,'Glucose(Fatsing) 2.8-5.0','Fasting Lipids Profile',1),(14,'Glucose(2HPP) 3.0-6.0','Fasting Lipids Profile',1),(15,'Bilirubin(Total)','LFT',1),(16,'Bilirubin(Conj.)','LFT',1),(17,'Alk Phos','LFT',1),(18,'Acid Phos','LFT',1),(19,'ALT(SGPT)','LFT',1),(20,'AST(SGOT)','LFT',1),(21,'Total protein','PROTEINS',1),(22,'Albumin','PROTEINS',1),(23,'Globulin','PROTEINS',1),(24,'Others','PROTEINS',1);
/*!40000 ALTER TABLE `chemical_pathology_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_pathology_request`
--

DROP TABLE IF EXISTS `chemical_pathology_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chemical_pathology_request` (
  `cpreq_id` int(11) NOT NULL AUTO_INCREMENT,
  `treatment_id` int(11) unsigned NOT NULL,
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
  KEY `fk_ChemicalStatus` (`status_id`),
  CONSTRAINT `fk_ChemicalDoctor` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
  CONSTRAINT `fk_ChemicalStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  CONSTRAINT `fk_ChemicalTreatment` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_pathology_request`
--

LOCK TABLES `chemical_pathology_request` WRITE;
/*!40000 ALTER TABLE `chemical_pathology_request` DISABLE KEYS */;
INSERT INTO `chemical_pathology_request` VALUES (1,1,'CP101','dont know oo','Check this dude','2015-03-11 00:00:00','2015-03-12 16:12:06',1,1,3,6,1);
/*!40000 ALTER TABLE `chemical_pathology_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communication`
--

DROP TABLE IF EXISTS `communication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communication` (
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
  KEY `fk_MsgRecipient` (`recipient_id`),
  CONSTRAINT `fk_MsgRecipient` FOREIGN KEY (`recipient_id`) REFERENCES `user_auth` (`userid`),
  CONSTRAINT `fk_MsgSender` FOREIGN KEY (`sender_id`) REFERENCES `user_auth` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communication`
--

LOCK TABLES `communication` WRITE;
/*!40000 ALTER TABLE `communication` DISABLE KEYS */;
INSERT INTO `communication` VALUES (1,1,2,'Lorem ipsum','Bacno ipsum',1,1,'2015-02-17 12:12:00','2015-02-23 12:36:35'),(10,1,2,'Labore jerky swine sausage','Labore jerky swine sausage alcatra leberkas nostrud sint. Consequat po',1,1,'2015-02-17 16:20:04','2015-02-23 12:36:36'),(11,2,1,'Pastrami doner tenderloin','Pastrami doner tenderloin sirloin jerky chuck flank filet mignon shoul',0,1,'2015-02-17 16:49:41','2015-02-23 12:19:40'),(12,1,2,'Pastrami tenderloin','Bacon ipsum dolor amet bresaola spare ribs pig, picanha tail turducken bacon chicken jerky tri-tip leberkas. Spare ribs shank t-bone, venison tenderloin ham hock hamburger leberkas. Kielbasa pork bell',1,1,'2015-02-23 11:48:58','2015-02-24 17:48:36'),(14,3,1,'tri-tip prosciutto','icanha tri-tip prosciutto landjaeger flank porchetta turducken pork. Shank drumstick pork chop picanha swine tenderloin porchetta doner sausage pork ball tip ground round jerky. Andouille prosciutto b',0,1,'2015-02-23 13:33:37','2015-02-23 16:21:40'),(15,3,2,'turkey jowl salami tongue','Salami tongue cupim jowl, turkey venison beef ribs shankle swine frankfurter tenderloin. Drumstick hamburger ham turducken tri-tip alcatra short loin pastrami. Jerky cupim porchetta corned beef, tri-t',0,1,'2015-02-23 13:35:32','2015-02-24 15:30:00'),(16,3,1,'Cupim alcatra drumstick','Shankle cow ball tip jerky tongue rump jowl filet mignon pig tri-tip shank spare ribs chicken. Venison biltong tri-tip, pork loin leberkas hamburger tail t-bone. Bacon frankfurter tenderloin shoulder,',0,1,'2015-02-23 13:48:39','2015-02-23 16:21:38'),(17,3,2,'pastrami rump chicken','andjaeger corned beef turkey, filet mignon tail pork ham hock pork chop short loin leberkas bacon strip steak ribeye pork loin alcatra. Fatback sausage bacon short ribs jerky brisket. Drumstick landja',0,1,'2015-02-23 13:52:17','2015-02-24 19:12:31'),(18,3,2,'Cupim alcatra drumstick','Andouille ham hock biltong, shoulder bacon flank strip steak frankfurter ball tip salami porchetta capicola. Pork andouille strip steak jerky pork loin ball tip. Meatloaf tail jowl, pig ham bresaola p',0,1,'2015-02-23 14:12:41','2015-02-24 15:29:16'),(19,3,1,'Cupim alcatra drumstick','Cupim alcatra drumstick',0,1,'2015-02-23 14:18:42','2015-02-23 16:21:31'),(20,3,1,'drumstick','Cupim alcatra drumstick',0,1,'2015-02-23 14:19:32','2015-02-23 16:21:16'),(21,3,2,'alcatra','Cupim alcatra drumstick\nCupim alcatra drumstick\nCupim alcatra drumstick',1,1,'2014-02-23 14:22:11','2015-02-24 17:48:35'),(22,2,1,'Fwd: turkey jowl salami tongue','\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 1:35:32 PM\nSubject: turkey jowl salami tongue\nTo: moses olajuwon adebayo\n\nSalami tongue cupim jowl, turke',1,1,'2015-02-24 15:30:40','2015-02-24 15:30:40'),(29,2,3,'Fwd: Fwd: turkey jowl salami tongue','Bacon ipsum dolor amet bacon tri-tip pancetta shoulder brisket. Ground round brisket chuck, tri-tip filet mignon bacon pork belly jowl rump salami spare ribs pancetta. Prosciutto cow tongue shankle po',1,1,'2015-02-24 17:42:38','2015-02-24 18:41:08'),(30,2,1,'Fwd: Cupim alcatra drumstick','\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 2:12:41 PM\nSubject: Cupim alcatra drumstick\nTo: moses olajuwon adebayo\n\nAndouille ham hock biltong, shoul',0,1,'2015-02-24 17:43:58','2015-03-03 10:59:20'),(31,2,1,'Fwd: alcatra','\n---------- Forwarded message ----------\nFrom: adewoye adeola abiodun\nDate: Mon Feb 23 2015 at 2:22:11 PM\nSubject: alcatra\nTo: moses olajuwon adebayo\n\nCupim alcatra drumstick\nCupim alcatra drumstick\nC',0,1,'2015-02-24 17:44:14','2015-03-03 10:59:30');
/*!40000 ALTER TABLE `communication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `department_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'doctor'),(2,'pharmacy'),(3,'mro'),(4,'parasitology'),(7,'haematology'),(8,'parasitology');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `differential_count`
--

DROP TABLE IF EXISTS `differential_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`differential_count_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_DiffCountHaematologyId` (`haematology_id`),
  CONSTRAINT `fk_DiffCountHaematologyId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `differential_count`
--

LOCK TABLES `differential_count` WRITE;
/*!40000 ALTER TABLE `differential_count` DISABLE KEYS */;
INSERT INTO `differential_count` VALUES (1,1,23,7.8,1.54,5,6.4,3,'AB','+','AA','2015-03-11 11:32:59','2015-04-17 10:52:36',1);
/*!40000 ALTER TABLE `differential_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drug_ref`
--

DROP TABLE IF EXISTS `drug_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drug_ref` (
  `drug_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`drug_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drug_ref`
--

LOCK TABLES `drug_ref` WRITE;
/*!40000 ALTER TABLE `drug_ref` DISABLE KEYS */;
INSERT INTO `drug_ref` VALUES (1,'paracetamol','2015-02-20 00:00:00',1),(2,'panadol','2015-02-20 00:00:00',1),(3,'ampiclox','2015-02-25 00:00:00',1),(4,'tetracycline','2015-02-25 00:00:00',1),(5,'as','2015-03-02 15:00:13',1),(6,'df','2015-03-02 15:12:13',1),(7,'der','2015-03-02 15:26:54',1),(8,'zx','2015-03-02 16:24:51',1),(9,'add','2015-03-02 16:30:50',1),(10,'dss','2015-03-02 16:31:45',1),(11,'ad','2015-03-02 16:33:45',1),(12,'ade','2015-03-02 16:41:03',1),(13,'cxc','2015-03-04 15:07:00',1),(14,'cxzc','2015-03-04 15:08:33',1);
/*!40000 ALTER TABLE `drug_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encounter`
--

DROP TABLE IF EXISTS `encounter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encounter`
--

LOCK TABLES `encounter` WRITE;
/*!40000 ALTER TABLE `encounter` DISABLE KEYS */;
/*!40000 ALTER TABLE `encounter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `film_appearance`
--

DROP TABLE IF EXISTS `film_appearance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`film_appearance_id`),
  UNIQUE KEY `haematology_id` (`haematology_id`),
  KEY `fk_FilmAppearanceHaematologyReportId` (`haematology_id`),
  CONSTRAINT `fk_FilmAppearanceHaematologyReportId` FOREIGN KEY (`haematology_id`) REFERENCES `haematology` (`haematology_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `film_appearance`
--

LOCK TABLES `film_appearance` WRITE;
/*!40000 ALTER TABLE `film_appearance` DISABLE KEYS */;
INSERT INTO `film_appearance` VALUES (1,1,'plenty','few','a little','some','quite','yes','no','white blood cells','e like so','Dont know what this is','yep','2015-03-11 11:08:01','2015-04-17 10:52:36',1);
/*!40000 ALTER TABLE `film_appearance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `haematology`
--

DROP TABLE IF EXISTS `haematology`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `haematology` (
  `haematology_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinical_diagnosis_details` text,
  `doctor_id` int(11) NOT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `laboratory_report` text NOT NULL,
  `laboratory_ref` varchar(10) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`haematology_id`),
  KEY `fk_DoctorId` (`doctor_id`),
  KEY `fk_TreatmentId` (`treatment_id`),
  KEY `fk_HaematologyStatus` (`status_id`),
  CONSTRAINT `fk_DoctorId` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
  CONSTRAINT `fk_HaematologyStatus` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  CONSTRAINT `fk_TreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `haematology`
--

LOCK TABLES `haematology` WRITE;
/*!40000 ALTER TABLE `haematology` DISABLE KEYS */;
INSERT INTO `haematology` VALUES (1,'something sha',1,2,'somthing too sha                                                                                ','H101','2015-03-10 00:00:00','2015-04-17 10:52:36',1,1,6),(2,'something',1,NULL,'','','2015-04-08 20:01:15','2015-04-08 20:01:15',2,1,5);
/*!40000 ALTER TABLE `haematology` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `microscopy`
--

DROP TABLE IF EXISTS `microscopy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `microscopy` (
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
  KEY `fk_MicroscopyUrineId` (`urine_id`),
  CONSTRAINT `fk_MicroscopyUrineId` FOREIGN KEY (`urine_id`) REFERENCES `urine` (`urine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `microscopy`
--

LOCK TABLES `microscopy` WRITE;
/*!40000 ALTER TABLE `microscopy` DISABLE KEYS */;
INSERT INTO `microscopy` VALUES (1,1,'yes','too much','much','nil','little','nil','2015-03-10 13:29:33','2015-04-17 11:33:36',1),(5,2,'yes','too much','much','nil','little','nil','2015-03-13 08:58:33','2015-04-17 11:34:12',1);
/*!40000 ALTER TABLE `microscopy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nok_relationship`
--

DROP TABLE IF EXISTS `nok_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nok_relationship` (
  `nok_relationship_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `relationship` varchar(25) NOT NULL,
  PRIMARY KEY (`nok_relationship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nok_relationship`
--

LOCK TABLES `nok_relationship` WRITE;
/*!40000 ALTER TABLE `nok_relationship` DISABLE KEYS */;
INSERT INTO `nok_relationship` VALUES (1,'father'),(2,'mother'),(3,'son'),(4,'daughter'),(5,'brother'),(6,'sister'),(7,'husband'),(8,'wife'),(9,'others');
/*!40000 ALTER TABLE `nok_relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outgoing_drugs`
--

DROP TABLE IF EXISTS `outgoing_drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outgoing_drugs`
--

LOCK TABLES `outgoing_drugs` WRITE;
/*!40000 ALTER TABLE `outgoing_drugs` DISABLE KEYS */;
INSERT INTO `outgoing_drugs` VALUES (66,1,20,1,'2015-02-25 13:00:43','2015-02-25 13:00:43',1),(67,3,20,1,'2015-02-25 13:00:43','2015-02-25 13:00:43',1),(68,1,20,1,'2015-02-25 13:02:05','2015-02-25 13:02:05',1),(69,3,20,1,'2015-02-25 13:02:05','2015-02-25 13:02:05',1),(70,1,20,1,'2015-02-25 13:02:11','2015-02-25 13:02:11',1),(71,3,20,1,'2015-02-25 13:02:11','2015-02-25 13:02:11',1),(72,1,20,1,'2015-02-25 13:10:55','2015-02-25 13:10:55',1),(73,3,20,1,'2015-02-25 13:10:55','2015-02-25 13:10:55',1),(74,1,20,1,'2015-02-25 13:10:58','2015-02-25 13:10:58',1),(75,3,20,1,'2015-02-25 13:10:58','2015-02-25 13:10:58',1),(76,1,20,1,'2015-02-25 13:10:59','2015-02-25 13:10:59',1),(77,3,20,1,'2015-02-25 13:10:59','2015-02-25 13:10:59',1),(78,1,20,1,'2015-02-25 13:25:26','2015-02-25 13:25:26',1),(79,3,20,1,'2015-02-25 13:25:26','2015-02-25 13:25:26',1),(80,1,20,1,'2015-02-25 13:43:24','2015-02-25 13:43:24',1),(81,3,20,1,'2015-02-25 13:43:24','2015-02-25 13:43:24',1),(82,1,20,1,'2015-02-25 16:30:09','2015-02-25 16:30:09',1),(83,3,20,1,'2015-02-25 16:30:09','2015-02-25 16:30:09',1),(84,1,20,1,'2015-02-25 17:40:21','2015-02-25 17:40:21',1),(85,3,20,1,'2015-02-25 17:40:21','2015-02-25 17:40:21',1),(89,3,2,1,'2015-03-02 14:17:17','2015-03-02 14:17:17',1),(90,3,2,1,'2015-03-02 14:20:50','2015-03-02 14:20:50',1),(91,3,2,1,'2015-03-02 14:55:19','2015-03-02 14:55:19',1),(92,5,2,1,'2015-03-02 15:00:13','2015-03-02 15:00:13',1),(93,6,2,1,'2015-03-02 15:12:13','2015-03-02 15:12:13',1),(94,7,2,1,'2015-03-02 15:26:54','2015-03-02 15:26:54',1),(95,3,2,1,'2015-03-02 16:23:16','2015-03-02 16:23:16',1),(96,8,2,1,'2015-03-02 16:24:51','2015-03-02 16:24:51',1),(97,5,2,1,'2015-03-02 16:30:07','2015-03-02 16:30:07',1),(98,9,2,1,'2015-03-02 16:30:50','2015-03-02 16:30:50',1),(99,10,2,1,'2015-03-02 16:31:45','2015-03-02 16:31:45',1),(100,11,2,1,'2015-03-02 16:33:45','2015-03-02 16:33:45',1),(101,12,2,1,'2015-03-02 16:41:03','2015-03-02 16:41:03',1),(102,12,2,1,'2015-03-02 16:42:40','2015-03-02 16:42:40',1),(103,10,2,1,'2015-03-04 14:54:32','2015-03-04 14:54:32',1),(104,13,2,1,'2015-03-04 15:07:00','2015-03-04 15:07:00',1),(105,14,2,1,'2015-03-04 15:08:33','2015-03-04 15:08:33',1);
/*!40000 ALTER TABLE `outgoing_drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parasitology_details`
--

DROP TABLE IF EXISTS `parasitology_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parasitology_details`
--

LOCK TABLES `parasitology_details` WRITE;
/*!40000 ALTER TABLE `parasitology_details` DISABLE KEYS */;
INSERT INTO `parasitology_details` VALUES (1,1,1,'2015-03-12 00:00:00','2015-04-08 14:07:03',0),(2,1,2,'2015-03-12 00:00:00','2015-04-08 14:07:03',0),(3,1,3,'2015-03-12 13:40:58','2015-04-08 14:07:03',0),(4,1,4,'2015-03-12 13:40:58','2015-04-08 14:07:03',0),(10,1,5,'2015-03-12 13:46:11','2015-04-08 14:07:03',0),(11,1,6,'2015-03-12 13:46:11','2015-04-08 14:07:03',0),(12,1,7,'2015-03-12 13:46:11','2015-04-08 14:07:03',0),(13,1,8,'2015-03-12 13:46:11','2015-04-08 14:07:03',1),(14,1,9,'2015-03-12 13:46:11','2015-04-08 14:07:03',0),(15,1,11,'2015-03-12 14:39:45','2015-04-08 14:07:03',1),(16,1,13,'2015-03-12 14:39:45','2015-04-08 14:07:03',1),(17,1,15,'2015-03-12 14:39:45','2015-04-08 14:07:03',0);
/*!40000 ALTER TABLE `parasitology_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parasitology_ref`
--

DROP TABLE IF EXISTS `parasitology_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parasitology_ref` (
  `pref_id` int(11) NOT NULL AUTO_INCREMENT,
  `parasite_name` varchar(50) DEFAULT NULL,
  `parasite_type` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parasitology_ref`
--

LOCK TABLES `parasitology_ref` WRITE;
/*!40000 ALTER TABLE `parasitology_ref` DISABLE KEYS */;
INSERT INTO `parasitology_ref` VALUES (1,'Hook worm','Ova of',1),(2,'A. lumbricoides','Ova of',1),(3,'T. Trichuris','Ova of',1),(4,'E. vemicularis','Ova of',1),(5,'S. haematobium','Ova of',1),(6,'No cysts. ova','Ova of',1),(7,'E. coli','Trophozoites/cyts of',1),(8,'E. hysto','Trophozoites/cyts of',1),(9,'G. lamblia','Trophozoites/cyts of',1),(10,'Hook worm','Larvae of',1),(11,'S. stercoralis','Larvae of',1),(12,'RBC\'s','Cells',1),(13,'WBC\'s','Cells',1),(14,'Positive','Occult Blood',1),(15,'Negative','Occult Blood',1);
/*!40000 ALTER TABLE `parasitology_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parasitology_req`
--

DROP TABLE IF EXISTS `parasitology_req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parasitology_req` (
  `preq_id` int(11) NOT NULL AUTO_INCREMENT,
  `treatment_id` int(11) unsigned NOT NULL,
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
  KEY `fk_ParasitologyStatusId` (`status_id`),
  CONSTRAINT `fk_ParasitologyDoctorId` FOREIGN KEY (`doctor_id`) REFERENCES `user_auth` (`userid`),
  CONSTRAINT `fk_ParasitologyStatusId` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  CONSTRAINT `fk_ParasitologyTreatmentId` FOREIGN KEY (`treatment_id`) REFERENCES `treatment` (`treatment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parasitology_req`
--

LOCK TABLES `parasitology_req` WRITE;
/*!40000 ALTER TABLE `parasitology_req` DISABLE KEYS */;
INSERT INTO `parasitology_req` VALUES (1,1,'Dont know','general checkup',NULL,'2015-03-12 00:00:00','2015-03-12 00:00:00','2015-04-08 14:07:03',1,1,3,6,NULL,'1','It is okay'),(11,2,NULL,NULL,'something',NULL,'2015-04-08 19:15:49','2015-04-08 19:15:49',1,1,NULL,5,NULL,NULL,NULL),(17,2,NULL,NULL,'something',NULL,'2015-04-08 19:19:09','2015-04-08 19:19:09',1,1,NULL,5,NULL,NULL,NULL);
/*!40000 ALTER TABLE `parasitology_req` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
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
  `family_position` int(11) NOT NULL,
  `mother_status` varchar(25) NOT NULL,
  `father_status` varchar(25) NOT NULL,
  `marital_status` varchar(25) NOT NULL,
  `no_of_children` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`patient_id`),
  KEY `fk_PatientNok` (`nok_relationship`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,'Adeyinka','Akinlabi','Toluwani','23453534','Bolade close','00809098700','Male',11,65,'2015-02-10','Olaniyi','Moses','Arawande','lagos','07030747331',4,'','',0,'','','',0,'2015-02-18 00:00:00','2015-02-19 00:00:00',1),(2,'Adefemi','Olatunji','Abayomi','56745689','lagos state','88909804889','Male',45,34,'2015-02-17','Gabriel','Adewale','Dada','ibadan','08025641756',3,'','',0,'','','',0,'2015-02-12 00:00:00','2015-02-06 00:00:00',1),(3,'Adefem3','Olatunjirf','Abayomiw','56745689','Ogun state','88909804889','Male',45,34,'2015-02-17','Ibrahim','Olakunle','Uthsman','ile-ife','09156234178',0,'','',0,'','','',0,'2015-02-12 00:00:00','2015-02-06 00:00:00',1),(4,'kunle','ajasin','chikaodi','234','fnfnfnnnn','345668','Male',3,4,'2015-02-17','chika','odi','chukuamaka','ilupeju','3459696999',5,'','',0,'','','',0,'2015-02-10 00:00:00','2015-02-08 00:00:00',1);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_queue`
--

DROP TABLE IF EXISTS `patient_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_queue` (
  `patient_queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) unsigned NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`patient_queue_id`),
  KEY `fk_patientQueue` (`patient_id`),
  KEY `fk_PatientDoctor` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_queue`
--

LOCK TABLES `patient_queue` WRITE;
/*!40000 ALTER TABLE `patient_queue` DISABLE KEYS */;
INSERT INTO `patient_queue` VALUES (1,1,NULL,2,'2015-02-23 15:31:11','2015-02-27 10:49:19'),(2,2,2,1,'2015-02-23 15:45:59','2015-02-27 10:47:19'),(3,3,NULL,2,'2015-02-27 10:50:48','2015-02-27 10:50:48');
/*!40000 ALTER TABLE `patient_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,2,1,'2015-01-27 16:25:12','2015-02-02 16:29:46',0),(2,1,1,2,'2015-01-27 16:25:35','2015-02-02 15:29:07',0),(3,1,1,3,'2015-01-28 18:02:22','2015-01-28 20:03:38',0),(4,1,2,4,'2015-01-28 18:38:27','2015-01-28 19:45:39',0),(5,1,1,1,'2015-01-30 15:10:20','2015-02-02 15:39:45',0),(6,1,1,1,'2015-01-30 16:07:18','2015-02-02 16:23:49',0),(7,1,1,3,'2015-02-02 14:59:39','2015-02-02 16:24:13',0),(8,1,1,4,'2015-02-02 15:05:44','2015-02-02 16:25:38',0),(9,1,1,5,'2015-02-02 15:05:51','2015-02-02 16:28:13',0),(10,1,1,6,'2015-02-02 15:06:44','2015-02-02 16:28:47',0),(11,1,1,9,'2015-02-02 15:13:44','2015-02-02 16:28:54',0),(12,1,2,7,'2015-02-02 15:14:52','2015-02-02 16:29:45',0),(13,1,1,8,'2015-02-02 15:15:34','2015-02-02 16:28:55',0),(14,1,1,1,'2015-02-02 15:28:44','2015-02-03 16:25:18',0),(15,1,1,2,'2015-02-02 16:24:09','2015-02-11 11:41:17',0),(16,1,1,3,'2015-02-02 16:25:35','2015-02-13 15:39:21',0),(17,1,1,4,'2015-02-02 16:27:41','2015-02-13 15:39:16',0),(18,1,1,10,'2015-02-02 16:28:02','2015-04-18 19:01:19',0),(19,1,1,5,'2015-02-02 16:28:31','2015-02-02 16:30:08',0),(20,1,1,1,'2015-02-10 11:14:09','2015-02-10 11:14:09',1),(21,2,2,1,'2015-02-10 12:33:01','2015-02-10 12:33:01',1),(22,2,2,10,'2015-02-10 12:33:11','2015-02-10 12:33:11',1),(23,2,2,8,'2015-02-10 12:33:24','2015-02-10 12:33:24',1),(24,1,1,2,'2015-02-11 11:41:24','2015-02-13 15:39:26',0),(25,2,2,2,'2015-02-11 15:54:45','2015-02-11 15:54:45',1),(26,1,1,14,'2015-02-13 15:38:05','2015-02-13 15:38:05',1),(27,1,2,2,'2015-02-13 15:39:39','2015-03-17 06:55:24',0),(28,1,1,3,'2015-02-13 15:40:34','2015-02-13 15:40:34',1),(29,1,1,5,'2015-02-13 15:41:09','2015-02-13 15:41:09',1),(30,1,1,11,'2015-02-13 15:41:19','2015-04-18 19:01:31',0),(31,1,1,8,'2015-02-13 15:41:24','2015-04-18 19:01:22',0),(32,1,1,4,'2015-02-13 15:48:29','2015-02-13 15:48:29',1),(33,1,2,15,'2015-02-16 11:16:27','2015-02-16 11:16:27',1),(34,3,2,1,'2015-02-16 14:03:58','2015-02-19 16:50:13',0),(35,3,2,2,'2015-02-16 14:06:22','2015-02-16 14:06:25',1),(36,3,2,3,'2015-02-16 14:06:33','2015-02-16 14:06:35',1),(37,1,2,9,'2015-02-17 17:32:17','2015-02-17 17:32:17',1),(38,1,1,2,'2015-03-17 06:55:31','2015-03-17 06:55:42',0),(39,1,2,2,'2015-03-17 06:55:49','2015-03-17 06:55:49',1),(40,2,1,7,'2015-03-17 06:57:10','2015-03-17 06:57:10',1),(41,1,2,6,'2015-04-18 19:01:11','2015-04-18 19:01:58',0),(42,1,2,7,'2015-04-18 19:01:14','2015-04-18 19:02:00',0),(43,1,2,8,'2015-04-18 19:01:38','2015-04-18 19:02:03',0),(44,1,2,10,'2015-04-18 19:01:40','2015-04-18 19:01:40',1),(45,1,2,11,'2015-04-18 19:01:43','2015-04-18 19:02:05',0),(46,1,2,6,'2015-04-18 19:02:10','2015-04-18 19:02:10',1),(47,1,2,7,'2015-04-18 19:02:15','2015-04-18 19:02:15',1),(48,1,2,8,'2015-04-18 19:02:18','2015-04-18 19:02:18',1),(49,1,2,11,'2015-04-18 19:02:19','2015-04-18 19:02:19',1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacist_outgoing_drug`
--

DROP TABLE IF EXISTS `pharmacist_outgoing_drug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmacist_outgoing_drug` (
  `pharmacist_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pharmacist_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pharmacist_outgoing_drug_id`),
  KEY `fk_Outgoing` (`outgoing_drug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacist_outgoing_drug`
--

LOCK TABLES `pharmacist_outgoing_drug` WRITE;
/*!40000 ALTER TABLE `pharmacist_outgoing_drug` DISABLE KEYS */;
INSERT INTO `pharmacist_outgoing_drug` VALUES (32,1,66,'2015-02-25 13:00:43',1),(33,1,67,'2015-02-25 13:00:43',1),(34,1,68,'2015-02-25 13:02:05',1),(35,1,69,'2015-02-25 13:02:05',1),(36,1,70,'2015-02-25 13:02:11',1),(37,1,71,'2015-02-25 13:02:11',1),(38,1,72,'2015-02-25 13:10:55',1),(39,1,73,'2015-02-25 13:10:55',1),(40,1,74,'2015-02-25 13:10:58',1),(41,1,75,'2015-02-25 13:10:58',1),(42,1,76,'2015-02-25 13:10:59',1),(43,1,77,'2015-02-25 13:10:59',1),(44,1,78,'2015-02-25 13:25:26',1),(45,1,79,'2015-02-25 13:25:26',1),(46,1,80,'2015-02-25 13:43:24',1),(47,1,81,'2015-02-25 13:43:24',1),(48,1,82,'2015-02-25 16:30:09',1),(49,1,83,'2015-02-25 16:30:09',1),(50,1,84,'2015-02-25 17:40:21',1),(51,1,85,'2015-02-25 17:40:21',1),(55,1,89,'2015-03-02 14:17:17',1),(56,1,90,'2015-03-02 14:20:50',1),(57,1,91,'2015-03-02 14:55:19',1),(58,1,92,'2015-03-02 15:00:13',1),(59,1,93,'2015-03-02 15:12:13',1),(60,1,94,'2015-03-02 15:26:54',1),(61,1,95,'2015-03-02 16:23:16',1),(62,1,96,'2015-03-02 16:24:51',1),(63,1,97,'2015-03-02 16:30:07',1),(64,1,98,'2015-03-02 16:30:50',1),(65,1,99,'2015-03-02 16:31:45',1),(66,1,100,'2015-03-02 16:33:45',1),(67,1,101,'2015-03-02 16:41:03',1),(68,1,102,'2015-03-02 16:42:40',1),(69,1,103,'2015-03-04 14:54:32',1),(70,1,104,'2015-03-04 15:07:00',1),(71,1,105,'2015-03-04 15:08:33',1);
/*!40000 ALTER TABLE `pharmacist_outgoing_drug` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `fk_PrescriptionStatus` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescription`
--

LOCK TABLES `prescription` WRITE;
/*!40000 ALTER TABLE `prescription` DISABLE KEYS */;
INSERT INTO `prescription` VALUES (5,'Quinine',1,1,1,2015,2015,1),(6,'Paracetamol',1,1,1,2015,2015,1),(7,'aaskas',1,1,1,2015,2015,1),(8,'xdsfdfs',1,1,1,2015,2015,1);
/*!40000 ALTER TABLE `prescription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescription_outgoing_drug`
--

DROP TABLE IF EXISTS `prescription_outgoing_drug`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription_outgoing_drug` (
  `prescription_outgoing_drug_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `prescription_id` int(11) unsigned NOT NULL,
  `outgoing_drug_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`prescription_outgoing_drug_id`),
  KEY `fk_Prescription` (`prescription_id`),
  KEY `fk_OutgoingDrug` (`outgoing_drug_id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescription_outgoing_drug`
--

LOCK TABLES `prescription_outgoing_drug` WRITE;
/*!40000 ALTER TABLE `prescription_outgoing_drug` DISABLE KEYS */;
INSERT INTO `prescription_outgoing_drug` VALUES (51,5,66,'2015-02-25 13:00:43',1),(52,6,66,'2015-02-25 13:00:43',1),(53,7,67,'2015-02-25 13:00:43',1),(54,5,68,'2015-02-25 13:02:05',1),(55,6,68,'2015-02-25 13:02:05',1),(56,7,69,'2015-02-25 13:02:05',1),(57,5,70,'2015-02-25 13:02:11',1),(58,6,70,'2015-02-25 13:02:11',1),(59,7,71,'2015-02-25 13:02:11',1),(60,5,72,'2015-02-25 13:10:55',1),(61,6,72,'2015-02-25 13:10:55',1),(62,7,73,'2015-02-25 13:10:55',1),(63,5,74,'2015-02-25 13:10:58',1),(64,6,74,'2015-02-25 13:10:58',1),(65,7,75,'2015-02-25 13:10:58',1),(66,5,76,'2015-02-25 13:10:59',1),(67,6,76,'2015-02-25 13:10:59',1),(68,7,77,'2015-02-25 13:10:59',1),(69,5,78,'2015-02-25 13:25:26',1),(70,6,78,'2015-02-25 13:25:26',1),(71,7,79,'2015-02-25 13:25:26',1),(72,5,80,'2015-02-25 13:43:24',1),(73,6,80,'2015-02-25 13:43:24',1),(74,7,81,'2015-02-25 13:43:24',1),(75,5,82,'2015-02-25 16:30:09',1),(76,6,82,'2015-02-25 16:30:09',1),(77,7,83,'2015-02-25 16:30:09',1),(78,5,84,'2015-02-25 17:40:21',1),(79,6,84,'2015-02-25 17:40:21',1),(80,7,85,'2015-02-25 17:40:21',1),(84,5,89,'2015-03-02 14:17:17',1),(85,6,89,'2015-03-02 14:17:17',1),(86,7,89,'2015-03-02 14:17:17',1),(87,8,89,'2015-03-02 14:17:17',1),(88,5,90,'2015-03-02 14:20:50',1),(89,6,90,'2015-03-02 14:20:50',1),(90,5,91,'2015-03-02 14:55:19',1),(91,6,91,'2015-03-02 14:55:19',1),(92,7,91,'2015-03-02 14:55:19',1),(93,5,92,'2015-03-02 15:00:13',1),(94,6,92,'2015-03-02 15:00:13',1),(95,5,93,'2015-03-02 15:12:13',1),(96,6,93,'2015-03-02 15:12:13',1),(97,5,94,'2015-03-02 15:26:54',1),(98,6,94,'2015-03-02 15:26:54',1),(99,5,95,'2015-03-02 16:23:16',1),(100,6,95,'2015-03-02 16:23:16',1),(101,5,96,'2015-03-02 16:24:51',1),(102,6,96,'2015-03-02 16:24:51',1),(103,5,97,'2015-03-02 16:30:07',1),(104,6,97,'2015-03-02 16:30:07',1),(105,5,98,'2015-03-02 16:30:50',1),(106,6,98,'2015-03-02 16:30:50',1),(107,5,99,'2015-03-02 16:31:45',1),(108,6,99,'2015-03-02 16:31:45',1),(109,5,100,'2015-03-02 16:33:45',1),(110,6,100,'2015-03-02 16:33:45',1),(111,5,101,'2015-03-02 16:41:03',1),(112,6,101,'2015-03-02 16:41:03',1),(113,5,102,'2015-03-02 16:42:40',1),(114,6,102,'2015-03-02 16:42:40',1),(115,7,102,'2015-03-02 16:42:40',1),(116,7,103,'2015-03-04 14:54:32',1),(117,6,104,'2015-03-04 15:07:00',1),(118,5,105,'2015-03-04 15:08:33',1),(119,6,105,'2015-03-04 15:08:33',1),(120,7,105,'2015-03-04 15:08:33',1),(121,8,105,'2015-03-04 15:08:33',1);
/*!40000 ALTER TABLE `prescription_outgoing_drug` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`profile_id`),
  KEY `fk_IdentificationUserId` (`userid`),
  KEY `fk_DepartmentProfile` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (7,1,'mbakwe','caleb','chukwuezugo',1,'room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu','room 012, computer building, obafemi awolowo university\r\n8, watch tower street, onipanu','+2348030420046','MALE',2,80,'2015-02-06','2015-02-06 12:10:49','2015-02-06 12:10:49',1),(9,2,'moses','adebayo','olajuwon',2,'23b ezeagu lane, ajegunle lagos','23b ezeagu lane, ajegunle lagos','+2348162886288','MALE',120,75,'1979-09-15','2015-02-10 12:27:27','2015-02-10 12:27:27',1),(10,3,'adewoye','abiodun','adeola',4,'23b ezeagu lane, ajegunle lagos','23b ezeagu lane, ajegunle lagos','+2348162886288','MALE',12,123,'2015-02-20','2015-02-19 16:47:22','2015-02-19 16:47:22',1);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radiology`
--

DROP TABLE IF EXISTS `radiology`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radiology` (
  `radiology_id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) NOT NULL,
  `lab_attendant_id` int(11) DEFAULT NULL,
  `ward_clinic_id` varchar(25) NOT NULL,
  `xray_case_id` int(11) NOT NULL,
  `xray_size_id` int(11) NOT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `consultant_in_charge` varchar(35) NOT NULL,
  `checked_by` varchar(35) NOT NULL,
  `radiographers_note` text NOT NULL,
  `radiologists_report` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `lmp` varchar(50) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`radiology_id`),
  KEY `fk_RadiologyDoctor` (`doctor_id`),
  KEY `fk_RadiologyTreatment` (`treatment_id`),
  KEY `fk_RadiologyStatus` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radiology`
--

LOCK TABLES `radiology` WRITE;
/*!40000 ALTER TABLE `radiology` DISABLE KEYS */;
INSERT INTO `radiology` VALUES (1,1,NULL,'',0,0,1,'','','','','2015-03-19 00:00:00','2015-03-19 00:00:00','',1,5),(2,1,NULL,'',0,0,2,'','','','','2015-04-08 20:08:12','2015-04-08 20:08:12','',1,5);
/*!40000 ALTER TABLE `radiology` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `radiology_request`
--

DROP TABLE IF EXISTS `radiology_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radiology_request` (
  `radiology_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `radiology_id` int(11) NOT NULL,
  `clinical_diagnosis_details` varchar(100) DEFAULT NULL,
  `previous_operation` varchar(25) NOT NULL,
  `any_known_allergies` varchar(25) NOT NULL,
  `previous_xray` tinyint(4) NOT NULL,
  `xray_number` varchar(7) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`radiology_request_id`),
  KEY `fk_ExaminationRequestedRadiologyId` (`radiology_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `radiology_request`
--

LOCK TABLES `radiology_request` WRITE;
/*!40000 ALTER TABLE `radiology_request` DISABLE KEYS */;
INSERT INTO `radiology_request` VALUES (1,1,NULL,'','none',0,'XR101','2015-03-19 00:00:00','2015-03-19 00:00:00',1),(2,2,'something','','',0,'','2015-04-08 20:08:12','2015-04-08 20:08:12',1);
/*!40000 ALTER TABLE `radiology_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roster`
--

DROP TABLE IF EXISTS `roster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `fk_ModifiedBy` (`modified_by`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=armscii8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roster`
--

LOCK TABLES `roster` WRITE;
/*!40000 ALTER TABLE `roster` DISABLE KEYS */;
INSERT INTO `roster` VALUES (74,2,2,2,8,'2015-02-09','2015-02-19 00:27:16','2015-02-20 16:22:42',1,0),(75,2,2,2,8,'2015-02-02','2015-02-19 00:28:24','2015-02-20 16:22:26',1,0),(76,1,2,1,8,'2015-02-03','2015-02-19 00:29:27','2015-02-20 16:22:32',1,0),(77,2,2,2,10,'2015-02-02','2015-02-19 01:44:19','2015-02-20 16:22:28',1,0),(78,2,1,2,9,'2015-02-09','2015-02-19 01:48:25','2015-02-20 16:22:46',1,0),(79,2,1,2,9,'2015-02-03','2015-02-19 01:48:48','2015-02-20 16:22:30',1,0),(80,1,1,1,8,'2015-02-19','2015-02-19 15:27:00','2015-02-20 16:23:01',1,0),(81,1,1,1,10,'2015-02-20','2015-02-19 15:27:03','2015-02-20 16:23:03',1,0),(82,1,1,1,9,'2015-02-21','2015-02-19 15:27:06','2015-02-20 16:23:06',1,0),(83,1,1,1,8,'2015-02-04','2015-02-19 15:42:25','2015-02-20 16:22:36',1,0),(84,1,1,1,9,'2015-03-02','2015-02-19 15:42:50','2015-02-20 16:23:22',1,0),(85,1,1,1,10,'2015-02-10','2015-02-19 15:44:45','2015-02-20 16:22:53',1,0),(86,1,1,1,10,'2015-03-03','2015-02-19 15:45:09','2015-02-20 16:23:29',1,0),(87,1,1,1,10,'2015-02-12','2015-02-19 15:45:36','2015-02-20 16:22:55',1,0),(88,1,1,1,10,'2015-02-05','2015-02-19 15:45:51','2015-02-20 16:22:38',1,0),(89,1,1,1,10,'2015-03-04','2015-02-19 15:46:35','2015-02-20 16:23:37',1,0),(90,3,1,4,10,'2015-02-02','2015-02-19 16:50:32','2015-02-20 16:22:25',1,0),(91,3,1,4,10,'2015-02-10','2015-02-19 16:50:35','2015-02-20 16:22:51',1,0),(92,3,1,4,10,'2015-02-19','2015-02-19 16:50:38','2015-02-20 16:22:59',1,0),(93,3,1,4,10,'2015-02-13','2015-02-19 16:50:41','2015-02-20 16:22:57',1,0),(94,2,1,2,9,'2015-02-04','2015-02-19 16:50:44','2015-02-20 16:22:34',1,0),(95,2,1,2,9,'2015-02-06','2015-02-19 16:50:47','2015-02-20 16:22:40',1,0),(96,2,1,2,9,'2015-02-27','2015-02-19 16:50:50','2015-02-20 16:23:09',1,0),(97,1,1,1,8,'2015-01-25','2015-02-20 16:17:19','2015-02-20 16:24:56',1,0),(98,1,1,1,8,'2015-01-25','2015-02-20 16:17:23','2015-02-20 16:17:23',NULL,1),(99,1,1,1,9,'2015-01-25','2015-02-20 16:17:32','2015-02-20 16:17:32',NULL,1),(100,1,1,1,10,'2015-01-25','2015-02-20 16:17:34','2015-02-20 16:17:34',NULL,1),(101,2,1,2,8,'2015-01-26','2015-02-20 16:17:42','2015-02-20 16:17:42',NULL,1),(102,2,1,2,8,'2015-01-26','2015-02-20 16:17:44','2015-02-20 16:25:00',1,0),(103,2,1,2,8,'2015-01-26','2015-02-20 16:17:46','2015-02-20 16:17:46',NULL,1),(104,2,1,2,8,'2015-01-26','2015-02-20 16:17:48','2015-02-20 16:17:48',NULL,1),(105,2,1,2,8,'2015-01-26','2015-02-20 16:17:50','2015-02-20 16:17:50',NULL,1),(106,2,1,2,9,'2015-01-26','2015-02-20 16:17:52','2015-02-20 16:17:52',NULL,1),(107,2,1,2,9,'2015-01-26','2015-02-20 16:17:54','2015-02-20 16:17:54',NULL,1),(108,2,1,2,10,'2015-01-26','2015-02-20 16:17:56','2015-02-20 16:24:58',1,0),(109,2,1,2,10,'2015-01-26','2015-02-20 16:18:05','2015-02-20 16:18:05',NULL,1),(110,2,1,2,10,'2015-01-26','2015-02-20 16:18:12','2015-02-20 16:18:12',NULL,1),(111,1,1,1,8,'2015-01-25','2015-02-20 16:19:11','2015-02-20 16:19:11',NULL,1),(112,1,1,1,9,'2015-01-25','2015-02-20 16:19:13','2015-02-20 16:19:13',NULL,1),(113,1,1,1,10,'2015-01-25','2015-02-20 16:19:15','2015-02-20 16:19:15',NULL,1),(114,1,1,1,10,'2015-01-26','2015-02-20 16:19:17','2015-02-20 16:19:17',NULL,1),(115,1,1,1,9,'2015-01-26','2015-02-20 16:19:19','2015-02-20 16:19:19',NULL,1),(116,1,1,1,8,'2015-01-26','2015-02-20 16:19:23','2015-02-20 16:19:23',NULL,1),(117,1,1,1,9,'2015-03-02','2015-02-20 16:20:45','2015-02-20 16:23:25',1,0),(118,1,1,1,10,'2015-03-03','2015-02-20 16:21:05','2015-02-20 16:23:32',1,0),(119,2,1,2,10,'2015-03-04','2015-02-20 16:21:10','2015-02-20 16:23:35',1,0),(120,3,1,4,8,'2015-03-01','2015-02-20 16:21:18','2015-02-20 16:23:15',1,0),(121,2,1,2,9,'2015-03-01','2015-02-20 16:21:21','2015-02-20 16:23:18',1,0),(122,2,1,2,10,'2015-03-01','2015-02-20 16:21:23','2015-02-20 16:23:20',1,0),(123,1,1,1,10,'2015-03-02','2015-02-20 16:21:56','2015-02-20 16:23:27',1,0),(124,1,1,1,8,'2015-02-01','2015-02-23 12:13:01','2015-02-23 12:13:01',NULL,1),(125,1,1,1,8,'2015-02-03','2015-02-23 12:13:06','2015-02-27 10:52:13',1,0),(126,2,1,2,8,'2015-02-17','2015-02-23 12:13:10','2015-02-23 12:13:10',NULL,1),(127,3,1,4,10,'2015-02-19','2015-02-23 12:13:21','2015-02-23 12:13:21',NULL,1),(128,1,1,1,8,'2015-02-03','2015-02-27 10:52:21','2015-02-27 10:52:21',NULL,1),(129,2,1,2,9,'2015-02-09','2015-03-03 11:50:46','2015-03-03 11:50:46',NULL,1);
/*!40000 ALTER TABLE `roster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_permission`
--

DROP TABLE IF EXISTS `staff_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_permission` (
  `staff_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_permission` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staff_permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_permission`
--

LOCK TABLES `staff_permission` WRITE;
/*!40000 ALTER TABLE `staff_permission` DISABLE KEYS */;
INSERT INTO `staff_permission` VALUES (1,'read_only','2015-01-26 12:44:17','2015-01-26 12:44:20',1),(2,'read_write','2015-01-26 12:46:14','2015-01-26 12:46:12',1);
/*!40000 ALTER TABLE `staff_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_role`
--

DROP TABLE IF EXISTS `staff_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_role` (
  `staff_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `staff_role` varchar(100) NOT NULL,
  `role_label` varchar(50) DEFAULT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`staff_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_role`
--

LOCK TABLES `staff_role` WRITE;
/*!40000 ALTER TABLE `staff_role` DISABLE KEYS */;
INSERT INTO `staff_role` VALUES (1,'2015-01-26 12:24:47','2015-01-26 12:24:54','administrator','adminisrator',1),(2,'0000-00-00 00:00:00','0000-00-00 00:00:00','doctor','doctor',1),(3,'2015-01-26 12:26:48','2015-01-26 12:26:52','pharmacist','pharmacist',1),(4,'2015-01-28 13:00:36','2015-01-28 13:00:42','medical_records','medical records',1),(5,'2015-01-28 13:01:20','2015-01-28 13:01:25','permission','permission_granter',1),(6,'2015-01-28 13:01:58','2015-01-28 13:02:01','urine','urine test conductor',1),(7,'2015-01-28 13:02:40','2015-01-28 13:02:43','visual','visual test conductor',1),(8,'2015-01-28 13:02:59','2015-01-28 13:03:03','xray ','xray test conductor',1),(9,'2015-01-28 13:03:32','2015-01-28 13:03:35','health_scheme','health scheme',1),(10,'2015-01-28 13:04:03','2015-01-28 13:04:06','parasitology','parasitology conductor',1),(11,'2015-01-28 13:04:24','2015-01-28 13:04:26','chemical_pathology','chemical pathology conductor',1),(12,'2015-01-28 13:05:02','2015-01-28 13:05:07','add_staff','staff adding officer',1),(13,'2015-01-28 13:05:30','2015-01-28 13:05:33','staff_reg','staff clearance',1),(14,'2015-01-28 13:05:51','2015-01-28 13:05:54','treatment_recrods','treatment history',1),(15,'2015-02-16 01:04:09','2015-02-16 00:00:00','roster','roster creator',1);
/*!40000 ALTER TABLE `staff_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(15) CHARACTER SET utf8 NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'active',1),(2,'inactive',1),(3,'unclear',1),(4,'cleared',1),(5,'pending',1),(6,'processing',1),(7,'completed',1),(8,'morning_duty',1),(9,'afternoon_duty',1),(10,'evening_duty',1);
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatment`
--

DROP TABLE IF EXISTS `treatment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatment`
--

LOCK TABLES `treatment` WRITE;
/*!40000 ALTER TABLE `treatment` DISABLE KEYS */;
INSERT INTO `treatment` VALUES (1,1,1,'','Head ache and body ache','Fever',NULL,'2015-02-20 00:00:00','2015-02-20 00:00:00',1),(2,1,2,'','','',NULL,'2015-04-08 00:00:00','2015-04-08 00:00:00',1),(3,1,4,'','','',NULL,'2015-04-08 00:00:00','2015-04-08 00:00:00',1);
/*!40000 ALTER TABLE `treatment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_ref`
--

DROP TABLE IF EXISTS `unit_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_ref` (
  `unit_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `unit` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`unit_ref_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_ref`
--

LOCK TABLES `unit_ref` WRITE;
/*!40000 ALTER TABLE `unit_ref` DISABLE KEYS */;
INSERT INTO `unit_ref` VALUES (1,'milligramme','2015-02-25 00:00:00',1),(2,'millilitre','2015-02-25 00:00:00',1);
/*!40000 ALTER TABLE `unit_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urinalysis`
--

DROP TABLE IF EXISTS `urinalysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urinalysis` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urinalysis`
--

LOCK TABLES `urinalysis` WRITE;
/*!40000 ALTER TABLE `urinalysis` DISABLE KEYS */;
INSERT INTO `urinalysis` VALUES (1,1,'greenish','neutral','too much','average','normal','very okay','2015-03-10 13:11:30','2015-04-17 11:33:36',1),(3,2,'greenish','neutral','too much','average','normal','okay','2015-03-13 08:58:33','2015-04-17 11:34:12',1);
/*!40000 ALTER TABLE `urinalysis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urinary`
--

DROP TABLE IF EXISTS `urinary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urinary` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urinary`
--

LOCK TABLES `urinary` WRITE;
/*!40000 ALTER TABLE `urinary` DISABLE KEYS */;
/*!40000 ALTER TABLE `urinary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urine`
--

DROP TABLE IF EXISTS `urine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urine` (
  `urine_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status_id` int(11) NOT NULL DEFAULT '5',
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urine_id`),
  KEY `fk_UrineStatusId` (`status_id`),
  KEY `fk_UrineTreatmentId` (`treatment_id`),
  KEY `fk_UrineDoctorId` (`doctor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urine`
--

LOCK TABLES `urine` WRITE;
/*!40000 ALTER TABLE `urine` DISABLE KEYS */;
INSERT INTO `urine` VALUES (1,1,2,'testing','general info',1,'Check this guy again oo                                                                                                                                                                                                ','M101','nice bacteria infection','2015-03-10 00:00:00','2015-04-17 11:33:36',6,1),(2,2,2,'testing','general info',0,'He is okay dude                                                                                ','M101','nice bacteria tinz','2015-03-13 00:00:00','2015-04-17 11:34:12',6,1),(3,2,0,'something','',0,'','','','2015-04-08 19:08:44','2015-04-08 19:08:44',5,1);
/*!40000 ALTER TABLE `urine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urine_sensitivity`
--

DROP TABLE IF EXISTS `urine_sensitivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urine_sensitivity` (
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urine_sensitivity`
--

LOCK TABLES `urine_sensitivity` WRITE;
/*!40000 ALTER TABLE `urine_sensitivity` DISABLE KEYS */;
INSERT INTO `urine_sensitivity` VALUES (12,1,1,1,'2015-03-13 08:32:26','2015-04-17 11:33:36',1),(13,1,2,1,'2015-03-13 08:32:26','2015-04-17 11:33:36',1),(14,1,5,0,'2015-03-13 08:32:26','2015-04-17 11:33:36',1),(15,2,1,1,'2015-03-13 08:58:33','2015-04-17 11:34:12',1),(16,2,2,1,'2015-03-13 08:58:33','2015-04-17 11:34:12',1),(17,2,5,1,'2015-03-13 08:58:33','2015-04-17 11:34:12',1),(18,1,3,1,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(19,1,4,0,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(20,1,6,0,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(21,1,7,1,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(22,1,8,1,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(23,1,9,1,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(24,1,10,0,'2015-04-17 11:30:17','2015-04-17 11:33:36',1),(25,2,10,0,'2015-04-17 11:34:12','2015-04-17 11:34:12',1);
/*!40000 ALTER TABLE `urine_sensitivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urine_sensitivity_ref`
--

DROP TABLE IF EXISTS `urine_sensitivity_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urine_sensitivity_ref` (
  `urine_sensitivity_ref_id` int(11) NOT NULL AUTO_INCREMENT,
  `antibiotics` varchar(35) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`urine_sensitivity_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `urine_sensitivity_ref`
--

LOCK TABLES `urine_sensitivity_ref` WRITE;
/*!40000 ALTER TABLE `urine_sensitivity_ref` DISABLE KEYS */;
/*!40000 ALTER TABLE `urine_sensitivity_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_auth`
--

LOCK TABLES `user_auth` WRITE;
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` VALUES (1,'PMS001','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-26 18:30:48','2015-02-13 15:25:18',1,1,1),(2,'PMS002','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-28 18:00:51','2015-02-06 12:05:46',1,1,1),(3,'PMS003','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2015-01-29 18:37:49','2015-02-19 16:45:59',1,1,1);
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visual_skills_profile`
--

DROP TABLE IF EXISTS `visual_skills_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visual_skills_profile` (
  `visual_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT '1',
  `treatment_id` int(11) unsigned NOT NULL,
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
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  `lab_attendant_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT '5',
  PRIMARY KEY (`visual_profile_id`),
  KEY `fk_VisualDoctor` (`doctor_id`),
  KEY `fk_VisualTreatment` (`treatment_id`),
  KEY `fk_VisualStatus` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visual_skills_profile`
--

LOCK TABLES `visual_skills_profile` WRITE;
/*!40000 ALTER TABLE `visual_skills_profile` DISABLE KEYS */;
INSERT INTO `visual_skills_profile` VALUES (1,1,1,'2','2','2','2','2','2','2','2','2','Very very good','Bad one gaan ni','Nice one','2015-03-10 00:00:00','2015-03-10 10:17:06',1,1,5),(2,0,2,'','','','','','','','','','','','','2015-04-08 19:09:13','2015-04-08 19:09:13',1,NULL,5),(3,0,2,'','','','','','','','','','','','','2015-04-08 19:09:18','2015-04-08 19:09:18',1,NULL,5),(4,1,2,'','','','','','','','','','','','','2015-04-08 20:07:28','2015-04-08 20:07:28',1,NULL,5);
/*!40000 ALTER TABLE `visual_skills_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vitals`
--

DROP TABLE IF EXISTS `vitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  KEY `added_by` (`added_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vitals`
--

LOCK TABLES `vitals` WRITE;
/*!40000 ALTER TABLE `vitals` DISABLE KEYS */;
/*!40000 ALTER TABLE `vitals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ward_ref`
--

DROP TABLE IF EXISTS `ward_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ward_ref` (
  `ward_ref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ward_ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ward_ref`
--

LOCK TABLES `ward_ref` WRITE;
/*!40000 ALTER TABLE `ward_ref` DISABLE KEYS */;
/*!40000 ALTER TABLE `ward_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xray_case`
--

DROP TABLE IF EXISTS `xray_case`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xray_case` (
  `xray_case_id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(25) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xray_case`
--

LOCK TABLES `xray_case` WRITE;
/*!40000 ALTER TABLE `xray_case` DISABLE KEYS */;
/*!40000 ALTER TABLE `xray_case` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xray_no`
--

DROP TABLE IF EXISTS `xray_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xray_no` (
  `xray_id` int(11) NOT NULL AUTO_INCREMENT,
  `radiology_id` int(11) NOT NULL,
  `xray_number` varchar(7) CHARACTER SET latin1 NOT NULL,
  `casual_no` varchar(25) CHARACTER SET latin1 NOT NULL,
  `gp_no` varchar(25) CHARACTER SET latin1 NOT NULL,
  `ante_natal_no` varchar(25) CHARACTER SET latin1 NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_id`),
  KEY `fk_XRayNoRadiologyId` (`radiology_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xray_no`
--

LOCK TABLES `xray_no` WRITE;
/*!40000 ALTER TABLE `xray_no` DISABLE KEYS */;
/*!40000 ALTER TABLE `xray_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `xray_size`
--

DROP TABLE IF EXISTS `xray_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `xray_size` (
  `xray_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `dimension` varchar(10) NOT NULL,
  `active_fg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`xray_size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `xray_size`
--

LOCK TABLES `xray_size` WRITE;
/*!40000 ALTER TABLE `xray_size` DISABLE KEYS */;
/*!40000 ALTER TABLE `xray_size` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-12 16:12:02
