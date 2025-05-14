<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../conexion/conexion.php';
require_once '../Enums/SeguroEnum.php';
require_once '../Enums/ImprontaEnum.php';

try {
    // Debug para ver qué datos están llegando
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));

    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    // Iniciar transacción
    $conn->begin_transaction();

    // Validar ID
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        throw new Exception("ID de peritaje no válido");
    }
    
    $id = intval($_POST['id']);

    // Validación de campos obligatorios
    if (empty($_POST['placa']) || empty($_POST['fecha']) || empty($_POST['nombre_apellidos']) || empty($_POST['identificacion'])) {
        throw new Exception("Todos los campos marcados son obligatorios");
    }

    // Procesar checkboxes
    $tiene_prenda = isset($_POST['prenda']) ? 1 : 0;
    $tiene_limitacion = isset($_POST['limitacion']) ? 1 : 0;
    $debe_impuestos = isset($_POST['impuestos']) ? 1 : 0;
    $tiene_comparendos = isset($_POST['comparendos']) ? 1 : 0;
    $vehiculo_rematado = isset($_POST['rematado']) ? 1 : 0;

    // Directorio de subida seguro
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Validación y subida de imágenes
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    // Procesamiento de la licencia frontal
    $licencia_frente_nombre = $_POST['current_licencia_frente'] ?? '';
    if (isset($_FILES['licencia_frente']) && $_FILES['licencia_frente']['error'] === UPLOAD_ERR_OK && $_FILES['licencia_frente']['size'] > 0) {
        $file_ext = strtolower(pathinfo($_FILES['licencia_frente']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Formato de archivo no permitido para licencia frente: $file_ext");
        }
        $nuevo_nombre = uniqid() . '_' . basename($_FILES['licencia_frente']['name']);
        if (!move_uploaded_file($_FILES['licencia_frente']['tmp_name'], $uploadDir . $nuevo_nombre)) {
            throw new Exception("Error al subir la imagen de licencia (frente)");
        }
        // Borrar imagen anterior si existe
        if (!empty($licencia_frente_nombre) && file_exists($uploadDir . $licencia_frente_nombre)) {
            @unlink($uploadDir . $licencia_frente_nombre);
        }
        $licencia_frente_nombre = $nuevo_nombre;
    }

    // Procesamiento de la licencia trasera
    $licencia_atras_nombre = $_POST['current_licencia_atras'] ?? '';
    if (isset($_FILES['licencia_atras']) && $_FILES['licencia_atras']['error'] === UPLOAD_ERR_OK && $_FILES['licencia_atras']['size'] > 0) {
        $file_ext = strtolower(pathinfo($_FILES['licencia_atras']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Formato de archivo no permitido para licencia atrás: $file_ext");
        }
        $nuevo_nombre = uniqid() . '_' . basename($_FILES['licencia_atras']['name']);
        if (!move_uploaded_file($_FILES['licencia_atras']['tmp_name'], $uploadDir . $nuevo_nombre)) {
            throw new Exception("Error al subir la imagen de licencia (atrás)");
        }
        // Borrar imagen anterior si existe
        if (!empty($licencia_atras_nombre) && file_exists($uploadDir . $licencia_atras_nombre)) {
            @unlink($uploadDir . $licencia_atras_nombre);
        }
        $licencia_atras_nombre = $nuevo_nombre;
    }

    // Convertir los valores de los ENUMs a minúsculas para la base de datos
    // Para revision_tecnicomecanica y soat
    $rtm_valor = isset($_POST['rtm']) ? strtolower($_POST['rtm']) : '';
    if ($rtm_valor === 'no_aplica' || $rtm_valor === 'no aplica') {
        $rtm_valor = 'no_aplica';
    } elseif ($rtm_valor === 'vigente') {
        $rtm_valor = 'vigente';
    } elseif ($rtm_valor === 'no_vigente' || $rtm_valor === 'no vigente') {
        $rtm_valor = 'no_vigente';
    }

    $soat_valor = isset($_POST['soat']) ? strtolower($_POST['soat']) : '';
    if ($soat_valor === 'no_aplica' || $soat_valor === 'no aplica') {
        $soat_valor = 'no_aplica';
    } elseif ($soat_valor === 'vigente') {
        $soat_valor = 'vigente';
    } elseif ($soat_valor === 'no_vigente' || $soat_valor === 'no vigente') {
        $soat_valor = 'no_vigente';
    }

    // Para estado_motor, estado_chasis y estado_serial
    $estado_motor = isset($_POST['estado_motor']) ? strtolower($_POST['estado_motor']) : '';
    if ($estado_motor === 'original') {
        $estado_motor = 'original';
    } elseif ($estado_motor === 'regrabado') {
        $estado_motor = 'regrabado';
    } elseif ($estado_motor === 'grabado_no_original' || $estado_motor === 'grabado no original') {
        $estado_motor = 'grabado_no_original';
    }

    $estado_chasis = isset($_POST['estado_chasis']) ? strtolower($_POST['estado_chasis']) : '';
    if ($estado_chasis === 'original') {
        $estado_chasis = 'original';
    } elseif ($estado_chasis === 'regrabado') {
        $estado_chasis = 'regrabado';
    } elseif ($estado_chasis === 'grabado_no_original' || $estado_chasis === 'grabado no original') {
        $estado_chasis = 'grabado_no_original';
    }

    $estado_serial = isset($_POST['estado_serial']) ? strtolower($_POST['estado_serial']) : '';
    if ($estado_serial === 'original') {
        $estado_serial = 'original';
    } elseif ($estado_serial === 'regrabado') {
        $estado_serial = 'regrabado';
    } elseif ($estado_serial === 'grabado_no_original' || $estado_serial === 'grabado no original') {
        $estado_serial = 'grabado_no_original';
    }

    // Manejo de fechas vacías
    $rtm_fecha_vencimiento = !empty($_POST['rtm_fecha_vencimiento']) ? $_POST['rtm_fecha_vencimiento'] : null;
    $soat_fecha_vencimiento = !empty($_POST['soat_fecha_vencimiento']) ? $_POST['soat_fecha_vencimiento'] : null;

    // Construir arrays para columnas y valores
    $columnas_valores = [
        'placa' => $_POST['placa'] ?? '',
        'fecha' => $_POST['fecha'] ?? '',
        'no_servicio' => $_POST['no_servicio'] ?? '',
        'servicio_para' => $_POST['servicio_para'] ?? '',
        'convenio' => $_POST['convenio'] ?? '',
        'nombre_apellidos' => $_POST['nombre_apellidos'] ?? '',
        'identificacion' => $_POST['identificacion'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'direccion' => $_POST['direccion'] ?? '',
        'clase' => $_POST['clase'] ?? '',
        'marca' => $_POST['marca'] ?? '',
        'linea' => $_POST['linea'] ?? '',
        'cilindraje' => $_POST['cilindraje'] ?? '',
        'servicio' => $_POST['servicio'] ?? '',
        'modelo' => $_POST['modelo'] ?? '',
        'color' => $_POST['color'] ?? '',
        'no_chasis' => $_POST['no_chasis'] ?? '',
        'no_motor' => $_POST['no_motor'] ?? '',
        'no_serie' => $_POST['no_serie'] ?? '',
        'tipo_carroceria' => $_POST['tipo_carroceria'] ?? '',
        'organismo_transito' => $_POST['organismo_transito'] ?? '',
        'tiene_prenda' => $tiene_prenda,
        'tiene_limitacion' => $tiene_limitacion,
        'debe_impuestos' => $debe_impuestos,
        'tiene_comparendos' => $tiene_comparendos,
        'vehiculo_rematado' => $vehiculo_rematado,
        'revision_tecnicomecanica' => $rtm_valor,
        'observaciones' => $_POST['observaciones'] ?? '',
        'licencia_frente' => $licencia_frente_nombre,
        'licencia_atras' => $licencia_atras_nombre,
        'estado_motor' => $estado_motor,
        'estado_chasis' => $estado_chasis,
        'estado_serial' => $estado_serial,
        'observaciones_finales' => $_POST['observaciones_finales'] ?? ''
    ];
    
    // Añadir fechas solo si tienen valores
    if ($rtm_fecha_vencimiento !== null) {
        $columnas_valores['rtm_fecha_vencimiento'] = $rtm_fecha_vencimiento;
    }
    
    if ($soat_fecha_vencimiento !== null) {
        $columnas_valores['soat_fecha_vencimiento'] = $soat_fecha_vencimiento;
    }
    
    // Agregar campo 'soat' que estaba faltando
    $columnas_valores['soat'] = $soat_valor;
    
    // Construir la sentencia UPDATE
    $update_parts = [];
    foreach ($columnas_valores as $columna => $valor) {
        $update_parts[] = "$columna = ?";
    }
    
    $sql = "UPDATE peritaje_basico SET " . implode(', ', $update_parts) . " WHERE id = ?";
    
    // Añadir el ID al final de los valores
    $valores = array_values($columnas_valores);
    $valores[] = $id;
    
    // Depuración
    error_log("SQL Update: " . $sql);
    error_log("Valores count: " . count($valores));
    
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }
    
    // Usar string para todos los parámetros
    $types = str_repeat('s', count($valores));
    
    error_log("Binding parameters with type string: " . $types);
    
    // Bind parameters
    $stmt->bind_param($types, ...$valores);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
    
    // Confirmar transacción
    $conn->commit();
    
    $_SESSION['success'] = "Peritaje básico actualizado correctamente";
    header('Location: ../l_peritajeB.php');
    exit;

} catch (Exception $e) {
    // Revertir transacción en caso de error
    if (isset($conn) && $conn->ping()) {
        $conn->rollback();
    }
    
    error_log("Error en actualización de peritaje básico: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    
    if (isset($conn)) {
        error_log("Error MySQL: " . $conn->error);
    }
    
    // Para depuración, muestro errores en pantalla
    echo "<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
    if (isset($conn)) {
        echo "<pre>MySQL: " . htmlspecialchars($conn->error) . "</pre>";
    }
    echo "<h3>POST:</h3><pre>" . print_r($_POST, true) . "</pre>";
    echo "<h3>FILES:</h3><pre>" . print_r($_FILES, true) . "</pre>";
    
    // Comentado para mostrar errores en pantalla
    // header('Location: ../E_peritajeB.php?id=' . $id);
    exit;

} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}