<?php
require_once dirname(__DIR__) . '/conexion/conexion.php';
require_once dirname(__DIR__) . '/Enums/SeguroEnum.php';
require_once dirname(__DIR__) . '/Enums/ImprontaEnum.php';

function obtenerPeritajePorId($id) {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM peritaje_basico WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $peritaje = $resultado->fetch_assoc();
            
            // Formatear fechas
            if (!empty($peritaje['rtm_fecha_vencimiento'])) {
                $peritaje['rtm_fecha_vencimiento'] = date('Y-m-d', strtotime($peritaje['rtm_fecha_vencimiento']));
            }
            if (!empty($peritaje['soat_fecha_vencimiento'])) {
                $peritaje['soat_fecha_vencimiento'] = date('Y-m-d', strtotime($peritaje['soat_fecha_vencimiento']));
            }
            if (!empty($peritaje['fecha'])) {
                $peritaje['fecha'] = date('Y-m-d', strtotime($peritaje['fecha']));
            }
            
            // IMPORTANTE: Asignar el valor de revision_tecnicomecanica al campo rtm
            // Convertir de minúsculas a mayúsculas para que coincida con las constantes ENUM
            $peritaje['rtm'] = strtoupper($peritaje['revision_tecnicomecanica'] ?? '');
            
            // Convertir valores de enum a mayúsculas para que coincidan con las constantes
            $peritaje['soat'] = strtoupper($peritaje['soat'] ?? '');
            $peritaje['estado_motor'] = strtoupper($peritaje['estado_motor'] ?? '');
            $peritaje['estado_chasis'] = strtoupper($peritaje['estado_chasis'] ?? '');
            $peritaje['estado_serial'] = strtoupper($peritaje['estado_serial'] ?? '');
            
            // Mapeo directo a las constantes ENUM (asegura valores exactos)
            // Para los campos de seguro (SOAT, RTM)
            $mapeoSeguros = [
                'VIGENTE' => SeguroEnum::VIGENTE,
                'NO_VIGENTE' => SeguroEnum::NO_VIGENTE,
                'NO_APLICA' => SeguroEnum::NO_APLICA,
            ];
            
            // Para los campos de estado (improntas)
            $mapeoImprontas = [
                'ORIGINAL' => ImprontaEnum::ORIGINAL,
                'REGRABADO' => ImprontaEnum::REGRABADO, 
                'GRABADO_NO_ORIGINAL' => ImprontaEnum::GRABADO_NO_ORIGINAL,
            ];
            
            // Verificar y asegurarse que los valores se mapean correctamente
            $peritaje['rtm'] = isset($mapeoSeguros[$peritaje['rtm']]) ? $peritaje['rtm'] : SeguroEnum::NO_APLICA;
            $peritaje['soat'] = isset($mapeoSeguros[$peritaje['soat']]) ? $peritaje['soat'] : SeguroEnum::NO_APLICA;
            $peritaje['estado_motor'] = isset($mapeoImprontas[$peritaje['estado_motor']]) ? $peritaje['estado_motor'] : ImprontaEnum::ORIGINAL;
            $peritaje['estado_chasis'] = isset($mapeoImprontas[$peritaje['estado_chasis']]) ? $peritaje['estado_chasis'] : ImprontaEnum::ORIGINAL;
            $peritaje['estado_serial'] = isset($mapeoImprontas[$peritaje['estado_serial']]) ? $peritaje['estado_serial'] : ImprontaEnum::ORIGINAL;
            
            // Asegurar que los campos booleanos están como enteros 0/1
            $booleanFields = ['tiene_prenda', 'tiene_limitacion', 'debe_impuestos', 
                             'tiene_comparendos', 'vehiculo_rematado'];
            foreach ($booleanFields as $field) {
                if (isset($peritaje[$field])) {
                    $peritaje[$field] = (int)$peritaje[$field];
                }
            }
            
            // Debug para verificar valores
            error_log("Valores cargados desde BD:");
            error_log("RTM: " . $peritaje['rtm'] . " - Original: " . $peritaje['revision_tecnicomecanica']);
            error_log("SOAT: " . $peritaje['soat']);
            error_log("Estado motor: " . $peritaje['estado_motor']);
            error_log("Estado chasis: " . $peritaje['estado_chasis']);
            error_log("Estado serial: " . $peritaje['estado_serial']);
            
            return $peritaje;
        }
        
        error_log("No se encontró peritaje con ID: $id");
        return null;
        
    } catch (Exception $e) {
        error_log("Error al obtener peritaje: " . $e->getMessage());
        return array('error' => $e->getMessage());
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}