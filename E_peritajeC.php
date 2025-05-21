<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

require_once 'Enums/SeguroEnum.php';
require_once 'Enums/ImprontaEnum.php';
require_once 'Enums/EstadoEnum.php';
require_once 'conexion/conexion.php';

// Definir constante para evitar salida JSON directa
define('NO_DIRECT_JSON_OUTPUT', true);
require_once 'peritaje_completo/Getid.php';

// Validar que se reciba un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de peritaje no especificado";
    header('Location: l_peritajeC.php');
    exit;
}

$id = intval($_GET['id']);
$peritaje = obtenerPeritajePorId($id);

if (!$peritaje || isset($peritaje['error'])) {
    $_SESSION['error'] = isset($peritaje['error']) ? $peritaje['error'] : "Peritaje no encontrado";
    header('Location: l_peritajeC.php');
    exit;
}

// Obtener datos del peritaje
try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    // Cargar inspección visual externa
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
} catch (Exception $e) {
    $_SESSION['error'] = "Error al cargar el peritaje: " . $e->getMessage();
    header('Location: l_peritajeC.php');
    exit;
}

// Definir los tipos de vehículos
$tiposVehiculos = [
    'COUPE - 3 PUERTAS',
    'HATCHBACK - 5 PUERTAS',
    'MICROBUS',
    'CAMIONETA WAGON- 5 PUERTAS',
    'CONVERTIBLE',
    'CAMIONETA DOBLE CABINA',
    'CAMIONETA CABINA SENCILLA PLATON',
    'COOPER',
    'MULTIPROPOSITO - PASAJEROS',
    'MULTIPROPOSITOS- CARGA',
    'SEDAN NOTCHBACK 4 PUERTAS',
    'CAMPERO 3 PUERTAS',
    'AUTOMOVIL – STATION WAGON',
    'MOTOCICLETA TURISMO',
    'MOTOCICLETA DEPORTIVA',
    'MOTOCICLETA SCOOTER',
    'MOTOCICLETA: TIPO ENDURO',
    'MOTOCICLETA CUSTOM',
    'NO APLICA'
];

$tiposChasismoto = [
    'CUNA INTERRUMPIDA',
    'MONO CUNA',
    'MONO CUNA DESDOBLADO',
    'DOBLE CUNA',
    'DOBLE VIDA O PERIMETAL',
    'MULTI-TUBULAR',
    'NO APLICA'
];
$tiposChasisCarro = [
    'APLICA',
    'NO APLICA'
];

$conceptosCarroceria = [
    'Bueno',
    'Buena reparación',
    'Mala reparación',
    'Bien repintado',
    'Mal repintado',
    'Regular',
    'Regular (Oxidación- corrosión)',
    'Fisurado',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido',
    'Rayón',
    'Hermeticidad deficiente'
];

$conceptosEstructura = [
    'Bueno',
    'Buena reparación',
    'Mala reparación',
    'Bien repintado',
    'Mal repintado',
    'Regular (Oxidación- corrosión)',
    'Fisurado',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido',
    'Rayón'
];

$conceptosChasis = [
    'Bueno',
    'Mala reparación',
    'Buena reparación',
    'Regular (soldadura no original)',
    'Deformidad media',
    'Deformidad fuerte',
    'Sumido'
];

// Función para generar select de estados usando EstadoEnum
function generarSelectEstado($nombreCampo, $valorActual = "", $requerido = true)
{
    $required = $requerido ? 'required' : '';
    $html = "<select class=\"form-select\" name=\"{$nombreCampo}\" {$required}>";
    $html .= "<option value=\"\">Seleccione</option>";

    foreach (EstadoEnum::getOptions() as $valor => $etiqueta) {
        $selected = ($valorActual === $valor || $valorActual === $etiqueta) ? 'selected' : '';
        $html .= "<option value=\"{$valor}\" {$selected}>{$etiqueta}</option>";
    }

    $html .= "</select>";
    return $html;
}

// Variables para manejar visualización responsiva
$titleClass = "h4 mb-4";
$gridClass = "row g-3";
$fullWidthCol = "col-12 mb-3";
$halfCol = "col-md-6 mb-3";
$thirdCol = "col-md-4 mb-3";
$quarterCol = "col-md-3 mb-3";

include 'layouts/header.php';
?>

<div id="content">
    <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (isset($_SESSION['error'])): ?>
                    Swal.fire({
                        title: '¡Error!',
                        text: '<?php echo $_SESSION['error']; ?>',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '<?php echo $_SESSION['success']; ?>',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <div class="container py-5">
        <h2 class="text-center mb-4">Editar Peritaje Completo</h2>
        <form id="peritajeForm" action="peritaje_completo/Update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $peritaje['id']; ?>">

            <!-- Servicio -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-concierge-bell me-2"></i>Servicio
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo htmlspecialchars($peritaje['fecha'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" value="<?php echo htmlspecialchars($peritaje['no_servicio'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" value="<?php echo htmlspecialchars($peritaje['servicio_para'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Convenio</label>
                            <input type="text" class="form-control" name="convenio" value="<?php echo htmlspecialchars($peritaje['convenio'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Solicitante -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-user me-2"></i>Datos del Solicitante
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre_apellidos" value="<?php echo htmlspecialchars($peritaje['nombre_apellidos'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" value="<?php echo htmlspecialchars($peritaje['identificacion'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($peritaje['telefono'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($peritaje['direccion'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($peritaje['email'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-car me-2"></i>Datos del Vehículo</span>
                    <button type="button" class="btn btn-light btn-sm" id="cambiarTipoVehiculo">
                        <i class="fas fa-edit"></i> Cambiar Tipo de Vehículo
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Vehículo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tipo_vehiculo_display" readonly value="<?php echo htmlspecialchars($peritaje['tipo_vehiculo'] ?? ''); ?>">
                            <input type="hidden" class="form-control" name="tipo_vehiculo" id="tipo_vehiculo_input" required value="<?php echo htmlspecialchars($peritaje['tipo_vehiculo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="placa" required value="<?php echo htmlspecialchars($peritaje['placa'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Clase</label>
                            <input type="text" class="form-control" name="clase" value="<?php echo htmlspecialchars($peritaje['clase'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" name="marca" value="<?php echo htmlspecialchars($peritaje['marca'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Línea</label>
                            <input type="text" class="form-control" name="linea" value="<?php echo htmlspecialchars($peritaje['linea'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cilindraje</label>
                            <input type="text" class="form-control" name="cilindraje" value="<?php echo htmlspecialchars($peritaje['cilindraje'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Servicio</label>
                            <input type="text" class="form-control" name="servicio" value="<?php echo htmlspecialchars($peritaje['servicio'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="modelo" value="<?php echo htmlspecialchars($peritaje['modelo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars($peritaje['color'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Chasis</label>
                            <input type="text" class="form-control" name="no_chasis" value="<?php echo htmlspecialchars($peritaje['no_chasis'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Motor</label>
                            <input type="text" class="form-control" name="no_motor" value="<?php echo htmlspecialchars($peritaje['no_motor'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Serie</label>
                            <input type="text" class="form-control" name="no_serie" value="<?php echo htmlspecialchars($peritaje['no_serie'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Carrocería</label>
                            <input type="text" class="form-control" name="tipo_carroceria" value="<?php echo htmlspecialchars($peritaje['tipo_carroceria'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Organismo de Tránsito</label>
                            <input type="text" class="form-control" name="organismo_transito" value="<?php echo htmlspecialchars($peritaje['organismo_transito'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kilometraje" class="form-label">Kilometraje</label>
                            <input type="number" id="kilometraje" class="form-control" name="kilometraje" value="<?php echo htmlspecialchars($peritaje['kilometraje'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="codigo_fasecolda" class="form-label">Código Fasecolda</label>
                            <input type="text" id="codigo_fasecolda" class="form-control" name="codigo_fasecolda" value="<?php echo htmlspecialchars($peritaje['codigo_fasecolda'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_fasecolda" class="form-label">Valor Fasecolda</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="valor_fasecolda" class="form-control" name="valor_fasecolda" value="<?php echo htmlspecialchars($peritaje['valor_fasecolda'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_sugerido" class="form-label">Valor Sugerido</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="valor_sugerido" class="form-control" name="valor_sugerido" value="<?php echo htmlspecialchars($peritaje['valor_sugerido'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_accesorios" class="form-label">Valor Accesorios</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" id="valor_accesorios" class="form-control" name="valor_accesorios" value="<?php echo htmlspecialchars($peritaje['valor_accesorios'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspección Visual (carroceria) -->
            <div class="card mb-3" id="cardCarroceria" <?php echo (strpos($peritaje['tipo_vehiculo'] ?? '', 'MOTOCICLETA') !== false) ? 'style="display:none;"' : ''; ?>>
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-external-link-alt me-2"></i>Inspección Visual Externa (Carrocería)
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaInspeccionVisual">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($carroceria)): ?>
                                    <?php foreach ($carroceria as $fila): ?>
                                        <tr class="fila-inspeccion">
                                            <td>
                                                <input type="text" class="form-control" name="descripcion_pieza[]" value="<?php echo htmlspecialchars($fila['descripcion_pieza']); ?>" placeholder="Ej: Parachoques delantero">
                                            </td>
                                            <td>
                                                <select class="form-select" name="concepto_pieza[]">
                                                    <option value="">-- Seleccione un concepto --</option>
                                                    <?php foreach ($conceptosCarroceria as $concepto): ?>
                                                        <option value="<?php echo htmlspecialchars($concepto); ?>" <?php echo ($fila['concepto'] == $concepto) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($concepto); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm eliminar-fila">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="fila-inspeccion">
                                        <td>
                                            <input type="text" class="form-control" name="descripcion_pieza[]" placeholder="Ej: Parachoques delantero">
                                        </td>
                                        <td>
                                            <select class="form-select" name="concepto_pieza[]">
                                                <option value="">-- Seleccione un concepto --</option>
                                                <?php foreach ($conceptosCarroceria as $concepto): ?>
                                                    <option value="<?php echo htmlspecialchars($concepto); ?>">
                                                        <?php echo htmlspecialchars($concepto); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-fila">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-success btn-sm" id="agregarFilaInspeccion">
                                <i class="fas fa-plus"></i> Agregar elemento
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label for="observaciones_inspeccion" class="form-label">Observaciones generales</label>
                            <textarea id="observaciones_inspeccion" class="form-control" name="observaciones_inspeccion" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_inspeccion'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspección Visual Interna (Estructura) -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-columns me-2"></i>Inspección Visual Interna (Estructura)
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaInspeccionEstructura">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($estructura)): ?>
                                    <?php foreach ($estructura as $fila): ?>
                                        <tr class="fila-estructura">
                                            <td>
                                                <input type="text" class="form-control" name="descripcion_pieza_estructura[]" value="<?php echo htmlspecialchars($fila['descripcion_pieza']); ?>" placeholder="Ej: Tablero central">
                                            </td>
                                            <td>
                                                <select class="form-select" name="concepto_pieza_estructura[]">
                                                    <option value="">-- Seleccione un concepto --</option>
                                                    <?php foreach ($conceptosEstructura as $concepto): ?>
                                                        <option value="<?php echo htmlspecialchars($concepto); ?>" <?php echo ($fila['concepto'] == $concepto) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($concepto); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm eliminar-fila-estructura">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="fila-estructura">
                                        <td>
                                            <input type="text" class="form-control" name="descripcion_pieza_estructura[]" placeholder="Ej: Tablero central">
                                        </td>
                                        <td>
                                            <select class="form-select" name="concepto_pieza_estructura[]">
                                                <option value="">-- Seleccione un concepto --</option>
                                                <?php foreach ($conceptosEstructura as $concepto): ?>
                                                    <option value="<?php echo htmlspecialchars($concepto); ?>">
                                                        <?php echo htmlspecialchars($concepto); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-fila-estructura">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-success btn-sm" id="agregarFilaEstructura">
                                <i class="fas fa-plus"></i> Agregar elemento
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label for="observaciones_estructura" class="form-label">Observaciones generales</label>
                            <textarea id="observaciones_estructura" class="form-control" name="observaciones_estructura" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_estructura'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspección Visual (Chasis) -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-cogs me-2"></i>Inspección Visual (Chasis)
                </div>
                <div class="card-body">
                    <div class="row <?php echo (strpos($peritaje['tipo_vehiculo'] ?? '', 'MOTOCICLETA') === false) ? 'd-none' : ''; ?>" id="rowTipoChasis">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="tipo_chasis" class="form-label">Tipo de chasis</label>
                            <select id="tipo_chasis" class="form-select" name="tipo_chasis">
                                <option value="">-- Seleccione --</option>
                                <?php
                                $tiposChasis = (strpos($peritaje['tipo_vehiculo'] ?? '', 'MOTOCICLETA') !== false) ? $tiposChasismoto : $tiposChasisCarro;
                                foreach ($tiposChasis as $tipoChasis):
                                ?>
                                    <option value="<?php echo htmlspecialchars($tipoChasis) ?>" <?php echo ($peritaje['tipo_chasis'] === $tipoChasis) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($tipoChasis) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive" id="tablaChasisContainer">
                        <table class="table table-bordered" id="tablaInspeccionChasis">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($chasis)): ?>
                                    <?php foreach ($chasis as $fila): ?>
                                        <tr class="fila-chasis">
                                            <td>
                                                <input type="text" class="form-control" name="descripcion_pieza_chasis[]" value="<?php echo htmlspecialchars($fila['descripcion_pieza']); ?>" placeholder="Ej: Larguero derecho">
                                            </td>
                                            <td>
                                                <select class="form-select" name="concepto_pieza_chasis[]">
                                                    <option value="">-- Seleccione un concepto --</option>
                                                    <?php foreach ($conceptosChasis as $concepto): ?>
                                                        <option value="<?php echo htmlspecialchars($concepto); ?>" <?php echo ($fila['concepto'] == $concepto) ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($concepto); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm eliminar-fila-chasis">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="fila-chasis">
                                        <td>
                                            <input type="text" class="form-control" name="descripcion_pieza_chasis[]" placeholder="Ej: Larguero derecho">
                                        </td>
                                        <td>
                                            <select class="form-select" name="concepto_pieza_chasis[]">
                                                <option value="">-- Seleccione un concepto --</option>
                                                <?php foreach ($conceptosChasis as $concepto): ?>
                                                    <option value="<?php echo htmlspecialchars($concepto); ?>">
                                                        <?php echo htmlspecialchars($concepto); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm eliminar-fila-chasis">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 mb-3" id="btnAgregarChasisContainer">
                            <button type="button" class="btn btn-success btn-sm" id="agregarFilaChasis">
                                <i class="fas fa-plus"></i> Agregar elemento
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label for="observaciones_chasis" class="form-label" id="lblObservacionesChasis">Observaciones generales</label>
                            <textarea id="observaciones_chasis" class="form-control" name="observaciones_chasis" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_chasis'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Llantas -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-ring me-2"></i>Llantas
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje anterior izquierda (%)</label>
                            <input type="number" class="form-control" name="llanta_anterior_izquierda" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['llanta_anterior_izquierda'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje anterior derecha (%)</label>
                            <input type="number" class="form-control" name="llanta_anterior_derecha" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['llanta_anterior_derecha'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje posterior izquierda (%)</label>
                            <input type="number" class="form-control" name="llanta_posterior_izquierda" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['llanta_posterior_izquierda'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje posterior derecha (%)</label>
                            <input type="number" class="form-control" name="llanta_posterior_derecha" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['llanta_posterior_derecha'] ?? ''); ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="observaciones_llantas" class="form-label">Observaciones</label>
                            <textarea id="observaciones_llantas" class="form-control" name="observaciones_llantas" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_llantas'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amortiguadores -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-compress-alt me-2"></i>Amortiguadores
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje anterior izquierdo (%)</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_izquierdo" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['amortiguador_anterior_izquierdo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje anterior derecho (%)</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_derecho" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['amortiguador_anterior_derecho'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje posterior izquierdo (%)</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_izquierdo" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['amortiguador_posterior_izquierdo'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Porcentaje posterior derecho (%)</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_derecho" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['amortiguador_posterior_derecho'] ?? ''); ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones_amortiguadores" rows="3"><?php echo htmlspecialchars($peritaje['observaciones2'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prueba de Observación y Diagnóstico Scanner -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-laptop-medical me-2"></i>Prueba de Observación y Diagnóstico Scanner
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Código</label>
                            <input type="text" class="form-control" name="prueba_escaner" value="<?php echo htmlspecialchars($peritaje['prueba_escaner'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Observaciones</label>
                            <input type="text" class="form-control" name="observaciones_escaner" value="<?php echo htmlspecialchars($peritaje['observaciones_escaner'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bateria -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-battery-full me-2"></i>Batería
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prueba de batería (%)</label>
                            <input type="number" class="form-control" name="prueba_bateria" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['prueba_bateria'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prueba de arranque (%)</label>
                            <input type="number" class="form-control" name="prueba_arranque" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['prueba_arranque'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Carga de batería (%)</label>
                            <input type="number" class="form-control" name="carga_bateria" min="0" max="100" value="<?php echo htmlspecialchars($peritaje['carga_bateria'] ?? ''); ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="observaciones_bateria" class="form-label">Observaciones</label>
                            <textarea id="observaciones_bateria" class="form-control" name="observaciones_bateria" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_bateria'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motor y sistemas -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-engine me-2"></i>Motor y Sistemas
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">Sistema</th>
                                    <th width="30%">Estado</th>
                                    <th width="30%">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sistemas = [
                                    ['Arranque', 'estado_arranque', 'respuesta_arranque'],
                                    ['Radiador', 'estado_radiador', 'respuesta_radiador'],
                                    ['Carter motor', 'estado_carter_motor', 'respuesta_carter_motor'],
                                    ['Carter caja', 'estado_carter_caja', 'respuesta_carter_caja'],
                                    ['Caja de velocidades', 'estado_caja_velocidades', 'respuesta_caja_velocidades'],
                                    ['Soporte caja', 'estado_soporte_caja', 'respuesta_soporte_caja'],
                                    ['Soporte Motor', 'estado_soporte_motor', 'respuesta_soporte_motor'],
                                    ['Estado mangueras radiador', 'estado_mangueras_radiador', 'respuesta_mangueras_radiador'],
                                    ['Estado correas', 'estado_correas', 'respuesta_correas'],
                                    ['Tensión correas', 'tension_correas', 'respuesta_tension_correas'],
                                    ['Estado filtro de aire', 'estado_filtro_aire', 'respuesta_filtro_aire'],
                                    ['Estado externo baterías', 'estado_externo_bateria', 'respuesta_externo_bateria'],
                                ];

                                $secciones = [
                                    12 => [
                                        'titulo' => 'Sistema de Frenos y Suspensión',
                                        'items' => [
                                            ['Pastilla freno', 'estado_pastilla_freno', 'respuesta_pastilla_freno'],
                                            ['Discos freno', 'estado_discos_freno', 'respuesta_discos_freno'],
                                            ['Punta eje', 'estado_punta_eje', 'respuesta_punta_eje'],
                                            ['Axiales', 'estado_axiales', 'respuesta_axiales'],
                                            ['Terminales', 'estado_terminales', 'respuesta_terminales'],
                                            ['Rotulas', 'estado_rotulas', 'respuesta_rotulas'],
                                            ['Tijeras', 'estado_tijeras', 'respuesta_tijeras'],
                                            ['Caja dirección', 'estado_caja_direccion', 'respuesta_caja_direccion'],
                                            ['Rodamientos', 'estado_rodamientos', 'respuesta_rodamientos'],
                                            ['Cardan', 'estado_cardan', 'respuesta_cardan'],
                                            ['Crucetas', 'estado_crucetas', 'respuesta_crucetas'],
                                        ]
                                    ],
                                    23 => [
                                        'titulo' => 'Interior del Automotor',
                                        'items' => [
                                            ['Calefacción', 'estado_calefaccion', 'respuesta_calefaccion'],
                                            ['Aire acondicionado', 'estado_aire_acondicionado', 'respuesta_aire_acondicionado'],
                                            ['Cinturones', 'estado_cinturones', 'respuesta_cinturones'],
                                            ['Tapicería asientos', 'estado_tapiceria_asientos', 'respuesta_tapiceria_asientos'],
                                            ['Tapicería techo', 'estado_tapiceria_techo', 'respuesta_tapiceria_techo'],
                                            ['Millaret', 'estado_millaret', 'respuesta_millaret'],
                                            ['Alfombra', 'estado_alfombra', 'respuesta_alfombra'],
                                            ['Chapas', 'estado_chapas', 'respuesta_chapas'],
                                        ]
                                    ]
                                ];

                                // Mostrar la sección de Motor
                                foreach ($sistemas as $sis) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($sis[0]) . '</td>';
                                    echo '<td>' . generarSelectEstado($sis[1], $peritaje[$sis[1]] ?? '') . '</td>';
                                    echo '<td><input type="text" class="form-control" name="' . $sis[2] . '" value="' . htmlspecialchars($peritaje[$sis[2]] ?? '') . '" placeholder="Observación"></td>';
                                    echo '</tr>';
                                }

                                // Mostrar las demás secciones
                                foreach ($secciones as $seccion) {
                                    echo '<tr><td class="table-secondary fw-bold" colspan="3">' . htmlspecialchars($seccion['titulo']) . '</td></tr>';

                                    foreach ($seccion['items'] as $item) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($item[0]) . '</td>';
                                        echo '<td>' . generarSelectEstado($item[1], $peritaje[$item[1]] ?? '') . '</td>';
                                        echo '<td><input type="text" class="form-control" name="' . $item[2] . '" value="' . htmlspecialchars($peritaje[$item[2]] ?? '') . '" placeholder="Observación"></td>';
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label>Observaciones de motor</label>
                            <textarea class="form-control" name="observaciones_motor" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_motor'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Observaciones del interior del automotor</label>
                            <textarea class="form-control" name="observaciones_interior" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_interior'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fugas y Niveles -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-tint me-2"></i>Fugas y Niveles
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="50%">Sistema</th>
                                    <th width="50%">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fugas = [
                                    ['Fuga aceite motor', 'respuesta_fuga_aceite_motor'],
                                    ['Fuga aceite caja de velocidades', 'respuesta_fuga_aceite_caja_velocidades'],
                                    ['Fuga aceite caja de transmisión', 'respuesta_fuga_aceite_caja_transmision'],
                                    ['Fuga líquido de frenos', 'respuesta_fuga_liquido_frenos'],
                                    ['Fuga aceite dirección hidraulica', 'respuesta_fuga_aceite_direccion_hidraulica'],
                                    ['Fuga liquido bomba embrague', 'respuesta_fuga_liquido_bomba_embrague'],
                                    ['Fuga tanque de combustible', 'respuesta_fuga_tanque_combustible'],
                                    ['Estado tanque silenciador', 'respuesta_estado_tanque_silenciador'],
                                    ['Estado tubo exhosto', 'respuesta_estado_tubo_exhosto'],
                                    ['Estado tanque catalizador de gases', 'respuesta_estado_tanque_catalizador_gases'],
                                    ['Estado guardapolvo caja dirección', 'respuesta_estado_guardapolvo_caja_direccion'],
                                    ['Estado tuberia frenos', 'respuesta_estado_tuberia_frenos'],
                                    ['Viscosidad aceite motor', 'respuesta_viscosidad_aceite_motor'],
                                    ['Nivel refrigerante motor', 'respuesta_nivel_refrigerante_motor'],
                                    ['Nivel liquido de frenos', 'respuesta_nivel_liquido_frenos'],
                                    ['Nivel agua limpiavidrios', 'respuesta_nivel_agua_limpiavidrios'],
                                    ['Nivel aceite dirección hidraulica', 'respuesta_nivel_aceite_direccion_hidraulica'],
                                    ['Nivel liquido embrague', 'respuesta_nivel_liquido_embrague'],
                                    ['Nivel aceite motor', 'respuesta_nivel_aceite_motor'],
                                ];
                                foreach ($fugas as $fuga) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($fuga[0]) . '</td>';
                                    echo '<td><input type="text" class="form-control" name="' . $fuga[1] . '" value="' . htmlspecialchars($peritaje[$fuga[1]] ?? '') . '" placeholder="Observación"></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Prueba ruta</label>
                        <textarea class="form-control" name="prueba_ruta" rows="2" placeholder="Describa la prueba de ruta"><?php echo htmlspecialchars($peritaje['prueba_ruta'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Observaciones</label>
                        <textarea class="form-control" name="observaciones_fugas" rows="3" placeholder="Observaciones generales de fugas y niveles"><?php echo htmlspecialchars($peritaje['observaciones_fugas'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Fijación fotográfica -->
            <div class="card mb-3">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-camera me-2"></i>Fijación Fotográfica
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Fotografía <?php echo $i; ?></label>
                                <?php $field = "fijacion_fotografica_" . $i; ?>

                                <?php if (!empty($peritaje[$field])): ?>
                                    <div class="card mb-2 p-2">
                                        <div class="text-center">
                                            <img src="uploads/<?php echo htmlspecialchars($peritaje[$field]); ?>" class="img-fluid img-thumbnail" style="max-height: 200px;">
                                        </div>
                                        <div class="mt-2 text-center">
                                            <small class="text-muted">Imagen actual: <?php echo htmlspecialchars($peritaje[$field]); ?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="input-group mb-1">
                                    <input type="file" class="form-control" name="<?php echo $field; ?>" accept="image/*">
                                    <input type="hidden" name="current_<?php echo $field; ?>" value="<?php echo htmlspecialchars($peritaje[$field] ?? ''); ?>">
                                </div>
                                <small class="text-muted">* Dejar en blanco para mantener la imagen actual</small>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 mb-4">
                <a href="l_peritajeC.php" class="btn btn-secondary px-4 me-2">
                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-save me-2"></i>Actualizar Peritaje
                </button>
            </div>
        </form>
    </div>

    <!-- Modal para seleccionar tipo de vehículo -->
    <div class="modal fade" id="tipoVehiculoModal" tabindex="-1" aria-labelledby="tipoVehiculoModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tipoVehiculoModalLabel">Seleccione el Tipo de Vehículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalBtn"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <?php foreach ($tiposVehiculos as $tipo): ?>
                            <button type="button" class="list-group-item list-group-item-action tipo-vehiculo-item">
                                <?php echo htmlspecialchars($tipo); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validación del formulario
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('peritajeForm').addEventListener('submit', function(e) {
                const requiredFields = this.querySelectorAll('[required]');
                let hasEmpty = false;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        hasEmpty = true;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (hasEmpty) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¡Atención!',
                        text: 'Por favor complete todos los campos requeridos',
                        icon: 'warning',
                        confirmButtonText: 'Entendido'
                    });
                }
            });

            // Funcionalidad para Inspección Visual Externa
            // Agregar fila de inspección
            document.getElementById('agregarFilaInspeccion').addEventListener('click', function() {
                agregarFila('tablaInspeccionVisual', 'fila-inspeccion', 'descripcion_pieza[]', 'concepto_pieza[]', 'eliminar-fila');
            });

            // Inicializar botones de eliminar existentes
            document.querySelectorAll('.eliminar-fila').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    eliminarFila(this, 'fila-inspeccion');
                });
            });

            // Funcionalidad para Inspección Estructura
            document.getElementById('agregarFilaEstructura').addEventListener('click', function() {
                agregarFila('tablaInspeccionEstructura', 'fila-estructura', 'descripcion_pieza_estructura[]', 'concepto_pieza_estructura[]', 'eliminar-fila-estructura');
            });

            document.querySelectorAll('.eliminar-fila-estructura').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    eliminarFila(this, 'fila-estructura');
                });
            });

            // Funcionalidad para Inspección Chasis
            document.getElementById('agregarFilaChasis').addEventListener('click', function() {
                agregarFila('tablaInspeccionChasis', 'fila-chasis', 'descripcion_pieza_chasis[]', 'concepto_pieza_chasis[]', 'eliminar-fila-chasis');
            });

            document.querySelectorAll('.eliminar-fila-chasis').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    eliminarFila(this, 'fila-chasis');
                });
            });

            // Referencia al modal
            const tipoVehiculoModal = new bootstrap.Modal(document.getElementById('tipoVehiculoModal'));
            const displayEl = document.getElementById('tipo_vehiculo_display');
            const inputEl = document.getElementById('tipo_vehiculo_input');
            const rowChasisInput = document.getElementById('rowTipoChasis');
            const cardCarroceria = document.getElementById('cardCarroceria');
            const closeModalBtn = document.getElementById('closeModalBtn');

            // Establecer estado inicial basado en el tipo de vehículo ya guardado
            const tipoVehiculoActual = inputEl.value;
            if (tipoVehiculoActual && tipoVehiculoActual.includes('MOTOCICLETA')) {
                rowChasisInput.classList.remove('d-none');
                cardCarroceria.style.display = 'none';
            } else {
                rowChasisInput.classList.add('d-none');
                cardCarroceria.style.display = 'block';
            }

            // Botón para cambiar tipo de vehículo
            document.getElementById('cambiarTipoVehiculo').addEventListener('click', function() {
                closeModalBtn.style.display = 'block';
                tipoVehiculoModal.show();
            });

            // Manejar la selección de un tipo de vehículo
            document.querySelectorAll('.tipo-vehiculo-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    const tipoSeleccionado = this.textContent.trim();
                    displayEl.value = tipoSeleccionado;
                    inputEl.value = tipoSeleccionado;
                    tipoVehiculoModal.hide();

                    const rowChasisInput = document.getElementById('rowTipoChasis');
                    const cardCarroceria = document.getElementById('cardCarroceria');
                    const selectChasis = document.getElementById('tipo_chasis');

                    // Limpiar opciones actuales del select de tipo de chasis
                    if (selectChasis) {
                        selectChasis.innerHTML = '<option value="">-- Seleccione --</option>';
                    }

                    if (tipoSeleccionado.includes('MOTOCICLETA')) {
                        rowChasisInput.classList.remove('d-none');
                        cardCarroceria.style.display = 'none';

                        // Cargar opciones de tipo de chasis para motocicletas
                        <?php foreach ($tiposChasismoto as $tipo): ?>
                            if (selectChasis) {
                                const optionMoto = document.createElement('option');
                                optionMoto.value = "<?php echo htmlspecialchars($tipo); ?>";
                                optionMoto.textContent = "<?php echo htmlspecialchars($tipo); ?>";
                                selectChasis.appendChild(optionMoto);
                            }
                        <?php endforeach; ?>
                    } else {
                        rowChasisInput.classList.remove('d-none'); // También mostrar para carros
                        cardCarroceria.style.display = 'block';

                        // Cargar opciones de tipo de chasis para carros
                        <?php foreach ($tiposChasisCarro as $tipo): ?>
                            if (selectChasis) {
                                const optionCarro = document.createElement('option');
                                optionCarro.value = "<?php echo htmlspecialchars($tipo); ?>";
                                optionCarro.textContent = "<?php echo htmlspecialchars($tipo); ?>";
                                selectChasis.appendChild(optionCarro);
                            }
                        <?php endforeach; ?>
                    }

                    // Resetear la selección para que el usuario elija una opción
                    if (selectChasis) {
                        selectChasis.selectedIndex = 0;
                        // Forzar un evento change para actualizar la visibilidad de los elementos
                        const event = new Event('change');
                        selectChasis.dispatchEvent(event);
                    }
                });
            });

            // Log de depuración para verificar el estado de los valores del peritaje
            console.log('Datos del peritaje:', <?php echo json_encode($peritaje); ?>);
        });

        // Agregar manejador para el cambio en el tipo de chasis
        const selectChasis = document.getElementById('tipo_chasis');
        if (selectChasis) {
            // Ejecutar una vez al cargar para establecer el estado inicial
            toggleChasisComponents(selectChasis.value);

            // Agregar listener para cambios futuros
            selectChasis.addEventListener('change', function() {
                toggleChasisComponents(this.value);
            });
        }

        // Función para mostrar/ocultar componentes del chasis según la selección
        function toggleChasisComponents(selectedValue) {
            const tablaChasis = document.getElementById('tablaChasisContainer');
            const btnAgregarChasis = document.getElementById('btnAgregarChasisContainer');
            const observacionesChasisLabel = document.getElementById('lblObservacionesChasis');

            if (selectedValue === 'NO APLICA') {
                // Ocultar tabla y botones cuando es "NO APLICA"
                tablaChasis.classList.add('d-none');
                btnAgregarChasis.classList.add('d-none');

                // Actualizar la etiqueta de observaciones
                observacionesChasisLabel.textContent = 'Observaciones generales (No Aplica Chasis)';
            } else {
                // Mostrar todos los componentes para cualquier otra selección
                tablaChasis.classList.remove('d-none');
                btnAgregarChasis.classList.remove('d-none');
                observacionesChasisLabel.textContent = 'Observaciones generales';
            }
        }

        // Función para agregar fila a una tabla
        function agregarFila(tablaId, claseFilas, nombreCampo1, nombreCampo2, claseBoton) {
            const tbody = document.querySelector(`#${tablaId} tbody`);
            const nuevaFila = document.createElement('tr');
            nuevaFila.className = claseFilas;

            // Si estamos agregando a la tabla de inspección visual externa (carrocería)
            if (tablaId === 'tablaInspeccionVisual') {
                // Crear select para conceptos de carrocería
                let opcionesConcepto = '<option value="">-- Seleccione un concepto --</option>';

                <?php foreach ($conceptosCarroceria as $concepto): ?>
                    opcionesConcepto += `<option value="<?php echo htmlspecialchars($concepto); ?>"><?php echo htmlspecialchars($concepto); ?></option>`;
                <?php endforeach; ?>

                nuevaFila.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${nombreCampo1}" placeholder="Ej: Descripción">
                    </td>
                    <td>
                        <select class="form-select" name="${nombreCampo2}">
                            ${opcionesConcepto}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm ${claseBoton}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            }
            // Si estamos agregando a la tabla de inspección visual interna (estructura)
            else if (tablaId === 'tablaInspeccionEstructura') {
                // Crear select para conceptos de estructura
                let opcionesConcepto = '<option value="">-- Seleccione un concepto --</option>';

                <?php foreach ($conceptosEstructura as $concepto): ?>
                    opcionesConcepto += `<option value="<?php echo htmlspecialchars($concepto); ?>"><?php echo htmlspecialchars($concepto); ?></option>`;
                <?php endforeach; ?>

                nuevaFila.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${nombreCampo1}" placeholder="Ej: Descripción">
                    </td>
                    <td>
                        <select class="form-select" name="${nombreCampo2}">
                            ${opcionesConcepto}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm ${claseBoton}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            }
            // Si estamos agregando a la tabla de inspección de chasis
            else if (tablaId === 'tablaInspeccionChasis') {
                // Crear select para conceptos de chasis
                let opcionesConcepto = '<option value="">-- Seleccione un concepto --</option>';

                <?php foreach ($conceptosChasis as $concepto): ?>
                    opcionesConcepto += `<option value="<?php echo htmlspecialchars($concepto); ?>"><?php echo htmlspecialchars($concepto); ?></option>`;
                <?php endforeach; ?>

                nuevaFila.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${nombreCampo1}" placeholder="Ej: Descripción">
                    </td>
                    <td>
                        <select class="form-select" name="${nombreCampo2}">
                            ${opcionesConcepto}
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm ${claseBoton}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            } else {
                // Para otras tablas, mantener el comportamiento original
                nuevaFila.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${nombreCampo1}" placeholder="Ej: Descripción">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="${nombreCampo2}" placeholder="Ej: Concepto">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm ${claseBoton}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            }

            tbody.appendChild(nuevaFila);

            // Agregar evento al nuevo botón
            nuevaFila.querySelector(`.${claseBoton}`).addEventListener('click', function() {
                eliminarFila(this, claseFilas);
            });
        }

        // Función para eliminar fila de una tabla
        function eliminarFila(boton, claseFilas) {
            const fila = boton.closest('tr');
            const tabla = fila.closest('table');
            const todasLasFilas = tabla.querySelectorAll(`.${claseFilas}`);

            if (todasLasFilas.length > 1) {
                fila.remove();
            } else {
                Swal.fire({
                    title: 'Información',
                    text: 'Debe haber al menos una fila en la tabla',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
            }
        }
    </script>
</div>

<?php include 'layouts/footer.php'; ?>