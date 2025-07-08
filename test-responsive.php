<?php
/**
 * Script para probar diferentes cantidades de filas en inspección
 * Permite verificar el comportamiento responsivo con 5, 10 y 14 filas
 */

// Incluir conexión
require_once __DIR__ . '/conexion/conexion.php';

if (!isset($argv[1])) {
    echo "Uso: php test-responsive.php [5|10|14]\n";
    echo "Ejemplo: php test-responsive.php 14\n";
    exit(1);
}

$cantidad = (int)$argv[1];

if (!in_array($cantidad, [5, 10, 14])) {
    echo "❌ Error: Solo se permiten 5, 10 o 14 filas\n";
    exit(1);
}

try {
    // Crear conexión
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    $peritaje_id = 23;
    
    // Limpiar datos anteriores
    $stmt = $conn->prepare("DELETE FROM inspeccion_visual_carroceria WHERE peritaje_id = ?");
    $stmt->bind_param("i", $peritaje_id);
    $stmt->execute();
    $stmt->close();
    
    $stmt = $conn->prepare("DELETE FROM inspeccion_visual_estructura WHERE peritaje_id = ?");
    $stmt->bind_param("i", $peritaje_id);
    $stmt->execute();
    $stmt->close();
    
    // Generar datos según la cantidad solicitada
    $conceptos = ['BUENO', 'REGULAR', 'MALO'];
    
    // Insertar carrocería
    $stmt = $conn->prepare("INSERT INTO inspeccion_visual_carroceria (peritaje_id, descripcion_pieza, concepto) VALUES (?, ?, ?)");
    
    for ($i = 1; $i <= $cantidad; $i++) {
        $concepto = $conceptos[($i - 1) % count($conceptos)];
        $stmt->bind_param("iss", $peritaje_id, $i, $concepto);
        $stmt->execute();
    }
    $stmt->close();
    
    // Insertar estructura
    $stmt = $conn->prepare("INSERT INTO inspeccion_visual_estructura (peritaje_id, descripcion_pieza, concepto) VALUES (?, ?, ?)");
    
    for ($i = 1; $i <= $cantidad; $i++) {
        $concepto = $conceptos[($i - 1) % count($conceptos)];
        $stmt->bind_param("iss", $peritaje_id, $i, $concepto);
        $stmt->execute();
    }
    $stmt->close();
    
    $conn->close();
    
    echo "✅ Insertadas $cantidad filas para carrocería y estructura.\n";
    echo "📄 Ver resultado: http://localhost/Pritec/pdf-modular/paginas/pagina-1.php?id=$peritaje_id\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
