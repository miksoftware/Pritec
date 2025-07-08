<?php
// Archivo de prueba para verificar la sección completa de datos
require_once 'conexion/conexion.php';
$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtener datos del peritaje ID 23
$stmt = $conn->prepare('SELECT * FROM peritaje_completo WHERE id = 23');
$stmt->execute();
$result = $stmt->get_result();
$peritaje = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Sección Completa de Datos</title>
    <link rel="stylesheet" href="pdf-modular/css/estilos.css">
    <style>
        body {
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container-test {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container-test">
        <h2 style="color: #000 !important; text-align: center; margin-bottom: 20px;">Test - Sección Completa de Datos</h2>
        
        <!-- Incluir la sección completa -->
        <?php include 'pdf-modular/secciones/datos-vehiculo.php'; ?>
    </div>
</body>
</html>
