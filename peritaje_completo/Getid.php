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
            
            // Formatear fechas si existen
            if (!empty($peritaje['fecha'])) {
                $peritaje['fecha'] = date('Y-m-d', strtotime($peritaje['fecha']));
            }
            
            // Asegurar que los campos para los selects estén correctos
            // Estados posibles para los selects
            $estadosValidos = ['Bueno', 'Regular', 'Malo', 'No Aplica'];
            
            // Lista de todos los campos estado_*
            $camposEstado = [
                'estado_arranque', 'estado_radiador', 'estado_carter_motor', 
                'estado_carter_caja', 'estado_caja_velocidades', 'estado_soporte_caja',
                'estado_soporte_motor', 'estado_mangueras_radiador', 'estado_correas',
                'tension_correas', 'estado_filtro_aire', 'estado_externo_bateria',
                'estado_pastilla_freno', 'estado_discos_freno', 'estado_punta_eje',
                'estado_axiales', 'estado_terminales', 'estado_rotulas',
                'estado_tijeras', 'estado_caja_direccion', 'estado_rodamientos',
                'estado_cardan', 'estado_crucetas', 'estado_calefaccion',
                'estado_aire_acondicionado', 'estado_cinturones', 'estado_tapiceria_asientos',
                'estado_tapiceria_techo', 'estado_millaret', 'estado_alfombra',
                'estado_chapas'
            ];
            
            // Normalizar valores de los campos estado
            foreach ($camposEstado as $campo) {
                if (isset($peritaje[$campo])) {
                    // Si el valor no está en los estados válidos, asignar valor por defecto
                    if (!in_array($peritaje[$campo], $estadosValidos)) {
                        $peritaje[$campo] = 'No Aplica';
                    }
                } else {
                    // Si el campo no existe, asignar valor por defecto
                    $peritaje[$campo] = 'No Aplica';
                }
            }
            
            // Log para depuración
            error_log("Peritaje recuperado con ID {$id}: " . print_r($peritaje, true));
            
            return $peritaje;
        }
        
        error_log("No se encontró peritaje con ID: $id");
        return null;
        
    } catch (Exception $e) {
        error_log("Error al obtener peritaje completo: " . $e->getMessage());
        return array('error' => $e->getMessage());
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}
?>