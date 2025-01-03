-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: clinicadental
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(75) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `sexo` char(1) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cedula` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'jorge','ramirez','elgamer-26@hotmail.com','0989376730','M','0940321854','mi casita','cliente.png',1),(2,'JORGE','RAMIREZ','CORREO','1234567890','M','0940321854','MILAGRO','IMG159202455.jpg',0),(3,'JOSE','ROJAS','ASAS','2121','F','0940321854','ASA','cliente.png',0),(4,'manuel','bonbo','as','1212','M','0940321854','qwqw','cliente.png',1);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `tipo_comprabante` char(10) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `iva` int DEFAULT NULL,
  `numero_factura` varchar(20) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `impuesto_sub` decimal(10,2) DEFAULT NULL,
  `total_pagar` decimal(10,2) DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  `id_usu` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
INSERT INTO `compra` VALUES (1,'2024-12-30','fac',12,'10',1.00,0.12,1.12,_binary '',1),(2,'2024-12-30','fac',12,'100',50.00,6.00,56.00,_binary '',1);
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_compra`
--

DROP TABLE IF EXISTS `detalle_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_compra` (
  `id_compra` int DEFAULT NULL,
  `id_pro` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  KEY `id_compra_idx` (`id_compra`),
  KEY `id_pro_idx` (`id_pro`),
  CONSTRAINT `id_compra` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_pro` FOREIGN KEY (`id_pro`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_compra`
--

LOCK TABLES `detalle_compra` WRITE;
/*!40000 ALTER TABLE `detalle_compra` DISABLE KEYS */;
INSERT INTO `detalle_compra` VALUES (1,5,1.00,1),(2,5,10.00,5);
/*!40000 ALTER TABLE `detalle_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img_producto`
--

DROP TABLE IF EXISTS `img_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `img_producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idproducto` int DEFAULT NULL,
  `imagen` text COLLATE utf8mb3_spanish_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `idproducto_idx` (`idproducto`),
  CONSTRAINT `idproducto` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img_producto`
--

LOCK TABLES `img_producto` WRITE;
/*!40000 ALTER TABLE `img_producto` DISABLE KEYS */;
INSERT INTO `img_producto` VALUES (7,2,'84511d60e5ac7ab096216fd48bc083a1c1feace7.jpg'),(8,2,'cd00825137b4d11be803a50b3f01aaf6dcd40733.jpg'),(9,2,'722a17b0dc7495dd255f0bf9e8c595dd7cd1d775.jpg'),(10,2,'2cd796afdac81be4a83d774e23bd6db39457cf32.jpg'),(11,2,'dab7d582b1c8359517dc7b9d145e1e7bb2213ea0.jpg'),(12,2,'929b270af6ff3c376bdd6fefde9f02076e27a14d.jpg'),(13,2,'afd1b4ee42e34637cd8a47443dfaafb365c39f0e.jpg'),(14,2,'448e515f6af020da2f7bfe505b7b7022d1d575fe.jpg'),(15,2,'054068a89d586c666a92f6e84154f0ef01bd8c12.jpg'),(16,2,'00a609a4610fbab910626ce368e6a3b628eea1ec.jpg'),(17,4,'a1713f2df6bc35f87495e69dd5dac64a6d5c7858.jpg'),(19,7,'09cb53af489b2c840c4b0045021e61629fa2341c.jpg'),(20,5,'6fcf23fcfe09999051ed443c580e4ad8c1c1195a.jpg');
/*!40000 ALTER TABLE `img_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `tipo` varchar(45) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_descuento` char(5) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `descuento` int DEFAULT NULL,
  `descripcion` text COLLATE utf8mb3_spanish_ci,
  `estado` bit(1) DEFAULT b'1',
  `stock` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (1,'PROTESIS','DIENTE',123.00,'proc',12,'DES',_binary '',1),(2,'edit','AAAA',12.00,'desc',10,'WWW',_binary '',1),(3,'sds','sd',232.00,'no',0,'23',_binary '',1),(4,'aaa','bbb',23.00,'no',0,'sew',_binary '',1),(5,'aaaaaw','bbb',23.00,'desc',50,'sew',_binary '',5),(6,'wa','bbb',23.00,'no',0,'sew',_binary '',1),(7,'sasa','bbb',23.00,'no',0,'sew',_binary '',11),(8,'sasazsxas','bbb',23.00,'proc',8,'sew',_binary '',11);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrador',_binary ''),(2,'vendedor',_binary '');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_descuento` char(5) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descuento` int DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci,
  `estado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
INSERT INTO `servicios` VALUES (3,'ORTODONCIA edit',12.00,'desc',12,'111',_binary ''),(4,'DE TODO UN POCO',30.00,'proc',15,'Descripción del servicio',_binary '');
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `apellido` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `rolid` int DEFAULT NULL,
  `password_usu` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `usuario_usu` varchar(45) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `foto` longtext COLLATE utf8mb4_spanish_ci,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'JORGE','RAMIREZ','ELGAMER@HOTMAIL.COM',1,'123','admin','admin.jpg',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'clinicadental'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-02 19:51:52
