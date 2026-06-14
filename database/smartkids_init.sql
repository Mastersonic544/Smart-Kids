-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: smartkids
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `smartkids`
--

/*!40000 DROP DATABASE IF EXISTS `smartkids`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `smartkids` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `smartkids`;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_time` time NOT NULL,
  `educator_id` bigint(20) unsigned NOT NULL,
  `requested_by` bigint(20) unsigned DEFAULT NULL,
  `max_participants` int(10) unsigned NOT NULL DEFAULT 30,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(32) NOT NULL DEFAULT 'approved',
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_educator_id_foreign` (`educator_id`),
  KEY `activities_requested_by_foreign` (`requested_by`),
  KEY `activities_approved_by_foreign` (`approved_by`),
  KEY `activities_status_index` (`status`),
  CONSTRAINT `activities_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `activities_educator_id_foreign` FOREIGN KEY (`educator_id`) REFERENCES `teachers` (`id`),
  CONSTRAINT `activities_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,'Sortie au parc (La Petite Étoile)','Ea et tempora quam sed doloremque blanditiis et provident.','2026-06-18','10:00:00',1,7,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','approved',6,'2026-06-11 14:48:55',NULL),(2,'Atelier peinture (La Petite Étoile)','Explicabo similique soluta voluptatibus quia tenetur dolore rerum sit rerum eum deleniti esse.','2026-06-10','10:00:00',2,8,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','completed',6,'2026-06-11 14:48:55',NULL),(3,'Yoga des petits (La Petite Étoile)','Quasi ut sed itaque eveniet saepe voluptatem expedita vel ab consectetur repellat.','2026-06-23','10:00:00',3,9,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','pending_approval',NULL,NULL,NULL),(4,'Spectacle de fin d\'année (La Petite Étoile)','Excepturi deserunt et cupiditate sed sunt officiis minus corporis ducimus nihil magnam ipsa aut magnam nihil.','2026-07-13','10:00:00',1,7,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','pending_approval',NULL,NULL,NULL),(5,'Initiation à la musique (La Petite Étoile)','Rerum nemo vel placeat velit aut occaecati sint voluptatem reprehenderit.','2026-06-20','10:00:00',2,8,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','approved',6,'2026-06-11 14:48:55',NULL),(6,'Journée pyjama (La Petite Étoile)','Quis quia voluptas autem sit praesentium cumque iusto et consequatur minus eveniet eum numquam aspernatur impedit.','2026-06-03','10:00:00',3,9,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','completed',6,'2026-06-11 14:48:55',NULL),(7,'Sortie ferme pédagogique (La Petite Étoile)','Deleniti aut voluptatibus quia quae commodi ut praesentium et numquam reprehenderit fuga illo optio et.','2026-06-27','10:00:00',1,7,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','rejected',6,'2026-06-11 14:48:55','Date conflictuelle avec un autre événement.'),(8,'Atelier cuisine (La Petite Étoile)','Nobis voluptatem aut aperiam tenetur a sunt fuga non iure soluta cumque quia debitis ut aut.','2026-06-16','10:00:00',2,8,25,'2026-06-13 14:48:55','2026-06-13 14:48:55','approved',6,'2026-06-11 14:48:55',NULL),(9,'Sortie au parc (Soleil d\'Hammamet)','Quo nam ducimus deserunt temporibus nostrum error nam dolorem et.','2026-06-18','10:00:00',4,17,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','approved',16,'2026-06-11 14:49:01',NULL),(10,'Atelier peinture (Soleil d\'Hammamet)','Laborum voluptatum vel ducimus sed omnis consectetur qui.','2026-06-10','10:00:00',5,18,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','completed',16,'2026-06-11 14:49:01',NULL),(11,'Yoga des petits (Soleil d\'Hammamet)','Voluptatibus optio cupiditate doloremque ut illum esse eligendi vel et hic non.','2026-06-23','10:00:00',6,19,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','pending_approval',NULL,NULL,NULL),(12,'Spectacle de fin d\'année (Soleil d\'Hammamet)','Neque est provident nulla autem voluptatem sunt animi et inventore perspiciatis ut deserunt nostrum eaque et quo.','2026-07-13','10:00:00',4,17,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','pending_approval',NULL,NULL,NULL),(13,'Initiation à la musique (Soleil d\'Hammamet)','Cum mollitia consequuntur deleniti laborum fugit et velit alias.','2026-06-20','10:00:00',5,18,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','approved',16,'2026-06-11 14:49:01',NULL),(14,'Journée pyjama (Soleil d\'Hammamet)','Dolorem voluptatem magni sit veniam pariatur sed et architecto consectetur hic vitae illum.','2026-06-03','10:00:00',6,19,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','completed',16,'2026-06-11 14:49:01',NULL),(15,'Sortie ferme pédagogique (Soleil d\'Hammamet)','Saepe nisi eligendi rerum at aliquam ut suscipit enim.','2026-06-27','10:00:00',4,17,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','rejected',16,'2026-06-11 14:49:01','Date conflictuelle avec un autre événement.'),(16,'Atelier cuisine (Soleil d\'Hammamet)','Totam ab quos eos enim corrupti officiis aut perferendis exercitationem eum ipsum labore dicta quos.','2026-06-16','10:00:00',5,18,25,'2026-06-13 14:49:01','2026-06-13 14:49:01','approved',16,'2026-06-11 14:49:01',NULL);
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_child`
--

DROP TABLE IF EXISTS `activity_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_child` (
  `activity_id` bigint(20) unsigned NOT NULL,
  `child_id` bigint(20) unsigned NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`activity_id`,`child_id`),
  KEY `activity_child_child_id_foreign` (`child_id`),
  CONSTRAINT `activity_child_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activity_child_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_child`
--

LOCK TABLES `activity_child` WRITE;
/*!40000 ALTER TABLE `activity_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `child_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `statut` varchar(255) NOT NULL,
  `motif` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendances_child_id_foreign` (`child_id`),
  CONSTRAINT `attendances_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,'2026-06-01','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(2,2,'2026-06-01','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(3,4,'2026-06-01','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(4,5,'2026-06-01','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(5,7,'2026-06-01','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(6,8,'2026-06-01','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(7,1,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(8,2,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(9,4,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(10,5,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(11,7,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(12,8,'2026-06-02','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(13,1,'2026-06-03','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(14,2,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(15,4,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(16,5,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(17,7,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(18,8,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(19,1,'2026-06-04','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(20,2,'2026-06-04','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(21,4,'2026-06-04','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(22,5,'2026-06-04','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(23,7,'2026-06-04','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(24,8,'2026-06-04','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(25,1,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(26,2,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(27,4,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(28,5,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(29,7,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(30,8,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(31,1,'2026-06-08','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(32,2,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(33,4,'2026-06-08','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(34,5,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(35,7,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(36,8,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(37,1,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(38,2,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(39,4,'2026-06-09','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(40,5,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(41,7,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(42,8,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(43,1,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(44,2,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(45,4,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(46,5,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(47,7,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(48,8,'2026-06-10','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(49,1,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(50,2,'2026-06-11','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(51,4,'2026-06-11','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(52,5,'2026-06-11','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(53,7,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(54,8,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(55,1,'2026-06-12','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(56,2,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(57,4,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(58,5,'2026-06-12','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(59,7,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(60,8,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(61,3,'2026-06-01','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(62,6,'2026-06-01','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(63,9,'2026-06-01','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(64,3,'2026-06-02','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(65,6,'2026-06-02','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(66,9,'2026-06-02','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(67,3,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(68,6,'2026-06-03','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(69,9,'2026-06-03','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(70,3,'2026-06-04','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(71,6,'2026-06-04','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(72,9,'2026-06-04','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(73,3,'2026-06-05','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(74,6,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(75,9,'2026-06-05','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(76,3,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(77,6,'2026-06-08','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(78,9,'2026-06-08','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(79,3,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(80,6,'2026-06-09','absent',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(81,9,'2026-06-09','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(82,3,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(83,6,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(84,9,'2026-06-10','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(85,3,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(86,6,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(87,9,'2026-06-11','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(88,3,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(89,6,'2026-06-12','en_retard',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(90,9,'2026-06-12','present',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(91,10,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(92,11,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(93,13,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(94,14,'2026-06-01','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(95,16,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(96,17,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(97,10,'2026-06-02','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(98,11,'2026-06-02','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(99,13,'2026-06-02','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(100,14,'2026-06-02','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(101,16,'2026-06-02','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(102,17,'2026-06-02','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(103,10,'2026-06-03','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(104,11,'2026-06-03','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(105,13,'2026-06-03','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(106,14,'2026-06-03','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(107,16,'2026-06-03','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(108,17,'2026-06-03','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(109,10,'2026-06-04','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(110,11,'2026-06-04','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(111,13,'2026-06-04','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(112,14,'2026-06-04','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(113,16,'2026-06-04','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(114,17,'2026-06-04','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(115,10,'2026-06-05','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(116,11,'2026-06-05','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(117,13,'2026-06-05','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(118,14,'2026-06-05','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(119,16,'2026-06-05','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(120,17,'2026-06-05','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(121,10,'2026-06-08','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(122,11,'2026-06-08','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(123,13,'2026-06-08','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(124,14,'2026-06-08','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(125,16,'2026-06-08','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(126,17,'2026-06-08','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(127,10,'2026-06-09','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(128,11,'2026-06-09','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(129,13,'2026-06-09','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(130,14,'2026-06-09','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(131,16,'2026-06-09','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(132,17,'2026-06-09','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(133,10,'2026-06-10','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(134,11,'2026-06-10','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(135,13,'2026-06-10','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(136,14,'2026-06-10','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(137,16,'2026-06-10','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(138,17,'2026-06-10','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(139,10,'2026-06-11','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(140,11,'2026-06-11','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(141,13,'2026-06-11','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(142,14,'2026-06-11','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(143,16,'2026-06-11','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(144,17,'2026-06-11','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(145,10,'2026-06-12','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(146,11,'2026-06-12','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(147,13,'2026-06-12','en_retard',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(148,14,'2026-06-12','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(149,16,'2026-06-12','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(150,17,'2026-06-12','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(151,12,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(152,15,'2026-06-01','present',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(153,18,'2026-06-01','absent',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(154,12,'2026-06-02','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(155,15,'2026-06-02','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(156,18,'2026-06-02','absent',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(157,12,'2026-06-03','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(158,15,'2026-06-03','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(159,18,'2026-06-03','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(160,12,'2026-06-04','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(161,15,'2026-06-04','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(162,18,'2026-06-04','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(163,12,'2026-06-05','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(164,15,'2026-06-05','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(165,18,'2026-06-05','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(166,12,'2026-06-08','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(167,15,'2026-06-08','absent',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(168,18,'2026-06-08','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(169,12,'2026-06-09','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(170,15,'2026-06-09','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(171,18,'2026-06-09','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(172,12,'2026-06-10','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(173,15,'2026-06-10','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(174,18,'2026-06-10','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(175,12,'2026-06-11','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(176,15,'2026-06-11','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(177,18,'2026-06-11','en_retard',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(178,12,'2026-06-12','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(179,15,'2026-06-12','present',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(180,18,'2026-06-12','absent',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `children`
--

DROP TABLE IF EXISTS `children`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `children` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naissance` date NOT NULL,
  `allergies` text DEFAULT NULL,
  `parent_id` bigint(20) unsigned NOT NULL,
  `classroom_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `children_parent_id_foreign` (`parent_id`),
  KEY `children_classroom_id_foreign` (`classroom_id`),
  CONSTRAINT `children_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`),
  CONSTRAINT `children_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `children`
--

LOCK TABLES `children` WRITE;
/*!40000 ALTER TABLE `children` DISABLE KEYS */;
INSERT INTO `children` VALUES (1,'Mejri','Ines','2024-05-08',NULL,10,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(2,'Sellami','Sarra','2021-07-21',NULL,11,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(3,'Trabelsi','Malek','2022-05-05',NULL,11,2,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(4,'Rezgui','Omar','2022-08-31',NULL,12,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(5,'Ayari','Yassine','2022-10-18',NULL,13,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(6,'Ben Ali','Lina','2021-10-10',NULL,13,2,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(7,'Ben Ali','Lina','2024-05-10',NULL,14,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(8,'Gharbi','Lina','2023-05-15',NULL,15,1,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(9,'Ben Ali','Ahmed','2023-10-20',NULL,15,2,'2026-06-13 14:48:55','2026-06-13 14:48:55'),(10,'Bouaziz','Ali','2023-12-11',NULL,20,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(11,'Dridi','Nour','2024-04-28',NULL,21,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(12,'Hajri','Ahmed','2022-05-25',NULL,21,5,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(13,'Ayari','Yassine','2024-01-16',NULL,22,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(14,'Sellami','Amine','2023-08-26',NULL,23,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(15,'Saidi','Omar','2023-08-25',NULL,23,5,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(16,'Dridi','Sarra','2022-07-06','Lait',24,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(17,'Kallel','Adem','2023-08-26',NULL,25,4,'2026-06-13 14:49:00','2026-06-13 14:49:00'),(18,'Kallel','Mohamed','2023-11-02',NULL,25,5,'2026-06-13 14:49:00','2026-06-13 14:49:00');
/*!40000 ALTER TABLE `children` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classrooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `niveau` varchar(255) NOT NULL,
  `capacite` int(11) NOT NULL DEFAULT 25,
  `educator_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classrooms_educator_id_foreign` (`educator_id`),
  CONSTRAINT `classrooms_educator_id_foreign` FOREIGN KEY (`educator_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classrooms`
--

LOCK TABLES `classrooms` WRITE;
/*!40000 ALTER TABLE `classrooms` DISABLE KEYS */;
INSERT INTO `classrooms` VALUES (1,'Petite Section — La Petite Étoile','PS',15,1,'2026-06-13 14:48:52','2026-06-13 14:48:52'),(2,'Moyenne Section — La Petite Étoile','MS',18,2,'2026-06-13 14:48:52','2026-06-13 14:48:52'),(3,'Grande Section — La Petite Étoile','GS',20,3,'2026-06-13 14:48:52','2026-06-13 14:48:52'),(4,'Étoiles — Soleil d\'Hammamet','PS',12,4,'2026-06-13 14:48:58','2026-06-13 14:48:58'),(5,'Soleils — Soleil d\'Hammamet','MS',16,5,'2026-06-13 14:48:58','2026-06-13 14:48:58'),(6,'Lunes — Soleil d\'Hammamet','GS',18,6,'2026-06-13 14:48:58','2026-06-13 14:48:58');
/*!40000 ALTER TABLE `classrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `child_id` bigint(20) unsigned NOT NULL,
  `statut` enum('en attente','validée','liste_d_attente') NOT NULL DEFAULT 'en attente',
  `date_inscription` date NOT NULL,
  `pieces_justificatives` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enrollments_child_id_foreign` (`child_id`),
  CONSTRAINT `enrollments_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `week_start` date NOT NULL,
  `monday` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`monday`)),
  `tuesday` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tuesday`)),
  `wednesday` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`wednesday`)),
  `thursday` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`thursday`)),
  `friday` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`friday`)),
  `created_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meals_created_by_foreign` (`created_by`),
  CONSTRAINT `meals_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meals`
--

LOCK TABLES `meals` WRITE;
/*!40000 ALTER TABLE `meals` DISABLE KEYS */;
INSERT INTO `meals` VALUES (1,'2026-06-08','\"{\\\"plat\\\":\\\"Couscous aux l\\\\u00e9gumes\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Fruits de saison\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Escalope de poulet grill\\\\u00e9e\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Salade tunisienne\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Gratin de p\\\\u00e2tes\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"',3,'2026-06-13 14:48:50','2026-06-13 14:48:50'),(2,'2026-06-01','\"{\\\"plat\\\":\\\"Soupe de lentilles (Chorba)\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Salade tunisienne\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Soupe de lentilles (Chorba)\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Riz cantonais\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Ojja aux \\\\u0153ufs\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"',3,'2026-06-13 14:48:50','2026-06-13 14:48:50'),(3,'2026-05-25','\"{\\\"plat\\\":\\\"Ojja aux \\\\u0153ufs\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Escalope de poulet grill\\\\u00e9e\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Gratin de p\\\\u00e2tes\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Soupe de lentilles (Chorba)\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Salade tunisienne\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"',3,'2026-06-13 14:48:50','2026-06-13 14:48:50'),(4,'2026-05-18','\"{\\\"plat\\\":\\\"P\\\\u00e2tes \\\\u00e0 la sauce bolognaise\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Pur\\\\u00e9e de pommes de terre et poisson\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Fruits de saison\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"','\"{\\\"plat\\\":\\\"Soupe de lentilles (Chorba)\\\",\\\"dessert\\\":\\\"Yaourt\\\"}\"','\"{\\\"plat\\\":\\\"Salade tunisienne\\\",\\\"dessert\\\":\\\"Fruit\\\"}\"',3,'2026-06-13 14:48:50','2026-06-13 14:48:50');
/*!40000 ALTER TABLE `meals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) unsigned NOT NULL,
  `receiver_id` bigint(20) unsigned NOT NULL,
  `body` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,10,6,'Bonjour, mon enfant sera absent demain.',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(2,6,10,'Merci pour l\'information, bonne journée.',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(3,11,7,'Bonjour, comment ma fille a-t-elle évolué cette semaine ?',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(4,7,11,'Très bien, elle progresse en lecture !',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(5,1,12,'Bienvenue sur SmartKids ! Vous recevrez ici les notifications importantes de votre établissement.',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(6,20,16,'Bonjour, mon enfant sera absent demain.',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(7,16,20,'Merci pour l\'information, bonne journée.',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(8,21,17,'Bonjour, comment ma fille a-t-elle évolué cette semaine ?',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(9,17,21,'Très bien, elle progresse en lecture !',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01'),(10,1,22,'Bienvenue sur SmartKids ! Vous recevrez ici les notifications importantes de votre établissement.',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_20_015400_create_classrooms_table',1),(5,'2026_04_20_015444_create_children_table',1),(6,'2026_04_20_020224_create_payments_table',1),(7,'2026_04_20_025613_create_teachers_table',1),(8,'2026_04_20_030925_create_enrollments_table',1),(9,'2026_04_20_164723_create_permission_tables',1),(10,'2026_04_20_170301_create_activities_table',1),(11,'2026_04_20_170301_create_activity_child_table',1),(12,'2026_04_20_170302_create_meals_table',1),(13,'2026_04_20_170302_create_messages_table',1),(14,'2026_04_20_170302_create_notifications_table',1),(15,'2026_04_20_174316_create_attendances_table',1),(16,'2026_04_29_100000_add_educator_id_to_classrooms_table',1),(17,'2026_05_23_173803_add_phone_to_users_table',1),(18,'2026_06_13_120000_add_vision_fields_to_existing_tables',1),(19,'2026_06_13_140000_create_saas_subscription_tables',1),(20,'2026_06_13_150000_add_billing_fields_to_payments_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',2),(2,'App\\Models\\User',3),(2,'App\\Models\\User',6),(2,'App\\Models\\User',16),(3,'App\\Models\\User',4),(3,'App\\Models\\User',7),(3,'App\\Models\\User',8),(3,'App\\Models\\User',9),(3,'App\\Models\\User',17),(3,'App\\Models\\User',18),(3,'App\\Models\\User',19),(4,'App\\Models\\User',5),(4,'App\\Models\\User',10),(4,'App\\Models\\User',11),(4,'App\\Models\\User',12),(4,'App\\Models\\User',13),(4,'App\\Models\\User',14),(4,'App\\Models\\User',15),(4,'App\\Models\\User',20),(4,'App\\Models\\User',21),(4,'App\\Models\\User',22),(4,'App\\Models\\User',23),(4,'App\\Models\\User',24),(4,'App\\Models\\User',25);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `child_id` bigint(20) unsigned NOT NULL,
  `montant` decimal(8,2) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mois` varchar(7) DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `paye_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_child_id_foreign` (`child_id`),
  KEY `payments_mois_index` (`mois`),
  CONSTRAINT `payments_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(2,1,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(3,1,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(4,2,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(5,2,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(6,2,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(7,3,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(8,3,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(9,3,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(10,4,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(11,4,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(12,4,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(13,5,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(14,5,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(15,5,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(16,6,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(17,6,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(18,6,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(19,7,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(20,7,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(21,7,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(22,8,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(23,8,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(24,8,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(25,9,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-04','2026-04-30','2026-04-20 14:48:55'),(26,9,400.00,'payé',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-05','2026-05-31','2026-05-18 14:48:55'),(27,9,400.00,'en attente',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','2026-06','2026-06-30',NULL),(28,10,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(29,10,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(30,10,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(31,11,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(32,11,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(33,11,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(34,12,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(35,12,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(36,12,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(37,13,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(38,13,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(39,13,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(40,14,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(41,14,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(42,14,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(43,15,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(44,15,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(45,15,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(46,16,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(47,16,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(48,16,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(49,17,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(50,17,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(51,17,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL),(52,18,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-04','2026-04-30','2026-04-20 14:49:01'),(53,18,400.00,'payé',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-05','2026-05-31','2026-05-18 14:49:01'),(54,18,400.00,'en attente',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01','2026-06','2026-06-30',NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2026-06-13 14:48:47','2026-06-13 14:48:47'),(2,'admin','web','2026-06-13 14:48:47','2026-06-13 14:48:47'),(3,'educateur','web','2026-06-13 14:48:47','2026-06-13 14:48:47'),(4,'parent','web','2026-06-13 14:48:47','2026-06-13 14:48:47');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saas_payments`
--

DROP TABLE IF EXISTS `saas_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saas_payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) unsigned NOT NULL,
  `amount_tnd` decimal(10,3) NOT NULL,
  `period` varchar(16) NOT NULL,
  `period_start` date NOT NULL,
  `period_end` date NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `receipt_pdf_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saas_payments_admin_id_foreign` (`admin_id`),
  KEY `saas_payments_status_index` (`status`),
  CONSTRAINT `saas_payments_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saas_payments`
--

LOCK TABLES `saas_payments` WRITE;
/*!40000 ALTER TABLE `saas_payments` DISABLE KEYS */;
INSERT INTO `saas_payments` VALUES (1,6,199.000,'monthly','2026-05-13','2026-08-13','paid','2026-05-02 14:48:56',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56'),(2,16,199.000,'monthly','2026-05-13','2026-06-19','paid','2026-05-02 14:49:01',NULL,'2026-06-13 14:49:01','2026-06-13 14:49:01');
/*!40000 ALTER TABLE `saas_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('9C0WL069oBYIfp6KI1aot5SRNID73xRml4khXvei',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7462','YTozOntzOjY6Il90b2tlbiI7czo0MDoia2Q1cjVaNHA3NkxXbnZLeVlZSFREQU5ZS1VkYk1aOUZWN3d6SXdxdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbi9jb2RlIjtzOjU6InJvdXRlIjtzOjEzOiJwYXNzY29kZS5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1781365787),('k0NdvlzWDD23gySso0zeY2O4XsztAfjFGXmmB7F4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7462','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGpHMThHSjBJSkZCVzkwanN1ZXJibkt6d3JFR1hsaFVCdHhMRUNxMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1781365786),('sys4BMVTcHME5rikb8AtWvreBC7wsBR7f7VIQadD',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.26100.7462','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUDQ4dEhRVk9QR3VKQTVKNzhuUUo4V3dKNmJIQ2s3VWRCeVJ2RGR0ViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1781365782);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `document_contractuel` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teachers_email_unique` (`email`),
  KEY `teachers_user_id_foreign` (`user_id`),
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,7,'Belhadj','Anissa','anissa.belhadj@smartkids.tn','24238411',NULL,'2026-06-13 14:48:51','2026-06-13 14:48:51'),(2,8,'Trabelsi','Mehdi','mehdi.trabelsi@smartkids.tn','29164822',NULL,'2026-06-13 14:48:51','2026-06-13 14:48:51'),(3,9,'Khelifi','Salma','salma.khelifi@smartkids.tn','22657780',NULL,'2026-06-13 14:48:52','2026-06-13 14:48:52'),(4,17,'Mansour','Wassim','wassim.mansour@smartkids.tn','28853833',NULL,'2026-06-13 14:48:57','2026-06-13 14:48:57'),(5,18,'Bouzid','Lina','lina.bouzid@smartkids.tn','24824193',NULL,'2026-06-13 14:48:57','2026-06-13 14:48:57'),(6,19,'Saadi','Karim','karim.saadi@smartkids.tn','28477982',NULL,'2026-06-13 14:48:58','2026-06-13 14:48:58');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `passcode` varchar(6) DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT 0,
  `monthly_tuition_tnd` decimal(8,3) DEFAULT NULL,
  `tenant_admin_id` bigint(20) unsigned DEFAULT NULL,
  `subscription_status` varchar(16) NOT NULL DEFAULT 'active',
  `billing_period` varchar(16) DEFAULT NULL,
  `subscription_started_at` timestamp NULL DEFAULT NULL,
  `subscription_due_at` timestamp NULL DEFAULT NULL,
  `frozen_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_tenant_admin_id_foreign` (`tenant_admin_id`),
  KEY `users_passcode_index` (`passcode`),
  KEY `users_is_system_index` (`is_system`),
  KEY `users_subscription_status_index` (`subscription_status`),
  KEY `users_subscription_due_at_index` (`subscription_due_at`),
  CONSTRAINT `users_tenant_admin_id_foreign` FOREIGN KEY (`tenant_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'SmartKids','system@smartkids.local',NULL,NULL,'$2y$12$Ph.p7VHKFnf/HVCDOTo5iuApL7Nbaxq8Cs94r9TW3Ea/3toaHfFz.',NULL,'2026-06-13 14:48:48','2026-06-13 14:48:48',NULL,1,NULL,NULL,'active',NULL,NULL,NULL,NULL),(2,'SmartKids SaaS Owner','superadmin@smartkids.tn',NULL,NULL,'$2y$12$Am2S.vD4vndKcU9SvpnnHuhr52HJEIjUhO7JgVsaSo87lKkBXRgKa',NULL,'2026-06-13 14:48:48','2026-06-13 14:48:48',NULL,0,NULL,NULL,'active',NULL,NULL,NULL,NULL),(3,'Admin User','admin@smartkids.tn',NULL,NULL,'$2y$12$gcY5KwBmlyfgxzH4PF2MM.HT5y/wxhydFhs5bgopey.IPo4Z63EDW',NULL,'2026-06-13 14:48:49','2026-06-13 14:48:49',NULL,0,NULL,NULL,'active','monthly','2026-06-13 14:48:49','2026-07-13 14:48:49',NULL),(4,'Educateur User','educateur@smartkids.tn',NULL,NULL,'$2y$12$MgPJrujDQ6eFIqDh0ixdAef3yOS0a5DTj4tzQda7KLhDAmjmiMHuG',NULL,'2026-06-13 14:48:49','2026-06-13 14:48:49',NULL,0,NULL,NULL,'active',NULL,NULL,NULL,NULL),(5,'Parent User','parent@smartkids.tn',NULL,NULL,'$2y$12$YeZzbfe183LXVTwkTo/NauKCSU6dNxqa7Wy5VpcXlPfyxDiDewRzK',NULL,'2026-06-13 14:48:50','2026-06-13 14:48:50',NULL,0,NULL,NULL,'active',NULL,NULL,NULL,NULL),(6,'La Petite Étoile','etoile@smartkids.tn','71200300',NULL,'$2y$12$r7f2kMGibdfGdzbCrvu2kO7AUCV7QvUNJbILzMEMyznVks9Pq4cA2',NULL,'2026-06-13 14:48:50','2026-06-13 14:48:50',NULL,0,380.000,NULL,'active','monthly','2026-05-13 14:48:50','2026-08-13 14:48:50',NULL),(7,'Anissa Belhadj','anissa.belhadj@smartkids.tn',NULL,NULL,'$2y$12$vE6jQLT5MN38H2/3qLru9eCQaGNBJGutx6Mib9P6OanYdd5wHcDpu',NULL,'2026-06-13 14:48:51','2026-06-13 14:48:51','715715',0,NULL,6,'active',NULL,NULL,NULL,NULL),(8,'Mehdi Trabelsi','mehdi.trabelsi@smartkids.tn',NULL,NULL,'$2y$12$5SbTcm0H/qqF7wVwNmb2/ONmgBmn7GIChf9LpYCNjVlsASuQauTWu',NULL,'2026-06-13 14:48:51','2026-06-13 14:48:51','406406',0,NULL,6,'active',NULL,NULL,NULL,NULL),(9,'Salma Khelifi','salma.khelifi@smartkids.tn',NULL,NULL,'$2y$12$MeA.ekTu2/71vtfiMZJiJeEwPNhf/6ZjdwH087Edo/SiH7xtVqnIe',NULL,'2026-06-13 14:48:52','2026-06-13 14:48:52','991100',0,NULL,6,'active',NULL,NULL,NULL,NULL),(10,'Augustin Pereira','parent1.etoile@example.com','23297180',NULL,'$2y$12$vSBlCZl.E85pHL5x/W/kA.zOHBbLNlo1YTmJwLvsVap.3yLBTThVa',NULL,'2026-06-13 14:48:52','2026-06-13 14:48:52','150150',0,NULL,6,'active',NULL,NULL,NULL,NULL),(11,'Christiane Jean','parent2.etoile@example.com','21828643',NULL,'$2y$12$FVnvM2KkYtrEm4U4jap4B.RCWF61pbnFB94Z49KEKlgUGx5DayLG6',NULL,'2026-06-13 14:48:53','2026-06-13 14:48:53','890123',0,NULL,6,'active',NULL,NULL,NULL,NULL),(12,'Françoise Verdier','parent3.etoile@example.com','27644252',NULL,'$2y$12$zZ/QZcFkPLZ72WmaDNxroebFRzxu5WB9VyzjluxALDCKQ.jUQ9GMm',NULL,'2026-06-13 14:48:53','2026-06-13 14:48:53','512512',0,NULL,6,'active',NULL,NULL,NULL,NULL),(13,'Bernard Bernard','parent4.etoile@example.com','27225757',NULL,'$2y$12$71UmVgE0kFVrzFD22JNJwuFy6FHEx7vfVmqV8v7VmuKJai.TzW6SS',NULL,'2026-06-13 14:48:54','2026-06-13 14:48:54','901234',0,NULL,6,'active',NULL,NULL,NULL,NULL),(14,'Auguste Faure','parent5.etoile@example.com','28816990',NULL,'$2y$12$h6C1QNz2ZVtMTw1Tzlrt1OBhnl.R.ocuvwetNd05YFHEEdw0ub3Ay',NULL,'2026-06-13 14:48:54','2026-06-13 14:48:54','123456',0,NULL,6,'active',NULL,NULL,NULL,NULL),(15,'Thibaut Gregoire','parent6.etoile@example.com','22545463',NULL,'$2y$12$pOiT/ej1KjD9YkUcbqPEHe0oq7VWeg5JkoPVRnRMzWDjymBGf7SyS',NULL,'2026-06-13 14:48:55','2026-06-13 14:48:55','552552',0,NULL,6,'active',NULL,NULL,NULL,NULL),(16,'Soleil d\'Hammamet','soleil@smartkids.tn','72444555',NULL,'$2y$12$35M4B29OW7pu0349odufIejcFXVALyVrlGoDkCfAeyvkK6.PFar0m',NULL,'2026-06-13 14:48:56','2026-06-13 14:48:56',NULL,0,420.000,NULL,'active','monthly','2026-05-13 14:48:56','2026-06-19 14:48:50',NULL),(17,'Wassim Mansour','wassim.mansour@smartkids.tn',NULL,NULL,'$2y$12$eip8kUpmyHEpGe1kNZrFD.RpqvMsXQI29W6auykpJMM.qdWbA9Ex2',NULL,'2026-06-13 14:48:57','2026-06-13 14:48:57','720720',0,NULL,16,'active',NULL,NULL,NULL,NULL),(18,'Lina Bouzid','lina.bouzid@smartkids.tn',NULL,NULL,'$2y$12$VMSfVVYVk0Mw.njGTHsX2O07dbqNmiG4wfE2tA.lMhCGC.FbLeWQ6',NULL,'2026-06-13 14:48:57','2026-06-13 14:48:57','518518',0,NULL,16,'active',NULL,NULL,NULL,NULL),(19,'Karim Saadi','karim.saadi@smartkids.tn',NULL,NULL,'$2y$12$GaWkZdztvLAixKIosnRhG.jgVJfwdJBE86NOxM9kAahXdEbNYBiZW',NULL,'2026-06-13 14:48:57','2026-06-13 14:48:57','234567',0,NULL,16,'active',NULL,NULL,NULL,NULL),(20,'Tristan Perrot','parent1.soleil@example.com','27421157',NULL,'$2y$12$MoErQFr6J1EZrV7HaVUKyu8gJGhIZiNNj3ik04100WQDNotrKAdWG',NULL,'2026-06-13 14:48:58','2026-06-13 14:48:58','500005',0,NULL,16,'active',NULL,NULL,NULL,NULL),(21,'Aurore Charpentier','parent2.soleil@example.com','26663143',NULL,'$2y$12$iFdrUy04lczGbthnlk4lreIqUYgyC/1QV/JyrhVMPv5YgZDabbRd2',NULL,'2026-06-13 14:48:58','2026-06-13 14:48:58','623326',0,NULL,16,'active',NULL,NULL,NULL,NULL),(22,'Alfred Ribeiro','parent3.soleil@example.com','22377793',NULL,'$2y$12$Kal0f4zAg6Q6/cY3yyyCz.5jCIyaKGdNBn4Zr9yJbnLSW2XJAxHZy',NULL,'2026-06-13 14:48:59','2026-06-13 14:48:59','776699',0,NULL,16,'active',NULL,NULL,NULL,NULL),(23,'Chantal Bonnin','parent4.soleil@example.com','24470671',NULL,'$2y$12$urd2U1dYYI2ZPQ2cEg5bYu78Dv6NnmSe8kDACrAFiYl64jFNq9lfO',NULL,'2026-06-13 14:48:59','2026-06-13 14:48:59','397793',0,NULL,16,'active',NULL,NULL,NULL,NULL),(24,'Valérie Duhamel','parent5.soleil@example.com','26300779',NULL,'$2y$12$gijVys0eTNf2sZvNm4qQQ.EmvtkhOt.uEPaJjy0A5YH7Yly6lWCji',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00','445511',0,NULL,16,'active',NULL,NULL,NULL,NULL),(25,'Gilbert Bousquet','parent6.soleil@example.com','27926561',NULL,'$2y$12$L8jvlNvh.NVE7oz2yXD66.FFYTBVtiF73lW0g26ZGTfiOxrKVhYtS',NULL,'2026-06-13 14:49:00','2026-06-13 14:49:00','888833',0,NULL,16,'active',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'smartkids'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-13 16:53:40
