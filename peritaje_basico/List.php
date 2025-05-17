<?php
// filepath: c:\laragon\www\Pritec\peritaje_basico\List.php
require_once '../conexion/conexion.php';

// Siempre responder con JSON
header('Content-Type: application/json');

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    // Obtener parámetros de ordenamiento
    $campoOrden = isset($_GET['order_by']) ? $_GET['order_by'] : 'id';
    $orden = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'DESC';
    
    // Validar campo de ordenamiento para prevenir SQL Injection
    $camposValidos = ['id', 'nombre_apellidos', 'identificacion', 'placa', 'fecha', 'fecha_creacion', 'marca', 'modelo', 'color'];
    if (!in_array($campoOrden, $camposValidos)) {
        $campoOrden = 'fecha_creacion';
    }
    
    // Validar orden
    $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
    
    // Búsqueda
    $busqueda = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
    
    // Campos a seleccionar
    $fields = [
        'id', 
        'nombre_apellidos', 
        'identificacion', 
        'placa', 
        'telefono', 
        'marca',
        'modelo',
        'color',
        'DATE_FORMAT(fecha, "%d/%m/%Y") as fecha',
        'DATE_FORMAT(fecha_creacion, "%d/%m/%Y %H:%i") as fecha_creacion'
    ];
    
    $query = "SELECT " . implode(", ", $fields) . " 
            FROM peritaje_basico 
            WHERE estado = 1 ";
    
    $params = [];
    $types = "";
    
    // Agregar condición de búsqueda si existe
    if (!empty($busqueda)) {
        $query .= "AND (nombre_apellidos LIKE ? 
                OR identificacion LIKE ? 
                OR placa LIKE ? 
                OR marca LIKE ?)";
        $busqueda = "%$busqueda%";
        $params = [$busqueda, $busqueda, $busqueda, $busqueda];
        $types = "ssss";
    }
    
    $query .= " ORDER BY $campoOrden $orden";
            
    $stmt = $conn->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $peritajes = [];
    while ($row = $resultado->fetch_assoc()) {
        $peritajes[] = [
            'id' => $row['id'],
            'nombre_apellidos' => htmlspecialchars($row['nombre_apellidos']),
            'identificacion' => htmlspecialchars($row['identificacion']),
            'placa' => strtoupper(htmlspecialchars($row['placa'])),
            'telefono' => htmlspecialchars($row['telefono'] ?: 'No registrado'),
            'marca' => htmlspecialchars($row['marca'] ?: 'No especificado'),
            'modelo' => htmlspecialchars($row['modelo'] ?: 'No especificado'),
            'color' => htmlspecialchars($row['color'] ?: 'No especificado'),
            'fecha' => $row['fecha'],
            'fecha_creacion' => $row['fecha_creacion']
        ];
    }
    
    // Devolver array directamente, DataTables lo procesa correctamente
    echo json_encode($peritajes);
    
} catch (Exception $e) {
    // Log el error para análisis posterior
    error_log("Error en listar peritajes básicos: " . $e->getMessage());
    
    // Devolver error al cliente
    echo json_encode([
        'error' => 'Error al cargar los peritajes: ' . $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}