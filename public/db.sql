-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: fbv
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.10.1

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,NULL,'2018-11-23 05:46:19','2018-11-23 07:09:48','SITE PREPARATION'),(2,NULL,'2018-11-23 05:52:47','2018-11-23 07:22:06','SITE PREPARATION-Pavement Demolition'),(3,NULL,'2018-11-23 05:53:20','2018-11-23 06:57:14','LEAK REPAIR'),(4,NULL,'2018-11-23 05:53:33','2018-11-23 06:57:05','TAPPING ASSEMBLY FOR NSC'),(5,NULL,'2018-11-23 05:53:47','2018-11-23 06:56:54','SERVICE TUBING'),(6,NULL,'2018-11-23 05:54:19','2018-11-23 06:56:45','METER SET ASSEMBLY'),(7,NULL,'2018-11-23 05:56:35','2018-11-23 06:56:34','SURFACE RESTORATION'),(8,NULL,'2018-11-23 05:56:43','2018-11-23 06:55:35','DISCONNECTION'),(9,NULL,'2018-11-23 05:56:56','2018-11-23 06:55:27','RECONNECTION'),(10,NULL,'2018-11-23 06:55:20','2018-11-23 06:55:20','METER CALIBRATION');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,NULL,'2018-11-23 07:26:37','2018-11-23 07:26:37','Subic'),(2,NULL,'2018-11-23 07:26:43','2018-11-26 14:33:44','Pangasinan - San Carlos / Lingayen'),(3,NULL,'2018-11-26 14:33:59','2018-11-26 14:33:59','Bulacan - Marilao'),(4,NULL,'2018-11-26 14:34:15','2018-11-26 14:34:15','Bulacan - Meycauayan'),(5,NULL,'2018-11-26 14:34:26','2018-11-26 14:34:26','Bulacan - Malolos');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `backup_size` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `backups_name_unique` (`name`),
  UNIQUE KEY `backups_file_name_unique` (`file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backups`
--

LOCK TABLES `backups` WRITE;
/*!40000 ALTER TABLE `backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tags` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '[]',
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Administration','[]','#000',NULL,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(2,'Billing','[]','#ff0000',NULL,'2018-12-03 06:56:15','2018-12-03 06:56:53');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `designation` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Male',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mobile2` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dept` int(10) unsigned NOT NULL DEFAULT '1',
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_birth` date NOT NULL DEFAULT '1990-01-01',
  `date_hire` date NOT NULL,
  `date_left` date NOT NULL DEFAULT '1990-01-01',
  `salary_cur` decimal(15,3) NOT NULL DEFAULT '0.000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employees_email_unique` (`email`),
  KEY `employees_dept_foreign` (`dept`),
  CONSTRAINT `employees_dept_foreign` FOREIGN KEY (`dept`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'Jake Ortega','Super Admin','Male','8888888888','','admin@fbv.com',1,'Pune','Karve nagar, Pune 411030','About user / biography','2018-11-18','2018-11-18','2018-11-18',0.000,NULL,'2018-11-18 07:30:56','2018-11-18 07:30:56'),(2,'Juan Dela Cruz','CEO','Male','09750828323','','ceo@fbv.com.ph',1,'','','','1990-01-01','1970-01-01','1990-01-01',0.000,NULL,'2018-11-18 08:39:19','2018-11-18 08:39:19'),(3,'encoder','Job Order Encoder','Male','09750828323','','a@a.com',2,'Ph','PH','Ph','1990-01-01','1970-01-01','1990-01-01',11983.000,NULL,'2018-12-03 08:14:53','2018-12-03 08:14:53');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_details`
--

DROP TABLE IF EXISTS `item_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  `area_id` int(10) unsigned NOT NULL DEFAULT '1',
  `activity_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `item_details_area_id_foreign` (`area_id`),
  KEY `item_details_activity_id_foreign` (`activity_id`),
  CONSTRAINT `item_details_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `item_details_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_details`
--

LOCK TABLES `item_details` WRITE;
/*!40000 ALTER TABLE `item_details` DISABLE KEYS */;
INSERT INTO `item_details` VALUES (1,NULL,'2018-11-23 07:27:43','2018-11-23 07:27:43','Pavement Cutting',100,1,1),(2,NULL,'2018-11-23 07:28:26','2018-11-23 07:28:26','Thickness ≤ 75mm - Asphalt Pavement',100,1,2),(3,NULL,'2018-11-23 07:28:54','2018-11-23 07:28:54','75mm to 150mm - Asphalt Pavement',100,1,2),(4,NULL,'2018-11-23 07:29:26','2018-11-23 07:29:26','150mm and above - Asphalt Pavement',100,1,2),(5,NULL,'2018-11-23 07:30:12','2018-11-23 07:30:12','Thickness ≤ 75mm - Concrete Pavement',200,1,2),(6,NULL,'2018-11-23 07:30:47','2018-11-23 07:30:47','75mm to 150mm - Concrete Pavement',1000,1,2),(7,NULL,'2018-11-23 07:31:09','2018-11-23 07:31:09','150mm and above - Concrete Pavement',100,1,2),(8,NULL,'2018-11-28 10:40:30','2018-11-28 10:44:41','Depth ≤ 1.20m - Excavation',100,1,2),(9,NULL,'2018-11-28 10:43:03','2018-11-28 10:43:03','1.2m < Depth < 2.0m - Excavation',100,1,2),(10,NULL,'2018-11-28 10:45:45','2018-11-28 10:45:45','2.0m < Depth < 2.5m - Excavation',100,1,2),(11,NULL,'2018-11-28 10:46:23','2018-12-14 06:32:37','2.5m < Depth < 3.0m - Excavation',100,1,2),(12,NULL,'2018-11-28 10:48:35','2018-11-28 10:48:35','12 in Ø - Mainline',100,1,3),(13,NULL,'2018-11-28 10:48:56','2018-11-28 10:50:23','10 in Ø - Mainline',100,1,3),(14,NULL,'2018-11-28 10:49:32','2018-11-28 10:50:08','8 in Ø - Mainline',100,1,3),(15,NULL,'2018-11-28 10:49:53','2018-11-28 10:49:53','6 in Ø - Mainline',100,1,3),(16,NULL,'2018-11-28 10:51:01','2018-11-28 10:51:01','4 in Ø - Mainline',100,1,3),(17,NULL,'2018-11-28 10:51:23','2018-11-28 10:51:23','3 in Ø - Mainline',100,1,3),(18,NULL,'2018-11-28 10:51:39','2018-11-28 10:51:39','2 in Ø - Mainline',100,1,3),(19,NULL,'2018-11-28 10:52:23','2018-11-28 10:52:23','½ in Ø - Tubing',100,1,3),(20,NULL,'2018-11-28 10:52:44','2018-11-28 10:52:44','¾ in Ø - Tubing',100,1,3),(21,NULL,'2018-11-28 10:53:28','2018-11-28 10:53:28','1 in Ø - Tubing',100,1,3),(22,NULL,'2018-11-28 10:53:48','2018-11-28 10:53:48','1 ½ in Ø - Tubing',100,1,3),(23,NULL,'2018-11-28 10:56:27','2018-11-28 10:56:27','12 in Ø - 20mm Ø (½ in Ø)',100,1,4),(24,NULL,'2018-11-28 10:59:23','2018-11-28 10:59:23','10 in Ø - 20mm Ø (½ in Ø)',100,1,4),(25,NULL,'2018-11-28 11:00:03','2018-11-28 11:00:03','8 in Ø - 20mm Ø (½ in Ø)',100,1,4),(26,NULL,'2018-11-28 11:00:51','2018-11-28 11:00:51','6 in Ø - 20mm Ø (½ in Ø)',100,1,4),(27,NULL,'2018-11-28 11:11:33','2018-11-28 11:11:33','4 in Ø - 20mm Ø (½ in Ø)',100,1,4),(28,NULL,'2018-11-28 11:12:13','2018-11-28 11:12:13','3 in Ø - 20mm Ø (½ in Ø)',100,1,4),(29,NULL,'2018-11-28 11:14:23','2018-11-28 11:14:23','2 in Ø - 20mm Ø (½ in Ø)',100,1,4),(30,NULL,'2018-11-28 11:15:21','2018-11-28 11:15:21','12 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(31,NULL,'2018-11-28 11:17:13','2018-11-28 11:17:13','10 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(32,NULL,'2018-11-28 11:26:22','2018-11-28 11:26:22','8 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(33,NULL,'2018-11-28 11:27:21','2018-11-28 11:27:21','6 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(34,NULL,'2018-11-28 11:28:38','2018-11-28 11:28:38','4 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(35,NULL,'2018-11-28 11:29:04','2018-11-28 11:29:04','3 in Ø - 25mm Ø (¾ in Ø) ',100,1,4),(36,NULL,'2018-11-28 11:29:35','2018-11-28 11:29:35','2 in Ø - 25mm Ø (¾ in Ø)',100,1,4),(37,NULL,'2018-11-28 11:31:17','2018-11-28 11:31:17','12 in Ø - 32mm Ø (1 in Ø)',100,1,4),(38,NULL,'2018-11-28 11:32:56','2018-11-28 11:32:56','10 in Ø - 32mm Ø (1 in Ø)',100,1,4),(39,NULL,'2018-11-28 11:33:41','2018-11-28 11:33:41','8 in Ø - 32mm Ø (1 in Ø)',100,1,4),(40,NULL,'2018-11-28 11:35:03','2018-11-28 11:35:03','6 in Ø - 32mm Ø (1 in Ø) ',100,1,4),(41,NULL,'2018-11-28 11:37:21','2018-11-28 11:37:21','4 in Ø - 32mm Ø (1 in Ø)',100,1,4),(42,NULL,'2018-11-28 11:37:58','2018-11-28 11:37:58','3 in Ø - 32mm Ø (1 in Ø)',100,1,4),(43,NULL,'2018-11-28 11:38:30','2018-11-28 11:38:30','2 in Ø - 32mm Ø (1 in Ø)',100,1,4),(44,NULL,'2018-11-28 11:44:54','2018-11-28 13:10:58','(½ in Ø) - Service Tubing (On a Trench)',100,1,5),(45,NULL,'2018-11-28 11:45:29','2018-11-28 13:10:47','(¾ in Ø) - Service Tubing (On a Trench)',100,1,5),(46,NULL,'2018-11-28 11:46:00','2018-11-28 13:10:31','(1 in Ø) - Service Tubing (On a Trench)',100,1,5),(47,NULL,'2018-11-28 11:46:55','2018-11-28 13:10:21','(½ in Ø) - Additional Tubing on a Trench',100,1,5),(48,NULL,'2018-11-28 11:47:58','2018-11-28 13:10:00','(¾ in Ø) - Additional Tubing on a Trench',100,1,5),(49,NULL,'2018-11-28 11:48:27','2018-11-28 13:09:51','(1 in Ø) - Additional Tubing on a Trench',100,1,5),(50,NULL,'2018-11-28 11:50:29','2018-11-28 13:09:42','(½ in Ø) GI PIPE - Exposed Service Tubing',100,1,5),(51,NULL,'2018-11-28 11:52:57','2018-11-28 13:09:30','(¾ in Ø) GI PIPE - Exposed Service Tubing',100,1,5),(52,NULL,'2018-11-28 11:53:46','2018-11-28 13:09:17','(1 in Ø) GI PIPE - Exposed Service Tubing',100,1,5),(53,NULL,'2018-11-28 11:55:33','2018-11-28 13:09:08','(½ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,1,5),(54,NULL,'2018-11-28 11:56:13','2018-11-28 13:08:59','(¾ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,1,5),(55,NULL,'2018-11-28 11:56:46','2018-11-28 13:08:47','(1 in Ø) GSP Casing - GSP Casing for Canal Crossing',100,1,5),(56,NULL,'2018-11-28 13:20:45','2018-11-28 13:20:45','(½ in Ø) - Installation of Meter Set Assembly',100,1,6),(57,NULL,'2018-11-28 13:21:40','2018-11-28 13:21:40','(¾ in Ø) - Installation of Meter Set Assembly',100,1,6),(58,NULL,'2018-11-28 13:22:16','2018-11-28 13:22:16','(1 in Ø) - Installation of Meter Set Assembly',100,1,6),(59,NULL,'2018-11-28 13:23:43','2018-11-28 13:23:43','(½ in Ø) - Replacement of Existing Meter Set Assembly ',100,1,6),(60,NULL,'2018-11-28 13:24:10','2018-11-28 13:24:10','(¾ in Ø) - Replacement of Existing Meter Set Assembly',100,1,6),(61,NULL,'2018-11-28 13:25:20','2018-11-28 13:25:20','(1 in Ø) - Replacement of Existing Meter Set Assembly',100,1,6),(62,NULL,'2018-11-28 13:28:10','2018-11-28 13:28:10','(½ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,1,6),(63,NULL,'2018-11-28 13:28:47','2018-11-28 13:28:47','(¾ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,1,6),(64,NULL,'2018-11-28 13:29:34','2018-11-28 13:29:34','(1 in Ø) - Relocate and Reinstall of Meter Set Assembly',100,1,6),(65,NULL,'2018-11-28 14:00:15','2018-11-28 14:00:15','(½ in Ø) - Replacement of Appurtenance',100,1,6),(66,NULL,'2018-11-28 14:00:44','2018-11-28 14:00:44','(¾ in Ø) - Replacement of Appurtenance',100,1,6),(67,NULL,'2018-11-28 14:01:08','2018-11-28 14:01:08','(1 in Ø) - Replacement of Appurtenance',100,1,6),(68,NULL,'2018-11-28 14:02:21','2018-11-28 14:02:21','(½ in Ø) - Replacement of Water Meter',100,1,6),(69,NULL,'2018-11-28 14:02:57','2018-11-28 14:02:57','(¾ in Ø) - Replacement of Water Meter',100,1,6),(70,NULL,'2018-11-28 14:03:21','2018-11-28 14:03:21','(1 in Ø) - Replacement of Water Meter',100,1,6),(71,NULL,'2018-11-28 14:04:16','2018-11-28 14:04:16','(½ in Ø) - Replacement of Corporation Stop',100,1,6),(72,NULL,'2018-11-28 14:04:38','2018-11-28 14:04:38','(¾ in Ø) - Replacement of Corporation Stop',100,1,6),(73,NULL,'2018-11-28 14:04:59','2018-11-28 14:04:59','(1 in Ø) - Replacement of Corporation Stop',100,1,6),(74,NULL,'2018-11-28 14:06:22','2018-11-28 14:06:22','Sub-base Coarse - Backfill and Compaction ',100,1,7),(75,NULL,'2018-11-28 14:06:44','2018-11-28 14:06:44','Base Coarse - Backfill and Compaction',100,1,7),(76,NULL,'2018-11-28 14:07:10','2018-11-28 14:07:10','Sub-base Coarse - Sand Bedding ',100,1,7),(77,NULL,'2018-11-28 14:22:45','2018-11-28 14:22:45','Base Coarse - Sand Bedding ',100,1,7),(78,NULL,'2018-11-28 14:23:10','2018-11-28 14:23:10','Sub-base Coarse - Pavement Restoration ',100,1,7),(79,NULL,'2018-11-28 14:23:45','2018-11-28 14:23:45','Base Coarse - Pavement Restoration',100,1,7),(80,NULL,'2018-11-28 14:24:39','2018-11-28 14:24:39','24 Mpa @ 3 Days - Concrete Restoration',100,1,7),(81,NULL,'2018-11-28 14:25:25','2018-11-28 14:25:25','24 Mpa @ 7 Days - Concrete Restoration',100,1,7),(82,NULL,'2018-11-28 14:25:41','2018-11-28 14:25:41','24 Mpa @ 14 Days - Concrete Restoration',100,1,7),(83,NULL,'2018-11-28 14:26:00','2018-11-28 14:26:00','21 Mpa @ 28 Days - Concrete Restoration',100,1,7),(84,NULL,'2018-11-28 14:26:30','2018-11-28 14:26:30','Hot Mix - Asphalt Restoration',99,1,7),(85,NULL,'2018-11-28 14:26:43','2018-11-28 14:26:43','Cold Mix - Asphalt Restoration',100,1,7),(86,NULL,'2018-11-28 14:30:10','2018-11-28 14:30:10','Concrete Meter Base',100,1,7),(87,NULL,'2018-11-30 07:34:33','2018-11-30 07:34:33','Padlock',100,1,8),(88,NULL,'2018-11-30 07:34:54','2018-11-30 07:34:54','Plugging',100,1,8),(89,NULL,'2018-11-30 07:35:08','2018-11-30 07:35:08','Meter Pull-Out',100,1,8),(90,NULL,'2018-11-30 07:35:25','2018-11-30 07:35:25','Padlock',100,1,9),(91,NULL,'2018-11-23 07:27:43','2018-11-23 07:27:43','Pavement Cutting',100,2,1),(92,NULL,'2018-11-23 07:28:26','2018-12-15 06:10:00','Thickness ≤ 75mm - Asphalt Pavement',200,2,2),(93,NULL,'2018-11-23 07:28:54','2018-11-23 07:28:54','75mm to 150mm - Asphalt Pavement',100,2,2),(94,NULL,'2018-11-23 07:29:26','2018-11-23 07:29:26','150mm and above - Asphalt Pavement',100,2,2),(95,NULL,'2018-11-23 07:30:12','2018-11-23 07:30:12','Thickness ≤ 75mm - Concrete Pavement',200,2,2),(96,NULL,'2018-11-23 07:30:47','2018-11-23 07:30:47','75mm to 150mm - Concrete Pavement',1000,2,2),(97,NULL,'2018-11-23 07:31:09','2018-11-23 07:31:09','150mm and above - Concrete Pavement',100,2,2),(98,NULL,'2018-11-28 10:40:30','2018-11-28 10:44:41','Depth ≤ 1.20m - Excavation',100,2,2),(99,NULL,'2018-11-28 10:43:03','2018-11-28 10:43:03','1.2m < Depth < 2.0m - Excavation',100,2,2),(100,NULL,'2018-11-28 10:45:45','2018-11-28 10:45:45','2.0m < Depth < 2.5m - Excavation',100,2,2),(101,NULL,'2018-11-28 10:46:23','2018-11-28 10:46:23','2.5m < Depth < 3.0m - Excavation ',100,2,2),(102,NULL,'2018-11-28 10:48:35','2018-11-28 10:48:35','12 in Ø - Mainline',100,2,3),(103,NULL,'2018-11-28 10:48:56','2018-11-28 10:50:23','10 in Ø - Mainline',100,2,3),(104,NULL,'2018-11-28 10:49:32','2018-11-28 10:50:08','8 in Ø - Mainline',100,2,3),(105,NULL,'2018-11-28 10:49:53','2018-11-28 10:49:53','6 in Ø - Mainline',100,2,3),(106,NULL,'2018-11-28 10:51:01','2018-11-28 10:51:01','4 in Ø - Mainline',100,2,3),(107,NULL,'2018-11-28 10:51:23','2018-11-28 10:51:23','3 in Ø - Mainline',100,2,3),(108,NULL,'2018-11-28 10:51:39','2018-11-28 10:51:39','2 in Ø - Mainline',100,2,3),(109,NULL,'2018-11-28 10:52:23','2018-11-28 10:52:23','½ in Ø - Tubing',100,2,3),(110,NULL,'2018-11-28 10:52:44','2018-11-28 10:52:44','¾ in Ø - Tubing',100,2,3),(111,NULL,'2018-11-28 10:53:28','2018-11-28 10:53:28','1 in Ø - Tubing',100,2,3),(112,NULL,'2018-11-28 10:53:48','2018-11-28 10:53:48','1 ½ in Ø - Tubing',100,2,3),(113,NULL,'2018-11-28 10:56:27','2018-11-28 10:56:27','12 in Ø - 20mm Ø (½ in Ø)',100,2,4),(114,NULL,'2018-11-28 10:59:23','2018-11-28 10:59:23','10 in Ø - 20mm Ø (½ in Ø)',100,2,4),(115,NULL,'2018-11-28 11:00:03','2018-11-28 11:00:03','8 in Ø - 20mm Ø (½ in Ø)',100,2,4),(116,NULL,'2018-11-28 11:00:51','2018-11-28 11:00:51','6 in Ø - 20mm Ø (½ in Ø)',100,2,4),(117,NULL,'2018-11-28 11:11:33','2018-11-28 11:11:33','4 in Ø - 20mm Ø (½ in Ø)',100,2,4),(118,NULL,'2018-11-28 11:12:13','2018-11-28 11:12:13','3 in Ø - 20mm Ø (½ in Ø)',100,2,4),(119,NULL,'2018-11-28 11:14:23','2018-11-28 11:14:23','2 in Ø - 20mm Ø (½ in Ø)',100,2,4),(120,NULL,'2018-11-28 11:15:21','2018-11-28 11:15:21','12 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(121,NULL,'2018-11-28 11:17:13','2018-11-28 11:17:13','10 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(122,NULL,'2018-11-28 11:26:22','2018-11-28 11:26:22','8 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(123,NULL,'2018-11-28 11:27:21','2018-11-28 11:27:21','6 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(124,NULL,'2018-11-28 11:28:38','2018-11-28 11:28:38','4 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(125,NULL,'2018-11-28 11:29:04','2018-11-28 11:29:04','3 in Ø - 25mm Ø (¾ in Ø) ',100,2,4),(126,NULL,'2018-11-28 11:29:35','2018-11-28 11:29:35','2 in Ø - 25mm Ø (¾ in Ø)',100,2,4),(127,NULL,'2018-11-28 11:31:17','2018-11-28 11:31:17','12 in Ø - 32mm Ø (1 in Ø)',100,2,4),(128,NULL,'2018-11-28 11:32:56','2018-11-28 11:32:56','10 in Ø - 32mm Ø (1 in Ø)',100,2,4),(129,NULL,'2018-11-28 11:33:41','2018-11-28 11:33:41','8 in Ø - 32mm Ø (1 in Ø)',100,2,4),(130,NULL,'2018-11-28 11:35:03','2018-11-28 11:35:03','6 in Ø - 32mm Ø (1 in Ø) ',100,2,4),(131,NULL,'2018-11-28 11:37:21','2018-11-28 11:37:21','4 in Ø - 32mm Ø (1 in Ø)',100,2,4),(132,NULL,'2018-11-28 11:37:58','2018-11-28 11:37:58','3 in Ø - 32mm Ø (1 in Ø)',100,2,4),(133,NULL,'2018-11-28 11:38:30','2018-11-28 11:38:30','2 in Ø - 32mm Ø (1 in Ø)',100,2,4),(134,NULL,'2018-11-28 11:44:54','2018-11-28 13:10:58','(½ in Ø) - Service Tubing (On a Trench)',100,2,5),(135,NULL,'2018-11-28 11:45:29','2018-11-28 13:10:47','(¾ in Ø) - Service Tubing (On a Trench)',100,2,5),(136,NULL,'2018-11-28 11:46:00','2018-11-28 13:10:31','(1 in Ø) - Service Tubing (On a Trench)',100,2,5),(137,NULL,'2018-11-28 11:46:55','2018-11-28 13:10:21','(½ in Ø) - Additional Tubing on a Trench',100,2,5),(138,NULL,'2018-11-28 11:47:58','2018-11-28 13:10:00','(¾ in Ø) - Additional Tubing on a Trench',100,2,5),(139,NULL,'2018-11-28 11:48:27','2018-11-28 13:09:51','(1 in Ø) - Additional Tubing on a Trench',100,2,5),(140,NULL,'2018-11-28 11:50:29','2018-11-28 13:09:42','(½ in Ø) GI PIPE - Exposed Service Tubing',100,2,5),(141,NULL,'2018-11-28 11:52:57','2018-11-28 13:09:30','(¾ in Ø) GI PIPE - Exposed Service Tubing',100,2,5),(142,NULL,'2018-11-28 11:53:46','2018-11-28 13:09:17','(1 in Ø) GI PIPE - Exposed Service Tubing',100,2,5),(143,NULL,'2018-11-28 11:55:33','2018-11-28 13:09:08','(½ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,2,5),(144,NULL,'2018-11-28 11:56:13','2018-11-28 13:08:59','(¾ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,2,5),(145,NULL,'2018-11-28 11:56:46','2018-11-28 13:08:47','(1 in Ø) GSP Casing - GSP Casing for Canal Crossing',100,2,5),(146,NULL,'2018-11-28 13:20:45','2018-11-28 13:20:45','(½ in Ø) - Installation of Meter Set Assembly',100,2,6),(147,NULL,'2018-11-28 13:21:40','2018-11-28 13:21:40','(¾ in Ø) - Installation of Meter Set Assembly',100,2,6),(148,NULL,'2018-11-28 13:22:16','2018-11-28 13:22:16','(1 in Ø) - Installation of Meter Set Assembly',100,2,6),(149,NULL,'2018-11-28 13:23:43','2018-11-28 13:23:43','(½ in Ø) - Replacement of Existing Meter Set Assembly ',100,2,6),(150,NULL,'2018-11-28 13:24:10','2018-11-28 13:24:10','(¾ in Ø) - Replacement of Existing Meter Set Assembly',100,2,6),(151,NULL,'2018-11-28 13:25:20','2018-11-28 13:25:20','(1 in Ø) - Replacement of Existing Meter Set Assembly',100,2,6),(152,NULL,'2018-11-28 13:28:10','2018-11-28 13:28:10','(½ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,2,6),(153,NULL,'2018-11-28 13:28:47','2018-11-28 13:28:47','(¾ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,2,6),(154,NULL,'2018-11-28 13:29:34','2018-11-28 13:29:34','(1 in Ø) - Relocate and Reinstall of Meter Set Assembly',100,2,6),(155,NULL,'2018-11-28 14:00:15','2018-11-28 14:00:15','(½ in Ø) - Replacement of Appurtenance',100,2,6),(156,NULL,'2018-11-28 14:00:44','2018-11-28 14:00:44','(¾ in Ø) - Replacement of Appurtenance',100,2,6),(157,NULL,'2018-11-28 14:01:08','2018-11-28 14:01:08','(1 in Ø) - Replacement of Appurtenance',100,2,6),(158,NULL,'2018-11-28 14:02:21','2018-11-28 14:02:21','(½ in Ø) - Replacement of Water Meter',100,2,6),(159,NULL,'2018-11-28 14:02:57','2018-11-28 14:02:57','(¾ in Ø) - Replacement of Water Meter',100,2,6),(160,NULL,'2018-11-28 14:03:21','2018-11-28 14:03:21','(1 in Ø) - Replacement of Water Meter',100,2,6),(161,NULL,'2018-11-28 14:04:16','2018-11-28 14:04:16','(½ in Ø) - Replacement of Corporation Stop',100,2,6),(162,NULL,'2018-11-28 14:04:38','2018-11-28 14:04:38','(¾ in Ø) - Replacement of Corporation Stop',100,2,6),(163,NULL,'2018-11-28 14:04:59','2018-11-28 14:04:59','(1 in Ø) - Replacement of Corporation Stop',100,2,6),(164,NULL,'2018-11-28 14:06:22','2018-11-28 14:06:22','Sub-base Coarse - Backfill and Compaction ',100,2,7),(165,NULL,'2018-11-28 14:06:44','2018-11-28 14:06:44','Base Coarse - Backfill and Compaction',100,2,7),(166,NULL,'2018-11-28 14:07:10','2018-11-28 14:07:10','Sub-base Coarse - Sand Bedding ',100,2,7),(167,NULL,'2018-11-28 14:22:45','2018-11-28 14:22:45','Base Coarse - Sand Bedding ',100,2,7),(168,NULL,'2018-11-28 14:23:10','2018-11-28 14:23:10','Sub-base Coarse - Pavement Restoration ',100,2,7),(169,NULL,'2018-11-28 14:23:45','2018-11-28 14:23:45','Base Coarse - Pavement Restoration',100,2,7),(170,NULL,'2018-11-28 14:24:39','2018-11-28 14:24:39','24 Mpa @ 3 Days - Concrete Restoration',100,2,7),(171,NULL,'2018-11-28 14:25:25','2018-11-28 14:25:25','24 Mpa @ 7 Days - Concrete Restoration',100,2,7),(172,NULL,'2018-11-28 14:25:41','2018-11-28 14:25:41','24 Mpa @ 14 Days - Concrete Restoration',100,2,7),(173,NULL,'2018-11-28 14:26:00','2018-11-28 14:26:00','21 Mpa @ 28 Days - Concrete Restoration',100,2,7),(174,NULL,'2018-11-28 14:26:30','2018-11-28 14:26:30','Hot Mix - Asphalt Restoration',99,2,7),(175,NULL,'2018-11-28 14:26:43','2018-11-28 14:26:43','Cold Mix - Asphalt Restoration',100,2,7),(176,NULL,'2018-11-28 14:30:10','2018-11-28 14:30:10','Concrete Meter Base',100,2,7),(177,NULL,'2018-11-30 07:34:33','2018-11-30 07:34:33','Padlock',100,2,8),(178,NULL,'2018-11-30 07:34:54','2018-11-30 07:34:54','Plugging',100,2,8),(179,NULL,'2018-11-30 07:35:08','2018-11-30 07:35:08','Meter Pull-Out',100,2,8),(180,NULL,'2018-11-30 07:35:25','2018-11-30 07:35:25','Padlock',100,2,9),(181,NULL,'2018-11-23 07:27:43','2018-11-23 07:27:43','Pavement Cutting',100,3,1),(182,NULL,'2018-11-23 07:28:26','2018-11-23 07:28:26','Thickness ≤ 75mm - Asphalt Pavement',100,3,2),(183,NULL,'2018-11-23 07:28:54','2018-11-23 07:28:54','75mm to 150mm - Asphalt Pavement',100,3,2),(184,NULL,'2018-11-23 07:29:26','2018-11-23 07:29:26','150mm and above - Asphalt Pavement',100,3,2),(185,NULL,'2018-11-23 07:30:12','2018-11-23 07:30:12','Thickness ≤ 75mm - Concrete Pavement',200,3,2),(186,NULL,'2018-11-23 07:30:47','2018-11-23 07:30:47','75mm to 150mm - Concrete Pavement',1000,3,2),(187,NULL,'2018-11-23 07:31:09','2018-11-23 07:31:09','150mm and above - Concrete Pavement',100,3,2),(188,NULL,'2018-11-28 10:40:30','2018-11-28 10:44:41','Depth ≤ 1.20m - Excavation',100,3,2),(189,NULL,'2018-11-28 10:43:03','2018-11-28 10:43:03','1.2m < Depth < 2.0m - Excavation',100,3,2),(190,NULL,'2018-11-28 10:45:45','2018-11-28 10:45:45','2.0m < Depth < 2.5m - Excavation',100,3,2),(191,NULL,'2018-11-28 10:46:23','2018-11-28 10:46:23','2.5m < Depth < 3.0m - Excavation ',100,3,2),(192,NULL,'2018-11-28 10:48:35','2018-11-28 10:48:35','12 in Ø - Mainline',100,3,3),(193,NULL,'2018-11-28 10:48:56','2018-11-28 10:50:23','10 in Ø - Mainline',100,3,3),(194,NULL,'2018-11-28 10:49:32','2018-11-28 10:50:08','8 in Ø - Mainline',100,3,3),(195,NULL,'2018-11-28 10:49:53','2018-11-28 10:49:53','6 in Ø - Mainline',100,3,3),(196,NULL,'2018-11-28 10:51:01','2018-11-28 10:51:01','4 in Ø - Mainline',100,3,3),(197,NULL,'2018-11-28 10:51:23','2018-11-28 10:51:23','3 in Ø - Mainline',100,3,3),(198,NULL,'2018-11-28 10:51:39','2018-11-28 10:51:39','2 in Ø - Mainline',100,3,3),(199,NULL,'2018-11-28 10:52:23','2018-11-28 10:52:23','½ in Ø - Tubing',100,3,3),(200,NULL,'2018-11-28 10:52:44','2018-11-28 10:52:44','¾ in Ø - Tubing',100,3,3),(201,NULL,'2018-11-28 10:53:28','2018-11-28 10:53:28','1 in Ø - Tubing',100,3,3),(202,NULL,'2018-11-28 10:53:48','2018-11-28 10:53:48','1 ½ in Ø - Tubing',100,3,3),(203,NULL,'2018-11-28 10:56:27','2018-11-28 10:56:27','12 in Ø - 20mm Ø (½ in Ø)',100,3,4),(204,NULL,'2018-11-28 10:59:23','2018-11-28 10:59:23','10 in Ø - 20mm Ø (½ in Ø)',100,3,4),(205,NULL,'2018-11-28 11:00:03','2018-11-28 11:00:03','8 in Ø - 20mm Ø (½ in Ø)',100,3,4),(206,NULL,'2018-11-28 11:00:51','2018-11-28 11:00:51','6 in Ø - 20mm Ø (½ in Ø)',100,3,4),(207,NULL,'2018-11-28 11:11:33','2018-11-28 11:11:33','4 in Ø - 20mm Ø (½ in Ø)',100,3,4),(208,NULL,'2018-11-28 11:12:13','2018-11-28 11:12:13','3 in Ø - 20mm Ø (½ in Ø)',100,3,4),(209,NULL,'2018-11-28 11:14:23','2018-11-28 11:14:23','2 in Ø - 20mm Ø (½ in Ø)',100,3,4),(210,NULL,'2018-11-28 11:15:21','2018-11-28 11:15:21','12 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(211,NULL,'2018-11-28 11:17:13','2018-11-28 11:17:13','10 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(212,NULL,'2018-11-28 11:26:22','2018-11-28 11:26:22','8 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(213,NULL,'2018-11-28 11:27:21','2018-11-28 11:27:21','6 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(214,NULL,'2018-11-28 11:28:38','2018-11-28 11:28:38','4 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(215,NULL,'2018-11-28 11:29:04','2018-11-28 11:29:04','3 in Ø - 25mm Ø (¾ in Ø) ',100,3,4),(216,NULL,'2018-11-28 11:29:35','2018-11-28 11:29:35','2 in Ø - 25mm Ø (¾ in Ø)',100,3,4),(217,NULL,'2018-11-28 11:31:17','2018-11-28 11:31:17','12 in Ø - 32mm Ø (1 in Ø)',100,3,4),(218,NULL,'2018-11-28 11:32:56','2018-11-28 11:32:56','10 in Ø - 32mm Ø (1 in Ø)',100,3,4),(219,NULL,'2018-11-28 11:33:41','2018-11-28 11:33:41','8 in Ø - 32mm Ø (1 in Ø)',100,3,4),(220,NULL,'2018-11-28 11:35:03','2018-11-28 11:35:03','6 in Ø - 32mm Ø (1 in Ø) ',100,3,4),(221,NULL,'2018-11-28 11:37:21','2018-11-28 11:37:21','4 in Ø - 32mm Ø (1 in Ø)',100,3,4),(222,NULL,'2018-11-28 11:37:58','2018-11-28 11:37:58','3 in Ø - 32mm Ø (1 in Ø)',100,3,4),(223,NULL,'2018-11-28 11:38:30','2018-11-28 11:38:30','2 in Ø - 32mm Ø (1 in Ø)',100,3,4),(224,NULL,'2018-11-28 11:44:54','2018-11-28 13:10:58','(½ in Ø) - Service Tubing (On a Trench)',100,3,5),(225,NULL,'2018-11-28 11:45:29','2018-11-28 13:10:47','(¾ in Ø) - Service Tubing (On a Trench)',100,3,5),(226,NULL,'2018-11-28 11:46:00','2018-11-28 13:10:31','(1 in Ø) - Service Tubing (On a Trench)',100,3,5),(227,NULL,'2018-11-28 11:46:55','2018-11-28 13:10:21','(½ in Ø) - Additional Tubing on a Trench',100,3,5),(228,NULL,'2018-11-28 11:47:58','2018-11-28 13:10:00','(¾ in Ø) - Additional Tubing on a Trench',100,3,5),(229,NULL,'2018-11-28 11:48:27','2018-11-28 13:09:51','(1 in Ø) - Additional Tubing on a Trench',100,3,5),(230,NULL,'2018-11-28 11:50:29','2018-11-28 13:09:42','(½ in Ø) GI PIPE - Exposed Service Tubing',100,3,5),(231,NULL,'2018-11-28 11:52:57','2018-11-28 13:09:30','(¾ in Ø) GI PIPE - Exposed Service Tubing',100,3,5),(232,NULL,'2018-11-28 11:53:46','2018-11-28 13:09:17','(1 in Ø) GI PIPE - Exposed Service Tubing',100,3,5),(233,NULL,'2018-11-28 11:55:33','2018-11-28 13:09:08','(½ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,3,5),(234,NULL,'2018-11-28 11:56:13','2018-11-28 13:08:59','(¾ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,3,5),(235,NULL,'2018-11-28 11:56:46','2018-11-28 13:08:47','(1 in Ø) GSP Casing - GSP Casing for Canal Crossing',100,3,5),(236,NULL,'2018-11-28 13:20:45','2018-11-28 13:20:45','(½ in Ø) - Installation of Meter Set Assembly',100,3,6),(237,NULL,'2018-11-28 13:21:40','2018-11-28 13:21:40','(¾ in Ø) - Installation of Meter Set Assembly',100,3,6),(238,NULL,'2018-11-28 13:22:16','2018-11-28 13:22:16','(1 in Ø) - Installation of Meter Set Assembly',100,3,6),(239,NULL,'2018-11-28 13:23:43','2018-11-28 13:23:43','(½ in Ø) - Replacement of Existing Meter Set Assembly ',100,3,6),(240,NULL,'2018-11-28 13:24:10','2018-11-28 13:24:10','(¾ in Ø) - Replacement of Existing Meter Set Assembly',100,3,6),(241,NULL,'2018-11-28 13:25:20','2018-11-28 13:25:20','(1 in Ø) - Replacement of Existing Meter Set Assembly',100,3,6),(242,NULL,'2018-11-28 13:28:10','2018-11-28 13:28:10','(½ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,3,6),(243,NULL,'2018-11-28 13:28:47','2018-11-28 13:28:47','(¾ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,3,6),(244,NULL,'2018-11-28 13:29:34','2018-11-28 13:29:34','(1 in Ø) - Relocate and Reinstall of Meter Set Assembly',100,3,6),(245,NULL,'2018-11-28 14:00:15','2018-11-28 14:00:15','(½ in Ø) - Replacement of Appurtenance',100,3,6),(246,NULL,'2018-11-28 14:00:44','2018-11-28 14:00:44','(¾ in Ø) - Replacement of Appurtenance',100,3,6),(247,NULL,'2018-11-28 14:01:08','2018-11-28 14:01:08','(1 in Ø) - Replacement of Appurtenance',100,3,6),(248,NULL,'2018-11-28 14:02:21','2018-11-28 14:02:21','(½ in Ø) - Replacement of Water Meter',100,3,6),(249,NULL,'2018-11-28 14:02:57','2018-11-28 14:02:57','(¾ in Ø) - Replacement of Water Meter',100,3,6),(250,NULL,'2018-11-28 14:03:21','2018-11-28 14:03:21','(1 in Ø) - Replacement of Water Meter',100,3,6),(251,NULL,'2018-11-28 14:04:16','2018-11-28 14:04:16','(½ in Ø) - Replacement of Corporation Stop',100,3,6),(252,NULL,'2018-11-28 14:04:38','2018-11-28 14:04:38','(¾ in Ø) - Replacement of Corporation Stop',100,3,6),(253,NULL,'2018-11-28 14:04:59','2018-11-28 14:04:59','(1 in Ø) - Replacement of Corporation Stop',100,3,6),(254,NULL,'2018-11-28 14:06:22','2018-11-28 14:06:22','Sub-base Coarse - Backfill and Compaction ',100,3,7),(255,NULL,'2018-11-28 14:06:44','2018-11-28 14:06:44','Base Coarse - Backfill and Compaction',100,3,7),(256,NULL,'2018-11-28 14:07:10','2018-11-28 14:07:10','Sub-base Coarse - Sand Bedding ',100,3,7),(257,NULL,'2018-11-28 14:22:45','2018-11-28 14:22:45','Base Coarse - Sand Bedding ',100,3,7),(258,NULL,'2018-11-28 14:23:10','2018-11-28 14:23:10','Sub-base Coarse - Pavement Restoration ',100,3,7),(259,NULL,'2018-11-28 14:23:45','2018-11-28 14:23:45','Base Coarse - Pavement Restoration',100,3,7),(260,NULL,'2018-11-28 14:24:39','2018-11-28 14:24:39','24 Mpa @ 3 Days - Concrete Restoration',100,3,7),(261,NULL,'2018-11-28 14:25:25','2018-11-28 14:25:25','24 Mpa @ 7 Days - Concrete Restoration',100,3,7),(262,NULL,'2018-11-28 14:25:41','2018-11-28 14:25:41','24 Mpa @ 14 Days - Concrete Restoration',100,3,7),(263,NULL,'2018-11-28 14:26:00','2018-11-28 14:26:00','21 Mpa @ 28 Days - Concrete Restoration',100,3,7),(264,NULL,'2018-11-28 14:26:30','2018-11-28 14:26:30','Hot Mix - Asphalt Restoration',99,3,7),(265,NULL,'2018-11-28 14:26:43','2018-11-28 14:26:43','Cold Mix - Asphalt Restoration',100,3,7),(266,NULL,'2018-11-28 14:30:10','2018-11-28 14:30:10','Concrete Meter Base',100,3,7),(267,NULL,'2018-11-30 07:34:33','2018-11-30 07:34:33','Padlock',100,3,8),(268,NULL,'2018-11-30 07:34:54','2018-11-30 07:34:54','Plugging',100,3,8),(269,NULL,'2018-11-30 07:35:08','2018-11-30 07:35:08','Meter Pull-Out',100,3,8),(270,NULL,'2018-11-30 07:35:25','2018-11-30 07:35:25','Padlock',100,3,9),(271,NULL,'2018-11-23 07:27:43','2018-11-23 07:27:43','Pavement Cutting',100,4,1),(272,NULL,'2018-11-23 07:28:26','2018-11-23 07:28:26','Thickness ≤ 75mm - Asphalt Pavement',100,4,2),(273,NULL,'2018-11-23 07:28:54','2018-11-23 07:28:54','75mm to 150mm - Asphalt Pavement',100,4,2),(274,NULL,'2018-11-23 07:29:26','2018-11-23 07:29:26','150mm and above - Asphalt Pavement',100,4,2),(275,NULL,'2018-11-23 07:30:12','2018-11-23 07:30:12','Thickness ≤ 75mm - Concrete Pavement',200,4,2),(276,NULL,'2018-11-23 07:30:47','2018-11-23 07:30:47','75mm to 150mm - Concrete Pavement',1000,4,2),(277,NULL,'2018-11-23 07:31:09','2018-11-23 07:31:09','150mm and above - Concrete Pavement',100,4,2),(278,NULL,'2018-11-28 10:40:30','2018-11-28 10:44:41','Depth ≤ 1.20m - Excavation',100,4,2),(279,NULL,'2018-11-28 10:43:03','2018-11-28 10:43:03','1.2m < Depth < 2.0m - Excavation',100,4,2),(280,NULL,'2018-11-28 10:45:45','2018-11-28 10:45:45','2.0m < Depth < 2.5m - Excavation',100,4,2),(281,NULL,'2018-11-28 10:46:23','2018-11-28 10:46:23','2.5m < Depth < 3.0m - Excavation ',100,4,2),(282,NULL,'2018-11-28 10:48:35','2018-11-28 10:48:35','12 in Ø - Mainline',100,4,3),(283,NULL,'2018-11-28 10:48:56','2018-11-28 10:50:23','10 in Ø - Mainline',100,4,3),(284,NULL,'2018-11-28 10:49:32','2018-11-28 10:50:08','8 in Ø - Mainline',100,4,3),(285,NULL,'2018-11-28 10:49:53','2018-11-28 10:49:53','6 in Ø - Mainline',100,4,3),(286,NULL,'2018-11-28 10:51:01','2018-11-28 10:51:01','4 in Ø - Mainline',100,4,3),(287,NULL,'2018-11-28 10:51:23','2018-11-28 10:51:23','3 in Ø - Mainline',100,4,3),(288,NULL,'2018-11-28 10:51:39','2018-11-28 10:51:39','2 in Ø - Mainline',100,4,3),(289,NULL,'2018-11-28 10:52:23','2018-11-28 10:52:23','½ in Ø - Tubing',100,4,3),(290,NULL,'2018-11-28 10:52:44','2018-11-28 10:52:44','¾ in Ø - Tubing',100,4,3),(291,NULL,'2018-11-28 10:53:28','2018-11-28 10:53:28','1 in Ø - Tubing',100,4,3),(292,NULL,'2018-11-28 10:53:48','2018-11-28 10:53:48','1 ½ in Ø - Tubing',100,4,3),(293,NULL,'2018-11-28 10:56:27','2018-11-28 10:56:27','12 in Ø - 20mm Ø (½ in Ø)',100,4,4),(294,NULL,'2018-11-28 10:59:23','2018-11-28 10:59:23','10 in Ø - 20mm Ø (½ in Ø)',100,4,4),(295,NULL,'2018-11-28 11:00:03','2018-11-28 11:00:03','8 in Ø - 20mm Ø (½ in Ø)',100,4,4),(296,NULL,'2018-11-28 11:00:51','2018-11-28 11:00:51','6 in Ø - 20mm Ø (½ in Ø)',100,4,4),(297,NULL,'2018-11-28 11:11:33','2018-11-28 11:11:33','4 in Ø - 20mm Ø (½ in Ø)',100,4,4),(298,NULL,'2018-11-28 11:12:13','2018-11-28 11:12:13','3 in Ø - 20mm Ø (½ in Ø)',100,4,4),(299,NULL,'2018-11-28 11:14:23','2018-11-28 11:14:23','2 in Ø - 20mm Ø (½ in Ø)',100,4,4),(300,NULL,'2018-11-28 11:15:21','2018-11-28 11:15:21','12 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(301,NULL,'2018-11-28 11:17:13','2018-11-28 11:17:13','10 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(302,NULL,'2018-11-28 11:26:22','2018-11-28 11:26:22','8 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(303,NULL,'2018-11-28 11:27:21','2018-11-28 11:27:21','6 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(304,NULL,'2018-11-28 11:28:38','2018-11-28 11:28:38','4 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(305,NULL,'2018-11-28 11:29:04','2018-11-28 11:29:04','3 in Ø - 25mm Ø (¾ in Ø) ',100,4,4),(306,NULL,'2018-11-28 11:29:35','2018-11-28 11:29:35','2 in Ø - 25mm Ø (¾ in Ø)',100,4,4),(307,NULL,'2018-11-28 11:31:17','2018-11-28 11:31:17','12 in Ø - 32mm Ø (1 in Ø)',100,4,4),(308,NULL,'2018-11-28 11:32:56','2018-11-28 11:32:56','10 in Ø - 32mm Ø (1 in Ø)',100,4,4),(309,NULL,'2018-11-28 11:33:41','2018-11-28 11:33:41','8 in Ø - 32mm Ø (1 in Ø)',100,4,4),(310,NULL,'2018-11-28 11:35:03','2018-11-28 11:35:03','6 in Ø - 32mm Ø (1 in Ø) ',100,4,4),(311,NULL,'2018-11-28 11:37:21','2018-11-28 11:37:21','4 in Ø - 32mm Ø (1 in Ø)',100,4,4),(312,NULL,'2018-11-28 11:37:58','2018-11-28 11:37:58','3 in Ø - 32mm Ø (1 in Ø)',100,4,4),(313,NULL,'2018-11-28 11:38:30','2018-11-28 11:38:30','2 in Ø - 32mm Ø (1 in Ø)',100,4,4),(314,NULL,'2018-11-28 11:44:54','2018-11-28 13:10:58','(½ in Ø) - Service Tubing (On a Trench)',100,4,5),(315,NULL,'2018-11-28 11:45:29','2018-11-28 13:10:47','(¾ in Ø) - Service Tubing (On a Trench)',100,4,5),(316,NULL,'2018-11-28 11:46:00','2018-11-28 13:10:31','(1 in Ø) - Service Tubing (On a Trench)',100,4,5),(317,NULL,'2018-11-28 11:46:55','2018-11-28 13:10:21','(½ in Ø) - Additional Tubing on a Trench',100,4,5),(318,NULL,'2018-11-28 11:47:58','2018-11-28 13:10:00','(¾ in Ø) - Additional Tubing on a Trench',100,4,5),(319,NULL,'2018-11-28 11:48:27','2018-11-28 13:09:51','(1 in Ø) - Additional Tubing on a Trench',100,4,5),(320,NULL,'2018-11-28 11:50:29','2018-11-28 13:09:42','(½ in Ø) GI PIPE - Exposed Service Tubing',100,4,5),(321,NULL,'2018-11-28 11:52:57','2018-11-28 13:09:30','(¾ in Ø) GI PIPE - Exposed Service Tubing',100,4,5),(322,NULL,'2018-11-28 11:53:46','2018-11-28 13:09:17','(1 in Ø) GI PIPE - Exposed Service Tubing',100,4,5),(323,NULL,'2018-11-28 11:55:33','2018-11-28 13:09:08','(½ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,4,5),(324,NULL,'2018-11-28 11:56:13','2018-11-28 13:08:59','(¾ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,4,5),(325,NULL,'2018-11-28 11:56:46','2018-11-28 13:08:47','(1 in Ø) GSP Casing - GSP Casing for Canal Crossing',100,4,5),(326,NULL,'2018-11-28 13:20:45','2018-11-28 13:20:45','(½ in Ø) - Installation of Meter Set Assembly',100,4,6),(327,NULL,'2018-11-28 13:21:40','2018-11-28 13:21:40','(¾ in Ø) - Installation of Meter Set Assembly',100,4,6),(328,NULL,'2018-11-28 13:22:16','2018-11-28 13:22:16','(1 in Ø) - Installation of Meter Set Assembly',100,4,6),(329,NULL,'2018-11-28 13:23:43','2018-11-28 13:23:43','(½ in Ø) - Replacement of Existing Meter Set Assembly ',100,4,6),(330,NULL,'2018-11-28 13:24:10','2018-11-28 13:24:10','(¾ in Ø) - Replacement of Existing Meter Set Assembly',100,4,6),(331,NULL,'2018-11-28 13:25:20','2018-11-28 13:25:20','(1 in Ø) - Replacement of Existing Meter Set Assembly',100,4,6),(332,NULL,'2018-11-28 13:28:10','2018-11-28 13:28:10','(½ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,4,6),(333,NULL,'2018-11-28 13:28:47','2018-11-28 13:28:47','(¾ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,4,6),(334,NULL,'2018-11-28 13:29:34','2018-11-28 13:29:34','(1 in Ø) - Relocate and Reinstall of Meter Set Assembly',100,4,6),(335,NULL,'2018-11-28 14:00:15','2018-11-28 14:00:15','(½ in Ø) - Replacement of Appurtenance',100,4,6),(336,NULL,'2018-11-28 14:00:44','2018-11-28 14:00:44','(¾ in Ø) - Replacement of Appurtenance',100,4,6),(337,NULL,'2018-11-28 14:01:08','2018-11-28 14:01:08','(1 in Ø) - Replacement of Appurtenance',100,4,6),(338,NULL,'2018-11-28 14:02:21','2018-11-28 14:02:21','(½ in Ø) - Replacement of Water Meter',100,4,6),(339,NULL,'2018-11-28 14:02:57','2018-11-28 14:02:57','(¾ in Ø) - Replacement of Water Meter',100,4,6),(340,NULL,'2018-11-28 14:03:21','2018-11-28 14:03:21','(1 in Ø) - Replacement of Water Meter',100,4,6),(341,NULL,'2018-11-28 14:04:16','2018-11-28 14:04:16','(½ in Ø) - Replacement of Corporation Stop',100,4,6),(342,NULL,'2018-11-28 14:04:38','2018-11-28 14:04:38','(¾ in Ø) - Replacement of Corporation Stop',100,4,6),(343,NULL,'2018-11-28 14:04:59','2018-11-28 14:04:59','(1 in Ø) - Replacement of Corporation Stop',100,4,6),(344,NULL,'2018-11-28 14:06:22','2018-11-28 14:06:22','Sub-base Coarse - Backfill and Compaction ',100,4,7),(345,NULL,'2018-11-28 14:06:44','2018-11-28 14:06:44','Base Coarse - Backfill and Compaction',100,4,7),(346,NULL,'2018-11-28 14:07:10','2018-11-28 14:07:10','Sub-base Coarse - Sand Bedding ',100,4,7),(347,NULL,'2018-11-28 14:22:45','2018-11-28 14:22:45','Base Coarse - Sand Bedding ',100,4,7),(348,NULL,'2018-11-28 14:23:10','2018-11-28 14:23:10','Sub-base Coarse - Pavement Restoration ',100,4,7),(349,NULL,'2018-11-28 14:23:45','2018-11-28 14:23:45','Base Coarse - Pavement Restoration',100,4,7),(350,NULL,'2018-11-28 14:24:39','2018-11-28 14:24:39','24 Mpa @ 3 Days - Concrete Restoration',100,4,7),(351,NULL,'2018-11-28 14:25:25','2018-11-28 14:25:25','24 Mpa @ 7 Days - Concrete Restoration',100,4,7),(352,NULL,'2018-11-28 14:25:41','2018-11-28 14:25:41','24 Mpa @ 14 Days - Concrete Restoration',100,4,7),(353,NULL,'2018-11-28 14:26:00','2018-11-28 14:26:00','21 Mpa @ 28 Days - Concrete Restoration',100,4,7),(354,NULL,'2018-11-28 14:26:30','2018-11-28 14:26:30','Hot Mix - Asphalt Restoration',99,4,7),(355,NULL,'2018-11-28 14:26:43','2018-11-28 14:26:43','Cold Mix - Asphalt Restoration',100,4,7),(356,NULL,'2018-11-28 14:30:10','2018-11-28 14:30:10','Concrete Meter Base',100,4,7),(357,NULL,'2018-11-30 07:34:33','2018-11-30 07:34:33','Padlock',100,4,8),(358,NULL,'2018-11-30 07:34:54','2018-11-30 07:34:54','Plugging',100,4,8),(359,NULL,'2018-11-30 07:35:08','2018-11-30 07:35:08','Meter Pull-Out',100,4,8),(360,NULL,'2018-11-30 07:35:25','2018-11-30 07:35:25','Padlock',100,4,9),(361,NULL,'2018-11-23 07:27:43','2018-11-23 07:27:43','Pavement Cutting',100,5,1),(362,NULL,'2018-11-23 07:28:26','2018-11-23 07:28:26','Thickness ≤ 75mm - Asphalt Pavement',100,5,2),(363,NULL,'2018-11-23 07:28:54','2018-11-23 07:28:54','75mm to 150mm - Asphalt Pavement',100,5,2),(364,NULL,'2018-11-23 07:29:26','2018-11-23 07:29:26','150mm and above - Asphalt Pavement',100,5,2),(365,NULL,'2018-11-23 07:30:12','2018-11-23 07:30:12','Thickness ≤ 75mm - Concrete Pavement',200,5,2),(366,NULL,'2018-11-23 07:30:47','2018-11-23 07:30:47','75mm to 150mm - Concrete Pavement',1000,5,2),(367,NULL,'2018-11-23 07:31:09','2018-11-23 07:31:09','150mm and above - Concrete Pavement',100,5,2),(368,NULL,'2018-11-28 10:40:30','2018-11-28 10:44:41','Depth ≤ 1.20m - Excavation',100,5,2),(369,NULL,'2018-11-28 10:43:03','2018-11-28 10:43:03','1.2m < Depth < 2.0m - Excavation',100,5,2),(370,NULL,'2018-11-28 10:45:45','2018-11-28 10:45:45','2.0m < Depth < 2.5m - Excavation',100,5,2),(371,NULL,'2018-11-28 10:46:23','2018-11-28 10:46:23','2.5m < Depth < 3.0m - Excavation ',100,5,2),(372,NULL,'2018-11-28 10:48:35','2018-11-28 10:48:35','12 in Ø - Mainline',100,5,3),(373,NULL,'2018-11-28 10:48:56','2018-11-28 10:50:23','10 in Ø - Mainline',100,5,3),(374,NULL,'2018-11-28 10:49:32','2018-11-28 10:50:08','8 in Ø - Mainline',100,5,3),(375,NULL,'2018-11-28 10:49:53','2018-11-28 10:49:53','6 in Ø - Mainline',100,5,3),(376,NULL,'2018-11-28 10:51:01','2018-11-28 10:51:01','4 in Ø - Mainline',100,5,3),(377,NULL,'2018-11-28 10:51:23','2018-11-28 10:51:23','3 in Ø - Mainline',100,5,3),(378,NULL,'2018-11-28 10:51:39','2018-11-28 10:51:39','2 in Ø - Mainline',100,5,3),(379,NULL,'2018-11-28 10:52:23','2018-11-28 10:52:23','½ in Ø - Tubing',100,5,3),(380,NULL,'2018-11-28 10:52:44','2018-11-28 10:52:44','¾ in Ø - Tubing',100,5,3),(381,NULL,'2018-11-28 10:53:28','2018-11-28 10:53:28','1 in Ø - Tubing',100,5,3),(382,NULL,'2018-11-28 10:53:48','2018-11-28 10:53:48','1 ½ in Ø - Tubing',100,5,3),(383,NULL,'2018-11-28 10:56:27','2018-11-28 10:56:27','12 in Ø - 20mm Ø (½ in Ø)',100,5,4),(384,NULL,'2018-11-28 10:59:23','2018-11-28 10:59:23','10 in Ø - 20mm Ø (½ in Ø)',100,5,4),(385,NULL,'2018-11-28 11:00:03','2018-11-28 11:00:03','8 in Ø - 20mm Ø (½ in Ø)',100,5,4),(386,NULL,'2018-11-28 11:00:51','2018-11-28 11:00:51','6 in Ø - 20mm Ø (½ in Ø)',100,5,4),(387,NULL,'2018-11-28 11:11:33','2018-11-28 11:11:33','4 in Ø - 20mm Ø (½ in Ø)',100,5,4),(388,NULL,'2018-11-28 11:12:13','2018-11-28 11:12:13','3 in Ø - 20mm Ø (½ in Ø)',100,5,4),(389,NULL,'2018-11-28 11:14:23','2018-11-28 11:14:23','2 in Ø - 20mm Ø (½ in Ø)',100,5,4),(390,NULL,'2018-11-28 11:15:21','2018-11-28 11:15:21','12 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(391,NULL,'2018-11-28 11:17:13','2018-11-28 11:17:13','10 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(392,NULL,'2018-11-28 11:26:22','2018-11-28 11:26:22','8 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(393,NULL,'2018-11-28 11:27:21','2018-11-28 11:27:21','6 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(394,NULL,'2018-11-28 11:28:38','2018-11-28 11:28:38','4 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(395,NULL,'2018-11-28 11:29:04','2018-11-28 11:29:04','3 in Ø - 25mm Ø (¾ in Ø) ',100,5,4),(396,NULL,'2018-11-28 11:29:35','2018-11-28 11:29:35','2 in Ø - 25mm Ø (¾ in Ø)',100,5,4),(397,NULL,'2018-11-28 11:31:17','2018-11-28 11:31:17','12 in Ø - 32mm Ø (1 in Ø)',100,5,4),(398,NULL,'2018-11-28 11:32:56','2018-11-28 11:32:56','10 in Ø - 32mm Ø (1 in Ø)',100,5,4),(399,NULL,'2018-11-28 11:33:41','2018-11-28 11:33:41','8 in Ø - 32mm Ø (1 in Ø)',100,5,4),(400,NULL,'2018-11-28 11:35:03','2018-11-28 11:35:03','6 in Ø - 32mm Ø (1 in Ø) ',100,5,4),(401,NULL,'2018-11-28 11:37:21','2018-11-28 11:37:21','4 in Ø - 32mm Ø (1 in Ø)',100,5,4),(402,NULL,'2018-11-28 11:37:58','2018-11-28 11:37:58','3 in Ø - 32mm Ø (1 in Ø)',100,5,4),(403,NULL,'2018-11-28 11:38:30','2018-11-28 11:38:30','2 in Ø - 32mm Ø (1 in Ø)',100,5,4),(404,NULL,'2018-11-28 11:44:54','2018-11-28 13:10:58','(½ in Ø) - Service Tubing (On a Trench)',100,5,5),(405,NULL,'2018-11-28 11:45:29','2018-11-28 13:10:47','(¾ in Ø) - Service Tubing (On a Trench)',100,5,5),(406,NULL,'2018-11-28 11:46:00','2018-11-28 13:10:31','(1 in Ø) - Service Tubing (On a Trench)',100,5,5),(407,NULL,'2018-11-28 11:46:55','2018-11-28 13:10:21','(½ in Ø) - Additional Tubing on a Trench',100,5,5),(408,NULL,'2018-11-28 11:47:58','2018-11-28 13:10:00','(¾ in Ø) - Additional Tubing on a Trench',100,5,5),(409,NULL,'2018-11-28 11:48:27','2018-11-28 13:09:51','(1 in Ø) - Additional Tubing on a Trench',100,5,5),(410,NULL,'2018-11-28 11:50:29','2018-11-28 13:09:42','(½ in Ø) GI PIPE - Exposed Service Tubing',100,5,5),(411,NULL,'2018-11-28 11:52:57','2018-11-28 13:09:30','(¾ in Ø) GI PIPE - Exposed Service Tubing',100,5,5),(412,NULL,'2018-11-28 11:53:46','2018-11-28 13:09:17','(1 in Ø) GI PIPE - Exposed Service Tubing',100,5,5),(413,NULL,'2018-11-28 11:55:33','2018-11-28 13:09:08','(½ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,5,5),(414,NULL,'2018-11-28 11:56:13','2018-11-28 13:08:59','(¾ in Ø) GSP Casing - GSP Casing for Canal Crossing',100,5,5),(415,NULL,'2018-11-28 11:56:46','2018-11-28 13:08:47','(1 in Ø) GSP Casing - GSP Casing for Canal Crossing',100,5,5),(416,NULL,'2018-11-28 13:20:45','2018-11-28 13:20:45','(½ in Ø) - Installation of Meter Set Assembly',100,5,6),(417,NULL,'2018-11-28 13:21:40','2018-11-28 13:21:40','(¾ in Ø) - Installation of Meter Set Assembly',100,5,6),(418,NULL,'2018-11-28 13:22:16','2018-11-28 13:22:16','(1 in Ø) - Installation of Meter Set Assembly',100,5,6),(419,NULL,'2018-11-28 13:23:43','2018-11-28 13:23:43','(½ in Ø) - Replacement of Existing Meter Set Assembly ',100,5,6),(420,NULL,'2018-11-28 13:24:10','2018-11-28 13:24:10','(¾ in Ø) - Replacement of Existing Meter Set Assembly',100,5,6),(421,NULL,'2018-11-28 13:25:20','2018-11-28 13:25:20','(1 in Ø) - Replacement of Existing Meter Set Assembly',100,5,6),(422,NULL,'2018-11-28 13:28:10','2018-11-28 13:28:10','(½ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,5,6),(423,NULL,'2018-11-28 13:28:47','2018-11-28 13:28:47','(¾ in Ø) - Relocate and Reinstall of Meter Set Assembly',100,5,6),(424,NULL,'2018-11-28 13:29:34','2018-11-28 13:29:34','(1 in Ø) - Relocate and Reinstall of Meter Set Assembly',100,5,6),(425,NULL,'2018-11-28 14:00:15','2018-11-28 14:00:15','(½ in Ø) - Replacement of Appurtenance',100,5,6),(426,NULL,'2018-11-28 14:00:44','2018-11-28 14:00:44','(¾ in Ø) - Replacement of Appurtenance',100,5,6),(427,NULL,'2018-11-28 14:01:08','2018-11-28 14:01:08','(1 in Ø) - Replacement of Appurtenance',100,5,6),(428,NULL,'2018-11-28 14:02:21','2018-11-28 14:02:21','(½ in Ø) - Replacement of Water Meter',100,5,6),(429,NULL,'2018-11-28 14:02:57','2018-11-28 14:02:57','(¾ in Ø) - Replacement of Water Meter',100,5,6),(430,NULL,'2018-11-28 14:03:21','2018-11-28 14:03:21','(1 in Ø) - Replacement of Water Meter',100,5,6),(431,NULL,'2018-11-28 14:04:16','2018-11-28 14:04:16','(½ in Ø) - Replacement of Corporation Stop',100,5,6),(432,NULL,'2018-11-28 14:04:38','2018-11-28 14:04:38','(¾ in Ø) - Replacement of Corporation Stop',100,5,6),(433,NULL,'2018-11-28 14:04:59','2018-11-28 14:04:59','(1 in Ø) - Replacement of Corporation Stop',100,5,6),(434,NULL,'2018-11-28 14:06:22','2018-11-28 14:06:22','Sub-base Coarse - Backfill and Compaction ',100,5,7),(435,NULL,'2018-11-28 14:06:44','2018-11-28 14:06:44','Base Coarse - Backfill and Compaction',100,5,7),(436,NULL,'2018-11-28 14:07:10','2018-11-28 14:07:10','Sub-base Coarse - Sand Bedding ',100,5,7),(437,NULL,'2018-11-28 14:22:45','2018-11-28 14:22:45','Base Coarse - Sand Bedding ',100,5,7),(438,NULL,'2018-11-28 14:23:10','2018-11-28 14:23:10','Sub-base Coarse - Pavement Restoration ',100,5,7),(439,NULL,'2018-11-28 14:23:45','2018-11-28 14:23:45','Base Coarse - Pavement Restoration',100,5,7),(440,NULL,'2018-11-28 14:24:39','2018-11-28 14:24:39','24 Mpa @ 3 Days - Concrete Restoration',100,5,7),(441,NULL,'2018-11-28 14:25:25','2018-11-28 14:25:25','24 Mpa @ 7 Days - Concrete Restoration',100,5,7),(442,NULL,'2018-11-28 14:25:41','2018-11-28 14:25:41','24 Mpa @ 14 Days - Concrete Restoration',100,5,7),(443,NULL,'2018-11-28 14:26:00','2018-11-28 14:26:00','21 Mpa @ 28 Days - Concrete Restoration',100,5,7),(444,NULL,'2018-11-28 14:26:30','2018-11-28 14:26:30','Hot Mix - Asphalt Restoration',99,5,7),(445,NULL,'2018-11-28 14:26:43','2018-11-28 14:26:43','Cold Mix - Asphalt Restoration',100,5,7),(446,NULL,'2018-11-28 14:30:10','2018-11-28 14:30:10','Concrete Meter Base',100,5,7),(447,NULL,'2018-11-30 07:34:33','2018-11-30 07:34:33','Padlock',100,5,8),(448,NULL,'2018-11-30 07:34:54','2018-11-30 07:34:54','Plugging',100,5,8),(449,NULL,'2018-11-30 07:35:08','2018-11-30 07:35:08','Meter Pull-Out',100,5,8),(450,NULL,'2018-11-30 07:35:25','2018-11-30 07:35:25','Padlock',100,5,9);
/*!40000 ALTER TABLE `item_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` int(10) unsigned NOT NULL DEFAULT '1',
  `activity_id` int(10) unsigned NOT NULL DEFAULT '1',
  `item_detail_id` int(10) unsigned NOT NULL DEFAULT '1',
  `measurement` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `unit_id` int(10) unsigned NOT NULL DEFAULT '1',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `subtotal` decimal(15,3) NOT NULL DEFAULT '0.000',
  `amount` double(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `items_order_id_foreign` (`order_id`),
  KEY `items_activity_id_foreign` (`activity_id`),
  KEY `items_item_detail_id_foreign` (`item_detail_id`),
  KEY `items_unit_id_foreign` (`unit_id`),
  CONSTRAINT `items_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`),
  CONSTRAINT `items_item_detail_id_foreign` FOREIGN KEY (`item_detail_id`) REFERENCES `item_details` (`id`),
  CONSTRAINT `items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `items_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,NULL,'2018-11-23 07:36:03','2018-12-14 00:06:56',1,1,1,'123',1,100,10000.000,100.00);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `la_configs`
--

DROP TABLE IF EXISTS `la_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `la_configs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `la_configs`
--

LOCK TABLES `la_configs` WRITE;
/*!40000 ALTER TABLE `la_configs` DISABLE KEYS */;
INSERT INTO `la_configs` VALUES (1,'sitename','','Foo Bar Var','2018-11-18 07:30:43','2018-12-14 00:04:50'),(2,'sitename_part1','','FBV','2018-11-18 07:30:43','2018-12-14 00:04:50'),(3,'sitename_part2','','Admin Panel','2018-11-18 07:30:43','2018-12-14 00:04:50'),(4,'sitename_short','','XX','2018-11-18 07:30:43','2018-12-14 00:04:50'),(5,'site_description','','FBV Admin Panel','2018-11-18 07:30:43','2018-12-14 00:04:50'),(6,'sidebar_search','','0','2018-11-18 07:30:43','2018-12-14 00:04:50'),(7,'show_messages','','0','2018-11-18 07:30:43','2018-12-14 00:04:50'),(8,'show_notifications','','0','2018-11-18 07:30:43','2018-12-14 00:04:50'),(9,'show_tasks','','0','2018-11-18 07:30:43','2018-12-14 00:04:50'),(10,'show_rightsidebar','','0','2018-11-18 07:30:43','2018-12-14 00:04:50'),(11,'skin','','skin-red','2018-11-18 07:30:43','2018-12-14 00:04:50'),(12,'layout','','fixed','2018-11-18 07:30:43','2018-12-14 00:04:50'),(13,'default_email','','admin@fbv.com.ph','2018-11-18 07:30:43','2018-12-14 00:04:50');
/*!40000 ALTER TABLE `la_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `la_menus`
--

DROP TABLE IF EXISTS `la_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `la_menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fa-cube',
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'module',
  `parent` int(10) unsigned NOT NULL DEFAULT '0',
  `hierarchy` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `la_menus`
--

LOCK TABLES `la_menus` WRITE;
/*!40000 ALTER TABLE `la_menus` DISABLE KEYS */;
INSERT INTO `la_menus` VALUES (1,'Team','#','fa-group','custom',0,6,'2018-11-18 07:30:43','2018-12-13 23:59:48'),(2,'Users','users','fa-group','module',1,1,'2018-11-18 07:30:43','2018-11-18 08:46:58'),(4,'Departments','departments','fa-tags','module',1,2,'2018-11-18 07:30:43','2018-11-18 08:46:58'),(5,'Employees','employees','fa-group','module',1,3,'2018-11-18 07:30:43','2018-11-18 08:46:58'),(6,'Roles','roles','fa-user-plus','module',1,4,'2018-11-18 07:30:43','2018-11-18 08:46:58'),(8,'Permissions','permissions','fa-magic','module',1,5,'2018-11-18 07:30:43','2018-11-18 08:46:58'),(9,'Areas','areas','fa fa-asterisk','module',0,1,'2018-11-18 07:57:50','2018-12-13 23:59:48'),(10,'Activities','activities','fa fa-asterisk','module',0,2,'2018-11-18 07:59:07','2018-12-13 23:59:48'),(11,'Units','units','fa fa-asterisk','module',0,3,'2018-11-18 08:00:07','2018-12-13 23:59:48'),(13,'Orders','orders','fa fa-cube','module',0,4,'2018-11-18 08:25:56','2018-12-13 23:59:48'),(14,'Item_Details','item_details','fa fa-cube','module',0,5,'2018-11-18 08:28:29','2018-12-13 23:59:48');
/*!40000 ALTER TABLE `la_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_05_26_050000_create_modules_table',1),('2014_05_26_055000_create_module_field_types_table',1),('2014_05_26_060000_create_module_fields_table',1),('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2014_12_01_000000_create_uploads_table',1),('2016_05_26_064006_create_departments_table',1),('2016_05_26_064007_create_employees_table',1),('2016_05_26_064446_create_roles_table',1),('2016_07_05_115343_create_role_user_table',1),('2016_07_06_140637_create_organizations_table',1),('2016_07_07_134058_create_backups_table',1),('2016_07_07_134058_create_menus_table',1),('2016_09_10_163337_create_permissions_table',1),('2016_09_10_163520_create_permission_role_table',1),('2016_09_22_105958_role_module_fields_table',1),('2016_09_22_110008_role_module_table',1),('2016_10_06_115413_create_la_configs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_field_types`
--

DROP TABLE IF EXISTS `module_field_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_field_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_field_types`
--

LOCK TABLES `module_field_types` WRITE;
/*!40000 ALTER TABLE `module_field_types` DISABLE KEYS */;
INSERT INTO `module_field_types` VALUES (1,'Address','2018-11-18 07:30:41','2018-11-18 07:30:41'),(2,'Checkbox','2018-11-18 07:30:41','2018-11-18 07:30:41'),(3,'Currency','2018-11-18 07:30:41','2018-11-18 07:30:41'),(4,'Date','2018-11-18 07:30:41','2018-11-18 07:30:41'),(5,'Datetime','2018-11-18 07:30:41','2018-11-18 07:30:41'),(6,'Decimal','2018-11-18 07:30:41','2018-11-18 07:30:41'),(7,'Dropdown','2018-11-18 07:30:41','2018-11-18 07:30:41'),(8,'Email','2018-11-18 07:30:41','2018-11-18 07:30:41'),(9,'File','2018-11-18 07:30:41','2018-11-18 07:30:41'),(10,'Float','2018-11-18 07:30:41','2018-11-18 07:30:41'),(11,'HTML','2018-11-18 07:30:41','2018-11-18 07:30:41'),(12,'Image','2018-11-18 07:30:41','2018-11-18 07:30:41'),(13,'Integer','2018-11-18 07:30:41','2018-11-18 07:30:41'),(14,'Mobile','2018-11-18 07:30:41','2018-11-18 07:30:41'),(15,'Multiselect','2018-11-18 07:30:41','2018-11-18 07:30:41'),(16,'Name','2018-11-18 07:30:41','2018-11-18 07:30:41'),(17,'Password','2018-11-18 07:30:41','2018-11-18 07:30:41'),(18,'Radio','2018-11-18 07:30:41','2018-11-18 07:30:41'),(19,'String','2018-11-18 07:30:41','2018-11-18 07:30:41'),(20,'Taginput','2018-11-18 07:30:41','2018-11-18 07:30:41'),(21,'Textarea','2018-11-18 07:30:41','2018-11-18 07:30:41'),(22,'TextField','2018-11-18 07:30:41','2018-11-18 07:30:41'),(23,'URL','2018-11-18 07:30:41','2018-11-18 07:30:41'),(24,'Files','2018-11-18 07:30:41','2018-11-18 07:30:41');
/*!40000 ALTER TABLE `module_field_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_fields`
--

DROP TABLE IF EXISTS `module_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `colname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `module` int(10) unsigned NOT NULL,
  `field_type` int(10) unsigned NOT NULL,
  `unique` tinyint(1) NOT NULL DEFAULT '0',
  `defaultvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `minlength` int(10) unsigned NOT NULL DEFAULT '0',
  `maxlength` int(10) unsigned NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `popup_vals` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_fields_module_foreign` (`module`),
  KEY `module_fields_field_type_foreign` (`field_type`),
  CONSTRAINT `module_fields_field_type_foreign` FOREIGN KEY (`field_type`) REFERENCES `module_field_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `module_fields_module_foreign` FOREIGN KEY (`module`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_fields`
--

LOCK TABLES `module_fields` WRITE;
/*!40000 ALTER TABLE `module_fields` DISABLE KEYS */;
INSERT INTO `module_fields` VALUES (1,'name','Name',1,16,0,'',5,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(2,'context_id','Context',1,13,0,'0',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(3,'email','Email',1,8,1,'',0,250,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(4,'password','Password',1,17,0,'',6,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(5,'type','User Type',1,7,0,'Employee',0,0,0,'[\"Employee\",\"Client\"]',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(6,'name','Name',2,16,0,'',5,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(7,'path','Path',2,19,0,'',0,250,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(8,'extension','Extension',2,19,0,'',0,20,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(9,'caption','Caption',2,19,0,'',0,250,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(10,'user_id','Owner',2,7,0,'1',0,0,0,'@users',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(11,'hash','Hash',2,19,0,'',0,250,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(12,'public','Is Public',2,2,0,'0',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(13,'name','Name',3,16,1,'',1,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(14,'tags','Tags',3,20,0,'[]',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(15,'color','Color',3,19,0,'',0,50,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(16,'name','Name',4,16,0,'',5,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(17,'designation','Designation',4,19,0,'',0,50,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(18,'gender','Gender',4,18,0,'Male',0,0,1,'[\"Male\",\"Female\"]',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(19,'mobile','Mobile',4,14,0,'',10,20,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(20,'mobile2','Alternative Mobile',4,14,0,'',10,20,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(21,'email','Email',4,8,1,'',5,250,1,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(22,'dept','Department',4,7,0,'0',0,0,1,'@departments',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(23,'city','City',4,19,0,'',0,50,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(24,'address','Address',4,1,0,'',0,1000,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(25,'about','About',4,19,0,'',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(26,'date_birth','Date of Birth',4,4,0,'1990-01-01',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(27,'date_hire','Hiring Date',4,4,0,'date(\'Y-m-d\')',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(28,'date_left','Resignation Date',4,4,0,'1990-01-01',0,0,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(29,'salary_cur','Current Salary',4,6,0,'0.0',0,2,0,'',0,'2018-11-18 07:30:41','2018-11-18 07:30:41'),(30,'name','Name',5,16,1,'',1,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(31,'display_name','Display Name',5,19,0,'',0,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(32,'description','Description',5,21,0,'',0,1000,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(33,'parent','Parent Role',5,7,0,'1',0,0,0,'@roles',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(34,'dept','Department',5,7,0,'1',0,0,0,'@departments',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(35,'name','Name',6,16,1,'',5,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(36,'email','Email',6,8,1,'',0,250,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(37,'phone','Phone',6,14,0,'',0,20,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(38,'website','Website',6,23,0,'http://',0,250,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(39,'assigned_to','Assigned to',6,7,0,'0',0,0,0,'@employees',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(40,'connect_since','Connected Since',6,4,0,'date(\'Y-m-d\')',0,0,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(41,'address','Address',6,1,0,'',0,1000,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(42,'city','City',6,19,0,'',0,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(43,'description','Description',6,21,0,'',0,1000,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(44,'profile_image','Profile Image',6,12,0,'',0,250,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(45,'profile','Company Profile',6,9,0,'',0,250,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(46,'name','Name',7,16,1,'',0,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(47,'file_name','File Name',7,19,1,'',0,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(48,'backup_size','File Size',7,19,0,'0',0,10,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(49,'name','Name',8,16,1,'',1,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(50,'display_name','Display Name',8,19,0,'',0,250,1,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(51,'description','Description',8,21,0,'',0,1000,0,'',0,'2018-11-18 07:30:42','2018-11-18 07:30:42'),(52,'name','Area',9,19,0,'',0,256,1,'',0,'2018-11-18 07:57:40','2018-11-18 07:57:40'),(53,'name','Activity',10,19,0,'',0,256,1,'',0,'2018-11-18 07:58:35','2018-11-18 07:58:35'),(55,'unit','Unit',11,19,0,'',0,256,1,'',0,'2018-11-18 07:59:40','2018-11-18 07:59:40'),(56,'description','Description',11,19,0,'',0,256,0,'',0,'2018-11-18 07:59:50','2018-11-18 07:59:50'),(60,'job_number','Job #',13,19,0,'',0,255,1,'',0,'2018-11-18 08:22:34','2018-11-18 08:23:38'),(61,'team_leader','Team Leader',13,19,0,'',0,256,1,'',0,'2018-11-18 08:22:56','2018-11-18 08:22:56'),(62,'area_id','Area',13,7,0,'',0,0,1,'@areas',0,'2018-11-18 08:24:38','2018-11-18 08:24:38'),(63,'area_id','Area',13,7,0,'',0,0,1,'@areas',0,'2018-11-18 08:24:38','2018-11-18 08:24:38'),(64,'date','Date',13,4,0,'',0,0,0,'',0,'2018-11-18 08:24:57','2018-11-18 08:24:57'),(65,'time_start','Time Start',13,5,0,'',0,0,0,'',0,'2018-11-18 08:25:13','2018-11-18 08:25:13'),(66,'time_finished','Time Finished',13,5,0,'',0,0,0,'',0,'2018-11-18 08:25:28','2018-11-18 08:25:28'),(67,'user_id','User',13,7,0,'',0,0,0,'@employees',0,'2018-11-18 08:25:49','2018-11-18 08:25:49'),(68,'name','Name',14,19,0,'',0,256,1,'',0,'2018-11-18 08:27:48','2018-11-18 08:27:48'),(69,'amount','Amount',14,13,0,'',0,11,1,'',0,'2018-11-18 08:27:59','2018-11-18 08:27:59'),(70,'area_id','Area',14,7,0,'',0,0,0,'@areas',0,'2018-11-18 08:28:12','2018-11-18 08:28:12'),(71,'order_id','Job #',15,7,0,'',0,0,1,'@orders',1,'2018-11-18 08:29:40','2018-11-18 08:29:40'),(72,'activity_id','Activity',15,7,0,'',0,0,1,'@activities',2,'2018-11-18 08:30:00','2018-11-18 08:30:00'),(73,'item_detail_id','Item Detail',15,7,0,'',0,0,1,'@item_details',3,'2018-11-18 08:30:28','2018-11-18 08:30:28'),(74,'measurement','Measurement',15,19,0,'',0,256,1,'',6,'2018-11-18 08:30:42','2018-11-18 08:30:42'),(75,'unit_id','Unit',15,7,0,'',0,0,1,'@units',7,'2018-11-18 08:30:59','2018-11-18 08:30:59'),(76,'activity_id','Activity',14,7,0,'',0,0,0,'@activities',0,'2018-11-23 07:25:54','2018-11-23 07:25:54'),(77,'total','Total',13,13,0,'00.00',0,11,1,'',0,'2018-11-30 15:18:46','2018-11-30 15:19:28'),(78,'quantity','Quantity',15,13,0,'0',0,11,0,'',5,'2018-12-03 07:28:49','2018-12-03 07:28:49'),(79,'subtotal','Subtotal',15,6,0,'0',0,11,0,'',8,'2018-12-03 08:11:31','2018-12-03 08:11:31'),(80,'amount','Amount',15,3,0,'0',0,11,1,'',4,'2018-12-13 23:58:45','2018-12-13 23:58:45');
/*!40000 ALTER TABLE `module_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name_db` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `view_col` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fa_icon` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fa-cube',
  `is_gen` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Users','Users','users','name','User','UsersController','fa-group',1,'2018-11-18 07:30:41','2018-11-18 07:30:43'),(2,'Uploads','Uploads','uploads','name','Upload','UploadsController','fa-files-o',1,'2018-11-18 07:30:41','2018-11-18 07:30:43'),(3,'Departments','Departments','departments','name','Department','DepartmentsController','fa-tags',1,'2018-11-18 07:30:41','2018-11-18 07:30:43'),(4,'Employees','Employees','employees','name','Employee','EmployeesController','fa-group',1,'2018-11-18 07:30:41','2018-11-18 07:30:43'),(5,'Roles','Roles','roles','name','Role','RolesController','fa-user-plus',1,'2018-11-18 07:30:42','2018-11-18 07:30:43'),(6,'Organizations','Organizations','organizations','name','Organization','OrganizationsController','fa-university',1,'2018-11-18 07:30:42','2018-11-18 07:30:43'),(7,'Backups','Backups','backups','name','Backup','BackupsController','fa-hdd-o',1,'2018-11-18 07:30:42','2018-11-18 07:30:43'),(8,'Permissions','Permissions','permissions','name','Permission','PermissionsController','fa-magic',1,'2018-11-18 07:30:42','2018-11-18 07:30:43'),(9,'Areas','Areas','areas','name','Area','AreasController','fa-asterisk',1,'2018-11-18 07:57:12','2018-11-18 07:57:50'),(10,'Activities','Activities','activities','name','Activity','ActivitiesController','fa-asterisk',1,'2018-11-18 07:58:15','2018-11-18 07:59:07'),(11,'Units','Units','units','unit','Unit','UnitsController','fa-asterisk',1,'2018-11-18 07:59:29','2018-11-18 08:00:07'),(13,'Orders','Orders','orders','job_number','Order','OrdersController','fa-cube',1,'2018-11-18 08:21:34','2018-11-18 08:25:56'),(14,'Item_Details','Item_Details','item_details','name','Item_Detail','Item_DetailsController','fa-cube',1,'2018-11-18 08:27:21','2018-11-18 08:28:29'),(15,'Items','Items','items','order_id','Item','ItemsController','fa-cube',1,'2018-11-18 08:28:53','2018-11-18 08:31:10');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `job_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `team_leader` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `area_id` int(10) unsigned NOT NULL DEFAULT '1',
  `date` date NOT NULL,
  `time_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_finished` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_job_number_unique` (`job_number`),
  KEY `orders_area_id_foreign` (`area_id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,'2018-11-23 07:32:27','2018-12-14 00:06:56','20','Juan Luna',1,'2018-11-23','2018-11-16 00:00:00','2018-11-16 00:00:00',1,10000),(2,NULL,'2018-12-14 06:20:05','2018-12-14 06:25:29','1234','asd',2,'2018-12-14','2018-12-15 00:00:00','2018-12-22 00:00:00',1,0),(3,NULL,'2018-12-15 05:26:40','2018-12-15 05:26:40','1230','I Don\'t Care',3,'2018-12-15','2018-12-22 00:00:00','2018-12-22 00:00:00',1,0);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://',
  `assigned_to` int(10) unsigned NOT NULL DEFAULT '1',
  `connect_since` date NOT NULL,
  `address` varchar(1000) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` int(11) NOT NULL,
  `profile` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_name_unique` (`name`),
  UNIQUE KEY `organizations_email_unique` (`email`),
  KEY `organizations_assigned_to_foreign` (`assigned_to`),
  CONSTRAINT `organizations_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `employees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `display_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'ADMIN_PANEL','Admin Panel','Admin Panel Permission',NULL,'2018-11-18 07:30:43','2018-11-18 07:30:43');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_module`
--

DROP TABLE IF EXISTS `role_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `acc_view` tinyint(1) NOT NULL,
  `acc_create` tinyint(1) NOT NULL,
  `acc_edit` tinyint(1) NOT NULL,
  `acc_delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_module_role_id_foreign` (`role_id`),
  KEY `role_module_module_id_foreign` (`module_id`),
  CONSTRAINT `role_module_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_module_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_module`
--

LOCK TABLES `role_module` WRITE;
/*!40000 ALTER TABLE `role_module` DISABLE KEYS */;
INSERT INTO `role_module` VALUES (1,1,1,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(2,1,2,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(3,1,3,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(4,1,4,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(5,1,5,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(6,1,6,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(7,1,7,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(8,1,8,1,1,1,1,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(9,1,9,1,1,1,1,'2018-11-18 07:57:50','2018-11-18 07:57:50'),(10,1,10,1,1,1,1,'2018-11-18 07:59:07','2018-11-18 07:59:07'),(11,1,11,1,1,1,1,'2018-11-18 08:00:07','2018-11-18 08:00:07'),(13,1,13,1,1,1,1,'2018-11-18 08:25:56','2018-11-18 08:25:56'),(14,1,14,1,1,1,1,'2018-11-18 08:28:29','2018-11-18 08:28:29'),(15,1,15,1,1,1,1,'2018-11-18 08:31:10','2018-11-18 08:31:10'),(16,2,1,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(17,2,2,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(18,2,3,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(19,2,4,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(20,2,5,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(21,2,6,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(22,2,7,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(23,2,8,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(24,2,9,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(25,2,10,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(26,2,11,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(27,2,13,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(28,2,14,1,0,0,0,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(29,2,15,1,1,1,1,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(44,3,1,1,0,0,0,'2018-12-04 14:15:59','2018-12-04 14:15:59'),(45,3,2,1,0,0,0,'2018-12-04 14:15:59','2018-12-04 14:15:59'),(46,3,3,1,0,0,0,'2018-12-04 14:15:59','2018-12-04 14:15:59'),(47,3,4,1,0,0,0,'2018-12-04 14:15:59','2018-12-04 14:15:59'),(48,3,5,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(49,3,6,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(50,3,7,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(51,3,8,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(52,3,9,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(53,3,10,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(54,3,11,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(55,3,13,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(56,3,14,1,0,0,0,'2018-12-04 14:16:00','2018-12-04 14:16:00'),(57,3,15,1,1,1,1,'2018-12-04 14:16:00','2018-12-04 14:16:00');
/*!40000 ALTER TABLE `role_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_module_fields`
--

DROP TABLE IF EXISTS `role_module_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_module_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `access` enum('invisible','readonly','write') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_module_fields_role_id_foreign` (`role_id`),
  KEY `role_module_fields_field_id_foreign` (`field_id`),
  CONSTRAINT `role_module_fields_field_id_foreign` FOREIGN KEY (`field_id`) REFERENCES `module_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_module_fields_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_module_fields`
--

LOCK TABLES `role_module_fields` WRITE;
/*!40000 ALTER TABLE `role_module_fields` DISABLE KEYS */;
INSERT INTO `role_module_fields` VALUES (1,1,1,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(2,1,2,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(3,1,3,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(4,1,4,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(5,1,5,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(6,1,6,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(7,1,7,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(8,1,8,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(9,1,9,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(10,1,10,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(11,1,11,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(12,1,12,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(13,1,13,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(14,1,14,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(15,1,15,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(16,1,16,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(17,1,17,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(18,1,18,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(19,1,19,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(20,1,20,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(21,1,21,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(22,1,22,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(23,1,23,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(24,1,24,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(25,1,25,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(26,1,26,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(27,1,27,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(28,1,28,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(29,1,29,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(30,1,30,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(31,1,31,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(32,1,32,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(33,1,33,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(34,1,34,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(35,1,35,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(36,1,36,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(37,1,37,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(38,1,38,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(39,1,39,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(40,1,40,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(41,1,41,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(42,1,42,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(43,1,43,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(44,1,44,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(45,1,45,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(46,1,46,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(47,1,47,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(48,1,48,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(49,1,49,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(50,1,50,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(51,1,51,'write','2018-11-18 07:30:43','2018-11-18 07:30:43'),(52,1,52,'write','2018-11-18 07:57:40','2018-11-18 07:57:40'),(53,1,53,'write','2018-11-18 07:58:35','2018-11-18 07:58:35'),(55,1,55,'write','2018-11-18 07:59:40','2018-11-18 07:59:40'),(56,1,56,'write','2018-11-18 07:59:50','2018-11-18 07:59:50'),(60,1,60,'write','2018-11-18 08:22:35','2018-11-18 08:22:35'),(61,1,61,'write','2018-11-18 08:22:56','2018-11-18 08:22:56'),(62,1,63,'write','2018-11-18 08:24:38','2018-11-18 08:24:38'),(63,1,64,'write','2018-11-18 08:24:57','2018-11-18 08:24:57'),(64,1,65,'write','2018-11-18 08:25:13','2018-11-18 08:25:13'),(65,1,66,'write','2018-11-18 08:25:28','2018-11-18 08:25:28'),(66,1,67,'write','2018-11-18 08:25:49','2018-11-18 08:25:49'),(67,1,68,'write','2018-11-18 08:27:48','2018-11-18 08:27:48'),(68,1,69,'write','2018-11-18 08:27:59','2018-11-18 08:27:59'),(69,1,70,'write','2018-11-18 08:28:12','2018-11-18 08:28:12'),(70,1,71,'write','2018-11-18 08:29:40','2018-11-18 08:29:40'),(71,1,72,'write','2018-11-18 08:30:00','2018-11-18 08:30:00'),(72,1,73,'write','2018-11-18 08:30:28','2018-11-18 08:30:28'),(73,1,74,'write','2018-11-18 08:30:42','2018-11-18 08:30:42'),(74,1,75,'write','2018-11-18 08:30:59','2018-11-18 08:30:59'),(75,2,1,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(76,2,2,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(77,2,3,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(78,2,4,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(79,2,5,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(80,2,6,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(81,2,7,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(82,2,8,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(83,2,9,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(84,2,10,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(85,2,11,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(86,2,12,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(87,2,13,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(88,2,14,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(89,2,15,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(90,2,16,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(91,2,17,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(92,2,18,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(93,2,19,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(94,2,20,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(95,2,21,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(96,2,22,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(97,2,23,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(98,2,24,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(99,2,25,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(100,2,26,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(101,2,27,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(102,2,28,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(103,2,29,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(104,2,30,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(105,2,31,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(106,2,32,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(107,2,33,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(108,2,34,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(109,2,35,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(110,2,36,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(111,2,37,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(112,2,38,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(113,2,39,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(114,2,40,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(115,2,41,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(116,2,42,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(117,2,43,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(118,2,44,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(119,2,45,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(120,2,46,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(121,2,47,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(122,2,48,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(123,2,49,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(124,2,50,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(125,2,51,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(126,2,52,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(127,2,53,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(129,2,55,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(130,2,56,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(131,2,60,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(132,2,61,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(133,2,63,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(134,2,64,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(135,2,65,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(136,2,66,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(137,2,67,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(138,2,68,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(139,2,69,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(140,2,70,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(141,2,71,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(142,2,72,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(143,2,73,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(144,2,74,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(145,2,75,'readonly','2018-11-18 08:37:53','2018-11-18 08:37:53'),(146,1,76,'write','2018-11-23 07:25:54','2018-11-23 07:25:54'),(147,1,77,'write','2018-11-30 15:18:47','2018-11-30 15:18:47'),(148,1,78,'write','2018-12-03 07:28:49','2018-12-03 07:28:49'),(149,1,79,'write','2018-12-03 08:11:31','2018-12-03 08:11:31'),(224,3,1,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(225,3,2,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(226,3,3,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(227,3,4,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(228,3,5,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(229,3,6,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(230,3,7,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(231,3,8,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(232,3,9,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(233,3,10,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(234,3,11,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(235,3,12,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(236,3,13,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(237,3,14,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(238,3,15,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(239,3,16,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(240,3,17,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(241,3,18,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(242,3,19,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(243,3,20,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(244,3,21,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(245,3,22,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(246,3,23,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(247,3,24,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(248,3,25,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(249,3,26,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(250,3,27,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(251,3,28,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(252,3,29,'readonly','2018-12-04 14:15:59','2018-12-04 14:15:59'),(253,3,30,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(254,3,31,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(255,3,32,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(256,3,33,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(257,3,34,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(258,3,35,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(259,3,36,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(260,3,37,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(261,3,38,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(262,3,39,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(263,3,40,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(264,3,41,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(265,3,42,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(266,3,43,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(267,3,44,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(268,3,45,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(269,3,46,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(270,3,47,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(271,3,48,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(272,3,49,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(273,3,50,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(274,3,51,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(275,3,52,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(276,3,53,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(277,3,55,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(278,3,56,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(279,3,60,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(280,3,61,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(281,3,63,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(282,3,64,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(283,3,65,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(284,3,66,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(285,3,67,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(286,3,77,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(287,3,68,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(288,3,69,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(289,3,70,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(290,3,76,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(291,3,71,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(292,3,72,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(293,3,73,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(294,3,78,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(295,3,74,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(296,3,75,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(297,3,79,'readonly','2018-12-04 14:16:00','2018-12-04 14:16:00'),(298,1,80,'write','2018-12-13 23:58:45','2018-12-13 23:58:45'),(299,2,80,'invisible','2018-12-13 23:59:17','2018-12-13 23:59:17'),(300,2,78,'invisible','2018-12-13 23:59:17','2018-12-13 23:59:17'),(301,2,79,'invisible','2018-12-13 23:59:17','2018-12-13 23:59:17'),(302,3,80,'invisible','2018-12-13 23:59:17','2018-12-13 23:59:17');
/*!40000 ALTER TABLE `role_module_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,NULL,NULL),(2,2,2,NULL,NULL);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `display_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '1',
  `dept` int(10) unsigned NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  KEY `roles_parent_foreign` (`parent`),
  KEY `roles_dept_foreign` (`dept`),
  CONSTRAINT `roles_dept_foreign` FOREIGN KEY (`dept`) REFERENCES `departments` (`id`),
  CONSTRAINT `roles_parent_foreign` FOREIGN KEY (`parent`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'SUPER_ADMIN','Super Admin','Full Access Role',1,1,NULL,'2018-11-18 07:30:43','2018-11-18 07:30:43'),(2,'ADMIN','Administrator','',1,1,NULL,'2018-11-18 08:37:53','2018-11-18 08:37:53'),(3,'ENCODER','Encoder','Taga add ng role',1,1,NULL,'2018-12-04 14:15:59','2018-12-04 14:15:59');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit` varchar(256) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,NULL,'2018-11-23 07:35:26','2018-11-23 07:35:26','mm','millimeter'),(2,NULL,'2018-11-23 07:35:35','2018-11-23 07:35:35','cm','centimeter'),(3,NULL,'2018-11-23 07:35:42','2018-11-23 07:35:42','cu m','cubic meter');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `hash` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploads_user_id_foreign` (`user_id`),
  CONSTRAINT `uploads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uploads`
--

LOCK TABLES `uploads` WRITE;
/*!40000 ALTER TABLE `uploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `context_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Employee',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jake Ortega',1,'admin@fbv.com','$2y$10$unjw0lqllGN9rWLT4oIMn.TiJsYG32w70XKd4jR5EelKvJO5wVOdu','Employee','xjQI4laqJMXoizdEaKSf3qEYhtL7xSZbW2b8Rvvsb8vPhTGRp3LSKCqDFO6f',NULL,'2018-11-18 07:30:56','2018-12-03 08:16:10'),(2,'Juan Dela Cruz',2,'ceo@fbv.com.ph','$2y$10$2Q0w/n/FPyhtq96Xmr/reeRTzCHWhTMdTEdCnZP9LgMp44gL37Inq','Employee','psbRuvC5w5Hruk2UuWvRgdoAMs4Pxr7oOqJ67KLiMTxf18Iu1TefRVkQsyGL',NULL,'2018-11-18 08:39:20','2018-11-18 08:41:54'),(3,'encoder',3,'a@a.com','$2y$10$NWKi1vt7qgn3dc7D4YyNGucavT7p9b0XV.5UCEt73T4DRDbplz9MK','Employee',NULL,NULL,'2018-12-03 08:14:53','2018-12-03 08:15:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-15 14:59:43
