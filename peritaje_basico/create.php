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
    $licencia_frente_nombre = '';
    if (isset($_FILES['licencia_frente']) && $_FILES['licencia_frente']['error'] === UPLOAD_ERR_OK && $_FILES['licencia_frente']['size'] > 0) {
        $file_ext = strtolower(pathinfo($_FILES['licencia_frente']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Formato de archivo no permitido para licencia frente: $file_ext");
        }
        $licencia_frente_nombre = uniqid() . '_' . basename($_FILES['licencia_frente']['name']);
        if (!move_uploaded_file($_FILES['licencia_frente']['tmp_name'], $uploadDir . $licencia_frente_nombre)) {
            throw new Exception("Error al subir la imagen de licencia (frente)");
        }
    }

    // Procesamiento de la licencia trasera
    $licencia_atras_nombre = '';
    if (isset($_FILES['licencia_atras']) && $_FILES['licencia_atras']['error'] === UPLOAD_ERR_OK && $_FILES['licencia_atras']['size'] > 0) {
        $file_ext = strtolower(pathinfo($_FILES['licencia_atras']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new Exception("Formato de archivo no permitido para licencia atrás: $file_ext");
        }
        $licencia_atras_nombre = uniqid() . '_' . basename($_FILES['licencia_atras']['name']);
        if (!move_uploaded_file($_FILES['licencia_atras']['tmp_name'], $uploadDir . $licencia_atras_nombre)) {
            throw new Exception("Error al subir la imagen de licencia (atrás)");
        }
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

    // Definir columnas explícitamente
    $columnas = [
        'placa', 'fecha', 'no_servicio', 'servicio_para', 'convenio',
        'nombre_apellidos', 'identificacion', 'telefono', 'direccion',
        'clase', 'marca', 'linea', 'cilindraje', 'servicio', 'modelo', 'color',
        'no_chasis', 'no_motor', 'no_serie', 'tipo_carroceria', 'organismo_transito',
        'tiene_prenda', 'tiene_limitacion', 'debe_impuestos', 'tiene_comparendos', 'vehiculo_rematado',
        'revision_tecnicomecanica'
    ];

    // Valores iniciales en el mismo orden
    $valores = [
        $_POST['placa'] ?? '',
        $_POST['fecha'] ?? '',
        $_POST['no_servicio'] ?? '',
        $_POST['servicio_para'] ?? '',
        $_POST['convenio'] ?? '',
        $_POST['nombre_apellidos'] ?? '',
        $_POST['identificacion'] ?? '',
        $_POST['telefono'] ?? '',
        $_POST['direccion'] ?? '',
        $_POST['clase'] ?? '',
        $_POST['marca'] ?? '',
        $_POST['linea'] ?? '',
        $_POST['cilindraje'] ?? '',
        $_POST['servicio'] ?? '',
        $_POST['modelo'] ?? '',
        $_POST['color'] ?? '',
        $_POST['no_chasis'] ?? '',
        $_POST['no_motor'] ?? '',
        $_POST['no_serie'] ?? '',
        $_POST['tipo_carroceria'] ?? '',
        $_POST['organismo_transito'] ?? '',
        $tiene_prenda,
        $tiene_limitacion,
        $debe_impuestos,
        $tiene_comparendos,
        $vehiculo_rematado,
        $rtm_valor
    ];

    // Añadir columnas y valores de forma condicional para las fechas
    if ($rtm_fecha_vencimiento !== null) {
        $columnas[] = 'rtm_fecha_vencimiento';
        $valores[] = $rtm_fecha_vencimiento;
    }

    $columnas[] = 'soat';
    $valores[] = $soat_valor;

    if ($soat_fecha_vencimiento !== null) {
        $columnas[] = 'soat_fecha_vencimiento';
        $valores[] = $soat_fecha_vencimiento;
    }

    // Añadir el resto de las columnas
    $columnas = array_merge($columnas, [
        'observaciones',
        'licencia_frente', 'licencia_atras',
        'estado_motor', 'estado_chasis', 'estado_serial', 'observaciones_finales'
    ]);
    
    // Añadir el resto de los valores
    $valores = array_merge($valores, [
        $_POST['observaciones'] ?? '',
        $licencia_frente_nombre,
        $licencia_atras_nombre,
        $estado_motor,
        $estado_chasis,
        $estado_serial,
        $_POST['observaciones_finales'] ?? ''
    ]);

    // Generar placeholders dinámicamente
    $placeholders = implode(',', array_fill(0, count($columnas), '?'));
    
    // Construir consulta SQL
    $query = "INSERT INTO peritaje_basico (" . implode(',', $columnas) . ") VALUES ($placeholders)";
    
    error_log("SQL Query: " . $query);
    error_log("Values count: " . count($valores));
    
    // Imprimir valores para depuración
    error_log("RTM valor: " . $rtm_valor);
    error_log("RTM fecha: " . ($rtm_fecha_vencimiento ?? 'NULL'));
    error_log("SOAT valor: " . $soat_valor);
    error_log("SOAT fecha: " . ($soat_fecha_vencimiento ?? 'NULL'));
    error_log("Estado motor: " . $estado_motor);
    error_log("Estado chasis: " . $estado_chasis);
    error_log("Estado serial: " . $estado_serial);

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($query);
    
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

    $_SESSION['success'] = "Peritaje guardado correctamente";
    $_SESSION['peritaje_id'] = $peritajeId; // Guardar el ID del peritaje recién creado
    header('Location: ../c_peritajeB.php?saved=true'); // Redirige de vuelta con parámetro saved
    exit;

} catch (Exception $e) {
    // Revertir transacción en caso de error
    if (isset($conn) && $conn->ping()) {
        $conn->rollback();
    }
    
    error_log("Error en peritaje básico: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    
    if (isset($conn)) {
        error_log("Error MySQL: " . $conn->error);
    }
    
    // Para depuración, muestra errores en pantalla
    echo "<h2>Error: " . htmlspecialchars($e->getMessage()) . "</h2>";
    if (isset($conn)) {
        echo "<pre>MySQL: " . htmlspecialchars($conn->error) . "</pre>";
    }
    echo "<h3>POST:</h3><pre>" . print_r($_POST, true) . "</pre>";
    echo "<h3>FILES:</h3><pre>" . print_r($_FILES, true) . "</pre>";
    
    // Comentado para mostrar errores en pantalla
    // header('Location: ../c_peritajeB.php');
    exit;

} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}