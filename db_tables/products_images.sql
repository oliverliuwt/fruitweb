-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: data
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

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
-- Table structure for table `products_images`
--

DROP TABLE IF EXISTS `products_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_images` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`row_id`),
  KEY `product_id` (`product_id`),
  KEY `image_id` (`image_id`),
  CONSTRAINT `images_image_id` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`),
  CONSTRAINT `products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_images`
--

LOCK TABLES `products_images` WRITE;
/*!40000 ALTER TABLE `products_images` DISABLE KEYS */;
INSERT INTO `products_images` VALUES (1,65,1,1),(2,65,2,1),(3,66,3,1),(4,67,4,1),(5,68,5,1),(6,68,6,1),(7,69,7,1),(8,70,8,1),(9,71,9,1),(10,72,10,1),(11,73,11,1),(12,74,12,1),(13,75,13,1),(14,76,14,1),(15,77,16,1),(16,78,1,1),(17,79,2,1),(18,80,3,1),(19,81,4,1),(20,82,5,1),(21,83,6,1),(22,84,7,1),(23,85,8,1),(24,86,9,1),(25,87,10,1),(26,88,11,1),(27,90,12,1),(28,91,13,1),(29,92,14,1),(30,93,15,1),(31,94,16,1),(32,95,1,1),(33,96,2,1),(34,97,3,1),(35,98,4,1),(36,99,5,1),(37,100,6,1),(38,101,7,1),(39,102,8,1),(40,103,9,1),(41,104,10,1),(42,105,11,1),(43,106,12,1),(44,107,13,1),(45,108,14,1),(46,109,14,1),(47,110,15,1),(48,111,16,1),(49,112,1,1),(50,113,2,1),(51,114,3,1),(52,115,4,1),(53,116,5,1),(54,117,6,1),(55,118,7,1),(56,119,8,1),(57,120,9,1),(58,121,10,1),(59,123,11,1),(60,124,12,1),(61,125,13,1),(62,126,14,1),(63,127,15,1),(64,128,16,1),(65,129,1,1),(66,130,2,1),(67,131,3,1),(68,132,4,1),(69,134,5,1),(70,136,6,1),(71,137,7,1),(72,138,8,1),(73,139,9,1),(74,140,10,1),(75,140,11,1),(76,141,12,1),(77,142,13,1),(78,143,14,1),(79,144,15,1),(80,145,16,1),(81,146,1,1);
/*!40000 ALTER TABLE `products_images` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-20  3:37:29
