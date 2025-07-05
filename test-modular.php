<?php
// Archivo de prueba para el sistema modular de peritajes
// Simula datos para probar los componentes sin necesidad de base de datos

// Datos de prueba del peritaje
$peritaje = [
    "fecha" => "2025-01-15",
    "no_servicio" => "PS-2025-001",
    "servicio_para" => "Compra de vehículo usado",
    "convenio" => "Convenio empresarial",
    "clase" => "Automóvil",
    "marca" => "Toyota",
    "linea" => "Corolla",
    "cilindraje" => "1800",
    "kilometraje" => "85000",
    "servicio" => "Particular",
    "modelo" => "2018",
    "color" => "Blanco",
    "no_chasis" => "ABC123XYZ789",
    "no_motor" => "MOT456789",
    "no_serie" => "SER789123",
    "tipo_carroceria" => "Sedán",
    "organismo_transito" => "Tránsito Municipal",
    "codigo_fasecolda" => "12345",
    "valor_fasecolda" => "$45,000,000",
    "valor_sugerido" => "$42,000,000",
    "valor_accesorios" => "$2,000,000",
    "placa" => "ABC123",
    "nombre_apellidos" => "Juan Pérez González",
    "identificacion" => "12345678",
    "telefono" => "3001234567",
    "direccion" => "Calle 123 #45-67",
    "email" => "juan.perez@email.com",
    "tipo_vehiculo" => "SEDAN - 4 PUERTAS",
    "observaciones_inspeccion" => "Vehículo en buen estado general",
    "observaciones_estructura" => "Estructura sin daños visibles",
    "observaciones_llantas" => "Llantas en buen estado",
    "llanta_anterior_izquierda" => 75,
    "llanta_anterior_derecha" => 80,
    "llanta_posterior_izquierda" => 70,
    "llanta_posterior_derecha" => 75,
    "amortiguador_anterior_izquierdo" => 85,
    "amortiguador_anterior_derecho" => 80,
    "amortiguador_posterior_izquierdo" => 75,
    "amortiguador_posterior_derecho" => 80,
];

// Datos de prueba para inspección visual
$carroceria = [
    ["descripcion_pieza" => "Capó", "concepto" => "Bueno"],
    ["descripcion_pieza" => "Parachoques delantero", "concepto" => "Excelente"],
    ["descripcion_pieza" => "Puerta conductor", "concepto" => "Bueno"],
];

$estructura = [
    ["descripcion_pieza" => "Chasis principal", "concepto" => "Excelente"],
    ["descripcion_pieza" => "Bastidor", "concepto" => "Bueno"],
];

$chasis = [
    ["descripcion_pieza" => "Estructura base", "concepto" => "Bueno"],
    ["descripcion_pieza" => "Soporte motor", "concepto" => "Excelente"],
];

// Incluir la configuración
require_once dirname(__FILE__) . "/pdf-completo/config.php";

// Configurar variables usando las funciones del config
$tiposVehiculos = getTiposVehiculos();
$llantas = getLlantas($peritaje);
$amortiguadores = getAmortiguadores($peritaje);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Sistema Modular - Peritajes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .yellow-background {
            background-color: #ffeb3b;
            font-weight: bold;
            padding: 5px;
        }
        .sub-title-vertical {
            writing-mode: vertical-lr;
            text-orientation: mixed;
            padding: 10px;
            text-align: center;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sub-title {
            padding: 8px;
            text-align: center;
            margin-bottom: 10px;
        }
        .label {
            padding: 5px;
            font-weight: bold;
        }
        .input {
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .plate {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .remarks {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #dee2e6;
            margin-top: 10px;
            min-height: 60px;
        }
        .page {
            margin: 20px;
            padding: 20px;
        }
        :root {
            --main-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="alert alert-info text-center">
            <h2>🧪 Prueba del Sistema Modular de Peritajes</h2>
            <p>Esta es una prueba con datos simulados para verificar que los componentes funcionen correctamente.</p>
        </div>

        <!-- Sección 1: Cabecera, datos del vehículo y solicitante -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>📋 Componente 1: Header Section</h5>
            </div>
            <div class="card-body">
                <?php include dirname(__FILE__) . "/pdf-completo/header-section.php"; ?>
            </div>
        </div>

        <!-- Sección 2: Inspección visual interna (para motocicletas) -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>🏍️ Componente 2: Inspección Visual Interna (Motocicletas)</h5>
            </div>
            <div class="card-body">
                <?php 
                // Cambiar temporalmente el tipo de vehículo para probar
                $peritaje_original = $peritaje["tipo_vehiculo"];
                $peritaje["tipo_vehiculo"] = "MOTOCICLETA";
                include dirname(__FILE__) . "/pdf-completo/inspeccion-visual-interna.php";
                $peritaje["tipo_vehiculo"] = $peritaje_original;
                ?>
            </div>
        </div>

        <!-- Sección 3: Llantas y amortiguadores -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>🚗 Componente 3: Llantas y Amortiguadores</h5>
            </div>
            <div class="card-body">
                <?php include dirname(__FILE__) . "/pdf-completo/llantas-amortiguadores.php"; ?>
            </div>
        </div>

        <div class="alert alert-success text-center">
            <h4>✅ Prueba Completada</h4>
            <p>Si puedes ver todas las secciones arriba, el sistema modular está funcionando correctamente.</p>
            <p><strong>Próximo paso:</strong> Prueba con el archivo <code>P_peritajeC_modular.php</code> usando un ID de peritaje real.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
