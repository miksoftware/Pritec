<?php
/**
 * PDF Modular de Peritaje Completo
 * Estructura modular donde cada sección es independiente y cada página incluye sus secciones correspondientes
 */

session_start();

// Verificar sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

// Definir constante para evitar salida JSON directa
define("NO_DIRECT_JSON_OUTPUT", true);

// Validar y obtener ID
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
if ($id === 0) {
    $_SESSION["error"] = "ID de peritaje no válido";
    header("Location: L_peritajeC.php");
    exit();
}

// Incluir dependencias
require_once dirname(__FILE__) . "/peritaje_completo/Getid.php";
require_once dirname(__FILE__) . "/peritaje_completo/TipoVehiculoUrl.php";
require_once dirname(__FILE__) . "/Enums/SeguroEnum.php";
require_once dirname(__FILE__) . "/Enums/ImprontaEnum.php";

// Conectar a la base de datos
$conexion = new Conexion();
$conn = $conexion->conectar();

// Obtener datos del peritaje
$stmt = $conn->prepare("SELECT * FROM peritaje_completo WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION["error"] = "Peritaje no encontrado";
    header("Location: l_peritajeC.php");
    exit();
}

$peritaje = $result->fetch_assoc();

// Cargar inspección visual externa - carrocería
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_carroceria WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$carroceria = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual estructura
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_estructura WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$estructura = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual chasis
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_chasis WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$chasis = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
    "MICROBUS" => new TipoVehiculoUrl(
        "img/carroceria/MICROBUS CARROCERIA.png",
        "img/estructura/MICROBUS estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "CAMIONETA WAGON- 5 PUERTAS" => new TipoVehiculoUrl(
        "img/carroceria/CAMIONETA WAGON - 5 PUERTAS carroceria.png",
        "img/estructura/CAMIONETA WAGON - 5 PUERTAS estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "CONVERTIBLE" => new TipoVehiculoUrl(
        "img/carroceria/convertible carroceria.png",
        "img/estructura/convertible estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "CAMIONETA DOBLE CABINA" => new TipoVehiculoUrl(
        "img/carroceria/Camioneta doble cabina carroceria.png",
        "img/estructura/Camioneta doble cabina estructura.png",
        "img/chasis/CAMIONETA doble cabina CHASIS camionet.png"
    ),
    "COOPER" => new TipoVehiculoUrl(
        "img/carroceria/MINI COOPER CARROCERIA.png",
        "img/estructura/MINI COOPER ESTRUCTURA.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "MULTIPROPOSITOS- CARGA" => new TipoVehiculoUrl(
        "img/carroceria/CABINA MULTIPROPOSITO carga CARROCERIA.png",
        "img/estructura/CABINA MULTIPROPOSITO carga ESTRUCTURA.png",
        "img/chasis/CABINA MULTIPROPOSITO CHASIS carga.png"
    ),
    "SEDAN NOTCHBACK 4 PUERTAS" => new TipoVehiculoUrl(
        "img/carroceria/SEDAN NOTCHBACK CARROCERIA.png",
        "img/estructura/SEDAN NOTCHBACK ESTRUCTURA.png",
        "img/chasis/chasis predeterminado.png"
    ),
    "MOTOCICLETA TURISMO" => new TipoVehiculoUrl(
        "img/carroceria/Motocicleta Turismo.png",
        "img/estructura/Motocicleta Turismo.png",
        "img/chasis/$tipoChasis.png"
    ),
    "MOTOCICLETA DEPORTIVA" => new TipoVehiculoUrl(
        "img/carroceria/motocicleta deportiva.png",
        "img/estructura/motocicleta deportiva.png",
        "img/chasis/$tipoChasis.png"
    ),
    "MOTOCICLETA SCOOTER" => new TipoVehiculoUrl(
        "img/carroceria/Motocicleta scooter.png",
        "img/estructura/Motocicleta scooter.png",
        "img/chasis/$tipoChasis.png"
    ),
    "MOTOCICLETA: TIPO ENDURO" => new TipoVehiculoUrl(
        "img/carroceria/Motocicleta tipo enduro.png",
        "img/estructura/Motocicleta tipo enduro.png",
        "img/chasis/$tipoChasis.png"
    ),
    "MOTOCICLETA CUSTOM" => new TipoVehiculoUrl(
        "img/carroceria/MOTOCICLETA CUSTOM.png",
        "img/estructura/MOTOCICLETA CUSTOM.png",
        "img/chasis/$tipoChasis.png"
    ),
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peritaje Completo - <?php echo htmlspecialchars($peritaje["placa"] ?? ''); ?></title>
    
    <!-- Bootstrap CSS (solo para utilidades de flexbox y espaciado) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Modular -->
    <link rel="stylesheet" href="pdf-modular/css/estilos.css">
</head>
<body>
    <main class="w-100">
        <!-- Página 1: Header, Datos del Vehículo, Inspección Visual Externa e Interna -->
        <?php include __DIR__ . '/pdf-modular/paginas/pagina-1.php'; ?>
        
        <!-- Página 2: Inspección Visual Interna - Chasis -->
        <?php include __DIR__ . '/pdf-modular/paginas/pagina-2.php'; ?>
        
        <!-- Aquí se incluirán las siguientes páginas cuando se modularicen -->
        <!--  -->
        <!-- <?php include __DIR__ . '/pdf-modular/paginas/pagina-3.php'; ?> -->
        <!-- <?php include __DIR__ . '/pdf-modular/paginas/pagina-4.php'; ?> -->
        <!-- <?php include __DIR__ . '/pdf-modular/paginas/pagina-5.php'; ?> -->
        <!-- <?php include __DIR__ . '/pdf-modular/paginas/pagina-6.php'; ?> -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-imprimir si está en producción o si se solicita explícitamente
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('print') === 'true') {
                window.print();
            }
        });
    </script>
</body>
</html>
