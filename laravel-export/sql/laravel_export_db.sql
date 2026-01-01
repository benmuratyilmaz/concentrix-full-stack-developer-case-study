-- MySQL dump 10.13  Distrib 9.3.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: laravel_export_db
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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warranty_period` int NOT NULL,
  `list_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int NOT NULL DEFAULT '0',
  `on_sale` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_barcode_unique` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Kablosuz Mouse','2.4Ghz USB alıcılı, 1600 DPI ergonomik mouse.','8690000000001',24,499.90,399.90,120,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(2,1,'Mekanik Klavye','Kırmızı switch, RGB aydınlatma, TR-Q düzen.','8690000000002',24,1899.00,1699.00,45,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(3,1,'27\" IPS Monitör','2K çözünürlük, 75Hz, IPS panel, ince çerçeve.','8690000000003',24,5999.00,0.00,18,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(4,1,'USB-C Şarj Kablosu 1m','Örgülü, hızlı şarj destekli Type-C kablo.','8690000000004',12,149.90,99.90,300,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(5,1,'USB-C Şarj Adaptörü 20W','PD destekli hızlı şarj adaptörü.','8690000000005',24,399.90,349.90,160,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(6,1,'Bluetooth Kulaklık TWS','Dokunmatik kontrol, şarj kutulu, ANC destekli.','8690000000006',24,1299.00,1099.00,70,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(7,1,'Powerbank 10000mAh','Çift USB çıkış, Type-C giriş, hızlı şarj destekli.','8690000000007',24,899.90,799.90,95,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(8,1,'HDMI Kablo 2m','4K 60Hz destekli, altın uçlu HDMI kablo.','8690000000008',12,199.90,0.00,220,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(9,1,'Laptop Standı Alüminyum','Yüksekliği ayarlanabilir, ısı dağıtıcı tasarım.','8690000000009',12,699.00,599.00,60,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(10,1,'USB Hub 4 Port','USB 3.0 destekli, 4 port çoğaltıcı.','8690000000010',24,549.90,499.90,110,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(11,1,'Klavye-Mouse Seti','Kablosuz, sessiz tuşlar, USB nano alıcı.','8690000000011',24,999.00,899.00,75,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(12,1,'Ekran Temizleme Spreyi','200ml, iz bırakmayan ekran temizleyici.','8690000000012',0,129.90,0.00,250,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(13,1,'Ethernet Kablo Cat6 10m','Gigabit destekli, Cat6 ağ kablosu.','8690000000013',12,249.90,199.90,140,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(14,1,'Akıllı Priz Wi-Fi','Uygulama kontrolü, zamanlayıcı, enerji takibi.','8690000000014',24,699.90,649.90,55,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(15,1,'LED Masa Lambası','3 renk modu, dokunmatik kontrol, USB güç.','8690000000015',24,899.00,0.00,40,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(16,1,'Webcam Full HD','1080p, dahili mikrofon, otomatik ışık ayarı.','8690000000016',24,1499.00,1299.00,35,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(17,1,'Bluetooth Hoparlör','Taşınabilir, su sıçramasına dayanıklı, 10 saat pil.','8690000000017',24,1199.00,999.00,48,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(18,1,'Taşınabilir SSD 1TB','USB 3.2, 1000MB/s okuma, şok dayanımı.','8690000000018',36,4499.00,4299.00,22,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(19,1,'Kablolu Kulaklık','3.5mm jack, mikrofonlu, hafif tasarım.','8690000000019',24,399.90,0.00,130,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(20,1,'Type-C to HDMI Dönüştürücü','4K görüntü aktarımı, tak-çalıştır adaptör.','8690000000020',24,999.90,899.90,65,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(21,1,'Akıllı Saat','Nabız ölçer, uyku takibi, bildirim desteği.','8690000000021',24,2999.00,2799.00,28,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(22,1,'Oyun Mouse Pad XL','Kaymaz taban, geniş yüzey, dikişli kenar.','8690000000022',12,499.00,449.00,90,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(23,1,'Kablo Düzenleyici Set','Cırt kelepçe + spiral kablo toplayıcı seti.','8690000000023',0,149.00,0.00,400,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(24,1,'Akıllı Ampul','Wi-Fi, 16 milyon renk, uygulama kontrolü.','8690000000024',24,399.00,349.00,150,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(25,1,'Telefon Tripodu','Ayarlanabilir, uzaktan kumandalı, hafif tripod.','8690000000025',12,699.00,599.00,52,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(26,1,'Masaüstü Mikrofon','USB bağlantı, cardioid, yayın/konferans için.','8690000000026',24,2499.00,2299.00,25,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(27,1,'Laptop Çantası 15.6\"','Su itici kumaş, darbe emici bölme.','8690000000027',12,1299.00,0.00,70,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(28,1,'Akıllı Tartı','Vücut analizi, Bluetooth senkronizasyon.','8690000000028',24,999.00,899.00,44,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(29,1,'Air Fryer 5L','Yağsız pişirme, dijital ekran, 8 program.','8690000000029',24,4499.00,3999.00,16,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(30,1,'Filtre Kahve Makinesi','1.25L kapasite, zamanlayıcı, sıcak tutma.','8690000000030',24,3299.00,0.00,12,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(31,1,'Elektrikli Süpürge','Yüksek emiş gücü, HEPA filtre, 800W.','8690000000031',24,7999.00,7499.00,10,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(32,1,'Blender Seti','Çok amaçlı, 1000W, doğrayıcı ve çırpıcı başlıklı.','8690000000032',24,2999.00,2799.00,20,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(33,1,'Şarjlı Matkap','18V, çift akü, darbeli, taşıma çantalı.','8690000000033',24,4999.00,4699.00,14,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(34,1,'Akıllı Kapı Zili','Wi-Fi, hareket algılama, gece görüşü.','8690000000034',24,2999.00,0.00,9,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(35,1,'Router Wi-Fi 6','AX1800, çift bant, geniş kapsama alanı.','8690000000035',36,3999.00,3699.00,27,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(36,1,'Akım Korumalı Priz','6’lı, aşırı gerilim koruma, anahtarlı.','8690000000036',24,699.00,599.00,85,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(37,1,'Ofis Sandalyesi','Ergonomik, bel destekli, nefes alır kumaş.','8690000000037',24,6499.00,5999.00,8,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(38,1,'Masaüstü Organizer','Metal file, kalemlik ve evrak bölmeli.','8690000000038',0,349.00,0.00,140,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(39,1,'Termal Macun','Yüksek iletkenlik, CPU/GPU için 4g.','8690000000039',0,249.00,199.00,200,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(40,1,'Klavye Bilek Desteği','Jel dolgulu, kaymaz taban, konforlu destek.','8690000000040',12,399.00,0.00,95,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(41,1,'Telefon Kılıfı','Darbe emici, şeffaf, sararmaya dayanıklı.','8690000000041',6,249.90,199.90,260,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(42,1,'Ekran Koruyucu Cam','9H sertlik, tam kaplama temperli cam.','8690000000042',0,149.90,0.00,500,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(43,1,'Araç İçi Telefon Tutucu','Havalandırma ızgarası uyumlu, güçlü mıknatıs.','8690000000043',12,349.90,299.90,180,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(44,1,'Akıllı Ev Sensörü','Kapı/pencere sensörü, anlık bildirim.','8690000000044',24,499.90,0.00,77,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(45,1,'Elektrikli Diş Fırçası','3 mod, şarj standı, 2 başlık.','8690000000045',24,1799.00,1599.00,33,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(46,1,'Saç Kurutma Makinesi','2200W, iyon teknolojisi, 2 hız 3 ısı.','8690000000046',24,1999.00,0.00,21,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(47,1,'Mutfak Tartısı Dijital','5kg kapasite, hassas ölçüm, dara fonksiyonu.','8690000000047',12,499.00,449.00,58,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(48,0,'Stok Dışı Ürün (Demo)','Test amaçlı pasif ürün kaydı.','8690000000048',0,99.00,0.00,0,0,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(49,1,'Notebook Soğutucu','5 fanlı, sessiz çalışma, LED aydınlatma.','8690000000049',24,1499.00,1299.00,26,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(50,1,'Pratik El Aleti Seti','31 parça tornavida uç seti, mıknatıslı uç.','8690000000050',24,999.00,899.00,64,1,'2025-12-30 10:24:53','2025-12-30 10:24:53'),(51,0,'Kablosuz Mouse','Sessiz tıklama, 2.4GHz, 1600 DPI','8691234567890sasa',24,499.90,399.90,150,1,'2026-01-01 14:25:08','2026-01-01 14:26:14');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-01 20:37:02
