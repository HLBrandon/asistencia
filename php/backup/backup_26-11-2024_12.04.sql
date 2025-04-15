-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: asistencia_app
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Current Database: `asistencia_app`
--

/*!40000 DROP DATABASE IF EXISTS `asistencia_app`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `asistencia_app` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `asistencia_app`;

--
-- Table structure for table `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asignaturas` (
  `id` varchar(10) NOT NULL,
  `nombre_asignatura` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignaturas`
--

LOCK TABLES `asignaturas` WRITE;
/*!40000 ALTER TABLE `asignaturas` DISABLE KEYS */;
INSERT INTO `asignaturas` VALUES ('ACA-0909','Taller de Investigación I'),('SCD-1016','Lenguajes y Autómatas II'),('SCG-1009','Gestión de Proyectos de Software');
/*!40000 ALTER TABLE `asignaturas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) NOT NULL,
  `dia_id` int(11) NOT NULL,
  `hora` time NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `clase_id` (`clase_id`,`dia_id`),
  KEY `dia_id` (`dia_id`),
  CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`dia_id`) REFERENCES `dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencias`
--

LOCK TABLES `asistencias` WRITE;
/*!40000 ALTER TABLE `asistencias` DISABLE KEYS */;
INSERT INTO `asistencias` VALUES (1,2,2,'11:49:53','2024-11-26');
/*!40000 ALTER TABLE `asistencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carreras`
--

DROP TABLE IF EXISTS `carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carreras` (
  `id` varchar(10) NOT NULL,
  `nombre_carrera` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carreras`
--

LOCK TABLES `carreras` WRITE;
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` VALUES ('IGE','Ingeniería en Gestión Empresarial'),('IMT','Ingeniería en Mecatrónica'),('ISC','Ingeniería en Sistemas Computacionales');
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clases`
--

DROP TABLE IF EXISTS `clases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_id` int(11) NOT NULL,
  `asignatura_id` varchar(10) NOT NULL,
  `carrera_id` varchar(10) NOT NULL,
  `semestre_id` int(11) NOT NULL,
  `sistema_id` int(11) NOT NULL,
  `periodo_id` int(11) NOT NULL,
  `salon_id` varchar(10) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `profesor_id` (`profesor_id`,`asignatura_id`,`carrera_id`,`semestre_id`,`sistema_id`,`periodo_id`,`salon_id`),
  KEY `asignatura_id` (`asignatura_id`),
  KEY `carrera_id` (`carrera_id`),
  KEY `semestre_id` (`semestre_id`),
  KEY `sistema_id` (`sistema_id`),
  KEY `periodo_id` (`periodo_id`),
  KEY `salon_id` (`salon_id`),
  CONSTRAINT `clases_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_2` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_3` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_4` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_5` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_6` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clases_ibfk_7` FOREIGN KEY (`salon_id`) REFERENCES `salones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clases`
--

LOCK TABLES `clases` WRITE;
/*!40000 ALTER TABLE `clases` DISABLE KEYS */;
INSERT INTO `clases` VALUES (1,3,'ACA-0909','ISC',7,1,1,'1BLC',1),(2,3,'SCG-1009','ISC',7,1,1,'1BLC',1);
/*!40000 ALTER TABLE `clases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_asistencia`
--

DROP TABLE IF EXISTS `detalle_asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_asistencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `presente` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asistencia_id` (`asistencia_id`,`estudiante_id`),
  KEY `estudiante_id` (`estudiante_id`),
  CONSTRAINT `detalle_asistencia_ibfk_1` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_asistencia_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_asistencia`
--

LOCK TABLES `detalle_asistencia` WRITE;
/*!40000 ALTER TABLE `detalle_asistencia` DISABLE KEYS */;
INSERT INTO `detalle_asistencia` VALUES (1,1,1,1),(2,1,2,0),(3,1,4,0),(4,1,5,1);
/*!40000 ALTER TABLE `detalle_asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dias`
--

DROP TABLE IF EXISTS `dias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dias`
--

LOCK TABLES `dias` WRITE;
/*!40000 ALTER TABLE `dias` DISABLE KEYS */;
INSERT INTO `dias` VALUES (1,'Lunes'),(2,'Martes'),(3,'Miércoles'),(4,'Jueves'),(5,'Viernes'),(6,'Sabado'),(7,'Domingo');
/*!40000 ALTER TABLE `dias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiantes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_pa` varchar(50) NOT NULL,
  `apellido_ma` varchar(50) NOT NULL,
  `carrera_id` varchar(10) NOT NULL,
  `semestre_id` int(11) NOT NULL,
  `sistema_id` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `carrera_id` (`carrera_id`,`semestre_id`,`sistema_id`),
  KEY `semestre_id` (`semestre_id`),
  KEY `sistema_id` (`sistema_id`),
  CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `estudiantes_ibfk_3` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes`
--

LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
INSERT INTO `estudiantes` VALUES (1,'210i0001','Brandon','Hernández','López','ISC',7,1,1),(2,'210i0013','Alan','Guevara','Quiroz','ISC',7,1,1),(3,'210i0008','Diego EDIT','Sanchez','Dominguez','ISC',7,2,1),(4,'210i0015','Kevin','Guevara','Quiroz','ISC',7,1,1),(5,'b220i0133','Cesar de Jesús','Reyez','Ruiz','ISC',7,1,1);
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clase_id` (`clase_id`,`estudiante_id`),
  KEY `estudiante_id` (`estudiante_id`),
  CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripciones`
--

LOCK TABLES `inscripciones` WRITE;
/*!40000 ALTER TABLE `inscripciones` DISABLE KEYS */;
INSERT INTO `inscripciones` VALUES (1,1,1),(2,2,1),(3,2,2),(4,2,4),(5,2,5);
/*!40000 ALTER TABLE `inscripciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodos`
--

DROP TABLE IF EXISTS `periodos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodos`
--

LOCK TABLES `periodos` WRITE;
/*!40000 ALTER TABLE `periodos` DISABLE KEYS */;
INSERT INTO `periodos` VALUES (1,'2024-08-26','2024-12-13',1);
/*!40000 ALTER TABLE `periodos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Docente'),(3,'Asistente');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salones`
--

DROP TABLE IF EXISTS `salones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salones` (
  `id` varchar(11) NOT NULL,
  `nombre_salon` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salones`
--

LOCK TABLES `salones` WRITE;
/*!40000 ALTER TABLE `salones` DISABLE KEYS */;
INSERT INTO `salones` VALUES ('1BLC','Laboratorio de Computo 1');
/*!40000 ALTER TABLE `salones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semestres`
--

DROP TABLE IF EXISTS `semestres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semestres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_semestre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semestres`
--

LOCK TABLES `semestres` WRITE;
/*!40000 ALTER TABLE `semestres` DISABLE KEYS */;
INSERT INTO `semestres` VALUES (1,'Primero'),(2,'Segundo'),(3,'Tercero'),(4,'Cuarto'),(5,'Quinto'),(6,'Sexto'),(7,'Septimo'),(8,'Octavo'),(9,'Noveno'),(10,'Decimo');
/*!40000 ALTER TABLE `semestres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistemas`
--

DROP TABLE IF EXISTS `sistemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sistemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_sistema` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas`
--

LOCK TABLES `sistemas` WRITE;
/*!40000 ALTER TABLE `sistemas` DISABLE KEYS */;
INSERT INTO `sistemas` VALUES (1,'Escolarizado'),(2,'Mixto');
/*!40000 ALTER TABLE `sistemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `role_id_2` (`role_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Programador','Programador','Administrador','programador@example.com','$2y$10$QtVcspqw7lvTygSCObN6lO0jleg4VorxUUum.QM1hewNe2/yqUrLy',1,1),(2,'Hugo','Lucas','Alvarado','hugo@example.com','$2y$10$2POcgsq4lzUIJ7Md11DInuagipdGbo7bklrtdeBEAsPDIcHoYssSu',2,1),(3,'Armando','Hernández','Basilio','Basilio@example.com','$2y$10$gKyUGzZrM8fJpA/bWKz4AeJ65sWIzWCFenvUFNgkkf8zdjTBq5pEu',2,1),(4,'Carlos','Sanchez','Tejeda','carlos@example.com','$2y$10$dNFgQmlSGYVJKmemzAJMU.GAvhhxyI/pDcrYwKmzMJjhzBfR.4GgG',3,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'asistencia_app'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-26 12:04:15
