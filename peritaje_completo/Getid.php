<?php
require_once dirname(__DIR__) . '/conexion/conexion.php';

function obtenerPeritajePorId($id) {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM peritaje_completo WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $peritaje = $resultado->fetch_assoc();
            
            return $peritaje;
        }
        
        return null;
        
    } catch (Exception $e) {
        return array('error' => $e->getMessage());
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}
?>