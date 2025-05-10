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


-- Volcando estructura de base de datos para pritec
CREATE DATABASE IF NOT EXISTS `pritec` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pritec`;

-- Volcando estructura para tabla pritec.inspeccion_visual_carroceria
CREATE TABLE IF NOT EXISTS `inspeccion_visual_carroceria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `peritaje_id` (`peritaje_id`),
  CONSTRAINT `inspeccion_visual_carroceria_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla pritec.inspeccion_visual_chasis
CREATE TABLE IF NOT EXISTS `inspeccion_visual_chasis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `peritaje_id` (`peritaje_id`) USING BTREE,
  CONSTRAINT `inspeccion_visual_chasis_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla pritec.inspeccion_visual_estructura
CREATE TABLE IF NOT EXISTS `inspeccion_visual_estructura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `peritaje_id` int NOT NULL,
  `descripcion_pieza` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `concepto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`) USING BTREE,
  KEY `peritaje_id` (`peritaje_id`) USING BTREE,
  CONSTRAINT `inspeccion_visual_estructura_ibfk_1` FOREIGN KEY (`peritaje_id`) REFERENCES `peritaje_completo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla pritec.peritaje_basico
CREATE TABLE IF NOT EXISTS `peritaje_basico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio_para` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convenio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_apellidos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `clase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linea` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cilindraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_chasis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_motor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_carroceria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organismo_transito` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiene_prenda` tinyint(1) DEFAULT '0',
  `tiene_limitacion` tinyint(1) DEFAULT '0',
  `debe_impuestos` tinyint(1) DEFAULT '0',
  `tiene_comparendos` tinyint(1) DEFAULT '0',
  `vehiculo_rematado` tinyint(1) DEFAULT '0',
  `revision_tecnicomecanica` enum('vigente','no_vigente','no_aplica') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rtm_fecha_vencimiento` date DEFAULT NULL,
  `soat` enum('vigente','no_vigente','no_aplica') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soat_fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `licencia_frente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licencia_atras` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_motor` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_chasis` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_serial` enum('original','regrabado','grabado_no_original') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones_finales` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla pritec.peritaje_completo
CREATE TABLE IF NOT EXISTS `peritaje_completo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio_para` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convenio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_apellidos` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `clase` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linea` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cilindraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_chasis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_motor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_carroceria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organismo_transito` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `llanta_anterior_izquierda` int DEFAULT NULL,
  `llanta_anterior_derecha` int DEFAULT NULL,
  `llanta_posterior_izquierda` int DEFAULT NULL,
  `llanta_posterior_derecha` int DEFAULT NULL,
  `amortiguador_anterior_izquierdo` int DEFAULT NULL,
  `amortiguador_anterior_derecho` int DEFAULT NULL,
  `amortiguador_posterior_izquierdo` int DEFAULT NULL,
  `amortiguador_posterior_derecho` int DEFAULT NULL,
  `prueba_escaner` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prueba_bateria` int DEFAULT NULL,
  `prueba_arranque` int DEFAULT NULL,
  `carga_bateria` int DEFAULT NULL,
  `observaciones_bateria` text COLLATE utf8mb4_unicode_ci,
  `fijacion_fotografica_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones_llantas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kilometraje` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_fasecolda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_fasecolda` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_sugerido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_accesorios` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_vehiculo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones_inspeccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `observaciones_estructura` text COLLATE utf8mb4_unicode_ci,
  `observaciones_chasis` text COLLATE utf8mb4_unicode_ci,
  `estado_arranque` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_arranque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_radiador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_radiador` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_carter_motor` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_carter_motor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_carter_caja` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_carter_caja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_caja_velocidades` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_caja_velocidades` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_soporte_caja` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_soporte_motor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_soporte_caja` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_soporte_motor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_mangueras_radiador` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_mangueras_radiador` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_correas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_correas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tension_correas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_tension_correas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_filtro_aire` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_filtro_aire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_externo_bateria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_externo_bateria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_pastilla_freno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_pastilla_freno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_discos_freno` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_discos_freno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_punta_eje` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_punta_eje` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_axiales` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_axiales` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_terminales` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_terminales` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_rotulas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_rotulas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tijeras` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_tijeras` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_caja_direccion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_caja_direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_rodamientos` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_rodamientos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_cardan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_cardan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_crucetas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_crucetas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT (now()),
  `fecha_actualizacion` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  `estado_calefaccion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_calefaccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_aire_acondicionado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_aire_acondicionado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_cinturones` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_cinturones` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tapiceria_asientos` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_tapiceria_asientos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tapiceria_techo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_tapiceria_techo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_millaret` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_millaret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_alfombra` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_alfombra` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_chapas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_chapas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_fuga_aceite_motor` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_aceite_caja_velocidades` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_aceite_caja_transmision` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_liquido_frenos` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_aceite_direccion_hidraulica` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_liquido_bomba_embrague` text COLLATE utf8mb4_unicode_ci,
  `respuesta_fuga_tanque_combustible` text COLLATE utf8mb4_unicode_ci,
  `respuesta_estado_tanque_silenciador` text COLLATE utf8mb4_unicode_ci,
  `respuesta_estado_tubo_exhosto` text COLLATE utf8mb4_unicode_ci,
  `respuesta_estado_tanque_catalizador_gases` text COLLATE utf8mb4_unicode_ci,
  `respuesta_estado_guardapolvo_caja_direccion` text COLLATE utf8mb4_unicode_ci,
  `respuesta_estado_tuberia_frenos` text COLLATE utf8mb4_unicode_ci,
  `respuesta_viscosidad_aceite_motor` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_refrigerante_motor` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_liquido_frenos` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_agua_limpiavidrios` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_aceite_direccion_hidraulica` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_liquido_embrague` text COLLATE utf8mb4_unicode_ci,
  `respuesta_nivel_aceite_motor` text COLLATE utf8mb4_unicode_ci,
  `prueba_ruta` text COLLATE utf8mb4_unicode_ci,
  `observaciones_fugas` text COLLATE utf8mb4_unicode_ci,
  `observaciones_motor` text COLLATE utf8mb4_unicode_ci,
  `observaciones_interior` text COLLATE utf8mb4_unicode_ci,
  `tipo_chasis` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla pritec.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
