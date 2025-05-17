<?php
// filepath: c:\laragon\www\Pritec\peritaje_completo\Getid.php
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
                $peritaje['fecha_formateada'] = date('d/m/Y', strtotime($peritaje['fecha']));
            }
            
            // Formatear fecha de creación
            if (!empty($peritaje['fecha_creacion'])) {
                $peritaje['fecha_creacion_formateada'] = date('d/m/Y H:i', strtotime($peritaje['fecha_creacion']));
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
            
            // Si existen los Enums, mapearlos
            if (class_exists('ImprontaEnum')) {
                // Mapear enums para interfaz
                $mapeoImprontas = [
                    'ORIGINAL' => 'ORIGINAL',
                    'REGRABADO' => 'REGRABADO',
                    'GRABADO_NO_ORIGINAL' => 'GRABADO_NO_ORIGINAL',
                ];
                
                // Verificar y asegurarse que los valores se mapean correctamente
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
                } else {
                    $peritaje[$field] = 0;
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
        
        error_log("No se encontró peritaje completo con ID: $id");
        return ['error' => 'No se encontró el peritaje solicitado'];
        
    } catch (Exception $e) {
        error_log("Error al obtener peritaje completo: " . $e->getMessage());
        return ['error' => 'Error al cargar los datos: ' . $e->getMessage()];
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}