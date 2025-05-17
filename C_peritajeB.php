<?php
// filepath: c:\laragon\www\Pritec\c_peritajeB.php
session_start();
require_once 'Enums/SeguroEnum.php';
require_once 'Enums/ImprontaEnum.php';
include 'layouts/header.php';

// Verificar si se acaba de guardar un peritaje
$justSaved = isset($_GET['saved']) && $_GET['saved'] === 'true';
$peritajeId = $_SESSION['peritaje_id'] ?? null;
// Limpiar la variable de sesión después de usarla
if (isset($_SESSION['peritaje_id'])) {
    unset($_SESSION['peritaje_id']);
}

// Variables para manejar visualización responsiva
$titleClass = "h4 mb-3";
$gridClass = "row g-3";
$fullWidthCol = "col-12 mb-3";
$halfCol = "col-md-6 mb-3";
$thirdCol = "col-md-4 mb-3";
$quarterCol = "col-md-3 mb-3";
?>

<div id="content" class="container-fluid py-4">
    <?php if ($justSaved): ?>
    <!-- Mensaje de éxito fijo en la parte superior cuando se acaba de guardar -->
    <div class="alert alert-success alert-dismissible sticky-top shadow-sm mt-2" role="alert">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div>
                <i class="fas fa-check-circle fa-lg me-2"></i>
                <strong>¡Peritaje guardado con éxito!</strong> 
                <?php echo $peritajeId ? "ID del peritaje: #$peritajeId" : ''; ?>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-2 mt-sm-0">
                <a href="l_peritajeB.php" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-list me-1"></i> Ver listado
                </a>
                <?php if ($peritajeId): ?>
                <a href="p_peritajeB.php?id=<?php echo $peritajeId; ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                    <i class="fas fa-print me-1"></i> Imprimir
                </a>
                <a href="e_peritajeB.php?id=<?php echo $peritajeId; ?>" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-edit me-1"></i> Editar
                </a>
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error']) || (isset($_SESSION['success']) && !$justSaved)): ?>
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

                <?php if (isset($_SESSION['success']) && !$justSaved): ?>
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
                <i class="fas fa-plus-circle me-2 text-primary"></i>Nuevo Peritaje Básico
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="dashboard.php">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="l_peritajeB.php">Peritajes Básicos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo Peritaje</li>
                </ol>
            </nav>
        </div>

        <form id="peritajeForm" action="peritaje_basico/create.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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
                            <input type="date" class="form-control" name="fecha" required value="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" required>
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" required>
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $quarterCol; ?>">
                            <label class="form-label">Convenio</label>
                            <input type="text" class="form-control" name="convenio">
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
                            <input type="text" class="form-control" name="nombre_apellidos" required>
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" required>
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono">
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion">
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
                            <input type="text" class="form-control" name="placa" required>
                            <div class="invalid-feedback">Este campo es requerido</div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Clase</label>
                            <input type="text" class="form-control" name="clase">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" name="marca">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Línea</label>
                            <input type="text" class="form-control" name="linea">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Cilindraje</label>
                            <input type="text" class="form-control" name="cilindraje">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Servicio</label>
                            <input type="text" class="form-control" name="servicio">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="modelo">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" name="color">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Chasis</label>
                            <input type="text" class="form-control" name="no_chasis">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Motor</label>
                            <input type="text" class="form-control" name="no_motor">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">No de Serie</label>
                            <input type="text" class="form-control" name="no_serie">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Tipo de Carrocería</label>
                            <input type="text" class="form-control" name="tipo_carroceria">
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Organismo de Tránsito</label>
                            <input type="text" class="form-control" name="organismo_transito">
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
                                <input type="checkbox" class="form-check-input" id="prenda" name="prenda">
                                <label class="form-check-label" for="prenda">Tiene prenda/gravamen</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="limitacion" name="limitacion">
                                <label class="form-check-label" for="limitacion">Tiene limitación</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="impuestos" name="impuestos">
                                <label class="form-check-label" for="impuestos">Debe impuestos</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="comparendos" name="comparendos">
                                <label class="form-check-label" for="comparendos">Tiene comparendos al tránsito</label>
                            </div>
                        </div>
                        <div class="<?php echo $thirdCol; ?>">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="rematado" name="rematado">
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
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                            <div id="rtm_fecha" class="mt-2" style="display:none">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="rtm_fecha_vencimiento">
                                <div class="invalid-feedback">Este campo es requerido</div>
                            </div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">SOAT <span class="text-danger">*</span></label>
                            <select class="form-select" name="soat" id="soat" onchange="toggleFechaVencimiento('soat')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                            <div id="soat_fecha" class="mt-2" style="display:none">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="soat_fecha_vencimiento">
                                <div class="invalid-feedback">Este campo es requerido</div>
                            </div>
                        </div>
                        <div class="<?php echo $fullWidthCol; ?>">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"></textarea>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Licencia Frente</label>
                            <input type="file" class="form-control" name="licencia_frente" accept="image/*">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                        </div>
                        <div class="<?php echo $halfCol; ?>">
                            <label class="form-label">Licencia Atrás</label>
                            <input type="file" class="form-control" name="licencia_atras" accept="image/*">
                            <div class="form-text">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
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
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>

                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Número de Chasis <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_chasis" id="estado_chasis" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>

                        <div class="<?php echo $thirdCol; ?>">
                            <label class="form-label">Número Serial <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_serial" id="estado_serial" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una opción</div>
                        </div>
                        <div class="<?php echo $fullWidthCol; ?>">
                            <label class="form-label">Observaciones Finales</label>
                            <textarea class="form-control" name="observaciones_finales" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-wrap justify-content-center gap-2 my-4">
                <a href="l_peritajeB.php" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Guardar Peritaje
                </button>
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
                fechaInput.value = '';
            }
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
                            
                            // Si el campo inválido está dentro de un collapse, abrirlo
                            const cardBody = invalidField.closest('.card-body');
                            if (cardBody) {
                                const card = cardBody.closest('.card');
                                if (card) {
                                    const cardHeader = card.querySelector('.card-header');
                                    if (cardHeader) {
                                        cardHeader.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }
                                }
                            }
                        }
                    }
                    form.classList.add('was-validated');
                }, false);
                
                // Validación de archivos
                const fileInputs = form.querySelectorAll('input[type="file"]');
                fileInputs.forEach(input => {
                    input.addEventListener('change', function(e) {
                        const file = this.files[0];
                        if (file) {
                            // Verificar tamaño (2MB máximo)
                            if (file.size > 2 * 1024 * 1024) {
                                this.value = '';
                                Swal.fire({
                                    title: 'Archivo demasiado grande',
                                    text: 'El archivo no debe superar los 2MB',
                                    icon: 'error',
                                    confirmButtonText: 'Entendido'
                                });
                                return;
                            }
                            
                            // Verificar tipo
                            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                            if (!validTypes.includes(file.type)) {
                                this.value = '';
                                Swal.fire({
                                    title: 'Tipo de archivo no válido',
                                    text: 'Solo se permiten imágenes (JPG, PNG, GIF)',
                                    icon: 'error',
                                    confirmButtonText: 'Entendido'
                                });
                                return;
                            }
                        }
                    });
                });
            });
        })();

        // Inicialización cuando carga la página
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar fecha actual por defecto
            document.querySelector('input[name="fecha"]').value = new Date().toISOString().substr(0, 10);
            
            // Si se acaba de guardar, hacer scroll al inicio
            <?php if ($justSaved): ?>
            window.scrollTo({ top: 0, behavior: 'smooth' });
            <?php endif; ?>
            
            // Mejorar apariencia de campos de archivo
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
                    const fileContainer = input.parentElement;
                    const infoText = fileContainer.querySelector('.form-text');
                    if (e.target.files.length > 0) {
                        if (infoText) infoText.innerHTML = `<span class="text-success"><i class="fas fa-check me-1"></i>${fileName}</span>`;
                    } else {
                        if (infoText) infoText.innerHTML = 'Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB';
                    }
                });
            });
            
            // Autocompletar campos de selección frecuentes con datalist
            const placaInput = document.querySelector('input[name="placa"]');
            if (placaInput) {
                placaInput.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            }
        });
    </script>
</div>

<?php include 'layouts/footer.php'; ?>