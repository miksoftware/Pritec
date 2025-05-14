<?php
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

// Incluir dependencias
require_once dirname(__FILE__) . '/peritaje_basico/Getid.php';
require_once dirname(__FILE__) . '/Enums/SeguroEnum.php';
require_once dirname(__FILE__) . '/Enums/ImprontaEnum.php';

// Obtener datos del peritaje
$peritaje = obtenerPeritajePorId($id);
if (!$peritaje) {
    $_SESSION['error'] = "Peritaje no encontrado";
    header('Location: l_peritajeB.php');
    exit;
}

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
        <h2 class="text-center mb-4">Editar Peritaje</h2>
        <form id="peritajeForm" action="peritaje_basico/Update.php" method="POST" enctype="multipart/form-data">

            <!-- Servicio -->
            <div class="card mb-3">
                <div class="card-header">Servicio</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha" required value="<?php echo htmlspecialchars($peritaje['fecha'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">No Servicio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_servicio" required value="<?php echo htmlspecialchars($peritaje['no_servicio'] ?? ''); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Servicio Para <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="servicio_para" required value="<?php echo htmlspecialchars($peritaje['servicio_para'] ?? ''); ?>">
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
                <div class="card-header">Datos del Solicitante</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre y Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre_apellidos" required value="<?php echo htmlspecialchars($peritaje['nombre_apellidos'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" required value="<?php echo htmlspecialchars($peritaje['identificacion'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($peritaje['telefono'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($peritaje['direccion'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Datos del Vehículo -->
            <div class="card mb-3">
                <div class="card-header">Datos del Vehículo</div>
                <div class="card-body">
                    <div class="row">
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
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Checkboxes -->
            <div class="card mb-3">
                <div class="card-header">Estado/Documentos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="prenda" <?php echo ($peritaje['tiene_prenda'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Tiene prenda/gravamen</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="limitacion" <?php echo ($peritaje['tiene_limitacion'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Tiene limitación</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="impuestos" <?php echo ($peritaje['debe_impuestos'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Debe impuestos</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="comparendos" <?php echo ($peritaje['tiene_comparendos'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Tiene comparendos al tránsito</label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="rematado" <?php echo ($peritaje['vehiculo_rematado'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Vehículo rematado</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Selects -->
            <div class="card mb-3">
                <div class="card-header">Documentación</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Revisión Tecnicomecánica <span class="text-danger">*</span></label>
                            <select class="form-select" name="rtm" onchange="toggleFechaVencimiento('rtm')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($peritaje['rtm'] === $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="rtm_fecha" class="mt-2" style="display:<?php echo (in_array($peritaje['rtm'], ['VIGENTE', 'NO_VIGENTE'])) ? 'block' : 'none'; ?>">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="rtm_fecha_vencimiento" value="<?php echo htmlspecialchars($peritaje['rtm_fecha_vencimiento'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SOAT <span class="text-danger">*</span></label>
                            <select class="form-select" name="soat" onchange="toggleFechaVencimiento('soat')" required>
                                <option value="">Seleccione</option>
                                <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($peritaje['soat'] === $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="soat_fecha" class="mt-2" style="display:<?php echo (in_array($peritaje['soat'], ['VIGENTE', 'NO_VIGENTE'])) ? 'block' : 'none'; ?>">
                                <label class="form-label">Fecha de Vencimiento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="soat_fecha_vencimiento" value="<?php echo htmlspecialchars($peritaje['soat_fecha_vencimiento'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"><?php echo htmlspecialchars($peritaje['observaciones'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Licencia Frente</label>
                            <input type="file" class="form-control" name="licencia_frente" accept="image/*">
                            <?php if (!empty($peritaje['licencia_frente'])): ?>
                                <input type="hidden" name="current_licencia_frente" value="<?php echo htmlspecialchars($peritaje['licencia_frente']); ?>">
                                <div class="mt-2">
                                    <p class="mb-1">Imagen actual:</p>
                                    <img src="uploads/<?php echo htmlspecialchars($peritaje['licencia_frente']); ?>" alt="Licencia frente" class="img-thumbnail mb-2" style="max-height: 100px">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Licencia Atrás</label>
                            <input type="file" class="form-control" name="licencia_atras" accept="image/*">
                            <?php if (!empty($peritaje['licencia_atras'])): ?>
                                <input type="hidden" name="current_licencia_atras" value="<?php echo htmlspecialchars($peritaje['licencia_atras']); ?>">
                                <div class="mt-2">
                                    <p class="mb-1">Imagen actual:</p>
                                    <img src="uploads/<?php echo htmlspecialchars($peritaje['licencia_atras']); ?>" alt="Licencia atrás" class="img-thumbnail mb-2" style="max-height: 100px">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Concepto e Improntas -->
            <div class="card mb-3">
                <div class="card-header">Concepto e Improntas</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de Motor <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_motor" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($peritaje['estado_motor'] === $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número de Chasis <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_chasis" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($peritaje['estado_chasis'] === $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Número Serial <span class="text-danger">*</span></label>
                            <select class="form-select" name="estado_serial" required>
                                <option value="">Seleccione</option>
                                <?php foreach (ImprontaEnum::getOptions() as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo ($peritaje['estado_serial'] === $value) ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones Finales</label>
                            <textarea class="form-control" name="observaciones_finales" rows="3"><?php echo htmlspecialchars($peritaje['observaciones_finales'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $peritaje['id']; ?>">
            <div class="text-center mt-4 d-flex justify-content-center gap-3">
                <a href="l_peritajeB.php" class="btn btn-secondary px-5">Volver</a>
                <button type="submit" class="btn btn-primary px-5">Actualizar Peritaje</button>
            </div>
        </form>
    </div>

    <script>
        // Función para mostrar/ocultar campos de fecha de vencimiento
        function toggleFechaVencimiento(tipo) {
            const select = document.querySelector(`select[name="${tipo}"]`);
            const fechaDiv = document.getElementById(`${tipo}_fecha`);
            const fechaInput = document.querySelector(`[name="${tipo}_fecha_vencimiento"]`);

            if (select.value === 'VIGENTE' || select.value === 'NO_VIGENTE') {
                fechaDiv.style.display = 'block';
                fechaInput.required = true;
            } else {
                fechaDiv.style.display = 'none';
                fechaInput.required = false;
                fechaInput.value = '';
            }
        }

        // Validación del formulario
        document.getElementById('peritajeForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let hasEmpty = false;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
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

        // Inicialización y depuración cuando carga la página
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Datos del peritaje:', <?php echo json_encode($peritaje); ?>);
            
            // Depuración de selects
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                console.log(`Select ${select.name} actual: ${select.value}`);
                console.log(`Valor esperado para ${select.name}: ${<?php echo json_encode($peritaje); ?>['${select.name}']}`)
                
                // Forzar la selección correcta en caso de que no coincida
                if (select.name === 'estado_motor' || select.name === 'estado_chasis' || select.name === 'estado_serial') {
                    const expectedValue = <?php echo json_encode($peritaje); ?>['estado_' + select.name.split('_')[1]];
                    if (expectedValue) {
                        Array.from(select.options).forEach(option => {
                            if (option.value === expectedValue) {
                                option.selected = true;
                                console.log(`Forzado select ${select.name} a valor ${expectedValue}`);
                            }
                        });
                    }
                } else if (select.name === 'rtm') {
                    const expectedValue = <?php echo json_encode($peritaje['rtm']); ?>;
                    if (expectedValue) {
                        Array.from(select.options).forEach(option => {
                            if (option.value === expectedValue) {
                                option.selected = true;
                                console.log(`Forzado select rtm a valor ${expectedValue}`);
                            }
                        });
                    }
                } else if (select.name === 'soat') {
                    const expectedValue = <?php echo json_encode($peritaje['soat']); ?>;
                    if (expectedValue) {
                        Array.from(select.options).forEach(option => {
                            if (option.value === expectedValue) {
                                option.selected = true;
                                console.log(`Forzado select soat a valor ${expectedValue}`);
                            }
                        });
                    }
                }
            });
            
            // Ejecutar las funciones de mostrar/ocultar fechas al iniciar
            toggleFechaVencimiento('rtm');
            toggleFechaVencimiento('soat');
        });
    </script>  
</div>

<?php include 'layouts/footer.php'; ?>