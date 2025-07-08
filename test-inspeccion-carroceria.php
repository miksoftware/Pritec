<?php
// Archivo de prueba para la inspección visual externa de carrocería
require_once 'conexion/conexion.php';
require_once 'peritaje_completo/TipoVehiculoUrl.php';

$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtener datos del peritaje ID 23
$stmt = $conn->prepare('SELECT * FROM peritaje_completo WHERE id = 23');
$stmt->execute();
$result = $stmt->get_result();
$peritaje = $result->fetch_assoc();

// Cargar inspección visual externa - carrocería
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_carroceria WHERE peritaje_id = 23");
$stmt->execute();
$carroceria = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();

// Configurar tipos de vehículos
$tipoChasis = $peritaje["tipo_chasis"];

$tiposVehiculos = [
    "COUPE - 3 PUERTAS" => new TipoVehiculoUrl(
        "img/carroceria/coupe carroceria.png",
        "img/estructura/coupe Estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "HATCHBACK - 5 PUERTAS" => new TipoVehiculoUrl(
        "img/carroceria/Hactback carroceria.png",
        "img/estructura/Hactback estructura.png",
        "img/estructura/chasis predeterminado.png"
    ),
    "CAMIONETA DOBLE CABINA" => new TipoVehiculoUrl(
        "img/carroceria/Camioneta doble cabina carroceria.png",
        "img/estructura/Camioneta doble cabina estructura.png",
        "img/chasis/CAMIONETA doble cabina CHASIS camionet.png"
    ),
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Inspección Visual Externa Carrocería</title>
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
        <h2 style="color: #000 !important; text-align: center; margin-bottom: 20px;">Test - Inspección Visual Externa Carrocería</h2>
        
        <p><strong>Datos del peritaje:</strong></p>
        <ul>
            <li>ID: <?php echo $peritaje['id']; ?></li>
            <li>Placa: <?php echo htmlspecialchars($peritaje['placa'] ?? ''); ?></li>
            <li>Tipo de vehículo: <?php echo htmlspecialchars($peritaje['tipo_vehiculo'] ?? ''); ?></li>
            <li>Cantidad de filas de carrocería: <?php echo count($carroceria); ?></li>
        </ul>

        <?php if (!empty($carroceria)): ?>
            <p><strong>Datos de carrocería encontrados:</strong></p>
            <pre><?php print_r($carroceria); ?></pre>
        <?php endif; ?>
        
        <!-- Incluir la sección de inspección visual externa -->
        <?php include 'pdf-modular/secciones/inspeccion-externa-carroceria.php'; ?>
    </div>
</body>
</html>
