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

    // Procesar checkboxes
    $tiene_prenda = isset($_POST['prenda']) ? 1 : 0;
    $tiene_limitacion = isset($_POST['limitacion']) ? 1 : 0;
    $debe_impuestos = isset($_POST['impuestos']) ? 1 : 0;
    $tiene_comparendos = isset($_POST['comparendos']) ? 1 : 0;
    $vehiculo_rematado = isset($_POST['rematado']) ? 1 : 0;

    // Inicializar variables para archivos
    $licencia_frente_nombre = '';
    $licencia_atras_nombre = '';

    // Procesamiento de archivos
    if (isset($_FILES['licencia_frente']) && $_FILES['licencia_frente']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $licencia_frente_nombre = uniqid() . '_' . $_FILES['licencia_frente']['name'];
        move_uploaded_file($_FILES['licencia_frente']['tmp_name'], $uploadDir . $licencia_frente_nombre);
    }

    if (isset($_FILES['licencia_atras']) && $_FILES['licencia_atras']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $licencia_atras_nombre = uniqid() . '_' . $_FILES['licencia_atras']['name'];
        move_uploaded_file($_FILES['licencia_atras']['tmp_name'], $uploadDir . $licencia_atras_nombre);
    }

    // Asegurar que todos los campos existan, incluso vacíos
    $fields = [
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
        'rtm' => $_POST['rtm'] ?? '',
        'rtm_fecha_vencimiento' => $_POST['rtm_fecha_vencimiento'] ?? '',
        'soat' => $_POST['soat'] ?? '',
        'soat_fecha_vencimiento' => $_POST['soat_fecha_vencimiento'] ?? '',
        'observaciones' => $_POST['observaciones'] ?? '',
        'estado_motor' => $_POST['estado_motor'] ?? '',
        'estado_chasis' => $_POST['estado_chasis'] ?? '',
        'estado_serial' => $_POST['estado_serial'] ?? '',
        'observaciones_finales' => $_POST['observaciones_finales'] ?? ''
    ];

   // Modificar la consulta SQL para especificar exactamente las columnas que vamos a insertar
$query = "INSERT INTO peritaje_basico (
    placa, fecha, no_servicio, servicio_para, convenio,
    nombre_apellidos, identificacion, telefono, direccion,
    clase, marca, linea, cilindraje, servicio, modelo, color,
    no_chasis, no_motor, no_serie, tipo_carroceria, organismo_transito,
    tiene_prenda, tiene_limitacion, debe_impuestos, tiene_comparendos, vehiculo_rematado,
    revision_tecnicomecanica, rtm_fecha_vencimiento,
    soat, soat_fecha_vencimiento, observaciones,
    licencia_frente, licencia_atras,
    estado_motor, estado_chasis, estado_serial, observaciones_finales
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);

if (!$stmt) {
    throw new Exception("Error en la preparación de la consulta: " . $conn->error);
}

foreach(['rtm_fecha_vencimiento', 'soat_fecha_vencimiento'] as $fecha_campo) {
    $fields[$fecha_campo] = !empty($fields[$fecha_campo]) ? $fields[$fecha_campo] : null;
}

// Modificar el tipo de parámetro en la cadena de tipos
$types = '';
$params = [];

// Primeros 21 parámetros string
for($i = 0; $i < 21; $i++) {
    $types .= 's';
}

// 5 parámetros TINYINT (booleanos)
$types .= 'iiiii';

// Último bloque incluyendo fechas
$types .= 's'; // rtm
$types .= empty($fields['rtm_fecha_vencimiento']) ? 's' : 's';  // rtm_fecha_vencimiento
$types .= 's'; // soat
$types .= empty($fields['soat_fecha_vencimiento']) ? 's' : 's';  // soat_fecha_vencimiento
$types .= str_repeat('s', 7); // resto de campos

$stmt->bind_param($types,
    $fields['placa'],
    $fields['fecha'],
    $fields['no_servicio'],
    $fields['servicio_para'],
    $fields['convenio'],
    $fields['nombre_apellidos'],
    $fields['identificacion'],
    $fields['telefono'],
    $fields['direccion'],
    $fields['clase'],
    $fields['marca'],
    $fields['linea'],
    $fields['cilindraje'],
    $fields['servicio'],
    $fields['modelo'],
    $fields['color'],
    $fields['no_chasis'],
    $fields['no_motor'],
    $fields['no_serie'],
    $fields['tipo_carroceria'],
    $fields['organismo_transito'],
    $tiene_prenda,
    $tiene_limitacion,
    $debe_impuestos,
    $tiene_comparendos,
    $vehiculo_rematado,
    $fields['rtm'],
    $fields['rtm_fecha_vencimiento'],
    $fields['soat'],
    $fields['soat_fecha_vencimiento'],
    $fields['observaciones'],
    $licencia_frente_nombre,
    $licencia_atras_nombre,
    $fields['estado_motor'],
    $fields['estado_chasis'],
    $fields['estado_serial'],
    $fields['observaciones_finales']
);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $_SESSION['success'] = "Peritaje guardado correctamente";
    header('Location: ../admin_panel.php');
    exit;

} catch (Exception $e) {
    error_log("Error en peritaje: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    if(isset($conn)) {
        error_log("Error MySQL: " . $conn->error);
    }
    header('Location: ../c_peritajeB.php');
    exit;

} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}