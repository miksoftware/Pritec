<?php
// filepath: c:\laragon\www\Pritec\peritaje_basico\Getid.php
require_once dirname(__DIR__) . '/conexion/conexion.php';

// Si existen, cargar los Enums
if (file_exists(dirname(__DIR__) . '/Enums/SeguroEnum.php')) {
    require_once dirname(__DIR__) . '/Enums/SeguroEnum.php';
}
if (file_exists(dirname(__DIR__) . '/Enums/ImprontaEnum.php')) {
    require_once dirname(__DIR__) . '/Enums/ImprontaEnum.php';
}

// Detectar si es una llamada AJAX directa, y sólo entonces enviar cabeceras JSON y salida directa
if (isset($_GET['id']) && !defined('NO_DIRECT_JSON_OUTPUT')) {
    header('Content-Type: application/json');
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        echo json_encode(obtenerPeritajePorId($id));
    } else {
        echo json_encode(['error' => 'ID inválido']);
    }
    exit;
}

function obtenerPeritajePorId($id) {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM peritaje_basico WHERE id = ? AND estado = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $peritaje = $resultado->fetch_assoc();
            
            // Formatear fechas si existen
            if (!empty($peritaje['rtm_fecha_vencimiento'])) {
                $peritaje['rtm_fecha_vencimiento'] = date('Y-m-d', strtotime($peritaje['rtm_fecha_vencimiento']));
            }
            
            if (!empty($peritaje['soat_fecha_vencimiento'])) {
                $peritaje['soat_fecha_vencimiento'] = date('Y-m-d', strtotime($peritaje['soat_fecha_vencimiento']));
            }
            
            // Formatear para presentación
            if (isset($peritaje['fecha_creacion']) && !empty($peritaje['fecha_creacion'])) {
                $peritaje['fecha_creacion_formateada'] = date('d/m/Y H:i', strtotime($peritaje['fecha_creacion']));
            } else {
                $peritaje['fecha_creacion_formateada'] = '';
            }
            
            if (isset($peritaje['fecha']) && !empty($peritaje['fecha'])) {
                $peritaje['fecha_formateada'] = date('d/m/Y', strtotime($peritaje['fecha']));
            } else {
                $peritaje['fecha_formateada'] = '';
            }
            
            // Si existen los Enums, mapearlos
            if (class_exists('SeguroEnum') && class_exists('ImprontaEnum')) {
                // Mapear enums para interfaz
                $mapeoSeguros = [
                    'VIGENTE' => 'VIGENTE',
                    'NO_VIGENTE' => 'NO_VIGENTE',
                    'NO_APLICA' => 'NO_APLICA'
                ];
                
                $mapeoImprontas = [
                    'ORIGINAL' => 'ORIGINAL',
                    'REGRABADO' => 'REGRABADO',
                    'GRABADO_NO_ORIGINAL' => 'GRABADO_NO_ORIGINAL',
                ];
                
                // Verificar y asegurarse que los valores se mapean correctamente
                if (isset($peritaje['revision_tecnicomecanica'])) {
                    $peritaje['rtm'] = isset($mapeoSeguros[strtoupper($peritaje['revision_tecnicomecanica'])]) 
                        ? strtoupper($peritaje['revision_tecnicomecanica']) 
                        : 'NO_APLICA';
                }
                
                if (isset($peritaje['soat'])) {
                    $peritaje['soat_estado'] = isset($mapeoSeguros[strtoupper($peritaje['soat'])]) 
                        ? strtoupper($peritaje['soat']) 
                        : 'NO_APLICA';
                }
                
                if (isset($peritaje['estado_motor'])) {
                    $peritaje['estado_motor_valor'] = isset($mapeoImprontas[strtoupper($peritaje['estado_motor'])]) 
                        ? strtoupper($peritaje['estado_motor']) 
                        : 'ORIGINAL';
                }
                
                if (isset($peritaje['estado_chasis'])) {
                    $peritaje['estado_chasis_valor'] = isset($mapeoImprontas[strtoupper($peritaje['estado_chasis'])]) 
                        ? strtoupper($peritaje['estado_chasis']) 
                        : 'ORIGINAL';
                }
                
                if (isset($peritaje['estado_serial'])) {
                    $peritaje['estado_serial_valor'] = isset($mapeoImprontas[strtoupper($peritaje['estado_serial'])]) 
                        ? strtoupper($peritaje['estado_serial']) 
                        : 'ORIGINAL';
                }
            }
            
            // Asegurar que los campos booleanos están como enteros 0/1
            $booleanFields = [
                'tiene_prenda', 'tiene_limitacion', 'debe_impuestos', 
                'tiene_comparendos', 'vehiculo_rematado'
            ];
            
            foreach ($booleanFields as $field) {
                if (isset($peritaje[$field])) {
                    $peritaje[$field] = (int)$peritaje[$field];
                }
            }
            
            // Asegurar que no hay datos null
            foreach ($peritaje as $key => $value) {
                if ($value === null) {
                    $peritaje[$key] = '';
                }
            }
            
            return $peritaje;
        }
        
        return false;
        
    } catch (Exception $e) {
        error_log("Error al obtener peritaje básico: " . $e->getMessage());
        return ['error' => 'Error al cargar los datos: ' . $e->getMessage()];
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}