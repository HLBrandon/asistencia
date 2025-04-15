-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2025 a las 05:10:28
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistencia_app`
--
CREATE DATABASE IF NOT EXISTS `asistencia_app` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `asistencia_app`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

DROP TABLE IF EXISTS `asignaturas`;
CREATE TABLE IF NOT EXISTS `asignaturas` (
  `id` varchar(10) NOT NULL,
  `nombre_asignatura` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `asignaturas`
--

TRUNCATE TABLE `asignaturas`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) NOT NULL,
  `dia_id` int(11) NOT NULL,
  `hora` time NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `clase_id` (`clase_id`,`dia_id`),
  KEY `dia_id` (`dia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `asistencias`
--

TRUNCATE TABLE `asistencias`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

DROP TABLE IF EXISTS `carreras`;
CREATE TABLE IF NOT EXISTS `carreras` (
  `id` varchar(10) NOT NULL,
  `nombre_carrera` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `carreras`
--

TRUNCATE TABLE `carreras`;
--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `nombre_carrera`) VALUES
('IGE', 'Ingeniería en Gestión Empresarial'),
('IMT', 'Ingeniería en Mecatrónica'),
('ISC', 'Ingeniería en Sistemas Computacionales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

DROP TABLE IF EXISTS `clases`;
CREATE TABLE IF NOT EXISTS `clases` (
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
  KEY `salon_id` (`salon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `clases`
--

TRUNCATE TABLE `clases`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_asistencia`
--

DROP TABLE IF EXISTS `detalle_asistencia`;
CREATE TABLE IF NOT EXISTS `detalle_asistencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `presente` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asistencia_id` (`asistencia_id`,`estudiante_id`),
  KEY `estudiante_id` (`estudiante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `detalle_asistencia`
--

TRUNCATE TABLE `detalle_asistencia`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dias`
--

DROP TABLE IF EXISTS `dias`;
CREATE TABLE IF NOT EXISTS `dias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `dias`
--

TRUNCATE TABLE `dias`;
--
-- Volcado de datos para la tabla `dias`
--

INSERT INTO `dias` (`id`, `nombre_id`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sabado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
CREATE TABLE IF NOT EXISTS `estudiantes` (
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
  KEY `sistema_id` (`sistema_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `estudiantes`
--

TRUNCATE TABLE `estudiantes`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE IF NOT EXISTS `horario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) NOT NULL,
  `dia_id` int(11) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clase_id` (`clase_id`,`dia_id`),
  KEY `dia_id` (`dia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `horario`
--

TRUNCATE TABLE `horario`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

DROP TABLE IF EXISTS `inscripciones`;
CREATE TABLE IF NOT EXISTS `inscripciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clase_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `clase_id` (`clase_id`,`estudiante_id`),
  KEY `estudiante_id` (`estudiante_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `inscripciones`
--

TRUNCATE TABLE `inscripciones`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

DROP TABLE IF EXISTS `periodos`;
CREATE TABLE IF NOT EXISTS `periodos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `periodos`
--

TRUNCATE TABLE `periodos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `roles`
--

TRUNCATE TABLE `roles`;
--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_role`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Asistente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salones`
--

DROP TABLE IF EXISTS `salones`;
CREATE TABLE IF NOT EXISTS `salones` (
  `id` varchar(11) NOT NULL,
  `nombre_salon` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `salones`
--

TRUNCATE TABLE `salones`;
--
-- Volcado de datos para la tabla `salones`
--

INSERT INTO `salones` (`id`, `nombre_salon`) VALUES
('1BLC', 'Laboratorio de Computo 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE IF NOT EXISTS `semestres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_semestre` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `semestres`
--

TRUNCATE TABLE `semestres`;
--
-- Volcado de datos para la tabla `semestres`
--

INSERT INTO `semestres` (`id`, `nombre_semestre`) VALUES
(1, 'Primero'),
(2, 'Segundo'),
(3, 'Tercero'),
(4, 'Cuarto'),
(5, 'Quinto'),
(6, 'Sexto'),
(7, 'Septimo'),
(8, 'Octavo'),
(9, 'Noveno'),
(10, 'Decimo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemas`
--

DROP TABLE IF EXISTS `sistemas`;
CREATE TABLE IF NOT EXISTS `sistemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_sistema` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `sistemas`
--

TRUNCATE TABLE `sistemas`;
--
-- Volcado de datos para la tabla `sistemas`
--

INSERT INTO `sistemas` (`id`, `nombre_sistema`) VALUES
(1, 'Escolarizado'),
(2, 'Mixto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
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
  KEY `role_id_2` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `contrasenia`, `role_id`, `activo`) VALUES
(1, 'Programador', 'Programador', 'Administrador', 'programador@example.com', '$2y$10$ESsslGnqr8c5sOhsfVSw4.JTWZdOPNlx4skmekSRbZ35auH50JTZi', 1, 1),
(2, 'Emanuel', 'López', 'Gómez', 'emanual.lopez@example.com', '$2y$10$ws7pjTj7ZhmBUsRJqb2wLuTywgRaU1n.13n1hM11YSs5mBUV514Fe', 2, 1),
(3, 'Armando', 'Sánchez', 'Alvarado', 'armando.sanchez@example.com', '$2y$10$BvOq0xfwC/LALHG9EGuD2ezob8cmRCBI04qBsWv1itfm1i.6CnE0y', 2, 0),
(4, 'Carlos', 'Sánchez', 'Tejeda', 'carlos.sanchez@example.com', '$2y$10$El82CEhJz4Aw3BAsE1TwbeIzkvvZogRbLx7MD0QOUqLXZPbAR55U2', 3, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`dia_id`) REFERENCES `dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `clases_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_2` FOREIGN KEY (`asignatura_id`) REFERENCES `asignaturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_3` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_4` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_5` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_6` FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clases_ibfk_7` FOREIGN KEY (`salon_id`) REFERENCES `salones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  ADD CONSTRAINT `detalle_asistencia_ibfk_1` FOREIGN KEY (`asistencia_id`) REFERENCES `asistencias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_asistencia_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiantes_ibfk_3` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`dia_id`) REFERENCES `dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
