-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
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

-- Volcando estructura para tabla pritec.peritaje_basico
CREATE TABLE IF NOT EXISTS `peritaje_basico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio_para` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convenio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_apellidos` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `clase` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linea` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cilindraje` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_chasis` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_serie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_carroceria` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organismo_transito` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiene_prenda` tinyint(1) DEFAULT '0',
  `tiene_limitacion` tinyint(1) DEFAULT '0',
  `debe_impuestos` tinyint(1) DEFAULT '0',
  `tiene_comparendos` tinyint(1) DEFAULT '0',
  `vehiculo_rematado` tinyint(1) DEFAULT '0',
  `revision_tecnicomecanica` enum('vigente','no_vigente','no_aplica') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rtm_fecha_vencimiento` date DEFAULT NULL,
  `soat` enum('vigente','no_vigente','no_aplica') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soat_fecha_vencimiento` date DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `licencia_frente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licencia_atras` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_motor` enum('original','regrabado','grabado_no_original') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_chasis` enum('original','regrabado','grabado_no_original') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_serial` enum('original','regrabado','grabado_no_original') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones_finales` text COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla pritec.peritaje_basico: ~3 rows (aproximadamente)
INSERT INTO `peritaje_basico` (`id`, `placa`, `fecha`, `no_servicio`, `servicio_para`, `convenio`, `nombre_apellidos`, `identificacion`, `telefono`, `direccion`, `clase`, `marca`, `linea`, `cilindraje`, `servicio`, `modelo`, `color`, `no_chasis`, `no_motor`, `no_serie`, `tipo_carroceria`, `organismo_transito`, `tiene_prenda`, `tiene_limitacion`, `debe_impuestos`, `tiene_comparendos`, `vehiculo_rematado`, `revision_tecnicomecanica`, `rtm_fecha_vencimiento`, `soat`, `soat_fecha_vencimiento`, `observaciones`, `licencia_frente`, `licencia_atras`, `estado_motor`, `estado_chasis`, `estado_serial`, `observaciones_finales`, `fecha_creacion`, `fecha_actualizacion`, `estado`) VALUES
	(1, 'w', '2025-01-01', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'ww', 'w', 'w', 'w', 'w', 'w', 0, 0, 0, 0, 1, 'no_aplica', NULL, 'no_aplica', NULL, 'asdas', '6789f1867e0b1_Captura de pantalla 2024-12-27 113309.png', '6789f1867e831_Captura de pantalla 2024-12-27 113348.png', 'regrabado', 'regrabado', 'regrabado', 'sdc', '2025-01-17 05:58:30', '2025-01-17 05:58:30', 1),
	(2, '3', '2025-01-14', '33', '3', '3', 'rrrr', 'rrrrrr', '3', '3', '3', '3', '33', '3', '3', '3', '3', '3', '', '3', '3', '3', 1, 0, 0, 0, 1, 'vigente', '2025-01-22', 'vigente', '2025-01-22', 'asdasdads', '678f04fbd6b02_costillas.jpg', '678f04fbd7442_HAMBURGUESA.jpg', 'regrabado', 'regrabado', 'grabado_no_original', 'asdadas', '2025-01-21 02:22:51', '2025-01-21 04:58:08', 0),
	(3, '5', '2025-01-02', '5', '5', '5', '5', '5', '5', '6', '5', '5', '5', '5', '5', '5', '', '5', '5', '5', '5', '5', 1, 0, 1, 1, 1, 'vigente', '2025-01-21', 'no_aplica', NULL, 'adasdasadsdas', '678f29a2d76b9_Tarjeta de presentación formal negro y blanco elegante.png', '678f29a2df7f4_Tarjeta de presentación formal negro y blanco elegante.png', 'regrabado', 'grabado_no_original', 'original', 'asdasdas', '2025-01-21 04:59:14', '2025-01-24 02:57:56', 1);

-- Volcando estructura para tabla pritec.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla pritec.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `usuario`, `password`) VALUES
	(1, 'danielcr7122@gmail.com', 'd829b843a6550a947e82f2f38ed6b7a7');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

-- Volcando estructura para tabla pritec.peritaje_basico
CREATE TABLE IF NOT EXISTS `peritaje_completo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `no_servicio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio_para` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convenio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_apellidos` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identificacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `clase` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linea` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cilindraje` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `servicio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modelo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_chasis` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_serie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_carroceria` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organismo_transito` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `llanta_anterior_izquierda` int NOT NULL,
  `llanta_anterior_derecha` int NOT NULL,
  `llanta_posterior_izquierda` int NOT NULL,
  `llanta_posterior_derecha` int NOT NULL,
  `amortiguador_anterior_izquierdo` int NOT NULL,
  `amortiguador_anterior_derecho` int NOT NULL,
  `amortiguador_posterior_izquierdo` int NOT NULL,
  `amortiguador_posterior_derecho` int NOT NULL,
  `estado_cauchos_suspension` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tanque_catalizador_gases` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tubo_exhosto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_radiador` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_externo_bateria` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_cables_instalacion_alta` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tanque_silenciador` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_filtro_aire` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_brazos_direccion_rotulas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fugas_tanque_combustible` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fugas_aceite_amortiguadores` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fugas_liquido_bomba_embrague` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuga_aceite_direccion_hidraulica` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuga_liquido_frenos` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuga_aceite_caja_transmision` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuga_aceite_caja_velocidades` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tension_correas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_correas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_mangueras_radiador` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tuberias_frenos` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_guardapolvo_caja_direccion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_protectores_inferiores` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_carter` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuga_aceite_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_guardapolvos_ejes` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_tijeras` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_radiador_aa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_soporte_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_carcasa_caja_velocidades` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viscosidad_aceite_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_refrigerante_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_liquido_frenos` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_agua_limpiavidrios` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_aceite_direccion_hidraulica` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_liquido_embrague` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nivel_aceite_motor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `funcionamiento_aa` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `soporte_caja_velocidades` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fijacion_fotografica_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int DEFAULT '1',
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `observaciones2` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kilometraje` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_fasecolda` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_fasecolda` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_sugerido` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_accesorios` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;