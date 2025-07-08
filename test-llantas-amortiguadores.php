<?php
/**
 * Script para insertar datos de prueba de llantas y amortiguadores
 */

// Incluir conexión
require_once __DIR__ . '/conexion/conexion.php';

try {
    // Crear conexión
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    $peritaje_id = 23; // Cambiar por el ID del peritaje que quieras actualizar
    
    // Actualizar datos de llantas y amortiguadores en peritaje_completo
    $stmt = $conn->prepare("
        UPDATE peritaje_completo 
        SET 
            llanta_anterior_izquierda = ?,
            llanta_anterior_derecha = ?,
            llanta_posterior_izquierda = ?,
            llanta_posterior_derecha = ?,
            observaciones_llantas = ?,
            amortiguador_anterior_izquierdo = ?,
            amortiguador_anterior_derecho = ?,
            amortiguador_posterior_izquierdo = ?,
            amortiguador_posterior_derecho = ?,
            observaciones_amortiguadores = ?
        WHERE id = ?
    ");
    
    // Datos de prueba
    $llanta_ant_izq = 85;  // Excelente
    $llanta_ant_der = 70;  // Bueno
    $llanta_post_izq = 45; // Regular
    $llanta_post_der = 20; // Malo
    $obs_llantas = "Llanta posterior derecha necesita reemplazo urgente. Las demás en condiciones aceptables.";
    
    $amort_ant_izq = 90;   // Excelente
    $amort_ant_der = 75;   // Excelente
    $amort_post_izq = 60;  // Bueno
    $amort_post_der = 35;  // Regular
    $obs_amortiguadores = "Amortiguador posterior derecho presenta leve pérdida de presión. Revisar en próximo mantenimiento.";
    
    $stmt->bind_param(
        "iiiiisiiisi", 
        $llanta_ant_izq, 
        $llanta_ant_der, 
        $llanta_post_izq, 
        $llanta_post_der, 
        $obs_llantas,
        $amort_ant_izq, 
        $amort_ant_der, 
        $amort_post_izq, 
        $amort_post_der, 
        $obs_amortiguadores,
        $peritaje_id
    );
    
    if ($stmt->execute()) {
        echo "✅ Datos de llantas y amortiguadores actualizados correctamente para el peritaje ID: $peritaje_id\n\n";
        echo "📊 Datos insertados:\n";
        echo "Llantas:\n";
        echo "  - Anterior izquierda: $llanta_ant_izq% (Excelente)\n";
        echo "  - Anterior derecha: $llanta_ant_der% (Bueno)\n";
        echo "  - Posterior izquierda: $llanta_post_izq% (Regular)\n";
        echo "  - Posterior derecha: $llanta_post_der% (Malo)\n\n";
        echo "Amortiguadores:\n";
        echo "  - Anterior izquierdo: $amort_ant_izq% (Excelente)\n";
        echo "  - Anterior derecho: $amort_ant_der% (Excelente)\n";
        echo "  - Posterior izquierdo: $amort_post_izq% (Bueno)\n";
        echo "  - Posterior derecho: $amort_post_der% (Regular)\n\n";
        echo "🔗 Probar en: http://localhost/Pritec/peritaje-modular.php?id=$peritaje_id\n";
    } else {
        echo "❌ Error al actualizar datos: " . $stmt->error . "\n";
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>