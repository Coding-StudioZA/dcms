-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: windykacja_DB
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellphone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contractor_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Arek Inwestycje',NULL,NULL,NULL,NULL,'kddevtest@gmail.com',277),(2,'Mariusz Windykacja',NULL,NULL,NULL,NULL,NULL,278),(3,'Witek Akcesoria SportoweE',NULL,NULL,NULL,NULL,NULL,1876),(4,'KD developement',NULL,NULL,NULL,NULL,NULL,109),(5,'Jarek Spedycja',NULL,NULL,NULL,NULL,NULL,2938),(6,'Żelazo Twarde',NULL,NULL,NULL,NULL,NULL,299),(7,'Jeden Gryz',NULL,NULL,NULL,NULL,NULL,87),(8,'Torby Kasi',NULL,NULL,NULL,NULL,NULL,367),(9,'Marek Eksterminacja',NULL,NULL,NULL,NULL,NULL,287),(10,'Marek Eksterminacja',NULL,NULL,NULL,NULL,NULL,287);
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invocies_import`
--

DROP TABLE IF EXISTS `invocies_import`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invocies_import` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_time` datetime NOT NULL,
  `aging` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invocies_import`
--

LOCK TABLES `invocies_import` WRITE;
/*!40000 ALTER TABLE `invocies_import` DISABLE KEYS */;
INSERT INTO `invocies_import` VALUES (1,'2018-01-23 10:58:04','ce87b87bc39c25d0a1208b7576f92a9d.xls');
/*!40000 ALTER TABLE `invocies_import` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evidence_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `due_date` date NOT NULL,
  `amount` double NOT NULL,
  `state` smallint(6) NOT NULL DEFAULT '0',
  `contractor_number` int(11) NOT NULL,
  `notes` longtext COLLATE utf8_unicode_ci,
  `due_interval` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'FVSU 1982','0999/10/2017','2016-06-11',1324.23,0,277,NULL,591),(2,'FVSU 1983','0089/11/2016','2017-05-10',2345.39,0,278,NULL,258),(3,'FVSU 1984','0001/01/2017','2016-01-04',4352.12,0,1876,NULL,750),(4,'FVSU 1985','0012/12/2017','2017-02-10',12345.22,0,109,NULL,347),(5,'FVSU 1986','0013/03/2017','2017-03-11',1398.45,0,2938,NULL,318),(6,'FVSU 1987','0100/11/2017','2017-04-12',987.23,0,299,NULL,286),(7,'FVSU 1988','0101/01/2017','2017-08-13',675.23,0,87,NULL,163),(8,'FVSU 1989','0200/02/2017','2016-09-14',78675.23,0,367,NULL,496),(9,'FVSU 1990','0300/12/2016','2017-02-02',2345.12,0,287,NULL,355),(10,'FVSU 2000','0301/12/2016','2017-02-03',2879.12,0,287,NULL,354);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20180122204312'),('20180123073107');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-27  1:10:20
