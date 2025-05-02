<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../conexion/conexion.php';

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $conn->begin_transaction();

    // Validación de campos obligatorios
    if (empty($_POST['placa']) || empty($_POST['fecha']) || empty($_POST['nombre_apellidos']) || empty($_POST['identificacion'])) {
        throw new Exception("Todos los campos marcados son obligatorios");
    }

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
            $uploaded_files[$file_key] = null;
        }
    }

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
    'observaciones_fugas'
    ];

    $valores = [];
    foreach ($columnas as $col) {
        if (strpos($col, 'fijacion_fotografica_') === 0) {
            $valores[] = $uploaded_files[$col] ?? null;
        } else {
            $valores[] = $_POST[$col] ?? null;
        }
    }

    $placeholders = implode(',', array_fill(0, count($columnas), '?'));
    $query = "INSERT INTO peritaje_completo (" . implode(',', $columnas) . ") VALUES ($placeholders)";

    $types = str_repeat('s', count($valores));
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$valores);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $peritajeId = $conn->insert_id;

    // Guardar inspección visual carrocería
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
                if (!$stmtInspeccion->execute()) {
                    throw new Exception("Error al guardar inspección visual: " . $stmtInspeccion->error);
                }
            }
        }
        $stmtInspeccion->close();
    }

    // Guardar inspección visual estructura
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
                if (!$stmtEstructura->execute()) {
                    throw new Exception("Error al guardar inspección de estructura: " . $stmtEstructura->error);
                }
            }
        }
        $stmtEstructura->close();
    }

    // Guardar inspección visual chasis
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
                if (!$stmtChasis->execute()) {
                    throw new Exception("Error al guardar inspección de chasis: " . $stmtChasis->error);
                }
            }
        }
        $stmtChasis->close();
    }

    $conn->commit();

    $_SESSION['success'] = "Peritaje guardado correctamente";
    header('Location: ../L_peritajeC.php');
    exit;
} catch (Exception $e) {
    if (isset($conn) && $conn->ping()) {
        $conn->rollback();
    }
    error_log("Error en peritaje: " . $e->getMessage());
    // Mostrar el error en pantalla para depuración
    echo "<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
    if (isset($conn)) {
        error_log("Error MySQL: " . $conn->error);
        echo "<pre>MySQL: " . htmlspecialchars($conn->error) . "</pre>";
    }
    // Mostrar el contenido de $_POST y $_FILES para depuración
    echo "<h3>POST:</h3><pre>" . print_r($_POST, true) . "</pre>";
    echo "<h3>FILES:</h3><pre>" . print_r($_FILES, true) . "</pre>";
    exit;
} finally {
    if (isset($stmtInspeccion)) $stmtInspeccion->close();
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}