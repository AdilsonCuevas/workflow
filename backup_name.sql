-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: workflow
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.22.04.1

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
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1695661507),('m160815_081611_sw_status',1695661521),('m160815_081612_sw_transition',1695661521),('m160815_081613_sw_workflow',1695661521),('m160815_223711_sw_metadata',1695661521),('m160815_223712_relations',1695661521);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_metadata`
--

DROP TABLE IF EXISTS `sw_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sw_metadata` (
  `workflow_id` varchar(32) NOT NULL,
  `status_id` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  UNIQUE KEY `workflow_status_id` (`workflow_id`,`status_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_metadata`
--

LOCK TABLES `sw_metadata` WRITE;
/*!40000 ALTER TABLE `sw_metadata` DISABLE KEYS */;
INSERT INTO `sw_metadata` VALUES ('13','11','gfdfgtuigkdc','entrada'),('21','22','fdgdfhtrhgf','valormeta'),('radicado','agreparRadicado','expedientes','factorizar'),('radicado','anexos','asignaciondeasnexos','false'),('radicado','expedienteController','asignacioncontroller','false'),('radicado','firmar','radicadofirma','funcionalidad'),('soluciones','4','34543','verificar'),('soluciones','5','34543','verificar'),('soluciones','7','34543','verificar'),('soluciones','8','457756','fghghf');
/*!40000 ALTER TABLE `sw_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_status`
--

DROP TABLE IF EXISTS `sw_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sw_status` (
  `id` varchar(32) NOT NULL,
  `workflow_id` varchar(32) NOT NULL,
  `label` varchar(64) DEFAULT NULL,
  `sort_order` int DEFAULT NULL,
  PRIMARY KEY (`id`,`workflow_id`),
  KEY `workflow_id` (`workflow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_status`
--

LOCK TABLES `sw_status` WRITE;
/*!40000 ALTER TABLE `sw_status` DISABLE KEYS */;
INSERT INTO `sw_status` VALUES ('1','13','factor',1),('11','13','fraccion',3),('12','soluciones','facores de prueba',1),('2','13','factor',2),('22','21','factorizacion',1),('4','soluciones','factor prueba',2),('5','soluciones','hgfhfg',3),('7','soluciones','ghjhffg',4),('8','soluciones','bgthgfhf',5),('agreparRadicado','radicado','agrupacion',2),('anexos','radicado','asignaranexos',4),('expedienteController','radicado','asignacion',3),('firmar','radicado','firmaRadicado',1),('socialf','adilson','funciones',1);
/*!40000 ALTER TABLE `sw_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_transition`
--

DROP TABLE IF EXISTS `sw_transition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sw_transition` (
  `workflow_id` varchar(32) NOT NULL,
  `start_status_id` varchar(32) NOT NULL,
  `end_status_id` varchar(32) NOT NULL,
  PRIMARY KEY (`workflow_id`,`start_status_id`,`end_status_id`),
  KEY `workflow_start_status_id` (`workflow_id`,`start_status_id`),
  KEY `workflow_end_status_id` (`workflow_id`,`end_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_transition`
--

LOCK TABLES `sw_transition` WRITE;
/*!40000 ALTER TABLE `sw_transition` DISABLE KEYS */;
INSERT INTO `sw_transition` VALUES ('radicado','expedienteController','firmar'),('radicado','firmar','anexos');
/*!40000 ALTER TABLE `sw_transition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sw_workflow`
--

DROP TABLE IF EXISTS `sw_workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sw_workflow` (
  `id` varchar(32) NOT NULL,
  `initial_status_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `initial_status_id` (`initial_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sw_workflow`
--

LOCK TABLES `sw_workflow` WRITE;
/*!40000 ALTER TABLE `sw_workflow` DISABLE KEYS */;
INSERT INTO `sw_workflow` VALUES ('13',NULL),('adilson',NULL),('soluciones',NULL),('21','22'),('radicado','firmar');
/*!40000 ALTER TABLE `sw_workflow` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-26 16:30:31
