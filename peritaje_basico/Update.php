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

    // Procesar checkboxes
    $tiene_prenda = isset($_POST['prenda']) ? 1 : 0;
    $tiene_limitacion = isset($_POST['limitacion']) ? 1 : 0;
    $debe_impuestos = isset($_POST['impuestos']) ? 1 : 0;
    $tiene_comparendos = isset($_POST['comparendos']) ? 1 : 0;
    $vehiculo_rematado = isset($_POST['rematado']) ? 1 : 0;

    // Construir consulta base
    $query = "UPDATE peritaje_basico SET 
        placa = ?, fecha = ?, no_servicio = ?, servicio_para = ?, convenio = ?,
        nombre_apellidos = ?, identificacion = ?, telefono = ?, direccion = ?,
        clase = ?, marca = ?, linea = ?, cilindraje = ?, servicio = ?,
        modelo = ?, color = ?, no_chasis = ?, no_motor = ?, no_serie = ?,
        tipo_carroceria = ?, organismo_transito = ?,
        tiene_prenda = ?, tiene_limitacion = ?, debe_impuestos = ?,
        tiene_comparendos = ?, vehiculo_rematado = ?,
        revision_tecnicomecanica = ?, rtm_fecha_vencimiento = ?,
        soat = ?, soat_fecha_vencimiento = ?, observaciones = ?,
        estado_motor = ?, estado_chasis = ?, estado_serial = ?,
        observaciones_finales = ? WHERE id = ?";

    // Debug query
    error_log("Query: " . $query);

    // Preparar statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Error en la preparación: " . $conn->error);
    }

    // Crear array de parámetros
    $params = [
        $_POST['placa'],
        $_POST['fecha'],
        $_POST['no_servicio'],
        $_POST['servicio_para'],
        $_POST['convenio'],
        $_POST['nombre_apellidos'],
        $_POST['identificacion'],
        $_POST['telefono'],
        $_POST['direccion'],
        $_POST['clase'],
        $_POST['marca'],
        $_POST['linea'],
        $_POST['cilindraje'],
        $_POST['servicio'],
        $_POST['modelo'],
        $_POST['color'],
        $_POST['no_chasis'],
        $_POST['no_motor'],
        $_POST['no_serie'],
        $_POST['tipo_carroceria'],
        $_POST['organismo_transito'],
        $tiene_prenda,
        $tiene_limitacion,
        $debe_impuestos,
        $tiene_comparendos,
        $vehiculo_rematado,
        $_POST['rtm'],
        empty($_POST['rtm_fecha_vencimiento']) ? null : $_POST['rtm_fecha_vencimiento'],
        $_POST['soat'],
        empty($_POST['soat_fecha_vencimiento']) ? null : $_POST['soat_fecha_vencimiento'],
        $_POST['observaciones'],
        $_POST['estado_motor'],
        $_POST['estado_chasis'],
        $_POST['estado_serial'],
        $_POST['observaciones_finales'],
        $_POST['id']
    ];

    // Debug parámetros
    error_log("Params: " . print_r($params, true));

    // Crear tipos
    $types = str_repeat('s', 21) . // strings
            str_repeat('i', 5) .    // booleans
            str_repeat('s', 10);    // resto de campos

    // Bind y ejecutar
    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar: " . $stmt->error);
    }

    $_SESSION['success'] = $stmt->affected_rows > 0 ? 
        "Peritaje actualizado exitosamente" : 
        "No se realizaron cambios";

} catch (Exception $e) {
    error_log("Error en update: " . $e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
    header('Location: ../l_peritajeB.php');
    exit;
}