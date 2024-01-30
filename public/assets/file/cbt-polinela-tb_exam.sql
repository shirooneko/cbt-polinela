-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: nss.h.filess.io	Database: cbtpolinela_calljumpgo
-- ------------------------------------------------------
-- Server version 	8.0.29-21
-- Date: Mon, 08 Jan 2024 06:46:46 +0700

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tb_exam`
--

DROP TABLE IF EXISTS `tb_exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_exam` (
  `id_exam` int NOT NULL AUTO_INCREMENT,
  `nama_exam` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_matkul` int NOT NULL,
  `id_kelas` int NOT NULL,
  `id_sesi` int NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_exam` date NOT NULL,
  PRIMARY KEY (`id_exam`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_exam`
--

LOCK TABLES `tb_exam` WRITE;
/*!40000 ALTER TABLE `tb_exam` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `tb_exam` VALUES (37,'Test ujian batch 1',18,7,13,'18:50:00','22:54:00','expired','2024-01-07');
/*!40000 ALTER TABLE `tb_exam` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `tb_exam` with 1 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Mon, 08 Jan 2024 06:46:47 +0700
