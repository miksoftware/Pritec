<?php
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
?>

<div id="content">

 <?php if ($justSaved): ?>
    <!-- Mensaje de éxito fijo en la parte superior cuando se acaba de guardar -->
    <div class="alert alert-success alert-dismissible sticky-top shadow-sm" role="alert">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <i class="fas fa-check-circle fa-lg me-2"></i>
                <strong>¡Peritaje guardado con éxito!</strong> 
                <?php echo $peritajeId ? "ID del peritaje: #$peritajeId" : ''; ?>
            </div>
            <div>
                <a href="l_peritajeB.php" class="btn btn-sm btn-outline-success me-2">
                    <i class="fas fa-list me-1"></i> Ver listado
                </a>
                <?php if ($peritajeId): ?>
                <a href="p_peritajeB.php?id=<?php echo $peritajeId; ?>" class="btn btn-sm btn-outline-primary me-2" target="_blank">
                    <i class="fas fa-print me-1"></i> Imprimir
                </a>
                <a href="e_peritajeB.php?id=<?php echo $peritajeId; ?>" class="btn btn-sm btn-outline-info me-2">
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
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success']) && !$justSaved): ?>
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
        <h2 class="text-center mb-4">Nuevo Peritaje</h2>
        <form id="peritajeForm" action="peritaje_basico/create.php" method="POST" enctype="multipart/form-data">

            <!-- Servicio -->
            <div class="card">
                <div class="card-header">Servicio</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Convenio</label>
                            <input type="text" class="form-control" name="convenio">
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
                            <input type="text" class="form-control" name="nombre_apellidos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="card">
                <div class="card-header">Datos del Vehículo</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="placa" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Clase</label>
                            <input type="text" class="form-control" name="clase">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" name="marca">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Línea</label>
                            <input type="text" class="form-control" name="linea">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cilindraje</label>
                            <input type="text" class="form-control" name="cilindraje">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Servicio</label>
                            <input type="text" class="form-control" name="servicio">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="modelo">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" name="color">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Chasis</label>
                            <input type="text" class="form-control" name="no_chasis">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Motor</label>
                            <input type="text" class="form-control" name="no_motor">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Serie</label>
                            <input type="text" class="form-control" name="no_serie">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Carrocería</label>
                            <input type="text" class="form-control" name="tipo_carroceria">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Organismo de Tránsito</label>
                            <input type="text" class="form-control" name="organismo_transito">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Checkboxes -->
            <div class="card">
                <div class="card-header">Estado/Documentos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="prenda">
                                <label class="form-check-label">Tiene prenda/gravamen</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="limitacion">
                                <label class="form-check-label">Tiene limitación</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="impuestos">
                                <label class="form-check-label">Debe impuestos</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="comparendos">
                                <label class="form-check-label">Tiene comparendos al tránsito</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="rematado">
                                <label class="form-check-label">Vehículo rematado</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Selects -->
            <div class="card">
                <div class="card-header">Documentación</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Revisión Tecnicomecánica <span class="text-danger">*</span></label>
                            <select class="form-select" name="rtm" onchange="toggleFechaVencimiento('rtm')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="rtm_fecha" class="mt-2" style="display:none">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="rtm_fecha_vencimiento">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SOAT <span class="text-danger">*</span></label>
                            <select class="form-select" name="soat" onchange="toggleFechaVencimiento('soat')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="soat_fecha" class="mt-2" style="display:none">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="soat_fecha_vencimiento">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Licencia Frente</label>
                            <input type="file" class="form-control" name="licencia_frente" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Licencia Atrás</label>
                            <input type="file" class="form-control" name="licencia_atras" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Concepto e Improntas -->
            <div class="card">
                <div class="card-header">Concepto e Improntas</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de Motor <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_motor" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de Chasis <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_chasis" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número Serial <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_serial" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones Finales</label>
                            <textarea class="form-control" name="observaciones_finales" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">Guardar Peritaje</button>
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

    <script>
        function toggleFechaVencimiento(tipo) {
            const select = document.querySelector(`select[name="${tipo}"]`);
            const fechaDiv = document.getElementById(`${tipo}_fecha`);
            console.log('Valor seleccionado:', select.value);

            if (select.value === 'VIGENTE' || select.value === 'NO_VIGENTE') {
                fechaDiv.style.display = 'block';
            } else {
                fechaDiv.style.display = 'none';
            }
        }

         <?php if ($justSaved): ?>
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        <?php endif; ?>
    </script>
</div>

<?php include 'layouts/footer.php'; ?>