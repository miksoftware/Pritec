<?php
session_start();
require_once 'Enums/SeguroEnum.php';
require_once 'Enums/ImprontaEnum.php';
require_once 'conexion/conexion.php';
include 'layouts/header.php';

// Validar que se reciba un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de peritaje no especificado";
    header('Location: L_peritajeC.php');
    exit;
}

// Obtener datos del peritaje
try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();

    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM peritaje_completo WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Peritaje no encontrado";
        header('Location: L_peritajeC.php');
        exit;
    }

    $peritaje = $result->fetch_assoc();

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
    header('Location: L_peritajeC.php');
    exit;
}

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
    'NO APLICA'
];

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
            <div class="card">
                <div class="card-header">Servicio</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo $peritaje['fecha']; ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" value="<?php echo $peritaje['no_servicio']; ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" value="<?php echo $peritaje['servicio_para']; ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Convenio</label>
                            <input type="text" class="form-control" name="convenio" value="<?php echo $peritaje['convenio']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Solicitante -->
            <div class="card">
                <div class="card-header">Datos del Solicitante</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre_apellidos" value="<?php echo $peritaje['nombre_apellidos']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" value="<?php echo $peritaje['identificacion']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo $peritaje['telefono']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo $peritaje['direccion']; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" id="email" class="form-control" name="email" value="<?php echo $peritaje['email']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Datos del Vehículo</span>
                    <button type="button" class="btn btn-info btn-sm" id="cambiarTipoVehiculo">
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
                            <label for="codigo_fasecolda" class="form-label">Código fasecolda</label>
                            <input type="text" id="codigo_fasecolda" class="form-control" name="codigo_fasecolda" value="<?php echo htmlspecialchars($peritaje['codigo_fasecolda'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_fasecolda" class="form-label">Valor fasecolda</label>
                            <input type="number" id="valor_fasecolda" class="form-control" name="valor_fasecolda" value="<?php echo htmlspecialchars($peritaje['valor_fasecolda'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_sugerido" class="form-label">Valor sugerido</label>
                            <input type="number" id="valor_sugerido" class="form-control" name="valor_sugerido" value="<?php echo htmlspecialchars($peritaje['valor_sugerido'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_accesorios" class="form-label">Valor accesorios</label>
                            <input type="number" id="valor_accesorios" class="form-control" name="valor_accesorios" value="<?php echo htmlspecialchars($peritaje['valor_accesorios'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inspección Visual (carroceria) -->
            <div class="card">
                <div class="card-header">Inspección Visual Externa (Carrocería)</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaInspeccionVisual">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
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
                                                <input type="text" class="form-control" name="concepto_pieza[]" value="<?php echo htmlspecialchars($fila['concepto']); ?>" placeholder="Ej: Buen estado, rayado, etc.">
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
                                            <input type="text" class="form-control" name="concepto_pieza[]" placeholder="Ej: Buen estado, rayado, etc.">
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
            <div class="card">
                <div class="card-header">Inspección Visual Interna (Estructura)</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaInspeccionEstructura">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
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
                                                <input type="text" class="form-control" name="concepto_pieza_estructura[]" value="<?php echo htmlspecialchars($fila['concepto']); ?>" placeholder="Ej: Buen estado, deteriorado, etc.">
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
                                            <input type="text" class="form-control" name="concepto_pieza_estructura[]" placeholder="Ej: Buen estado, deteriorado, etc.">
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
            <div class="card">
                <div class="card-header">Inspección Visual (Chasis)</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaInspeccionChasis">
                            <thead class="table-light">
                                <tr>
                                    <th>Descripción de Pieza</th>
                                    <th>Concepto</th>
                                    <th>Acciones</th>
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
                                                <input type="text" class="form-control" name="concepto_pieza_chasis[]" value="<?php echo htmlspecialchars($fila['concepto']); ?>" placeholder="Ej: Original, intervenido, etc.">
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
                                            <input type="text" class="form-control" name="concepto_pieza_chasis[]" placeholder="Ej: Original, intervenido, etc.">
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
                        <div class="col-md-12 mb-3">
                            <button type="button" class="btn btn-success btn-sm" id="agregarFilaChasis">
                                <i class="fas fa-plus"></i> Agregar elemento
                            </button>
                        </div>
                        <div class="col-md-12">
                            <label for="observaciones_chasis" class="form-label">Observaciones generales</label>
                            <textarea id="observaciones_chasis" class="form-control" name="observaciones_chasis" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_chasis'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Llantas -->
            <div class="card">
                <div class="card-header">Llantas</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior izquierda</label>
                            <input type="number" class="form-control" name="llanta_anterior_izquierda" value="<?php echo $peritaje['llanta_anterior_izquierda']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior derecha</label>
                            <input type="number" class="form-control" name="llanta_anterior_derecha" value="<?php echo $peritaje['llanta_anterior_derecha']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior izquierda</label>
                            <input type="number" class="form-control" name="llanta_posterior_izquierda" value="<?php echo $peritaje['llanta_posterior_izquierda']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior derecha</label>
                            <input type="number" class="form-control" name="llanta_posterior_derecha" value="<?php echo $peritaje['llanta_posterior_derecha']; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="observaciones_llantas" class="form-label">Observaciones</label>
                            <textarea id="observaciones_llantas" class="form-control" name="observaciones_llantas"
                                value="<?php echo $peritaje['observaciones_llantas']; ?>"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- amortiguadores -->
            <div class="card">
                <div class="card-header">Amortiguadores</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior izquierdo</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_izquierdo" value="<?php echo $peritaje['amortiguador_anterior_izquierdo']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior derecho</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_derecho" value="<?php echo $peritaje['amortiguador_anterior_derecho']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior izquierdo</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_izquierdo" value="<?php echo $peritaje['amortiguador_posterior_izquierdo']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior derecho</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_derecho" value="<?php echo $peritaje['amortiguador_posterior_derecho']; ?>">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones2" rows="3"><?php echo $peritaje['observaciones2']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bateria -->
            <div class="card">
                <div class="card-header">Batería</div>
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
            <div class="card">
                <div class="card-header">Motor y Sistemas</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">Sistema</th>
                                    <th width="30%">Estado</th>
                                    <th width="30%">Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $selectEstados = '
                    <select class="form-select" name="%s" required>
                        <option value="">Seleccione</option>
                        <option value="Bueno" %s>Bueno</option>
                        <option value="Regular" %s>Regular</option>
                        <option value="Malo" %s>Malo</option>
                        <option value="No Aplica" %s>No Aplica</option>
                    </select>
                    ';
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
                                    // Suspensión y dirección
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
                                    // Interior del automotor
                                    ['Calefacción', 'estado_calefaccion', 'respuesta_calefaccion'],
                                    ['Aire acondicionado', 'estado_aire_acondicionado', 'respuesta_aire_acondicionado'],
                                    ['Cinturones', 'estado_cinturones', 'respuesta_cinturones'],
                                    ['Tapicería asientos', 'estado_tapiceria_asientos', 'respuesta_tapiceria_asientos'],
                                    ['Tapicería techo', 'estado_tapiceria_techo', 'respuesta_tapiceria_techo'],
                                    ['Millaret', 'estado_millaret', 'respuesta_millaret'],
                                    ['Alfombra', 'estado_alfombra', 'respuesta_alfombra'],
                                    ['Chapas', 'estado_chapas', 'respuesta_chapas'],
                                ];
                                $seccion = [
                                    12 => 'Sistema de Frenos y Suspensión',
                                    23 => 'Interior del Automotor'
                                ];
                                foreach ($sistemas as $i => $sis) {
                                    if (isset($seccion[$i])) {
                                        echo '<tr><td class="table-secondary fw-bold" colspan="3">' . $seccion[$i] . '</td></tr>';
                                    }
                                    $estado = $peritaje[$sis[1]] ?? '';
                                    echo '<tr>';
                                    echo '<td>' . $sis[0] . '</td>';
                                    echo '<td>' . sprintf(
                                        $selectEstados,
                                        $sis[1],
                                        $estado == 'Bueno' ? 'selected' : '',
                                        $estado == 'Regular' ? 'selected' : '',
                                        $estado == 'Malo' ? 'selected' : '',
                                        $estado == 'No Aplica' ? 'selected' : ''
                                    ) . '</td>';
                                    echo '<td><input type="text" class="form-control" name="' . $sis[2] . '" value="' . htmlspecialchars($peritaje[$sis[2]] ?? '') . '" placeholder="Observación"></td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Fugas y Niveles -->
            <div class="card">
                <div class="card-header">Fugas y Niveles</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="50%">Sistema</th>
                                    <th width="50%">Respuesta</th>
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
                                    echo '<td>' . $fuga[0] . '</td>';
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

            <!-- fotografias -->
            <div class="card">
                <div class="card-header">Fijación fotográfica</div>
                <div class="card-body">
                    <div class="row">
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fotografía <?php echo $i; ?></label>
                                <?php $field = "fijacion_fotografica_" . $i; ?>
                                <?php if (!empty($peritaje[$field])): ?>
                                    <div class="mb-2">
                                        <img src="uploads/<?php echo $peritaje[$field]; ?>" class="img-fluid img-thumbnail" style="max-height: 150px;">
                                        <input type="hidden" name="current_<?php echo $field; ?>" value="<?php echo $peritaje[$field]; ?>">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="<?php echo $field; ?>" accept="image/*">
                                <small class="text-muted">Dejar en blanco para mantener la imagen actual</small>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="L_peritajeC.php" class="btn btn-secondary px-4 me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary px-5">Actualizar Peritaje</button>
            </div>
        </form>
    </div>

    <script>
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
    </script>
</div>

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
                            <?php echo $tipo; ?>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Referencia al modal
        const tipoVehiculoModal = new bootstrap.Modal(document.getElementById('tipoVehiculoModal'));
        const displayEl = document.getElementById('tipo_vehiculo_display');
        const inputEl = document.getElementById('tipo_vehiculo_input');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Botón para cambiar tipo de vehículo
        document.getElementById('cambiarTipoVehiculo').addEventListener('click', function() {
            // Mostrar el botón de cerrar cuando se abre manualmente
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
            });
        });

        // Verificar si se seleccionó un tipo al intentar cerrar el modal
        document.getElementById('tipoVehiculoModal').addEventListener('hide.bs.modal', function(event) {
            // Si es la primera carga y no hay tipo seleccionado, prevenir el cierre
            if (!inputEl.value && closeModalBtn.style.display === 'none') {
                event.preventDefault();
                Swal.fire({
                    title: '¡Atención!',
                    text: 'Debe seleccionar un tipo de vehículo para continuar',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    });
</script>

<?php include 'layouts/footer.php'; ?>