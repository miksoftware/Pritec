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
            
            // Para el campo RTM (revision_tecnicomecanica)
            $peritaje['rtm'] = $peritaje['revision_tecnicomecanica'] ?? '';
            
            // Asegurar que los valores de los enums sean exactamente los mismos que en las clases Enum
            // Para los campos de estado (improntas)
            $mapeoImprontas = [
                'ORIGINAL' => ImprontaEnum::ORIGINAL,
                'REGRABADO' => ImprontaEnum::REGRABADO,
                'GRABADO_NO_ORIGINAL' => ImprontaEnum::GRABADO_NO_ORIGINAL,
            ];
            
            // Para los campos de seguro (SOAT, RTM)
            $mapeoSeguros = [
                'VIGENTE' => SeguroEnum::VIGENTE,
                'NO_VIGENTE' => SeguroEnum::NO_VIGENTE,
                'NO_APLICA' => SeguroEnum::NO_APLICA,
            ];
            
            // Aplicar mapeo para asegurar valores exactos
            if (isset($peritaje['estado_motor'])) {
                $peritaje['estado_motor'] = $mapeoImprontas[$peritaje['estado_motor']] ?? ImprontaEnum::ORIGINAL;
            }
            
            if (isset($peritaje['estado_chasis'])) {
                $peritaje['estado_chasis'] = $mapeoImprontas[$peritaje['estado_chasis']] ?? ImprontaEnum::ORIGINAL;
            }
            
            if (isset($peritaje['estado_serial'])) {
                $peritaje['estado_serial'] = $mapeoImprontas[$peritaje['estado_serial']] ?? ImprontaEnum::ORIGINAL;
            }
            
            if (isset($peritaje['soat'])) {
                $peritaje['soat'] = $mapeoSeguros[$peritaje['soat']] ?? SeguroEnum::NO_APLICA;
            }
            
            if (isset($peritaje['revision_tecnicomecanica'])) {
                $peritaje['revision_tecnicomecanica'] = $mapeoSeguros[$peritaje['revision_tecnicomecanica']] ?? SeguroEnum::NO_APLICA;
                $peritaje['rtm'] = $peritaje['revision_tecnicomecanica']; // Garantizar que rtm tenga el valor correcto
            }
            
            // Asegurar que los campos booleanos están como enteros 0/1
            $booleanFields = ['tiene_prenda', 'tiene_limitacion', 'debe_impuestos', 
                             'tiene_comparendos', 'vehiculo_rematado'];
            foreach ($booleanFields as $field) {
                if (isset($peritaje[$field])) {
                    $peritaje[$field] = (int)$peritaje[$field];
                }
            }
            
            // Debug para ver qué valores tenemos
            error_log("Valores disponibles en ImprontaEnum: " . print_r(ImprontaEnum::getOptions(), true));
            error_log("Valores disponibles en SeguroEnum: " . print_r(SeguroEnum::getOptions(), true));
            error_log("Valor de estado_motor: " . $peritaje['estado_motor']);
            error_log("Valor de estado_chasis: " . $peritaje['estado_chasis']);
            error_log("Valor de estado_serial: " . $peritaje['estado_serial']);
            error_log("Valor de soat: " . $peritaje['soat']);
            error_log("Valor de rtm: " . $peritaje['rtm']);
            
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
?>