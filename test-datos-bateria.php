<?php
/**
 * Script de prueba para datos de batería
 * Simula datos de batería para testing del PDF modular
 */

// Datos de prueba para batería
$datosPruebaBateria = [
    'bateria_voltaje' => 85,           // Excelente
    'bateria_amperaje' => 60,          // Bueno  
    'bateria_estado_fisico' => 30,     // Bajo
    'bateria_terminales' => 95,        // Excelente
    'bateria_carga' => 15,             // Crítico
    'observaciones_bateria' => 'Observaciones de prueba para la batería del vehículo. Se recomienda revisar la conexión de los terminales y considerar el reemplazo próximo debido al bajo estado de carga.'
];

// Si se incluye en otra página, agregar los datos al array $peritaje
if (isset($peritaje) && is_array($peritaje)) {
    $peritaje = array_merge($peritaje, $datosPruebaBateria);
    echo "<!-- Datos de prueba de batería agregados al peritaje -->\n";
} else {
    // Si se ejecuta directamente, mostrar los datos
    echo "<!DOCTYPE html>\n";
    echo "<html>\n<head>\n<title>Datos de Prueba - Batería</title>\n</head>\n<body>\n";
    echo "<h1>Datos de Prueba para Batería</h1>\n";
    echo "<pre>\n";
    print_r($datosPruebaBateria);
    echo "</pre>\n";
    echo "<p>Para usar estos datos, incluye este archivo en tu script de peritaje.</p>\n";
    echo "</body>\n</html>\n";
}
?>
