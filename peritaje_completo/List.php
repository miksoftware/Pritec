<?php
require_once '../conexion/conexion.php';

function listarPeritajes() {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT 
                    id,
                    nombre_apellidos,
                    identificacion,
                    placa,
                    telefono,
                    fecha
                FROM peritaje_completo 
                WHERE estado = 1
                ORDER BY fecha_creacion DESC";
                
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $peritajes = array();
        while ($row = $resultado->fetch_assoc()) {
            $peritajes[] = array(
                'id' => $row['id'],
                'nombre_apellidos' => $row['nombre_apellidos'],
                'identificacion' => $row['identificacion'],
                'placa' => $row['placa'],
                'telefono' => $row['telefono'],
                'fecha' => $row['fecha']
            );
        }
        
        return $peritajes;
        
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}

// Si se hace una petición AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(listarPeritajes());
}