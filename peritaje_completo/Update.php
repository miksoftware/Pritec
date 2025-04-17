<?php
session_start();
require_once '../conexion/conexion.php';

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    // Debug POST y FILES
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));

    // Validar ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("ID de peritaje no válido");
    }

    // Directorio de subida seguro
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validación y subida de imágenes
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $uploaded_files = [];
    for ($i = 1; $i <= 4; $i++) {
        $file_key = "fijacion_fotografica_$i";
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
            $file_ext = strtolower(pathinfo($_FILES[$file_key]['name'], PATHINFO_EXTENSION));
            if (!in_array($file_ext, $allowed_extensions)) {
                throw new Exception("Formato de archivo no permitido: $file_ext");
            }
            $file_name = uniqid() . '_' . basename($_FILES[$file_key]['name']);
            $file_path = $uploadDir . $file_name;
            move_uploaded_file($_FILES[$file_key]['tmp_name'], $file_path);
            $uploaded_files[$file_key] = $file_name;
        } else {
            // Si no hay nuevo archivo, mantener el existente
            $uploaded_files[$file_key] = $_POST["current_" . $file_key] ?? null;
        }
    }

    // Construir consulta base
    $query = "UPDATE peritaje_completo SET 
        placa = ?, fecha = ?, no_servicio = ?, servicio_para = ?, convenio = ?,
        nombre_apellidos = ?, identificacion = ?, telefono = ?, direccion = ?,
        clase = ?, marca = ?, linea = ?, cilindraje = ?, servicio = ?, modelo = ?, 
        color = ?, no_chasis = ?, no_motor = ?, no_serie = ?, tipo_carroceria = ?, 
        organismo_transito = ?, llanta_anterior_izquierda = ?, llanta_anterior_derecha = ?, 
        llanta_posterior_izquierda = ?, llanta_posterior_derecha = ?, 
        amortiguador_anterior_izquierdo = ?, amortiguador_anterior_derecho = ?, 
        amortiguador_posterior_izquierdo = ?, amortiguador_posterior_derecho = ?, 
        estado_cauchos_suspension = ?, estado_tanque_catalizador_gases = ?, estado_tubo_exhosto = ?, 
        estado_radiador = ?, estado_externo_bateria = ?, estado_cables_instalacion_alta = ?, 
        estado_tanque_silenciador = ?, estado_filtro_aire = ?, estado_brazos_direccion_rotulas = ?, 
        fugas_tanque_combustible = ?, fugas_aceite_amortiguadores = ?, fugas_liquido_bomba_embrague = ?, 
        fuga_aceite_direccion_hidraulica = ?, fuga_liquido_frenos = ?, fuga_aceite_caja_transmision = ?, 
        fuga_aceite_caja_velocidades = ?, tension_correas = ?, estado_correas = ?, 
        estado_mangueras_radiador = ?, estado_tuberias_frenos = ?, estado_guardapolvo_caja_direccion = ?, 
        estado_protectores_inferiores = ?, estado_carter = ?, fuga_aceite_motor = ?, 
        estado_guardapolvos_ejes = ?, estado_tijeras = ?, estado_radiador_aa = ?, 
        estado_soporte_motor = ?, estado_carcasa_caja_velocidades = ?, viscosidad_aceite_motor = ?, 
        nivel_refrigerante_motor = ?, nivel_liquido_frenos = ?, nivel_agua_limpiavidrios = ?, 
        nivel_aceite_direccion_hidraulica = ?, nivel_liquido_embrague = ?, nivel_aceite_motor = ?, 
        funcionamiento_aa = ?, soporte_caja_velocidades = ?, fijacion_fotografica_1 = ?, 
        fijacion_fotografica_2 = ?, fijacion_fotografica_3 = ?, fijacion_fotografica_4 = ?, 
        observaciones = ?, observaciones2 = ?, email = ?, kilometraje = ?, codigo_fasecolda = ?,
         valor_fasecolda = ?, valor_sugerido = ?, valor_accesorios = ? WHERE id = ?";

    // Debug query
    error_log("Query: " . $query);

    // Preparar statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error en la preparación: " . $conn->error);
    }

    // Crear array de parámetros
    $params = [
        $_POST['placa'] ?? null,
        $_POST['fecha'] ?? null,
        $_POST['no_servicio'] ?? null,
        $_POST['servicio_para'] ?? null,
        $_POST['convenio'] ?? null,
        $_POST['nombre_apellidos'] ?? null,
        $_POST['identificacion'] ?? null,
        $_POST['telefono'] ?? null,
        $_POST['direccion'] ?? null,
        $_POST['clase'] ?? null,
        $_POST['marca'] ?? null,
        $_POST['linea'] ?? null,
        $_POST['cilindraje'] ?? null,
        $_POST['servicio'] ?? null,
        $_POST['modelo'] ?? null,
        $_POST['color'] ?? null,
        $_POST['no_chasis'] ?? null,
        $_POST['no_motor'] ?? null,
        $_POST['no_serie'] ?? null,
        $_POST['tipo_carroceria'] ?? null,
        $_POST['organismo_transito'] ?? null,
        $_POST['llanta_anterior_izquierda'] ?? null,
        $_POST['llanta_anterior_derecha'] ?? null,
        $_POST['llanta_posterior_izquierda'] ?? null,
        $_POST['llanta_posterior_derecha'] ?? null,
        $_POST['amortiguador_anterior_izquierdo'] ?? null,
        $_POST['amortiguador_anterior_derecho'] ?? null,
        $_POST['amortiguador_posterior_izquierdo'] ?? null,
        $_POST['amortiguador_posterior_derecho'] ?? null,
        $_POST['estado_cauchos_suspension'] ?? null,
        $_POST['estado_tanque_catalizador_gases'] ?? null,
        $_POST['estado_tubo_exhosto'] ?? null,
        $_POST['estado_radiador'] ?? null,
        $_POST['estado_externo_bateria'] ?? null,
        $_POST['estado_cables_instalacion_alta'] ?? null,
        $_POST['estado_tanque_silenciador'] ?? null,
        $_POST['estado_filtro_aire'] ?? null,
        $_POST['estado_brazos_direccion_rotulas'] ?? null,
        $_POST['fugas_tanque_combustible'] ?? null,
        $_POST['fugas_aceite_amortiguadores'] ?? null,
        $_POST['fugas_liquido_bomba_embrague'] ?? null,
        $_POST['fuga_aceite_direccion_hidraulica'] ?? null,
        $_POST['fuga_liquido_frenos'] ?? null,
        $_POST['fuga_aceite_caja_transmision'] ?? null,
        $_POST['fuga_aceite_caja_velocidades'] ?? null,
        $_POST['tension_correas'] ?? null,
        $_POST['estado_correas'] ?? null,
        $_POST['estado_mangueras_radiador'] ?? null,
        $_POST['estado_tuberias_frenos'] ?? null,
        $_POST['estado_guardapolvo_caja_direccion'] ?? null,
        $_POST['estado_protectores_inferiores'] ?? null,
        $_POST['estado_carter'] ?? null,
        $_POST['fuga_aceite_motor'] ?? null,
        $_POST['estado_guardapolvos_ejes'] ?? null,
        $_POST['estado_tijeras'] ?? null,
        $_POST['estado_radiador_aa'] ?? null,
        $_POST['estado_soporte_motor'] ?? null,
        $_POST['estado_carcasa_caja_velocidades'] ?? null,
        $_POST['viscosidad_aceite_motor'] ?? null,
        $_POST['nivel_refrigerante_motor'] ?? null,
        $_POST['nivel_liquido_frenos'] ?? null,
        $_POST['nivel_agua_limpiavidrios'] ?? null,
        $_POST['nivel_aceite_direccion_hidraulica'] ?? null,
        $_POST['nivel_liquido_embrague'] ?? null,
        $_POST['nivel_aceite_motor'] ?? null,
        $_POST['funcionamiento_aa'] ?? null,
        $_POST['soporte_caja_velocidades'] ?? null,
        $uploaded_files['fijacion_fotografica_1'] ?? null,
        $uploaded_files['fijacion_fotografica_2'] ?? null,
        $uploaded_files['fijacion_fotografica_3'] ?? null,
        $uploaded_files['fijacion_fotografica_4'] ?? null,
        $_POST['observaciones'] ?? null,
        $_POST['observaciones2'] ?? null,
        $_POST['email'] ?? null,
        $_POST['kilometraje'] ?? null,
        $_POST['codigo_fasecolda'] ?? null,
        $_POST['valor_fasecolda'] ?? null,
        $_POST['valor_sugerido'] ?? null,
        $_POST['valor_accesorios'] ?? null,
        $_POST['id']
    ];

    // Debug parámetros
    error_log("Params: " . print_r($params, true));

    // Crear tipos para todos los parámetros (todo como string para simplificar)
    $types = str_repeat('s', count($params));

    // Convertir array de parámetros a referencias
    $refs = [];
    $refs[] = &$types; // Primer parámetro es la cadena de tipos
    foreach($params as $key => $value) {
        $refs[] = &$params[$key];
    }

    // Usar call_user_func_array para aplicar bind_param con todos los parámetros
    call_user_func_array([$stmt, 'bind_param'], $refs);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar: " . $stmt->error);
    }

    $_SESSION['success'] = $stmt->affected_rows > 0 ? 
        "Peritaje actualizado exitosamente" : 
        "No se realizaron cambios";

} catch (Exception $e) {
    error_log("Error en update: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    if(isset($conn)) {
        error_log("Error MySQL: " . $conn->error);
    }
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
    header('Location: ../L_peritajeC.php');
    exit;
}
?>