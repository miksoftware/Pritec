<?php
// filepath: c:\laragon\www\Pritec\e_peritajeB.php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Validar y obtener ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    $_SESSION['error'] = "ID de peritaje no válido";
    header('Location: l_peritajeB.php');
    exit;
}

// Incluir dependencias - Nota: No usar echo/print antes de los headers
require_once 'conexion/conexion.php';
require_once 'Enums/SeguroEnum.php';
require_once 'Enums/ImprontaEnum.php';

// Función para obtener peritaje sin imprimir resultados
function obtenerPeritajePorId($id) {
    try {
        $conexion = new Conexion();
        $conn = $conexion->conectar();
        
        $query = "SELECT * FROM peritaje_basico WHERE id = ? AND estado = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }
        
        return false;
    } catch (Exception $e) {
        return false;
    } finally {
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
}

// Obtener datos del peritaje
$peritaje = obtenerPeritajePorId($id);
if (!$peritaje) {
    $_SESSION['error'] = "Peritaje no encontrado";
    header('Location: l_peritajeB.php');
    exit;
}

// Variables para manejar visualización responsiva
$titleClass = "h4 mb-3";
$gridClass = "row g-3";
$fullWidthCol = "col-12 mb-3";
$halfCol = "col-md-6 mb-3";
$thirdCol = "col-md-4 mb-3";
$quarterCol = "col-md-3 mb-3";

// Después de todas las redirecciones, ahora podemos incluir el header
include 'layouts/header.php';
?>

<div id="content" class="container-fluid py-4">
    <?php if (isset($_SESSION['error']) || isset($_SESSION['success'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (isset($_SESSION['error'])): ?>
                    Swal.fire({
                        title: '¡Error!',
                        text: '<?php echo $_SESSION['error']; ?>',
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: 'var(--primary-color, #3f51b5)'
                    });
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    Swal.fire({
                        title: '¡Éxito!',
                        text: '<?php echo $_SESSION['success']; ?>',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: 'var(--primary-color, #3f51b5)'
                    });
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h1 class="<?php echo $titleClass; ?>">
                <i class="fas fa-edit me-2 text-primary"></i>Editar Peritaje Básico
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="l_peritajeB.php">Peritajes Básicos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Peritaje #<?php echo $peritaje['id']; ?></li>
                </ol>
            </nav>
        </div>

        <form id="peritajeForm" action="peritaje_basico/Update.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <!-- Servicio -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Información del Servicio
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha" required value="<?php echo htmlspecialchars($peritaje['fecha'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" required value="<?php echo htmlspecialchars($peritaje['no_servicio'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" required value="<?php echo htmlspecialchars($peritaje['servicio_para'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">Convenio</label>
                            <input type="text" class="form-control" name="convenio" value="<?php echo htmlspecialchars($peritaje['convenio'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Solicitante -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Datos del Solicitante
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre_apellidos" required value="<?php echo htmlspecialchars($peritaje['nombre_apellidos'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" required value="<?php echo htmlspecialchars($peritaje['identificacion'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($peritaje['telefono'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($peritaje['direccion'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-car me-2"></i>Datos del Vehículo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="placa" required value="<?php echo htmlspecialchars($peritaje['placa'] ?? ''); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Clase</label>
                            <input type="text" class="form-control" name="clase" value="<?php echo htmlspecialchars($peritaje['clase'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" name="marca" value="<?php echo htmlspecialchars($peritaje['marca'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Línea</label>
                            <input type="text" class="form-control" name="linea" value="<?php echo htmlspecialchars($peritaje['linea'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Cilindraje</label>
                            <input type="text" class="form-control" name="cilindraje" value="<?php echo htmlspecialchars($peritaje['cilindraje'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Servicio</label>
                            <input type="text" class="form-control" name="servicio" value="<?php echo htmlspecialchars($peritaje['servicio'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="modelo" value="<?php echo htmlspecialchars($peritaje['modelo'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars($peritaje['color'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Chasis</label>
                            <input type="text" class="form-control" name="no_chasis" value="<?php echo htmlspecialchars($peritaje['no_chasis'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Motor</label>
                            <input type="text" class="form-control" name="no_motor" value="<?php echo htmlspecialchars($peritaje['no_motor'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Serie</label>
                            <input type="text" class="form-control" name="no_serie" value="<?php echo htmlspecialchars($peritaje['no_serie'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Tipo de Carrocería</label>
                            <input type="text" class="form-control" name="tipo_carroceria" value="<?php echo htmlspecialchars($peritaje['tipo_carroceria'] ?? ''); ?>">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Organismo de Tránsito</label>
                            <input type="text" class="form-control" name="organismo_transito" value="<?php echo htmlspecialchars($peritaje['organismo_transito'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Checkboxes -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-check-square me-2"></i>Estado/Documentos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="prenda" name="prenda" <?php echo (isset($peritaje['tiene_prenda']) && $peritaje['tiene_prenda'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="prenda">Tiene prenda/gravamen</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="limitacion" name="limitacion" <?php echo (isset($peritaje['tiene_limitacion']) && $peritaje['tiene_limitacion'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="limitacion">Tiene limitación</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="impuestos" name="impuestos" <?php echo (isset($peritaje['debe_impuestos']) && $peritaje['debe_impuestos'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="impuestos">Debe impuestos</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="comparendos" name="comparendos" <?php echo (isset($peritaje['tiene_comparendos']) && $peritaje['tiene_comparendos'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="comparendos">Tiene comparendos al tránsito</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="rematado" name="rematado" <?php echo (isset($peritaje['vehiculo_rematado']) && $peritaje['vehiculo_rematado'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="rematado">Vehículo rematado</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Selects -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Documentación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Revisión Tecnicomecánica <span class="text-danger">*</span></label>
                            <select class="form-select" name="rtm" id="rtm" onchange="toggleFechaVencimiento('rtm')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (strtoupper($peritaje['revision_tecnicomecanica'] ?? '') === strtoupper($value)) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                            <div id="rtm_fecha" class="mt-2" style="display:<?php echo (in_array(strtoupper($peritaje['revision_tecnicomecanica'] ?? ''), ['VIGENTE', 'NO_VIGENTE'])) ? 'block' : 'none'; ?>">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="rtm_fecha_vencimiento" value="<?php echo htmlspecialchars($peritaje['rtm_fecha_vencimiento'] ?? ''); ?>">
                                <div class="invalid-feedback">Este campo es requerido</div>
                            </div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">SOAT <span class="text-danger">*</span></label>
                            <select class="form-select" name="soat" id="soat" onchange="toggleFechaVencimiento('soat')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (strtoupper($peritaje['soat'] ?? '') === strtoupper($value)) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                            <div id="soat_fecha" class="mt-2" style="display:<?php echo (in_array(strtoupper($peritaje['soat'] ?? ''), ['VIGENTE', 'NO_VIGENTE'])) ? 'block' : 'none'; ?>">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="soat_fecha_vencimiento" value="<?php echo htmlspecialchars($peritaje['soat_fecha_vencimiento'] ?? ''); ?>">
                                <div class="invalid-feedback">Este campo es requerido</div>
                            </div>
                        </div>
                        <div class="<?php echo $fullWidthCol; ?>">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"><?php echo htmlspecialchars($peritaje['observaciones'] ?? ''); ?></textarea>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Licencia Frente</label>
                            <input type="file" class="form-control" name="licencia_frente" accept="image/*">
                            <?php if (!empty($peritaje['licencia_frente'])): ?>
                                <input type="hidden" name="current_licencia_frente" value="<?php echo htmlspecialchars($peritaje['licencia_frente']); ?>">
                                <div class="mt-2">
                                    <div class="d-flex align-items-center">
                                        <img src="uploads/<?php echo htmlspecialchars($peritaje['licencia_frente']); ?>" alt="Licencia frente" class="img-thumbnail me-2" style="max-height: 80px">
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="removeImage('licencia_frente')">
                                            <i class="fas fa-trash me-1"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Licencia Atrás</label>
                            <input type="file" class="form-control" name="licencia_atras" accept="image/*">
                            <?php if (!empty($peritaje['licencia_atras'])): ?>
                                <input type="hidden" name="current_licencia_atras" value="<?php echo htmlspecialchars($peritaje['licencia_atras']); ?>">
                                <div class="mt-2">
                                    <div class="d-flex align-items-center">
                                        <img src="uploads/<?php echo htmlspecialchars($peritaje['licencia_atras']); ?>" alt="Licencia atrás" class="img-thumbnail me-2" style="max-height: 80px">
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="removeImage('licencia_atras')">
                                            <i class="fas fa-trash me-1"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Concepto e Improntas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-stamp me-2"></i>Concepto e Improntas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="<?php echo $gridClass; ?>">
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Número de Motor <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_motor" id="estado_motor" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (strtoupper($peritaje['estado_motor'] ?? '') === strtoupper($value)) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>

                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Número de Chasis <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_chasis" id="estado_chasis" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (strtoupper($peritaje['estado_chasis'] ?? '') === strtoupper($value)) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>

                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Número Serial <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_serial" id="estado_serial" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo (strtoupper($peritaje['estado_serial'] ?? '') === strtoupper($value)) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>
                        <div class="<?php echo $fullWidthCol; ?>">
                            <label class="form-label">Observaciones Finales</label>
                            <textarea class="form-control" name="observaciones_finales" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_finales'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="id" value="<?php echo $peritaje['id']; ?>">
            <input type="hidden" name="remove_licencia_frente" id="remove_licencia_frente" value="0">
            <input type="hidden" name="remove_licencia_atras" id="remove_licencia_atras" value="0">
            
            <div class="d-flex flex-wrap justify-content-center gap-2 my-4">
                <a href="l_peritajeB.php" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Actualizar Peritaje
                </button>
                <a href="p_peritajeB.php?id=<?php echo $peritaje['id']; ?>" class="btn btn-success px-4" target="_blank">
                    <i class="fas fa-print me-2"></i>Imprimir
                </a>
            </div>
        </form>
    </div>

    <script>
        // Función para mostrar/ocultar campos de fecha de vencimiento
        function toggleFechaVencimiento(tipo) {
            const select = document.getElementById(tipo);
            const fechaDiv = document.getElementById(`${tipo}_fecha`);
            const fechaInput = document.querySelector(`[name="${tipo}_fecha_vencimiento"]`);
            
            if (!select || !fechaDiv) return;

            if (select.value.toUpperCase() === 'VIGENTE' || select.value.toUpperCase() === 'NO_VIGENTE') {
                fechaDiv.style.display = 'block';
                fechaInput.required = true;
            } else {
                fechaDiv.style.display = 'none';
                fechaInput.required = false;
            }
        }
        
        // Función para eliminar imagen
        function removeImage(field) {
            const container = document.querySelector(`input[name="current_${field}"]`).parentNode;
            document.getElementById(`remove_${field}`).value = "1";
            container.innerHTML = '<p class="text-muted mt-2">La imagen será eliminada al guardar cambios</p>';
        }

        // Validación del formulario con Bootstrap
        (() => {
            'use strict';

            // Obtener todos los formularios a los que queremos aplicar validación de Bootstrap
            const forms = document.querySelectorAll('.needs-validation');

            // Bucle sobre ellos y prevenir envío
            Array.prototype.slice.call(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        
                        // Mostrar mensaje de error con SweetAlert2
                        Swal.fire({
                            title: 'Error de validación',
                            text: 'Por favor complete todos los campos requeridos',
                            icon: 'warning',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: 'var(--primary-color, #3f51b5)'
                        });
                        
                        // Mover el focus al primer campo inválido
                        const invalidField = form.querySelector(':invalid');
                        if (invalidField) {
                            invalidField.focus();
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Inicialización cuando carga la página
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración inicial de los campos de fecha de vencimiento
            toggleFechaVencimiento('rtm');
            toggleFechaVencimiento('soat');
        });
    </script>
</div>

<?php include 'layouts/footer.php'; ?>