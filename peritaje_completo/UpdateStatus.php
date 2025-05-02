<?php
session_start();
require_once '../conexion/conexion.php';

try {
    // Validar método y parámetros
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        throw new Exception('ID no válido');
    }

    // Conectar a BD
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Preparar y ejecutar consulta
    $query = "UPDATE peritaje_completo SET estado = 0 WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception("Error en la preparación: " . $conn->error);
    }

    $stmt->bind_param('i', $id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar: " . $stmt->error);
    }

    // Preparar respuesta
    $response = [
        'success' => true,
        'message' => 'Peritaje eliminado exitosamente'
    ];

} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}

// Enviar respuesta
header('Content-Type: application/json');
echo json_encode($response);