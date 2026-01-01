-- MySQL dump 10.13  Distrib 9.3.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: file_system_db
-- ------------------------------------------------------
-- Server version	9.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `files` (
  `fileId` int NOT NULL AUTO_INCREMENT,
  `originalName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `size` bigint unsigned NOT NULL,
  `mimeType` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `checksum` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`fileId`),
  UNIQUE KEY `uq_files_checksum` (`checksum`),
  KEY `idx_files_createdAt` (`createdAt`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (16,'milk.jpg','/uploads/34151e2ce2a579a8.jpg','Taze ve besleyici süt, günlük kalsiyum ve protein ihtiyacını karşılamaya yardımcı olan doğal bir içecektir.',109886,'image/jpeg','eb1b3b908cfc8e801423d30e4980e44dae137671fc0160c7d10e1a82e3b416a3','2026-01-01 16:39:57',NULL),(17,'eggs.jpg','/uploads/c6e9fd15b431f62a.jpg','Yumurta, yüksek protein içeriğiyle besleyici ve pratik bir gıdadır.',45149,'image/jpeg','450a7fd796c557954083019736dfd911012f9c4463c3859c09e1f62a24a5305f','2026-01-01 16:49:22',NULL),(18,'apple.jpg','/uploads/c8031f65fe717f74.jpg','Elma, lif ve vitamin açısından zengin, sağlıklı bir meyvedir.',85299,'image/jpeg','96b18c0e1ec2222b572b6469f1387790c62942b441641a295671ad4c702fa661','2026-01-01 16:50:30',NULL),(19,'banana.jpg','/uploads/d266bf0904858752.jpg','Muz, potasyum bakımından zengin ve pratik bir atıştırmalıktır.',204806,'image/jpeg','aad055e1a171fd0ce8775127d64dffacd486403aceae2b4d26759d68555db2bb','2026-01-01 16:52:27',NULL),(20,'orange.jpg','/uploads/331a9a82c7f88492.jpg','Portakal, C vitamini açısından zengin ve ferahlatıcı tadıyla özellikle kış aylarının en sevilen meyvelerindendir.',88690,'image/jpeg','38ff7f27c575e884478e77b9f2ba61af44ad07b7aaa7e18ce59a9e50c2f67f02','2026-01-01 16:53:33','2026-01-01 16:54:06');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'file_system_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-01 17:19:31
