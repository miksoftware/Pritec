<?php
session_start();
require_once '../conexion/conexion.php';

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Validar ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("ID de peritaje no válido");
    }
    $peritajeId = $_POST['id'];

    // Directorio de subida seguro
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validación y subida de imágenes
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $uploaded_files = [];
    for ($i = 1; $i <= 6; $i++) {
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

    // Array de columnas igual que en create.php
    $columnas = [
        'placa','fecha','no_servicio','servicio_para','convenio','nombre_apellidos','identificacion','telefono','direccion',
        'clase','marca','linea','cilindraje','servicio','modelo','color','no_chasis','no_motor','no_serie','tipo_carroceria',
        'organismo_transito','llanta_anterior_izquierda','llanta_anterior_derecha','llanta_posterior_izquierda',
        'llanta_posterior_derecha','amortiguador_anterior_izquierdo','amortiguador_anterior_derecho',
        'amortiguador_posterior_izquierdo','amortiguador_posterior_derecho','prueba_bateria','prueba_arranque',
        'carga_bateria','observaciones_bateria','fijacion_fotografica_1','fijacion_fotografica_2','fijacion_fotografica_3',
        'fijacion_fotografica_4','fijacion_fotografica_5','fijacion_fotografica_6','observaciones','observaciones2',
        'observaciones_llantas','email','kilometraje','codigo_fasecolda','valor_fasecolda','valor_sugerido','valor_accesorios',
        'tipo_vehiculo','observaciones_inspeccion','observaciones_estructura','observaciones_chasis',
        'estado_arranque','respuesta_arranque','estado_radiador','respuesta_radiador','estado_carter_motor','respuesta_carter_motor',
        'estado_carter_caja','respuesta_carter_caja','estado_caja_velocidades','respuesta_caja_velocidades',
        'estado_soporte_caja','respuesta_soporte_caja','estado_soporte_motor','respuesta_soporte_motor',
        'estado_mangueras_radiador','respuesta_mangueras_radiador','estado_correas','respuesta_correas',
        'tension_correas','respuesta_tension_correas','estado_filtro_aire','respuesta_filtro_aire',
        'estado_externo_bateria','respuesta_externo_bateria','estado_pastilla_freno','respuesta_pastilla_freno',
        'estado_discos_freno','respuesta_discos_freno','estado_punta_eje','respuesta_punta_eje',
        'estado_axiales','respuesta_axiales','estado_terminales','respuesta_terminales',
        'estado_rotulas','respuesta_rotulas','estado_tijeras','respuesta_tijeras',
        'estado_caja_direccion','respuesta_caja_direccion','estado_rodamientos','respuesta_rodamientos',
        'estado_cardan','respuesta_cardan','estado_crucetas','respuesta_crucetas',
        'estado_calefaccion','respuesta_calefaccion',
        'estado_aire_acondicionado','respuesta_aire_acondicionado',
        'estado_cinturones','respuesta_cinturones',
        'estado_tapiceria_asientos','respuesta_tapiceria_asientos',
        'estado_tapiceria_techo','respuesta_tapiceria_techo',
        'estado_millaret','respuesta_millaret',
        'estado_alfombra','respuesta_alfombra',
        'estado_chapas','respuesta_chapas',
        'respuesta_fuga_aceite_motor',
        'respuesta_fuga_aceite_caja_velocidades',
        'respuesta_fuga_aceite_caja_transmision',
        'respuesta_fuga_liquido_frenos',
        'respuesta_fuga_aceite_direccion_hidraulica',
        'respuesta_fuga_liquido_bomba_embrague',
        'respuesta_fuga_tanque_combustible',
        'respuesta_estado_tanque_silenciador',
        'respuesta_estado_tubo_exhosto',
        'respuesta_estado_tanque_catalizador_gases',
        'respuesta_estado_guardapolvo_caja_direccion',
        'respuesta_estado_tuberia_frenos',
        'respuesta_viscosidad_aceite_motor',
        'respuesta_nivel_refrigerante_motor',
        'respuesta_nivel_liquido_frenos',
        'respuesta_nivel_agua_limpiavidrios',
        'respuesta_nivel_aceite_direccion_hidraulica',
        'respuesta_nivel_liquido_embrague',
        'respuesta_nivel_aceite_motor',
        'prueba_ruta',
        'observaciones_fugas',
        'tipo_chasis',
        'prueba_escaner'
    ];

    // Construir SET dinámico para el UPDATE
    $set = [];
    foreach ($columnas as $col) {
        $set[] = "$col = ?";
    }
    $query = "UPDATE peritaje_completo SET " . implode(', ', $set) . " WHERE id = ?";

    // Construir valores igual que en create.php
    $valores = [];
    foreach ($columnas as $col) {
        if (strpos($col, 'fijacion_fotografica_') === 0) {
            $valores[] = $uploaded_files[$col] ?? null;
        } else {
            $valores[] = $_POST[$col] ?? null;
        }
    }
    $valores[] = $peritajeId; // Para el WHERE

    $types = str_repeat('s', count($valores));
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error en la preparación: " . $conn->error);
    }
    $stmt->bind_param($types, ...$valores);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar: " . $stmt->error);
    }

    // --- Inspección Visual Externa (Carrocería) ---
    $conn->query("DELETE FROM inspeccion_visual_carroceria WHERE peritaje_id = $peritajeId");
    if (
        isset($_POST['descripcion_pieza']) && is_array($_POST['descripcion_pieza']) &&
        isset($_POST['concepto_pieza']) && is_array($_POST['concepto_pieza'])
    ) {
        $queryInspeccion = "INSERT INTO inspeccion_visual_carroceria (peritaje_id, descripcion_pieza, concepto) VALUES (?, ?, ?)";
        $stmtInspeccion = $conn->prepare($queryInspeccion);
        for ($i = 0; $i < count($_POST['descripcion_pieza']); $i++) {
            $descripcion = trim($_POST['descripcion_pieza'][$i]);
            $concepto = trim($_POST['concepto_pieza'][$i]);
            if (!empty($descripcion) || !empty($concepto)) {
                $stmtInspeccion->bind_param('iss', $peritajeId, $descripcion, $concepto);
                $stmtInspeccion->execute();
            }
        }
        $stmtInspeccion->close();
    }

    // --- Inspección Visual Interna (Estructura) ---
    $conn->query("DELETE FROM inspeccion_visual_estructura WHERE peritaje_id = $peritajeId");
    if (
        isset($_POST['descripcion_pieza_estructura']) && is_array($_POST['descripcion_pieza_estructura']) &&
        isset($_POST['concepto_pieza_estructura']) && is_array($_POST['concepto_pieza_estructura'])
    ) {
        $queryEstructura = "INSERT INTO inspeccion_visual_estructura (peritaje_id, descripcion_pieza, concepto) VALUES (?, ?, ?)";
        $stmtEstructura = $conn->prepare($queryEstructura);
        for ($i = 0; $i < count($_POST['descripcion_pieza_estructura']); $i++) {
            $descripcion = trim($_POST['descripcion_pieza_estructura'][$i]);
            $concepto = trim($_POST['concepto_pieza_estructura'][$i]);
            if (!empty($descripcion) || !empty($concepto)) {
                $stmtEstructura->bind_param('iss', $peritajeId, $descripcion, $concepto);
                $stmtEstructura->execute();
            }
        }
        $stmtEstructura->close();
    }

    // --- Inspección Visual Chasis ---
    $conn->query("DELETE FROM inspeccion_visual_chasis WHERE peritaje_id = $peritajeId");
    if (
        isset($_POST['descripcion_pieza_chasis']) && is_array($_POST['descripcion_pieza_chasis']) &&
        isset($_POST['concepto_pieza_chasis']) && is_array($_POST['concepto_pieza_chasis'])
    ) {
        $queryChasis = "INSERT INTO inspeccion_visual_chasis (peritaje_id, descripcion_pieza, concepto) VALUES (?, ?, ?)";
        $stmtChasis = $conn->prepare($queryChasis);
        for ($i = 0; $i < count($_POST['descripcion_pieza_chasis']); $i++) {
            $descripcion = trim($_POST['descripcion_pieza_chasis'][$i]);
            $concepto = trim($_POST['concepto_pieza_chasis'][$i]);
            if (!empty($descripcion) || !empty($concepto)) {
                $stmtChasis->bind_param('iss', $peritajeId, $descripcion, $concepto);
                $stmtChasis->execute();
            }
        }
        $stmtChasis->close();
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