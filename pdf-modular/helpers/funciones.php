<?php
/**
 * Funciones helper para el PDF modular
 */

/**
 * Función para formatear conceptos con numeración
 * @param string $concepto El concepto original
 * @param array $listaConceptos Array de conceptos disponibles
 * @return string Concepto formateado con número
 */
function formatearConceptoConNumero($concepto, $listaConceptos) {
    if (empty($concepto)) {
        return '';
    }
    
    // Buscar el índice del concepto en la lista
    $indice = array_search($concepto, $listaConceptos);
    
    if ($indice !== false) {
        // Los arrays empiezan en 0, pero queremos mostrar desde 1
        $numero = $indice + 1;
        return "$concepto - ($numero)";
    }
    
    return $concepto;
}

/**
 * Función para formatear descripción de pieza con número
 * @param string $descripcion La descripción original
 * @param array $listaDescripciones Array asociativo de descripciones
 * @return string Descripción formateada con número
 */
function formatearDescripcionConNumero($descripcion, $listaDescripciones) {
    if (empty($descripcion)) {
        return '';
    }
    
    // Buscar la clave de la descripción en la lista
    $numero = array_search($descripcion, $listaDescripciones);
    
    if ($numero !== false) {
        return "$descripcion - ($numero)";
    }
    
    // Si no se encuentra en el array, simplemente devolver la descripción
    return $descripcion;
}

// Descripción de piezas para carrocería
$descripcionesPiezas = [
    1 => 'BOMPER DELANTERO',
    2 => 'PERSIANA',
    3 => 'GUARDAFANGO DELANTERO IZQ',
    4 => 'PUERTA DELANTERA IZQ',
    5 => 'PUERTA TRASERA IZQ',
    6 => 'COSTADO IZQUIERDO',
    7 => 'PUERTA BAUL',
    8 => 'COSTADO DERECHO',
    9 => 'PUERTA TRASERA DERECHA',
    10 => 'PUERTA DELANTERA DERECHA',
    11 => 'GUARDAFANGO DELANTERO DERECHO',
    12 => 'CAPOT',
    13 => 'TECHO CARROCERIA',
    14 => 'BOMPER TRASERO',
    15 => 'PISO CARROCERIA'
];

// Descripción de piezas para estructura
$descripcionesPiezasEstructura = [
    1 => 'PANEL FRONTAL SUPERIOR',
    2 => 'PANEL FRONTAL INFERIOR',
    3 => 'PUNTA DELANTERA DERECHA',
    4 => 'PUNTA DELANTERA IZQUIERDA',
    5 => 'PUNTA TRASERA DERECHA',
    6 => 'PUNTA TRASERA IZQUIERDA',
    7 => 'MARCO PARALLAMAS',
    8 => 'PARAL PUERTA DELANTERA IZQUIERDA',
    9 => 'PARAL PUERTA DELANTERA DERECHA',
    10 => 'PARAL LARGERO CAPOTA IZQUIERDO',
    11 => 'PARAL LARGERO CAPOTA DERECHO',
    12 => 'PARAL PANORAMICO IZQUIERDO',
    13 => 'PARAL PANORAMICO DERECHO',
    14 => 'PARAL TRASERO CABINA DERECHO N/A PARA ESTRUCTURA DE AUTOMOVILES',
    15 => 'PARAL TRASERO CABINA IZQUIERDO N/A PARA ESTRUCTURA DE AUTOMOVILES',
    16 => 'PARAL CENTRAL IZQUIERDO',
    17 => 'PARAL CENTRAL DERECHO',
    18 => 'CUNA MOTOR',
    19 => 'CAJA DE IMPACTO',
    20 => 'ESTRIBO DERECHO',
    21 => 'ESTRIBO IZQUIERDO',
    22 => 'PANEL TRASERO'
];

// Conceptos para carrocería
$conceptosCarroceria = [
    'Bueno',
    'Buena reparación',
    'Mala reparación',
    'Bien repintado',
    'Mal repintado',
    'Regular',
    'Regular (Oxidación- corrosión)',
    'Fisurado',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido',
    'Rayón',
    'Hermeticidad deficiente'
];

// Conceptos para estructura
$conceptosEstructura = [
    'Bueno',
    'Buena reparación',
    'Mala reparación',
    'Bien repintado',
    'Mal repintado',
    'Regular (Oxidación- corrosión)',
    'Fisurado',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido',
    'Rayón'
];

// Descripción de piezas para chasis
$descripcionesPiezasChasis = [
    1 => 'LARGUERO IZQUIERDO',
    2 => 'LARGUERO DERECHO',
    3 => 'TRAVESAÑO DELANTERO',
    4 => 'TRAVESAÑO CENTRAL',
    5 => 'TRAVESAÑO TRASERO',
    6 => 'SOPORTE DE MOTOR',
    7 => 'SOPORTE DE TRANSMISIÓN',
    8 => 'SOPORTE DE SUSPENSIÓN DELANTERA',
    9 => 'SOPORTE DE SUSPENSIÓN TRASERA',
    10 => 'PUNTOS DE ANCLAJE'
];

// Conceptos para chasis
$conceptosChasis = [
    'Bueno',
    'Mala reparación',
    'Buena reparación',
    'Regular (soldadura no original)',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido'
];

/**
 * Convierte el número de descripción de pieza de carrocería al texto correspondiente
 * @param string|int $numero Número de la pieza
 * @return string Descripción de la pieza o el número original si no se encuentra
 */
function obtenerDescripcionPiezaCarroceria($numero) {
    global $descripcionesPiezas;
    
    // Convertir a entero si es string
    $numero = intval($numero);
    
    // Buscar en el array de descripciones
    if (isset($descripcionesPiezas[$numero])) {
        return $descripcionesPiezas[$numero];
    }
    
    // Si no se encuentra, devolver el número original
    return (string)$numero;
}

/**
 * Convierte el número de descripción de pieza de estructura al texto correspondiente
 * @param string|int $numero Número de la pieza
 * @return string Descripción de la pieza o el número original si no se encuentra
 */
function obtenerDescripcionPiezaEstructura($numero) {
    global $descripcionesPiezasEstructura;
    
    // Convertir a entero si es string
    $numero = intval($numero);
    
    // Buscar en el array de descripciones
    if (isset($descripcionesPiezasEstructura[$numero])) {
        return $descripcionesPiezasEstructura[$numero];
    }
    
    // Si no se encuentra, devolver el número original
    return (string)$numero;
}

/**
 * Obtiene la descripción de pieza con su número correspondiente
 * @param string|int $numero Número de la pieza
 * @param array $arrayDescripciones Array de descripciones
 * @return string Descripción formateada con número
 */
function obtenerDescripcionConNumero($numero, $arrayDescripciones) {
    // Convertir a entero si es string
    $numero = intval($numero);
    
    // Buscar en el array de descripciones
    if (isset($arrayDescripciones[$numero])) {
        return $numero . '. ' . $arrayDescripciones[$numero];
    }
    
    // Si no se encuentra, devolver el número original
    return (string)$numero;
}

/**
 * Valida si un tipo de vehículo es motocicleta
 * @param string $tipoVehiculo Tipo del vehículo
 * @return bool True si es motocicleta, false en caso contrario
 */
function esMotocicleta($tipoVehiculo) {
    return str_contains(strtoupper($tipoVehiculo), 'MOTOCICLETA');
}

/**
 * Formatea el concepto sin número, solo el texto
 * @param string $concepto El concepto original
 * @return string Concepto sin numeración
 */
function formatearConceptoSinNumero($concepto) {
    // Simplemente devolver el concepto tal como está
    return trim($concepto);
}

/**
 * Obtiene el estado de una llanta o amortiguador basado en su porcentaje
 * @param int $porcentaje Porcentaje del 0 al 100
 * @return string Estado correspondiente al porcentaje
 */
function obtenerEstadoPorPorcentaje($porcentaje) {
    $porcentaje = intval($porcentaje);
    
    if ($porcentaje >= 75) {
        return 'Excelente';
    } elseif ($porcentaje >= 50) {
        return 'Bueno';
    } elseif ($porcentaje >= 25) {
        return 'Regular';
    } else {
        return 'Malo';
    }
}

/**
 * Obtiene la clase CSS correspondiente al porcentaje
 * @param int $porcentaje Porcentaje del 0 al 100
 * @return string Clase CSS correspondiente
 */
function obtenerClasePorPorcentaje($porcentaje) {
    $porcentaje = intval($porcentaje);
    
    if ($porcentaje >= 75) {
        return 'porcentaje-excelente';
    } elseif ($porcentaje >= 50) {
        return 'porcentaje-bueno';
    } elseif ($porcentaje >= 25) {
        return 'porcentaje-regular';
    } else {
        return 'porcentaje-malo';
    }
}
?>
