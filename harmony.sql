CREATE DATABASE  IF NOT EXISTS `harmony` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `harmony`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: harmony
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.13-MariaDB

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
-- Table structure for table `hs_invoice`
--

DROP TABLE IF EXISTS `hs_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_invoice` (
  `invc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_total` decimal(38,2) NOT NULL,
  `invoice_datetime` datetime NOT NULL,
  `invoice_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid_amt` decimal(38,2) NOT NULL,
  `return_amt` decimal(38,2) NOT NULL,
  PRIMARY KEY (`invc_id`),
  UNIQUE KEY `hs_invoice_invoice_no_unique` (`invoice_no`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_invoice`
--

LOCK TABLES `hs_invoice` WRITE;
/*!40000 ALTER TABLE `hs_invoice` DISABLE KEYS */;
INSERT INTO `hs_invoice` VALUES (1,44000.00,'2020-10-24 00:00:00',NULL,'INACTIVE',0.00,0.00),(2,4000.00,'2020-10-25 00:00:00','IV00000001','ACTIVE',5000.00,1000.00),(3,160000.00,'2020-10-25 00:00:00','IV00000002','ACTIVE',160000.00,0.00),(4,160000.00,'2020-10-25 00:00:00','IV00000003','ACTIVE',160000.00,0.00),(5,8000.00,'2020-10-25 00:00:00','IV00000004','ACTIVE',20000.00,12000.00),(6,8000.00,'2020-10-25 00:00:00','IV00000005','ACTIVE',10000.00,2000.00),(7,8000.00,'2020-10-25 00:00:00','IV00000006','ACTIVE',10000.00,2000.00),(8,16000.00,'2020-10-25 00:00:00','IV00000007','ACTIVE',20000.00,4000.00),(9,8000.00,'2020-10-25 00:00:00','IV00000009','ACTIVE',20000.00,12000.00),(10,8000.00,'2020-10-25 00:00:00','IV00000008','ACTIVE',10000.00,2000.00),(11,16000.00,'2020-10-25 00:00:00','IV00000010','ACTIVE',20000.00,4000.00),(12,49000.00,'2020-10-25 00:00:00','IV00000011','ACTIVE',100000.00,49000.00),(13,15000.00,'2020-10-29 00:00:00','IV00000012','ACTIVE',20000.00,5000.00),(14,22000.00,'2020-10-29 00:00:00','IV00000013','ACTIVE',30000.00,8000.00),(15,5000.00,'2020-10-31 00:00:00','IV00000014','ACTIVE',10000.00,5000.00),(16,5000.00,'2020-10-31 00:00:00','IV00000015','ACTIVE',10000.00,5000.00),(17,10000.00,'2020-10-31 00:00:00','IV00000016','ACTIVE',20000.00,10000.00),(18,14000.00,'2020-11-07 00:00:00','IV00000017','ACTIVE',20000.00,6000.00);
/*!40000 ALTER TABLE `hs_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_invoice_detail`
--

DROP TABLE IF EXISTS `hs_invoice_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_invoice_detail` (
  `ivdt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invc_id` int(10) unsigned NOT NULL,
  `quantity` decimal(21,2) NOT NULL,
  `price` decimal(38,2) NOT NULL,
  `sub_total` decimal(38,2) NOT NULL,
  `itdt_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ivdt_id`),
  KEY `hs_invoice_detail_invc_id_foreign` (`invc_id`),
  KEY `itdt_id` (`itdt_id`),
  CONSTRAINT `hs_invoice_detail_ibfk_1` FOREIGN KEY (`itdt_id`) REFERENCES `hs_item_detail` (`itdt_id`),
  CONSTRAINT `hs_invoice_detail_invc_id_foreign` FOREIGN KEY (`invc_id`) REFERENCES `hs_invoice` (`invc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_invoice_detail`
--

LOCK TABLES `hs_invoice_detail` WRITE;
/*!40000 ALTER TABLE `hs_invoice_detail` DISABLE KEYS */;
INSERT INTO `hs_invoice_detail` VALUES (2,1,2.00,2000.00,4000.00,5),(3,1,5.00,8000.00,40000.00,4),(7,2,2.00,2000.00,4000.00,5),(8,3,20.00,8000.00,160000.00,4),(9,4,20.00,8000.00,160000.00,4),(10,5,1.00,8000.00,8000.00,4),(11,6,1.00,8000.00,8000.00,4),(15,7,1.00,8000.00,8000.00,4),(16,8,2.00,8000.00,16000.00,4),(17,10,1.00,8000.00,8000.00,4),(18,9,1.00,8000.00,8000.00,4),(19,11,2.00,8000.00,16000.00,4),(20,12,3.00,8000.00,24000.00,4),(21,12,5.00,5000.00,25000.00,3),(22,13,1.00,2000.00,2000.00,5),(23,13,1.00,8000.00,8000.00,4),(24,13,1.00,5000.00,5000.00,3),(25,14,1.00,5000.00,5000.00,6),(26,14,2.00,2000.00,4000.00,5),(27,14,1.00,8000.00,8000.00,4),(28,14,1.00,5000.00,5000.00,3),(29,15,1.00,5000.00,5000.00,6),(30,16,1.00,5000.00,5000.00,6),(31,17,2.00,5000.00,10000.00,6),(35,18,2.00,5000.00,10000.00,6),(36,18,2.00,2000.00,4000.00,5);
/*!40000 ALTER TABLE `hs_invoice_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_invoice_log`
--

DROP TABLE IF EXISTS `hs_invoice_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_invoice_log` (
  `ivlg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invc_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`ivlg_id`),
  KEY `hs_invoice_log_invc_id_foreign` (`invc_id`),
  KEY `hs_invoice_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_invoice_log_invc_id_foreign` FOREIGN KEY (`invc_id`) REFERENCES `hs_invoice` (`invc_id`),
  CONSTRAINT `hs_invoice_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_invoice_log`
--

LOCK TABLES `hs_invoice_log` WRITE;
/*!40000 ALTER TABLE `hs_invoice_log` DISABLE KEYS */;
INSERT INTO `hs_invoice_log` VALUES (1,1,'STORE',1,'2020-10-24 19:18:58'),(2,1,'EDIT',1,'2020-10-24 21:04:48'),(3,1,'TERMINATE',1,'2020-10-24 21:05:57'),(4,2,'STORE',1,'2020-10-25 10:40:01'),(5,2,'EDIT',1,'2020-10-25 16:38:37'),(7,2,'EDIT',1,'2020-10-25 20:11:06'),(8,3,'STORE',1,'2020-10-25 20:27:01'),(9,4,'STORE',1,'2020-10-25 20:27:40'),(10,5,'STORE',1,'2020-10-25 20:32:51'),(11,6,'STORE',1,'2020-10-25 20:36:54'),(12,7,'STORE',1,'2020-10-25 20:37:35'),(13,8,'STORE',1,'2020-10-25 20:39:09'),(14,9,'STORE',1,'2020-10-25 20:40:25'),(15,7,'EDIT',1,'2020-10-25 20:49:05'),(16,8,'EDIT',1,'2020-10-25 20:49:45'),(17,10,'STORE',1,'2020-10-25 20:50:17'),(18,9,'EDIT',1,'2020-10-25 20:55:57'),(19,11,'STORE',1,'2020-10-25 20:56:49'),(20,12,'STORE',1,'2020-10-25 20:57:26'),(21,13,'STORE',1,'2020-10-29 15:09:14'),(22,14,'STORE',1,'2020-10-29 15:10:30'),(23,15,'STORE',1,'2020-10-31 17:12:12'),(24,16,'STORE',1,'2020-10-31 17:20:56'),(25,17,'STORE',5,'2020-10-31 19:29:25'),(26,18,'STORE',5,'2020-11-07 10:39:24'),(27,18,'EDIT',5,'2020-11-07 10:41:29'),(28,18,'EDIT',5,'2020-11-07 10:41:48');
/*!40000 ALTER TABLE `hs_invoice_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_category`
--

DROP TABLE IF EXISTS `hs_item_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_category` (
  `itcg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`itcg_id`),
  UNIQUE KEY `hs_item_category_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_category`
--

LOCK TABLES `hs_item_category` WRITE;
/*!40000 ALTER TABLE `hs_item_category` DISABLE KEYS */;
INSERT INTO `hs_item_category` VALUES (2,'CG00000001','Makanan123','Makanan123','INACTIVE'),(3,'CG00000002','Makanan','Kategori Makanan','ACTIVE'),(4,'CG00000003','Minuman','Kategori Minuman','ACTIVE');
/*!40000 ALTER TABLE `hs_item_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_category_log`
--

DROP TABLE IF EXISTS `hs_item_category_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_category_log` (
  `itcl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itcg_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`itcl_id`),
  KEY `hs_item_category_log_itcg_id_foreign` (`itcg_id`),
  KEY `hs_item_category_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_item_category_log_itcg_id_foreign` FOREIGN KEY (`itcg_id`) REFERENCES `hs_item_category` (`itcg_id`),
  CONSTRAINT `hs_item_category_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_category_log`
--

LOCK TABLES `hs_item_category_log` WRITE;
/*!40000 ALTER TABLE `hs_item_category_log` DISABLE KEYS */;
INSERT INTO `hs_item_category_log` VALUES (1,2,'STORE',1,'2020-09-15 23:05:16'),(2,2,'EDIT',1,'2020-09-15 23:12:22'),(3,2,'TERMINATE',1,'2020-09-15 23:12:27'),(4,2,'EDIT',1,'2020-09-15 23:12:37'),(5,2,'TERMINATE',1,'2020-09-15 23:15:08'),(6,3,'STORE',1,'2020-09-21 20:21:35'),(7,4,'STORE',1,'2020-09-21 20:36:28');
/*!40000 ALTER TABLE `hs_item_category_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_detail`
--

DROP TABLE IF EXISTS `hs_item_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_detail` (
  `itdt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(38,2) NOT NULL,
  `splr_id` int(10) unsigned NOT NULL,
  `itcg_id` int(10) unsigned NOT NULL,
  `quantity` decimal(21,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ituo_id` int(10) unsigned NOT NULL,
  `net_pct` decimal(38,2) DEFAULT NULL,
  `net_price` decimal(38,2) DEFAULT NULL,
  PRIMARY KEY (`itdt_id`),
  UNIQUE KEY `hs_item_detail_code_unique` (`code`),
  KEY `hs_item_detail_splr_id_foreign` (`splr_id`),
  KEY `hs_item_detail_itcg_id_foreign` (`itcg_id`),
  KEY `ituo_id` (`ituo_id`),
  CONSTRAINT `hs_item_detail_ibfk_1` FOREIGN KEY (`ituo_id`) REFERENCES `hs_item_uom` (`ituo_id`),
  CONSTRAINT `hs_item_detail_itcg_id_foreign` FOREIGN KEY (`itcg_id`) REFERENCES `hs_item_category` (`itcg_id`),
  CONSTRAINT `hs_item_detail_splr_id_foreign` FOREIGN KEY (`splr_id`) REFERENCES `hs_supplier` (`splr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_detail`
--

LOCK TABLES `hs_item_detail` WRITE;
/*!40000 ALTER TABLE `hs_item_detail` DISABLE KEYS */;
INSERT INTO `hs_item_detail` VALUES (3,'IT00000001','Cocal cola','minuman gas',5000.00,6,4,193.00,'2020-09-26 09:49:10','2020-10-12 13:58:33','ACTIVE',2,10.00,5500.00),(4,'IT00000002','Minuman123','Picture 2',8000.00,6,4,6.00,'2020-10-20 13:42:47','2020-10-20 13:43:29','ACTIVE',2,20.00,9600.00),(5,'IT00000003','Recheese','ayam go',2000.00,5,3,19976.00,'2020-10-21 12:32:24',NULL,'ACTIVE',2,0.00,2000.00),(6,'IT00000004','jus','minumas siryp',5000.00,5,4,1993.00,'2020-10-29 08:09:59',NULL,'ACTIVE',2,2.00,5100.00);
/*!40000 ALTER TABLE `hs_item_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_detail_log`
--

DROP TABLE IF EXISTS `hs_item_detail_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_detail_log` (
  `itdl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itdt_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`itdl_id`),
  KEY `hs_item_detail_log_itdt_id_foreign` (`itdt_id`),
  KEY `hs_item_detail_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_item_detail_log_itdt_id_foreign` FOREIGN KEY (`itdt_id`) REFERENCES `hs_item_detail` (`itdt_id`),
  CONSTRAINT `hs_item_detail_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_detail_log`
--

LOCK TABLES `hs_item_detail_log` WRITE;
/*!40000 ALTER TABLE `hs_item_detail_log` DISABLE KEYS */;
INSERT INTO `hs_item_detail_log` VALUES (3,3,'STORE',1,'2020-09-26 16:49:10'),(4,3,'EDIT',1,'2020-09-26 19:07:52'),(5,3,'TERMINATE',1,'2020-09-26 19:08:12'),(6,3,'EDIT',1,'2020-09-26 19:08:25'),(7,4,'STORE',1,'2020-10-20 20:42:47'),(8,4,'EDIT',1,'2020-10-20 20:43:29'),(9,5,'STORE',1,'2020-10-21 19:32:24'),(10,6,'STORE',1,'2020-10-29 15:09:59');
/*!40000 ALTER TABLE `hs_item_detail_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_stock_log`
--

DROP TABLE IF EXISTS `hs_item_stock_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_stock_log` (
  `itsk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itdt_id` int(10) unsigned NOT NULL,
  `original_quantity` decimal(21,2) NOT NULL,
  `add_quantity` decimal(21,2) NOT NULL,
  `min_quantity` decimal(21,2) NOT NULL,
  `prdt_id` int(10) unsigned DEFAULT NULL,
  `ivdt_id` int(10) unsigned DEFAULT NULL,
  `change_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `change_time` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `new_quantity` decimal(21,2) DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`itsk_id`),
  KEY `hs_item_stock_log_itdt_id_foreign` (`itdt_id`),
  KEY `hs_item_stock_log_prdt_id_foreign` (`prdt_id`),
  KEY `hs_item_stock_log_ivdt_id_foreign` (`ivdt_id`),
  KEY `hs_item_stock_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_item_stock_log_itdt_id_foreign` FOREIGN KEY (`itdt_id`) REFERENCES `hs_item_detail` (`itdt_id`),
  CONSTRAINT `hs_item_stock_log_ivdt_id_foreign` FOREIGN KEY (`ivdt_id`) REFERENCES `hs_invoice_detail` (`ivdt_id`),
  CONSTRAINT `hs_item_stock_log_prdt_id_foreign` FOREIGN KEY (`prdt_id`) REFERENCES `hs_purchase_detail` (`prdt_id`),
  CONSTRAINT `hs_item_stock_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_stock_log`
--

LOCK TABLES `hs_item_stock_log` WRITE;
/*!40000 ALTER TABLE `hs_item_stock_log` DISABLE KEYS */;
INSERT INTO `hs_item_stock_log` VALUES (1,3,0.00,500.00,0.00,NULL,NULL,'NEWITEM','2020-09-26 16:49:10',1,500.00,''),(7,3,500.00,10.00,0.00,NULL,NULL,'EDITITEM','2020-10-12 20:58:16',1,510.00,'123'),(8,3,510.00,0.00,310.00,NULL,NULL,'EDITITEM','2020-10-12 20:58:33',1,200.00,'test kurang'),(9,4,0.00,60.00,0.00,NULL,NULL,'NEWITEM','2020-10-20 20:42:47',1,60.00,'Buat Item Baru'),(10,5,0.00,50.00,0.00,NULL,NULL,'NEWITEM','2020-10-21 19:32:24',1,50.00,'Buat Item Baru'),(11,3,200.00,8.00,0.00,9,NULL,'PURCHASE','2020-10-23 19:41:12',1,208.00,'Transaksi pembelian item pada PO: PO00000001'),(12,4,60.00,1.00,0.00,10,NULL,'PURCHASE','2020-10-23 19:41:12',1,61.00,'Transaksi pembelian item pada PO: PO00000001'),(13,5,50.00,5.00,0.00,12,NULL,'PURCHASE','2020-10-23 19:47:03',1,55.00,'Transaksi pembelian item pada PO: PO00000002'),(14,3,200.00,2.00,0.00,13,NULL,'PURCHASE','2020-10-25 14:53:25',1,202.00,'Transaksi pembelian item pada PO: PO00000003'),(15,5,50.00,0.00,2.00,NULL,7,'SALES','2020-10-25 20:11:06',1,-48.00,'Transaksi penjualan item pada IV: IV00000001'),(16,4,60.00,0.00,20.00,NULL,8,'SALES','2020-10-25 20:27:01',1,40.00,'Transaksi penjualan item pada IV: IV00000002'),(17,4,40.00,0.00,20.00,NULL,9,'SALES','2020-10-25 20:27:40',1,20.00,'Transaksi penjualan item pada IV: IV00000003'),(18,4,20.00,0.00,1.00,NULL,10,'SALES','2020-10-25 20:32:51',1,19.00,'Transaksi penjualan item pada IV: IV00000004'),(19,4,19.00,0.00,1.00,NULL,11,'SALES','2020-10-25 20:36:54',1,18.00,'Transaksi penjualan item pada IV: IV00000005'),(20,4,18.00,0.00,1.00,NULL,15,'SALES','2020-10-25 20:49:05',1,17.00,'Transaksi penjualan item pada IV: IV00000006'),(21,4,17.00,0.00,2.00,NULL,16,'SALES','2020-10-25 20:49:45',1,15.00,'Transaksi penjualan item pada IV: IV00000007'),(22,4,15.00,0.00,1.00,NULL,17,'SALES','2020-10-25 20:50:17',1,14.00,'Transaksi penjualan item pada IV: IV00000008'),(23,4,14.00,0.00,1.00,NULL,18,'SALES','2020-10-25 20:55:57',1,13.00,'Transaksi penjualan item pada IV: IV00000009'),(24,4,13.00,0.00,2.00,NULL,19,'SALES','2020-10-25 20:56:50',1,11.00,'Transaksi penjualan item pada IV: IV00000010'),(25,4,11.00,0.00,3.00,NULL,20,'SALES','2020-10-25 20:57:26',1,8.00,'Transaksi penjualan item pada IV: IV00000011'),(26,3,200.00,0.00,5.00,NULL,21,'SALES','2020-10-25 20:57:26',1,195.00,'Transaksi penjualan item pada IV: IV00000011'),(27,5,-48.00,29.00,0.00,14,NULL,'PURCHASE','2020-10-29 15:02:02',1,-19.00,'Transaksi pembelian item pada PO: PO00000004'),(28,5,-19.00,20000.00,0.00,15,NULL,'PURCHASE','2020-10-29 15:08:25',1,19981.00,'Transaksi pembelian item pada PO: PO00000005'),(29,5,19981.00,0.00,1.00,NULL,22,'SALES','2020-10-29 15:09:14',1,19980.00,'Transaksi penjualan item pada IV: IV00000012'),(30,4,8.00,0.00,1.00,NULL,23,'SALES','2020-10-29 15:09:14',1,7.00,'Transaksi penjualan item pada IV: IV00000012'),(31,3,195.00,0.00,1.00,NULL,24,'SALES','2020-10-29 15:09:14',1,194.00,'Transaksi penjualan item pada IV: IV00000012'),(32,6,0.00,2000.00,0.00,NULL,NULL,'NEWITEM','2020-10-29 15:10:00',1,2000.00,'Buat Item Baru'),(33,6,2000.00,0.00,1.00,NULL,25,'SALES','2020-10-29 15:10:30',1,1999.00,'Transaksi penjualan item pada IV: IV00000013'),(34,5,19980.00,0.00,2.00,NULL,26,'SALES','2020-10-29 15:10:30',1,19978.00,'Transaksi penjualan item pada IV: IV00000013'),(35,4,7.00,0.00,1.00,NULL,27,'SALES','2020-10-29 15:10:30',1,6.00,'Transaksi penjualan item pada IV: IV00000013'),(36,3,194.00,0.00,1.00,NULL,28,'SALES','2020-10-29 15:10:30',1,193.00,'Transaksi penjualan item pada IV: IV00000013'),(37,6,1999.00,0.00,1.00,NULL,29,'SALES','2020-10-31 17:12:12',1,1998.00,'Transaksi penjualan item pada IV: IV00000014'),(38,6,1998.00,0.00,1.00,NULL,30,'SALES','2020-10-31 17:20:56',1,1997.00,'Transaksi penjualan item pada IV: IV00000015'),(39,6,1997.00,0.00,2.00,NULL,31,'SALES','2020-10-31 19:29:25',5,1995.00,'Transaksi penjualan item pada IV: IV00000016'),(40,6,1995.00,0.00,2.00,NULL,35,'SALES','2020-11-07 10:41:49',5,1993.00,'Transaksi penjualan item pada IV: IV00000017'),(41,5,19978.00,0.00,2.00,NULL,36,'SALES','2020-11-07 10:41:49',5,19976.00,'Transaksi penjualan item pada IV: IV00000017');
/*!40000 ALTER TABLE `hs_item_stock_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_uom`
--

DROP TABLE IF EXISTS `hs_item_uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_uom` (
  `ituo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ituo_id`),
  UNIQUE KEY `hs_item_uom_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_uom`
--

LOCK TABLES `hs_item_uom` WRITE;
/*!40000 ALTER TABLE `hs_item_uom` DISABLE KEYS */;
INSERT INTO `hs_item_uom` VALUES (1,'KG','Kilogram aw','INACTIVE'),(2,'PCS','Jenis Kilogram','ACTIVE');
/*!40000 ALTER TABLE `hs_item_uom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_item_uom_log`
--

DROP TABLE IF EXISTS `hs_item_uom_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_item_uom_log` (
  `itul_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ituo_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`itul_id`),
  KEY `hs_item_uom_log_ituo_id_foreign` (`ituo_id`),
  KEY `hs_item_uom_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_item_uom_log_ituo_id_foreign` FOREIGN KEY (`ituo_id`) REFERENCES `hs_item_uom` (`ituo_id`),
  CONSTRAINT `hs_item_uom_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_item_uom_log`
--

LOCK TABLES `hs_item_uom_log` WRITE;
/*!40000 ALTER TABLE `hs_item_uom_log` DISABLE KEYS */;
INSERT INTO `hs_item_uom_log` VALUES (1,1,'STORE',1,'2020-09-15 22:25:01'),(2,1,'EDIT',1,'2020-09-15 22:44:54'),(3,1,'EDIT',1,'2020-09-15 22:45:03'),(4,1,'TERMINATE',1,'2020-09-15 22:45:22'),(5,1,'TERMINATE',1,'2020-09-15 23:13:08'),(6,2,'STORE',1,'2020-09-21 21:21:39');
/*!40000 ALTER TABLE `hs_item_uom_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_purchase`
--

DROP TABLE IF EXISTS `hs_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_purchase` (
  `prch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `splr_id` int(10) unsigned NOT NULL,
  `sub_total` decimal(38,2) NOT NULL,
  `purchase_datetime` datetime NOT NULL,
  `po_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`prch_id`),
  UNIQUE KEY `hs_purchase_po_no_unique` (`po_no`),
  KEY `hs_purchase_splr_id_foreign` (`splr_id`),
  CONSTRAINT `hs_purchase_splr_id_foreign` FOREIGN KEY (`splr_id`) REFERENCES `hs_supplier` (`splr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_purchase`
--

LOCK TABLES `hs_purchase` WRITE;
/*!40000 ALTER TABLE `hs_purchase` DISABLE KEYS */;
INSERT INTO `hs_purchase` VALUES (25,6,48000.00,'2020-10-20 00:00:00','PO00000001','ACTIVE'),(26,5,4000.00,'2020-10-23 00:00:00',NULL,'INACTIVE'),(27,5,10000.00,'2020-10-16 00:00:00','PO00000002','ACTIVE'),(28,6,10000.00,'2020-10-25 00:00:00','PO00000003','ACTIVE'),(29,5,58000.00,'2020-10-29 00:00:00','PO00000004','ACTIVE'),(30,5,40000.00,'2020-10-15 00:00:00','PO00000005','ACTIVE');
/*!40000 ALTER TABLE `hs_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_purchase_detail`
--

DROP TABLE IF EXISTS `hs_purchase_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_purchase_detail` (
  `prdt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prch_id` int(10) unsigned NOT NULL,
  `itdt_id` int(10) unsigned NOT NULL,
  `quantity` decimal(21,2) NOT NULL,
  `sub_total` decimal(38,2) NOT NULL,
  `price` decimal(38,2) DEFAULT NULL,
  PRIMARY KEY (`prdt_id`),
  KEY `hs_purchase_detail_prch_id_foreign` (`prch_id`),
  KEY `hs_purchase_detail_itdt_id_foreign` (`itdt_id`),
  CONSTRAINT `hs_purchase_detail_itdt_id_foreign` FOREIGN KEY (`itdt_id`) REFERENCES `hs_item_detail` (`itdt_id`),
  CONSTRAINT `hs_purchase_detail_prch_id_foreign` FOREIGN KEY (`prch_id`) REFERENCES `hs_purchase` (`prch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_purchase_detail`
--

LOCK TABLES `hs_purchase_detail` WRITE;
/*!40000 ALTER TABLE `hs_purchase_detail` DISABLE KEYS */;
INSERT INTO `hs_purchase_detail` VALUES (9,25,3,8.00,40000.00,5000.00),(10,25,4,1.00,8000.00,8000.00),(11,26,5,2.00,4000.00,2000.00),(12,27,5,5.00,10000.00,2000.00),(13,28,3,2.00,10000.00,5000.00),(14,29,5,29.00,58000.00,2000.00),(15,30,5,20000.00,40000.00,2000.00);
/*!40000 ALTER TABLE `hs_purchase_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_purchase_log`
--

DROP TABLE IF EXISTS `hs_purchase_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_purchase_log` (
  `prlg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prch_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`prlg_id`),
  KEY `hs_purchase_log_prch_id_foreign` (`prch_id`),
  KEY `hs_purchase_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_purchase_log_prch_id_foreign` FOREIGN KEY (`prch_id`) REFERENCES `hs_purchase` (`prch_id`),
  CONSTRAINT `hs_purchase_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_purchase_log`
--

LOCK TABLES `hs_purchase_log` WRITE;
/*!40000 ALTER TABLE `hs_purchase_log` DISABLE KEYS */;
INSERT INTO `hs_purchase_log` VALUES (1,25,'STORE',1,'2020-10-20 22:17:28'),(2,25,'EDIT',1,'2020-10-23 18:10:33'),(3,25,'EDIT',1,'2020-10-23 18:11:43'),(19,25,'EDIT',1,'2020-10-23 19:41:12'),(20,26,'STORE',1,'2020-10-23 19:41:51'),(21,26,'TERMINATE',1,'2020-10-23 19:45:19'),(22,27,'STORE',1,'2020-10-23 19:46:55'),(23,27,'EDIT',1,'2020-10-23 19:47:03'),(24,28,'STORE',1,'2020-10-25 14:53:16'),(25,28,'EDIT',1,'2020-10-25 14:53:25'),(26,29,'STORE',1,'2020-10-29 15:01:27'),(27,29,'EDIT',1,'2020-10-29 15:02:02'),(28,30,'STORE',1,'2020-10-29 15:03:17'),(34,30,'EDIT',1,'2020-10-29 15:08:25');
/*!40000 ALTER TABLE `hs_purchase_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_supplier`
--

DROP TABLE IF EXISTS `hs_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_supplier` (
  `splr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp_no` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_1` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_3` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name_1` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name_2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name_3` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`splr_id`),
  UNIQUE KEY `hs_supplier_code_unique` (`code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_supplier`
--

LOCK TABLES `hs_supplier` WRITE;
/*!40000 ALTER TABLE `hs_supplier` DISABLE KEYS */;
INSERT INTO `hs_supplier` VALUES (2,'SP00000001','Sunware Solutions Hongkong','Jln. Bridgen Katamo No. 8',NULL,NULL,NULL,'077120715','081372647955',NULL,NULL,'INACTIVE','Steven',NULL,NULL,NULL),(5,'SP00000002','Velocity Solutions','tanjung pinang',NULL,NULL,NULL,'077120715','081372647955','081372647955',NULL,'ACTIVE','steven','steven',NULL,'steven.yeo@velocity-solutions.com'),(6,'SP00000003','Suzy Bae','123',NULL,NULL,NULL,'077120769','456789876545','456789876545',NULL,'ACTIVE','Suzy','Suzy',NULL,'suzybae8@gmail.com');
/*!40000 ALTER TABLE `hs_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_supplier_log`
--

DROP TABLE IF EXISTS `hs_supplier_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_supplier_log` (
  `splg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `splr_id` int(10) unsigned NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_date_time` datetime NOT NULL,
  PRIMARY KEY (`splg_id`),
  KEY `hs_supplier_log_splr_id_foreign` (`splr_id`),
  KEY `hs_supplier_log_user_id_foreign` (`user_id`),
  CONSTRAINT `hs_supplier_log_splr_id_foreign` FOREIGN KEY (`splr_id`) REFERENCES `hs_supplier` (`splr_id`),
  CONSTRAINT `hs_supplier_log_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `hs_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_supplier_log`
--

LOCK TABLES `hs_supplier_log` WRITE;
/*!40000 ALTER TABLE `hs_supplier_log` DISABLE KEYS */;
INSERT INTO `hs_supplier_log` VALUES (1,2,'STORE',1,'2020-09-13 15:53:27'),(2,5,'STORE',1,'2020-09-13 16:08:00'),(3,6,'STORE',1,'2020-09-13 16:18:27'),(4,2,'EDIT',1,'2020-09-13 19:09:24'),(5,2,'EDIT',1,'2020-09-13 19:09:50'),(6,2,'TERMINATE',1,'2020-09-13 19:14:32');
/*!40000 ALTER TABLE `hs_supplier_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hs_user`
--

DROP TABLE IF EXISTS `hs_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hs_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_admin` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `hs_user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hs_user`
--

LOCK TABLES `hs_user` WRITE;
/*!40000 ALTER TABLE `hs_user` DISABLE KEYS */;
INSERT INTO `hs_user` VALUES (1,'admin','stevenyeo70@gmail.com','081372647955','$2y$10$fh3/fLjAepR0FhgI7iTBTeWODyO/jWzBfVOUMcqomRDpwFuEvit/G',NULL,NULL,'YES','ACTIVE','clR6fKf79ydX9BnCqYWNpQfjzLijWn0p0o9MvOKWi4hh8XZHLqgWggrTaYqe','2020-08-21 09:36:41','2020-09-05 01:15:04'),(2,'sibel99','shintabella1403@gmail.com','4567890456789','$2y$10$ugDYcY02bFH6TZ7ywaHoY.Wa7AlOZTGf3HDs.Q1PTQS41xwazx3Uy',1,NULL,'NO','INACTIVE',NULL,'2020-09-03 08:37:34','2020-09-05 14:39:18'),(3,'sibel992','loseruib@gmail.com','1232131231321231','$2y$10$ztTNaAls7hEaGvYPTnp6IOJZMElLrRCJhDr1aiC912re9Vvj/cFka',1,NULL,'NO','INACTIVE',NULL,'2020-09-05 01:15:59','2020-09-05 09:49:15'),(4,'steven','steby.yeo@gmail.com','081372647955','$2y$10$nB8TZ7i6S8ezYbJBXa2creli0MVY8i2XSCrabOVH4QrvzNVfrGhge',1,1,'NO','ACTIVE',NULL,'2020-09-13 08:44:41','2020-10-26 13:09:41'),(5,'boss','stevenmaildeveloper@gmail.com','081372647955','$2y$10$fh3/fLjAepR0FhgI7iTBTeWODyO/jWzBfVOUMcqomRDpwFuEvit/G',NULL,NULL,'YESNO','ACTIVE',NULL,'2020-10-31 10:15:35',NULL),(6,'Shinta Bella','stefy.yang@gmail.com','08213819212131','$2y$10$Yjek4Bx504Q.AXXliglg6u2Xjmh2p2ywf.OgC1u4jr3weKZppZA22',5,5,'YES','ACTIVE',NULL,'2020-11-07 03:38:25','2020-11-07 03:38:45');
/*!40000 ALTER TABLE `hs_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (51,'2014_10_12_000000_create_users_table',1),(52,'2014_10_12_100000_create_password_resets_table',1),(53,'2020_08_15_064731_create_hs_suppliers_table',1),(54,'2020_08_16_123707_create_hs_supplier_logs_table',1),(55,'2020_08_16_124318_create_hs_item_categories_table',1),(56,'2020_08_16_124454_create_hs_item_category_logs_table',1),(57,'2020_08_16_124852_create_hs_item_details_table',1),(58,'2020_08_16_125410_create_hs_item_detail_logs_table',1),(59,'2020_08_16_125859_create_hs_purchases_table',1),(60,'2020_08_16_130124_create_hs_purchase_details_table',1),(61,'2020_08_16_130436_create_hs_purchase_logs_table',1),(62,'2020_08_16_130735_create_hs_invoices_table',1),(63,'2020_08_16_131054_create_hs_invoice_details_table',1),(64,'2020_08_16_131252_create_hs_invoice_logs_table',1),(65,'2020_08_16_131550_create_hs_item_stock_logs_table',1),(66,'2020_09_13_203814_create_hs_item_uom',2),(67,'2020_09_13_204044_create_hs_item_uom_log_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('stevenyeo70@gmail.com','$2y$10$W9vtHwBWRcEuCU1sHD1RmOGs8cdeSrrXfJhzaTRmyRVJ/eWvmMfiG','2020-09-05 15:15:15'),('shintabella1403@gmail.com','$2y$10$wj.tpn/T0KnZ6veH.M.mE.x7/xDWm34z.7tZLUBgPxzURVppZkhJG','2020-09-05 15:17:01');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'harmony'
--

--
-- Dumping routines for database 'harmony'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-07 10:49:45
