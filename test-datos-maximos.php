<?php
/**
 * Script para insertar múltiples filas de prueba en inspección de carrocería
 * Esto nos permitirá verificar el comportamiento responsivo
 */

// Incluir conexión
require_once __DIR__ . '/conexion/conexion.php';

try {
    // Crear conexión
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    // ID del peritaje (usar uno existente)
    $peritaje_id = 23; // Cambiar según necesites
    
    // Primero limpiar datos anteriores de este peritaje
    $stmt = $conn->prepare("DELETE FROM inspeccion_visual_carroceria WHERE peritaje_id = ?");
    $stmt->bind_param("i", $peritaje_id);
    $stmt->execute();
    $stmt->close();
    
    // Datos de prueba para carrocería (14 elementos máximo)
    $piezas_carroceria = [
        ['descripcion_pieza' => '1', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '2', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '3', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '4', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '5', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '6', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '7', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '8', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '9', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '10', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '11', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '12', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '13', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '14', 'concepto' => 'MALO']
    ];
    
    // Insertar cada pieza
    $stmt = $conn->prepare("
        INSERT INTO inspeccion_visual_carroceria 
        (peritaje_id, descripcion_pieza, concepto) 
        VALUES (?, ?, ?)
    ");
    
    foreach ($piezas_carroceria as $pieza) {
        $stmt->bind_param("iss", $peritaje_id, $pieza['descripcion_pieza'], $pieza['concepto']);
        $stmt->execute();
    }
    $stmt->close();
    
    echo "✅ Insertadas " . count($piezas_carroceria) . " filas de prueba para carrocería.\n";
    echo "📄 Puedes ver el resultado en: http://localhost/Pritec/pdf-modular/paginas/pagina-1.php?id=" . $peritaje_id . "\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

try {
    // También insertar datos para estructura
    $stmt = $conn->prepare("DELETE FROM inspeccion_visual_estructura WHERE peritaje_id = ?");
    $stmt->bind_param("i", $peritaje_id);
    $stmt->execute();
    $stmt->close();
    
    // Datos de prueba para estructura (14 elementos máximo)
    $piezas_estructura = [
        ['descripcion_pieza' => '1', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '2', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '3', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '4', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '5', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '6', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '7', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '8', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '9', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '10', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '11', 'concepto' => 'MALO'],
        ['descripcion_pieza' => '12', 'concepto' => 'REGULAR'],
        ['descripcion_pieza' => '13', 'concepto' => 'BUENO'],
        ['descripcion_pieza' => '14', 'concepto' => 'MALO']
    ];
    
    // Insertar cada pieza de estructura
    $stmt = $conn->prepare("
        INSERT INTO inspeccion_visual_estructura 
        (peritaje_id, descripcion_pieza, concepto) 
        VALUES (?, ?, ?)
    ");
    
    foreach ($piezas_estructura as $pieza) {
        $stmt->bind_param("iss", $peritaje_id, $pieza['descripcion_pieza'], $pieza['concepto']);
        $stmt->execute();
    }
    $stmt->close();
    
    echo "✅ Insertadas " . count($piezas_estructura) . " filas de prueba para estructura.\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error en estructura: " . $e->getMessage() . "\n";
}
?>
