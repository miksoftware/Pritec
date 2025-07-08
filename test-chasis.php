<?php
/**
 * Script para insertar datos de prueba en inspección visual interna del chasis
 */

// Incluir conexión
require_once __DIR__ . '/conexion/conexion.php';

try {
    // Crear conexión
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    $peritaje_id = 23;
    
    // Limpiar datos anteriores
    $stmt = $conn->prepare("DELETE FROM inspeccion_visual_chasis WHERE peritaje_id = ?");
    $stmt->bind_param("i", $peritaje_id);
    $stmt->execute();
    $stmt->close();
    
    // Datos de prueba para chasis (10 elementos típicos)
    $piezas_chasis = [
        ['descripcion_pieza' => '1', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '2', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '3', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '4', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '5', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '6', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '7', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '8', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '9', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '10', 'concepto' => 'BUENO']
    ];
    
    // Insertar cada pieza de chasis
    $stmt = $conn->prepare("
        INSERT INTO inspeccion_visual_chasis 
        (peritaje_id, descripcion_pieza, concepto) 
        VALUES (?, ?, ?)
    ");
    
    foreach ($piezas_chasis as $pieza) {
        $stmt->bind_param("iss", $peritaje_id, $pieza['descripcion_pieza'], $pieza['concepto']);
        $stmt->execute();
    }
    $stmt->close();
    
    $conn->close();
    
    echo "✅ Insertadas " . count($piezas_chasis) . " filas de prueba para chasis.\n";
    echo "📄 Ver resultado: http://localhost/Pritec/pdf-modular/paginas/pagina-2.php?id=$peritaje_id\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
