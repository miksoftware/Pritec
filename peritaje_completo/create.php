<?php
session_start();
require_once '../conexion/conexion.php';

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Validación de campos obligatorios
    if (empty($_POST['placa']) || empty($_POST['fecha']) || empty($_POST['nombre_apellidos']) || empty($_POST['identificacion'])) {
        throw new Exception("Todos los campos marcados son obligatorios");
    }

    if (isset($_FILES['fijacion_fotografica_1']) && $_FILES['fijacion_fotografica_1']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fijacion_fotografica_1_nombre = uniqid() . '_' . $_FILES['fijacion_fotografica_1']['name'];
        move_uploaded_file($_FILES['fijacion_fotografica_1']['tmp_name'], $uploadDir . $fijacion_fotografica_1_nombre);
    }

    if (isset($_FILES['fijacion_fotografica_2']) && $_FILES['fijacion_fotografica_2']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fijacion_fotografica_2_nombre = uniqid() . '_' . $_FILES['fijacion_fotografica_2']['name'];
        move_uploaded_file($_FILES['fijacion_fotografica_2']['tmp_name'], $uploadDir . $fijacion_fotografica_2_nombre);
    }

    if (isset($_FILES['fijacion_fotografica_3']) && $_FILES['fijacion_fotografica_3']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fijacion_fotografica_3_nombre = uniqid() . '_' . $_FILES['fijacion_fotografica_3']['name'];
        move_uploaded_file($_FILES['fijacion_fotografica_3']['tmp_name'], $uploadDir . $fijacion_fotografica_3_nombre);
    }

    if (isset($_FILES['fijacion_fotografica_4']) && $_FILES['fijacion_fotografica_4']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fijacion_fotografica_4_nombre = uniqid() . '_' . $_FILES['fijacion_fotografica_4']['name'];
        move_uploaded_file($_FILES['fijacion_fotografica_4']['tmp_name'], $uploadDir . $fijacion_fotografica_4_nombre);
    }

    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO peritaje_completo (
        placa, fecha, no_servicio, servicio_para, convenio, nombre_apellidos, identificacion, telefono, direccion, 
        clase, marca, linea, cilindraje, servicio, modelo, color, no_chasis, no_motor, no_serie, tipo_carroceria, 
        organismo_transito, llanta_anterior_izquierda, llanta_anterior_derecha, llanta_posterior_izquierda, 
        llanta_posterior_derecha, amortiguador_anterior_izquierdo, amortiguador_anterior_derecho, 
        amortiguador_posterior_izquierdo, amortiguador_posterior_derecho, estado_cauchos_suspension, 
        estado_tanque_catalizador_gases, estado_tubo_exhosto, estado_radiador, estado_externo_bateria, 
        estado_cables_instalacion_alta, estado_tanque_silenciador, estado_filtro_aire, 
        estado_brazos_direccion_rotulas, fugas_tanque_combustible, fugas_aceite_amortiguadores, 
        fugas_liquido_bomba_embrague, fuga_aceite_direccion_hidraulica, fuga_liquido_frenos, 
        fuga_aceite_caja_transmision, fuga_aceite_caja_velocidades, tension_correas, estado_correas, 
        estado_mangueras_radiador, estado_tuberias_frenos, estado_guardapolvo_caja_direccion, 
        estado_protectores_inferiores, estado_carter, fuga_aceite_motor, estado_guardapolvos_ejes, 
        estado_tijeras, estado_radiador_aa, estado_soporte_motor, estado_carcasa_caja_velocidades, 
        viscosidad_aceite_motor, nivel_refrigerante_motor, nivel_liquido_frenos, nivel_agua_limpiavidrios, 
        nivel_aceite_direccion_hidraulica, nivel_liquido_embrague, nivel_aceite_motor, funcionamiento_aa, 
        soporte_caja_velocidades, fijacion_fotografica_1, fijacion_fotografica_2, fijacion_fotografica_3, 
        fijacion_fotografica_4, estado
    ) VALUES (
        :placa, :fecha, :no_servicio, :servicio_para, :convenio, :nombre_apellidos, :identificacion, :telefono, :direccion, 
        :clase, :marca, :linea, :cilindraje, :servicio, :modelo, :color, :no_chasis, :no_motor, :no_serie, :tipo_carroceria, 
        :organismo_transito, :llanta_anterior_izquierda, :llanta_anterior_derecha, :llanta_posterior_izquierda, 
        :llanta_posterior_derecha, :amortiguador_anterior_izquierdo, :amortiguador_anterior_derecho, 
        :amortiguador_posterior_izquierdo, :amortiguador_posterior_derecho, :estado_cauchos_suspension, 
        :estado_tanque_catalizador_gases, :estado_tubo_exhosto, :estado_radiador, :estado_externo_bateria, 
        :estado_cables_instalacion_alta, :estado_tanque_silenciador, :estado_filtro_aire, 
        :estado_brazos_direccion_rotulas, :fugas_tanque_combustible, :fugas_aceite_amortiguadores, 
        :fugas_liquido_bomba_embrague, :fuga_aceite_direccion_hidraulica, :fuga_liquido_frenos, 
        :fuga_aceite_caja_transmision, :fuga_aceite_caja_velocidades, :tension_correas, :estado_correas, 
        :estado_mangueras_radiador, :estado_tuberias_frenos, :estado_guardapolvo_caja_direccion, 
        :estado_protectores_inferiores, :estado_carter, :fuga_aceite_motor, :estado_guardapolvos_ejes, 
        :estado_tijeras, :estado_radiador_aa, :estado_soporte_motor, :estado_carcasa_caja_velocidades, 
        :viscosidad_aceite_motor, :nivel_refrigerante_motor, :nivel_liquido_frenos, :nivel_agua_limpiavidrios, 
        :nivel_aceite_direccion_hidraulica, :nivel_liquido_embrague, :nivel_aceite_motor, :funcionamiento_aa, 
        :soporte_caja_velocidades, :fijacion_fotografica_1, :fijacion_fotografica_2, :fijacion_fotografica_3, 
        :fijacion_fotografica_4, :estado
    )");

    // Bind de parámetros
    $stmt->execute($_POST);
    
    echo json_encode(["success" => true, "message" => "Registro insertado correctamente"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
