-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla pritec.inspeccion_visual_carroceria
CREATE TABLE IF NOT EXISTS `inspeccion_visual_carroceria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `concepto` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `peritaje_id` (`peritaje_id`),
  CONSTRAINT `inspeccion_visual_carroceria_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.inspeccion_visual_carroceria: ~13 rows (aproximadamente)
INSERT INTO `inspeccion_visual_carroceria` (`id`, `peritaje_id`, `descripcion_pieza`, `concepto`, `created_at`) VALUES
	(1, 7, '1', '1', '2025-04-28 22:48:56'),
	(2, 7, '2', '2', '2025-04-28 22:48:56'),
	(3, 8, 'asads', 'asdasd', '2025-04-29 00:10:54'),
	(4, 8, 'asdasd', 'asdasd', '2025-04-29 00:10:54'),
	(5, 9, '9', '9', '2025-05-02 05:21:36'),
	(6, 10, '8', '8', '2025-05-02 05:30:56'),
	(8, 12, 'u', 'u', '2025-05-13 23:17:47'),
	(9, 13, '6', '7', '2025-05-14 06:05:54'),
	(10, 13, '5', '5', '2025-05-14 06:05:54'),
	(17, 11, '099', '9', '2025-05-14 20:29:43'),
	(18, 14, '7', '7', '2025-05-14 20:32:52'),
	(19, 15, '8', '8', '2025-05-15 03:18:23'),
	(21, 16, '9', '9', '2025-05-15 04:49:41');

-- Volcando estructura para tabla pritec.inspeccion_visual_chasis
CREATE TABLE IF NOT EXISTS `inspeccion_visual_chasis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `peritaje_id` (`peritaje_id`) USING BTREE,
  CONSTRAINT `inspeccion_visual_chasis_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.inspeccion_visual_chasis: ~12 rows (aproximadamente)
INSERT INTO `inspeccion_visual_chasis` (`id`, `peritaje_id`, `descripcion_pieza`, `concepto`, `created_at`) VALUES
	(1, 8, 'asd', 'asd', '2025-04-29 00:10:54'),
	(2, 9, '9', '9', '2025-05-02 05:21:36'),
	(3, 10, '8', '8', '2025-05-02 05:30:56'),
	(5, 12, 'u', 'u', '2025-05-13 23:17:47'),
	(12, 11, '9', '9', '2025-05-14 20:29:43'),
	(13, 14, '7', '7', '2025-05-14 20:32:52'),
	(14, 15, '8', '8', '2025-05-15 03:18:23'),
	(20, 16, '9', '9', '2025-05-15 04:49:41'),
	(21, 17, 'BBBBBBBBBBB', 'JJJJJJJJJJJ', '2025-05-17 02:17:34'),
	(22, 17, 'JJJJJJJJJJJ', 'JJJJJJJJJJ', '2025-05-17 02:17:34'),
	(23, 17, 'BBBBBBBBBBBBBB', 'BBBBBBBBBBB', '2025-05-17 02:17:34'),
	(24, 17, 'BBBBBBBBBBV', 'VVVVVVVVVV', '2025-05-17 02:17:34');

-- Volcando estructura para tabla pritec.inspeccion_visual_estructura
CREATE TABLE IF NOT EXISTS `inspeccion_visual_estructura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `peritaje_id` (`peritaje_id`) USING BTREE,
  CONSTRAINT `inspeccion_visual_estructura_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.inspeccion_visual_estructura: ~11 rows (aproximadamente)
INSERT INTO `inspeccion_visual_estructura` (`id`, `peritaje_id`, `descripcion_pieza`, `concepto`, `created_at`) VALUES
	(1, 8, 'asdasd', 'asda', '2025-04-29 00:10:54'),
	(2, 8, 'asdads', 'asdas', '2025-04-29 00:10:54'),
	(3, 9, '9', '9', '2025-05-02 05:21:36'),
	(4, 10, '8', '8', '2025-05-02 05:30:56'),
	(6, 12, 'u', 'u', '2025-05-13 23:17:47'),
	(13, 11, '9', '9', '2025-05-14 20:29:43'),
	(14, 14, '7', '7', '2025-05-14 20:32:52'),
	(15, 15, '8', '8', '2025-05-15 03:18:23'),
	(19, 16, '9', '9', '2025-05-15 04:49:41'),
	(20, 17, 'HWCWJUEHCUWCW', 'JHWEWGCWGYCYGE', '2025-05-17 02:17:34'),
	(21, 17, 'EKHWUEUHWUC JHECUWECH', 'UIUIUIIU', '2025-05-17 02:17:34');

-- Volcando estructura para tabla pritec.peritaje_basico
CREATE TABLE IF NOT EXISTS `peritaje_basico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `servicio_para` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `convenio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `nombre_apellidos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `clase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `linea` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cilindraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_chasis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_motor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tipo_carroceria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `organismo_transito` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tiene_prenda` tinyint(1) DEFAULT '0',
  `tiene_limitacion` tinyint(1) DEFAULT '0',
  `debe_impuestos` tinyint(1) DEFAULT '0',
  `tiene_comparendos` tinyint(1) DEFAULT '0',
  `vehiculo_rematado` tinyint(1) DEFAULT '0',
  `revision_tecnicomecanica` enum('vigente','no_vigente','no_aplica') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rtm_fecha_vencimiento` date DEFAULT NULL,
  `soat` enum('vigente','no_vigente','no_aplica') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `soat_fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `licencia_frente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `licencia_atras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_motor` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_chasis` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_serial` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `observaciones_finales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.peritaje_basico: ~9 rows (aproximadamente)
INSERT INTO `peritaje_basico` (`id`, `placa`, `fecha`, `no_servicio`, `servicio_para`, `convenio`, `nombre_apellidos`, `identificacion`, `telefono`, `direccion`, `clase`, `marca`, `linea`, `cilindraje`, `servicio`, `modelo`, `color`, `no_chasis`, `no_motor`, `no_serie`, `tipo_carroceria`, `organismo_transito`, `tiene_prenda`, `tiene_limitacion`, `debe_impuestos`, `tiene_comparendos`, `vehiculo_rematado`, `revision_tecnicomecanica`, `rtm_fecha_vencimiento`, `soat`, `soat_fecha_vencimiento`, `observaciones`, `licencia_frente`, `licencia_atras`, `estado_motor`, `estado_chasis`, `estado_serial`, `observaciones_finales`, `fecha_creacion`, `fecha_actualizacion`, `estado`) VALUES
	(1, 'w', '2025-01-01', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'ww', 'w', 'w', 'w', 'w', 'w', 0, 0, 0, 0, 1, 'no_aplica', NULL, 'no_aplica', NULL, 'asdas', '6789f1867e0b1_Captura de pantalla 2024-12-27 113309.png', '6789f1867e831_Captura de pantalla 2024-12-27 113348.png', 'regrabado', 'regrabado', 'regrabado', 'sdc', '2025-01-17 05:58:30', '2025-05-14 19:31:42', 0),
	(2, '3', '2025-01-14', '33', '3', '3', 'rrrr', 'rrrrrr', '3', '3', '3', '3', '33', '3', '3', '3', '3', '3', '', '3', '3', '3', 1, 0, 0, 0, 1, 'vigente', '2025-01-22', 'vigente', '2025-01-22', 'asdasdads', '678f04fbd6b02_costillas.jpg', '678f04fbd7442_HAMBURGUESA.jpg', 'regrabado', 'regrabado', 'grabado_no_original', 'asdadas', '2025-01-21 02:22:51', '2025-01-21 04:58:08', 0),
	(3, '77', '2025-01-02', '777', '7', '7', 'CINCO', 'U7', '7', '6', '5', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', 0, 1, 0, 0, 0, 'no_vigente', '2025-01-01', 'vigente', '2025-05-15', 'adasdasadsdasSBHJQBSYSUSGU', '68256e10e91be_licencia frente.jpeg', '678f29a2df7f4_Tarjeta de presentación formal negro y blanco elegante.png', 'original', 'regrabado', 'grabado_no_original', 'asdasdasJSHHUSUHSU', '2025-01-21 04:59:14', '2025-05-15 04:31:12', 1),
	(4, 'h', '2025-05-01', 'u', 'u', 'u', 'uh hu uh hu ', 'h', 'h', 'h', 'h', 'h', 'h', 'h', 'h', 'h', 'hh', 'h', 'h', 'h', 'h', 'h', 0, 1, 0, 0, 0, 'vigente', '2025-05-31', 'no_vigente', '2025-05-01', 'cdadasdsasnwbjdhqw dwqwhjd', '6824ef7664a55_1.png', '6824ef7664efe_2.png', 'original', 'regrabado', 'grabado_no_original', 'asdasdnc hjcjswchs', '2025-05-14 03:24:12', '2025-05-15 04:34:02', 0),
	(5, '2', '2025-05-08', '2', '2', '2', 'DOS', '2', '2', '22', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', 1, 0, 0, 0, 1, 'no_aplica', NULL, 'vigente', '2025-02-02', '2asdasdasd', '68240d06db79c_1.png', '68240d06db941_2.png', 'original', 'original', 'original', '2asdadsdas', '2025-05-14 03:24:54', '2025-05-14 20:01:26', 1),
	(6, 'XRW345', '2025-05-14', '1', '111', 'na', 'SASASA', 'SASASAS', 'SASASA', 'WAS WEWD', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 0, 0, 1, 0, 0, 'no_aplica', NULL, 'no_aplica', NULL, 'NO UEYE BBWUEUFYW9E UEFUYW', '6824f38991752_licencia frente.jpeg', '6824f38992003_licencia atras.jpg', 'original', 'regrabado', 'grabado_no_original', 'DNNDWHJHNV JHVBWJH', '2025-05-14 19:27:48', '2025-05-14 19:48:25', 1),
	(7, 'CTY456', '2025-05-14', '9', 'w', 'HUHU', 'JUAQO', '111', '2', '2', 'JJ', 'J', 'J', 'J', 'J', 'J', 'JJ', 'J', 'JJ', '', 'J', 'J', 0, 0, 1, 0, 0, 'no_aplica', NULL, 'no_aplica', NULL, 'JSKFHKJEHFEW FWUHFIWFHIFHW JWHFIF', '6824f5b3d8379_licencia atras.jpg', '6824f5b3d84c6_licencia frente.jpeg', 'original', 'regrabado', 'regrabado', 'JUJUJUJ', '2025-05-14 19:57:39', '2025-05-14 19:57:39', 1),
	(8, '4', '2025-05-14', '23', '9000', '009', 'NIFUNIFA', '4', '4', '4', '4', '4', '4', '4', '44', '4', '4', '4', '4', '44', '4', '4', 0, 0, 0, 0, 1, 'no_aplica', NULL, 'no_aplica', NULL, 'NWEHIEWFEW YFWUWWUI', '68256da57af59_licencia atras.jpg', '68256da57b64b_licencia frente.jpeg', 'original', 'regrabado', 'grabado_no_original', 'KWJD3 3J3HFI3F F3UIFHU', '2025-05-15 04:29:25', '2025-05-15 04:29:25', 1),
	(9, 'HJH567', '2025-05-14', '123123123', 'CC', 'colombia ', 'daniel david chavarro quimbaya ', '222222222', 'J', 'HHJ', 'JHJHJ', 'HJHJH', 'JHJHJG', 'HHGJHJ', 'GJGHGH', 'HGJGHJGHJ', 'HGGHJGJ', 'GJHGJGJH', 'GHGJJH', 'GGH', 'GGH', 'GHHJGH', 0, 0, 1, 0, 0, 'vigente', '2025-05-14', 'no_vigente', '2025-05-01', 'HGUHGYUG YUG YU G', '68256e79d4ffe_1.png', '68256e79d64cd_2.png', 'original', 'regrabado', 'grabado_no_original', 'NJJH HJBBSBHBHJS SHHSJH', '2025-05-15 04:32:57', '2025-05-17 01:38:24', 1),
	(10, '123 ABC', '2025-05-17', '123123', 'mi', 'no tiene', 'ps yo quien mas', '12345678901', '123', '123', 'asd', 'asdads', 'asdihi', 'iu', 'iu', 'iu', 'iu', 'iu', 'iu', 'iu', 'iu', 'iu', 0, 1, 1, 1, 0, 'no_vigente', '2025-05-22', 'no_aplica', NULL, 'sdasasasdasd', '6827ea3a44e60_Captura de pantalla 2025-04-28 221455.png', '6827ea3a45f53_Captura de pantalla 2025-04-29 095427.png', 'original', 'regrabado', 'grabado_no_original', 'asdasdads', '2025-05-17 01:45:30', '2025-05-17 01:45:30', 1);

-- Volcando estructura para tabla pritec.peritaje_completo
CREATE TABLE IF NOT EXISTS `peritaje_completo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `servicio_para` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `convenio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `nombre_apellidos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `clase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `linea` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `cilindraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_chasis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_motor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `no_serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tipo_carroceria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `organismo_transito` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `llanta_anterior_izquierda` int DEFAULT NULL,
  `llanta_anterior_derecha` int DEFAULT NULL,
  `llanta_posterior_izquierda` int DEFAULT NULL,
  `llanta_posterior_derecha` int DEFAULT NULL,
  `amortiguador_anterior_izquierdo` int DEFAULT NULL,
  `amortiguador_anterior_derecho` int DEFAULT NULL,
  `amortiguador_posterior_izquierdo` int DEFAULT NULL,
  `amortiguador_posterior_derecho` int DEFAULT NULL,
  `observaciones_amortiguadores` varchar(250) COLLATE utf8mb4_bin DEFAULT NULL,
  `prueba_escaner` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `observaciones_escaner` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `prueba_bateria` int DEFAULT NULL,
  `prueba_arranque` int DEFAULT NULL,
  `carga_bateria` int DEFAULT NULL,
  `observaciones_bateria` text COLLATE utf8mb4_bin,
  `fijacion_fotografica_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fijacion_fotografica_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fijacion_fotografica_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fijacion_fotografica_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fijacion_fotografica_5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fijacion_fotografica_6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `observaciones2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `observaciones_llantas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `kilometraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `codigo_fasecolda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `valor_fasecolda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `valor_sugerido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `valor_accesorios` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tipo_vehiculo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `observaciones_inspeccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `observaciones_estructura` text COLLATE utf8mb4_bin,
  `observaciones_chasis` text COLLATE utf8mb4_bin,
  `estado_arranque` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_arranque` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_radiador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_radiador` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_carter_motor` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_carter_motor` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_carter_caja` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_carter_caja` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_caja_velocidades` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_caja_velocidades` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_soporte_caja` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_soporte_motor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_soporte_caja` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_soporte_motor` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_mangueras_radiador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_mangueras_radiador` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_correas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_correas` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `tension_correas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_tension_correas` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_filtro_aire` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_filtro_aire` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_externo_bateria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_externo_bateria` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_pastilla_freno` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_pastilla_freno` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_discos_freno` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_discos_freno` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_punta_eje` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_punta_eje` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_axiales` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_axiales` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_terminales` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_terminales` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_rotulas` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_rotulas` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_tijeras` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_tijeras` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_caja_direccion` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_caja_direccion` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_rodamientos` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_rodamientos` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_cardan` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_cardan` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_crucetas` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_crucetas` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT (now()),
  `fecha_actualizacion` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  `estado_calefaccion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_calefaccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_aire_acondicionado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_aire_acondicionado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_cinturones` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_cinturones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_tapiceria_asientos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_tapiceria_asientos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_tapiceria_techo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_tapiceria_techo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_millaret` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_millaret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_alfombra` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_alfombra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `estado_chapas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_chapas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `respuesta_fuga_aceite_motor` text COLLATE utf8mb4_bin,
  `respuesta_fuga_aceite_caja_velocidades` text COLLATE utf8mb4_bin,
  `respuesta_fuga_aceite_caja_transmision` text COLLATE utf8mb4_bin,
  `respuesta_fuga_liquido_frenos` text COLLATE utf8mb4_bin,
  `respuesta_fuga_aceite_direccion_hidraulica` text COLLATE utf8mb4_bin,
  `respuesta_fuga_liquido_bomba_embrague` text COLLATE utf8mb4_bin,
  `respuesta_fuga_tanque_combustible` text COLLATE utf8mb4_bin,
  `respuesta_estado_tanque_silenciador` text COLLATE utf8mb4_bin,
  `respuesta_estado_tubo_exhosto` text COLLATE utf8mb4_bin,
  `respuesta_estado_tanque_catalizador_gases` text COLLATE utf8mb4_bin,
  `respuesta_estado_guardapolvo_caja_direccion` text COLLATE utf8mb4_bin,
  `respuesta_estado_tuberia_frenos` text COLLATE utf8mb4_bin,
  `respuesta_viscosidad_aceite_motor` text COLLATE utf8mb4_bin,
  `respuesta_nivel_refrigerante_motor` text COLLATE utf8mb4_bin,
  `respuesta_nivel_liquido_frenos` text COLLATE utf8mb4_bin,
  `respuesta_nivel_agua_limpiavidrios` text COLLATE utf8mb4_bin,
  `respuesta_nivel_aceite_direccion_hidraulica` text COLLATE utf8mb4_bin,
  `respuesta_nivel_liquido_embrague` text COLLATE utf8mb4_bin,
  `respuesta_nivel_aceite_motor` text COLLATE utf8mb4_bin,
  `prueba_ruta` text COLLATE utf8mb4_bin,
  `observaciones_fugas` text COLLATE utf8mb4_bin,
  `observaciones_motor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `observaciones_interior` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `tipo_chasis` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.peritaje_completo: ~13 rows (aproximadamente)
INSERT INTO `peritaje_completo` (`id`, `placa`, `fecha`, `no_servicio`, `servicio_para`, `convenio`, `nombre_apellidos`, `identificacion`, `telefono`, `direccion`, `clase`, `marca`, `linea`, `cilindraje`, `servicio`, `modelo`, `color`, `no_chasis`, `no_motor`, `no_serie`, `tipo_carroceria`, `organismo_transito`, `llanta_anterior_izquierda`, `llanta_anterior_derecha`, `llanta_posterior_izquierda`, `llanta_posterior_derecha`, `amortiguador_anterior_izquierdo`, `amortiguador_anterior_derecho`, `amortiguador_posterior_izquierdo`, `amortiguador_posterior_derecho`, `observaciones_amortiguadores`, `prueba_escaner`, `observaciones_escaner`, `prueba_bateria`, `prueba_arranque`, `carga_bateria`, `observaciones_bateria`, `fijacion_fotografica_1`, `fijacion_fotografica_2`, `fijacion_fotografica_3`, `fijacion_fotografica_4`, `fijacion_fotografica_5`, `fijacion_fotografica_6`, `observaciones`, `observaciones2`, `observaciones_llantas`, `email`, `kilometraje`, `codigo_fasecolda`, `valor_fasecolda`, `valor_sugerido`, `valor_accesorios`, `tipo_vehiculo`, `observaciones_inspeccion`, `observaciones_estructura`, `observaciones_chasis`, `estado_arranque`, `respuesta_arranque`, `estado_radiador`, `respuesta_radiador`, `estado_carter_motor`, `respuesta_carter_motor`, `estado_carter_caja`, `respuesta_carter_caja`, `estado_caja_velocidades`, `respuesta_caja_velocidades`, `estado_soporte_caja`, `estado_soporte_motor`, `respuesta_soporte_caja`, `respuesta_soporte_motor`, `estado_mangueras_radiador`, `respuesta_mangueras_radiador`, `estado_correas`, `respuesta_correas`, `tension_correas`, `respuesta_tension_correas`, `estado_filtro_aire`, `respuesta_filtro_aire`, `estado_externo_bateria`, `respuesta_externo_bateria`, `estado_pastilla_freno`, `respuesta_pastilla_freno`, `estado_discos_freno`, `respuesta_discos_freno`, `estado_punta_eje`, `respuesta_punta_eje`, `estado_axiales`, `respuesta_axiales`, `estado_terminales`, `respuesta_terminales`, `estado_rotulas`, `respuesta_rotulas`, `estado_tijeras`, `respuesta_tijeras`, `estado_caja_direccion`, `respuesta_caja_direccion`, `estado_rodamientos`, `respuesta_rodamientos`, `estado_cardan`, `respuesta_cardan`, `estado_crucetas`, `respuesta_crucetas`, `fecha_creacion`, `fecha_actualizacion`, `estado`, `estado_calefaccion`, `respuesta_calefaccion`, `estado_aire_acondicionado`, `respuesta_aire_acondicionado`, `estado_cinturones`, `respuesta_cinturones`, `estado_tapiceria_asientos`, `respuesta_tapiceria_asientos`, `estado_tapiceria_techo`, `respuesta_tapiceria_techo`, `estado_millaret`, `respuesta_millaret`, `estado_alfombra`, `respuesta_alfombra`, `estado_chapas`, `respuesta_chapas`, `respuesta_fuga_aceite_motor`, `respuesta_fuga_aceite_caja_velocidades`, `respuesta_fuga_aceite_caja_transmision`, `respuesta_fuga_liquido_frenos`, `respuesta_fuga_aceite_direccion_hidraulica`, `respuesta_fuga_liquido_bomba_embrague`, `respuesta_fuga_tanque_combustible`, `respuesta_estado_tanque_silenciador`, `respuesta_estado_tubo_exhosto`, `respuesta_estado_tanque_catalizador_gases`, `respuesta_estado_guardapolvo_caja_direccion`, `respuesta_estado_tuberia_frenos`, `respuesta_viscosidad_aceite_motor`, `respuesta_nivel_refrigerante_motor`, `respuesta_nivel_liquido_frenos`, `respuesta_nivel_agua_limpiavidrios`, `respuesta_nivel_aceite_direccion_hidraulica`, `respuesta_nivel_liquido_embrague`, `respuesta_nivel_aceite_motor`, `prueba_ruta`, `observaciones_fugas`, `observaciones_motor`, `observaciones_interior`, `tipo_chasis`) VALUES
	(5, 'asd', '2025-04-22', 'ads', 'asd', 'asd', 'asd', 'asds', 'asd', 'asd', 'asd', 'asd', 'asd', 'iu', 'i', 'iu', 'iu', 'uii', 'ui', 'ui', 'ui', 'ui', 8, 8, 8, 8, 8, 8, 8, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdasd', 'asdas', 'ads@ads.asd', '', 'ui', '7', '7', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-28 21:33:44', '2025-05-02 18:23:42', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(6, 'i', '2025-04-21', 'asdads', 'asdasd', 'asd', 'asdasd', 'iuh', 'uh', 'iuh', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i', 9, 9, 9, 9, 9, 9, 9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdasd', 'asdasd', 'qqq@qq.q', '', 'i', '1', '1', '1', 'MICROBUS', 'asdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-28 22:35:00', '2025-04-28 22:35:00', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(7, 'ohi', '2025-04-16', 'asdasdasdasd', 'uhu', 'uh', 'uuhu', 'uhuh', 'uhhu', 'uhu', 'uhu', 'hu', 'uhu', 'hu', 'huh', 'uh', 'uh', 'uh', 'u', 'hu', 'u', 'h', 9, 9, 9, 9, 9, 9, 9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdasdasd', 'asdasd', 'uu@u.ii', '2', '1', '2', '2', '2', 'CONVERTIBLE', 'sadasddsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-28 22:48:56', '2025-04-28 22:48:56', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(8, 'asdads', '2025-04-08', 'asddsa', 'asdas', 'asdsad', 'asdad', 'asdas', 'asdad', 'asdasd', 'iuh', 'iuh', 'iuh', 'iuh', 'iu', 'hiu', 'hi', 'uh', 'iuh', 'i', 'uhi', 'uh', 9, 9, 9, 9, 9, 9, 9, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'asdsad', 'asdads', 'qqq@qq.q', '', '', '', '', '', 'COOPER', 'asdsad', 'asdsad', 'asddsa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-29 00:10:54', '2025-04-29 00:10:54', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(9, '9', '2025-05-08', '3', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', 9, 9, 9, 9, 9, 9, 9, 9, NULL, NULL, NULL, 9, 9, 9, '9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9', '9', 'qqq@qq.q', '9', '9', '9', '9', '9', 'HATCHBACK - 5 PUERTAS', '9', '9', '9', 'Bueno', '9', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', 'Bueno', '', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', '2025-05-02 05:21:36', '2025-05-02 05:21:36', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(10, '8', '2025-05-02', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', 8, 8, 8, 8, 8, 8, 8, 8, NULL, NULL, NULL, 8, 8, 8, '8', '681458908a32d_foto face.jpg', NULL, NULL, NULL, NULL, '681458908a560_Imagen de WhatsApp 2025-05-01 a las 16.59.19_e8d07641.jpg', NULL, '8', '8', 'qqq@qq.q', '8', '8', '8', '8', '8', 'CONVERTIBLE', '8', '8', '8', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', 'Bueno', '', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', '2025-05-02 05:30:56', '2025-05-14 20:03:10', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(11, '9', '2025-05-02', '9', '9', '9', 'NUEVE', '9', '9JEFJEBF', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', 9, 9, 9, 9, 9, 9, 9, 9, '', '', '', 9, 9, 9, '9', '6824f6d701c0e_licencia atras.jpg', '6824f6d701da7_licencia frente.jpeg', '6824fd37ae2b3_licencia frente.jpeg', '6824fd37ae484_licencia atras.jpg', '6824fd37ae5c9_licencia atras.jpg', '6824fd37ae6ef_licencia frente.jpeg', NULL, NULL, '9', 'qqq@qq.q', '9', '9', '9', '9', '9', 'CONVERTIBLE', '9', '9', '9', 'NO_APLICA', '9', 'NO_APLICA', '9', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', 'NO_APLICA', '', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', '2025-05-02 06:00:14', '2025-05-14 20:29:43', 1, 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', '', '', ''),
	(12, 'u', '2025-05-08', 'asdasda', 'asdasd', 'asdasd', 'asdasd', 'asd', 'asd', 'ads', 'u', 'uu', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 1, 1, 1, 1, 7, 7, 7, 7, NULL, NULL, NULL, 8, 8, 8, 'u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'u', 'u', 'asdasd@as.as', '', 'uu', '1', '1', '1', 'CAMIONETA WAGON- 5 PUERTAS', 'u', 'u', 'u', 'Regular', 'u', 'Bueno', 'u', 'Regular', 'u', 'Bueno', 'u', 'Bueno', 'u', 'Bueno', 'Bueno', 'u', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', '2025-05-13 23:17:47', '2025-05-13 23:17:47', 1, 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'a', 'u', 'u', 'uu', 'u', 'u', 'u', 'u', 'u', 'uu', 'u', 'u', 'u', 'u', 'u', 'u', 'uu', 'u', 'u', 'u', 'u', NULL, NULL, NULL),
	(13, '562', '2025-05-08', '2', '2', '2', '2', '2', '2', '2', '65', '6', '65', '56', '65', '65', '65', '65', '56', '65', 'q', '6', 6, 6, 6, 6, 6, 6, 6, 6, NULL, '6', NULL, 6, 6, 6, '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6', '6', 'qqq@qq.q', '6', '6', '6', '6', '2', 'COUPE - 3 PUERTAS', '6', '', '', 'Bueno', '6', 'Bueno', '6', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', 'Bueno', '', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', 'Regular', '', '2025-05-14 06:05:54', '2025-05-14 06:05:54', 1, 'Regular', '', 'Regular', '', 'Regular', '', 'Bueno', '', 'Regular', '', 'Bueno', '', 'Bueno', '', 'Bueno', '', '6', '6', '6', '6', '6', '6', '66', '6', '6', '6', '6', '6', '6', '6', '66', '6', '6', '6', '6', '66', '6', 'asdasd', 'asdads', ''),
	(14, '7', '2025-05-07', '8', '8', '8', 'seven', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', 7, 7, 7, 7, 77, 8, 77, 7, '', '7', '7', 7, 7, 7, '787', '68243e055eef3_Frame 1.png', '68243672a7537_2.png', '68243cf85c016_4.png', '68243db33e1d3_4.png', NULL, NULL, NULL, NULL, '787', 'qqq@qq.q', '7', '7', '7', '7', '7', 'MICROBUS', '787', '787', '787', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', 'NO_APLICA', '7', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', '2025-05-14 06:21:38', '2025-05-14 20:32:52', 1, 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', 'NO_APLICA', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '7', '77', '7', '7', '7', '7', '7', '7', '7877', '787', '78', '78', ''),
	(15, '8', '2025-05-08', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', '8', 8, 8, 8, 8, 8, 8, 8, 8, '8', '8', '8', 8, 8, 8, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8', 'qqq@qq.q', '8', '8', '8', '8', '8', 'COUPE - 3 PUERTAS', '8', '8', '8', 'MALO', '8', 'BUENO', '8', 'MALO', '8', 'BUENO', '', 'BUENO', '', 'BUENO', 'BUENO', '', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'REGULAR', '', 'MALO', '', 'MALO', '', 'MALO', '', 'MALO', '', 'BUENO', '', 'MALO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', '2025-05-15 03:18:23', '2025-05-15 03:18:23', 1, 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', '', 'BUENO', 'SSSSSS', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', '0', '0', 'o', 'o', ''),
	(16, '9hhh', '2025-05-07', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', '9', 99, 9, 9, 9, 9, 9, 9, 9, '', '9', '9', 9, 9, 9, '9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9', 'qqq@qq.q9', '9', '9', '9', '9', '9', 'NO APLICA', '9', '9', '9', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', 'NO_APLICA', '', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', '2025-05-15 03:39:13', '2025-05-15 04:49:41', 1, 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', '', '', '', 'i', 'i', 'i', 'oi', 'io', 'oioi', 'io', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', 'oi', '', '', ''),
	(17, 'CTY67H', '2025-05-14', 'ggggg', 'gggg', 'gggg', 'asdasdadsads', 'Ñ', 'ÑÑ', 'Ñ', 'KJJI', 'IUJIIU', 'JUIII', 'IJIJJIJI', 'JIUJJJI', 'UIIJIJ', 'UIUJ', 'JIJIJI', 'IUIJI', 'JIJJII', 'JIUJIYU', 'UHUJH', 16, 0, 15, 0, 29, 0, 15, 14, '', 'AHJHAHJHJAHJ', 'HHAJJAJHAHJ', 76, 78, 89, 'JAHJAJHJHAJAJHAJHAJHA', '6825707105904_licencia atras.jpg', '6825707105bf8_licencia frente.jpeg', '6825707105e1a_licencia frente.jpeg', '6825707106104_licencia atras.jpg', '6825707106423_licencia frente.jpeg', '6825707106922_licencia frente.jpeg', NULL, NULL, 'BHG BHJK JKAJJKAJK', 'NIINJCJHC@GM', '45', '89HNI', '888666', '7876786', '676767678', 'MOTOCICLETA DEPORTIVA', '', 'BBBBBBBBBBBBBBBBBBBBBBBB', 'HBBYUGUYV YUV', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', 'NO_APLICA', '', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', 'KOFO', 'NO_APLICA', 'JJJK', 'NO_APLICA', 'NJHJHHJ', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', '2025-05-15 04:41:21', '2025-05-17 02:17:34', 1, 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'NO_APLICA', '', 'KKKKKKKKK', 'KKKK', 'K', 'K', 'K', 'KK', 'K', 'KK', 'K', 'K', 'K', 'KK', 'K', 'K', 'KK', 'K', 'K', 'KK', 'K', 'JHUYGBBBMNNMKKJKUH', 'JNJJHJKKKJIUH HGYGTYGHAHUHAUI', 'HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH', 'JJJJJJJJJJJJJJJJJJJJJJJJJJJ', 'DOBLE CUNA');

-- Volcando estructura para tabla pritec.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `nombre_completo` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `ultimo_login` datetime DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Volcando datos para la tabla pritec.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `usuario`, `nombre_completo`, `email`, `password`, `fecha_creacion`, `ultimo_login`, `activo`) VALUES
	(1, 'danielcr7122@gmail.com', NULL, NULL, 'd829b843a6550a947e82f2f38ed6b7a7', '2025-05-16 19:17:26', NULL, 1),
	(3, 'admin', 'admin', 'admin@admin.com', '$2y$10$ZC2qaTRaMSpPNF9vFFF3POzqeKJUtpEvZUx5k64nhiosPaDe/HoRe', '2025-05-16 19:24:48', '2025-05-16 19:24:54', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
