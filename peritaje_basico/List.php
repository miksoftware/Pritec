<?php
require_once '../conexion/conexion.php';

/**
 * Obtiene el listado de peritajes básicos ordenados por fecha de creación descendente
 * 
 * @param string $busqueda Término de búsqueda opcional
 * @param string $campo Campo por el que ordenar los resultados
 * @param string $orden Dirección de ordenamiento (ASC o DESC)
 * @return array Listado de peritajes o mensaje de error
 */
function listarPeritajes($busqueda = '', $campo = 'id', $orden = 'DESC') {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
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
            'DATE_FORMAT(fecha_creacion, "%d/%m/%Y %H:%i") as fecha_formateada'
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
        
        // Validar campo de ordenamiento para prevenir SQL Injection
        $camposValidos = ['id', 'nombre_apellidos', 'identificacion', 'placa', 'fecha', 'fecha_creacion', 'marca', 'modelo', 'color'];
        if (!in_array($campo, $camposValidos)) {
            $campo = 'fecha_creacion';
        }
        
        // Validar orden
        $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';
        
        $query .= "ORDER BY $campo $orden";
                
        $stmt = $conn->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $peritajes = [];
        while ($row = $resultado->fetch_assoc()) {
            // Preparar datos con formato adaptado para la tabla
            $peritajes[] = [
                'id' => $row['id'],
                'nombre_apellidos' => $row['nombre_apellidos'],
                'identificacion' => $row['identificacion'],
                'placa' => strtoupper($row['placa']), // Convertir placas a mayúsculas
                'telefono' => $row['telefono'] ?: 'No registrado',
                'marca' => $row['marca'] ?: 'No especificado',
                'modelo' => $row['modelo'] ?: 'No especificado',
                'color' => $row['color'] ?: 'No especificado',
                'fecha' => $row['fecha'],
                'fecha_creacion' => $row['fecha_formateada']
            ];
        }
        
        return $peritajes;
        
    } catch (Exception $e) {
        error_log("Error en listar peritajes básicos: " . $e->getMessage());
        return ['error' => $e->getMessage()];
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}

// Si se hace una petición AJAX, responder con JSON
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    header('Content-Type: application/json');
    
    // Recoger parámetros de búsqueda y orden
    $busqueda = $_GET['search']['value'] ?? '';
    $campoOrden = $_GET['order_by'] ?? 'id';
    $orden = $_GET['order_dir'] ?? 'DESC';
    
    echo json_encode(listarPeritajes($busqueda, $campoOrden, $orden));
}