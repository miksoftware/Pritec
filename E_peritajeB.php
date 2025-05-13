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
    header('Location: L_peritajeB.php');
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
    header('Location: L_peritajeB.php');
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
            <div class="text-center mt-4 d-flex justify-content-center gap-3">
                <a href="L_peritajeB.php" class="btn btn-secondary px-5">Volver</a>
                <button type="submit" class="btn btn-primary px-5">Actualizar Peritaje</button>
            </div>
        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const peritaje = <?php echo json_encode($peritaje); ?>;
            console.log('Datos peritaje:', peritaje);

            // Función para establecer valores en selects
            function setSelectValue(selectName, value) {
                const select = document.querySelector(`select[name="${selectName}"]`);
                if (select && value) {
                    // Verificar si el valor existe en las opciones
                    const optionExists = Array.from(select.options).some(option => option.value === value);
                    if (optionExists) {
                        select.value = value;
                        // Disparar evento change para selects específicos
                        if (selectName === 'rtm' || selectName === 'soat') {
                            const event = new Event('change');
                            select.dispatchEvent(event);
                        }
                    } else {
                        console.warn(`Valor '${value}' no encontrado en las opciones de ${selectName}`);
                    }
                }
            }

            // Función para establecer valores en inputs
            function setInputValue(inputName, value) {
                const input = document.querySelector(`[name="${inputName}"]`);
                if (input && value !== null && value !== undefined) {
                    if (input.type === 'checkbox') {
                        input.checked = parseInt(value) === 1;
                    } else if (input.type === 'date' && value) {
                        // Asegurarse de que la fecha esté en formato YYYY-MM-DD
                        const date = new Date(value);
                        if (!isNaN(date.getTime())) {
                            input.value = date.toISOString().split('T')[0];
                        }
                    } else {
                        input.value = value;
                    }
                }
            }

            // Mapeo de campos checkbox
            const checkboxMapping = {
                'tiene_prenda': 'prenda',
                'tiene_limitacion': 'limitacion',
                'debe_impuestos': 'impuestos',
                'tiene_comparendos': 'comparendos',
                'vehiculo_rematado': 'rematado'
            };

            // Establecer valores de checkboxes
            Object.entries(checkboxMapping).forEach(([dbField, formField]) => {
                setInputValue(formField, peritaje[dbField]);
            });

            // Establecer valores de selects
            const selectFields = [
                'rtm',
                'soat',
                'estado_motor',
                'estado_chasis',
                'estado_serial'
            ];

            selectFields.forEach(field => {
                setSelectValue(field, peritaje[field]);
            });

            // Establecer valores de fechas de vencimiento
            if (peritaje.rtm === 'VIGENTE' || peritaje.rtm === 'NO_VIGENTE') {
                setInputValue('rtm_fecha_vencimiento', peritaje.rtm_fecha_vencimiento);
                document.getElementById('rtm_fecha').style.display = 'block';
            }

            if (peritaje.soat === 'VIGENTE' || peritaje.soat === 'NO_VIGENTE') {
                setInputValue('soat_fecha_vencimiento', peritaje.soat_fecha_vencimiento);
                document.getElementById('soat_fecha').style.display = 'block';
            }

            // Establecer valores de campos de texto y áreas de texto
            const textFields = [
                'fecha',
                'no_servicio',
                'servicio_para',
                'convenio',
                'nombre_apellidos',
                'identificacion',
                'telefono',
                'direccion',
                'placa',
                'clase',
                'marca',
                'linea',
                'cilindraje',
                'servicio',
                'modelo',
                'color',
                'no_chasis',
                'no_motor',
                'no_serie',
                'tipo_carroceria',
                'organismo_transito',
                'observaciones',
                'observaciones_finales'
            ];

            textFields.forEach(field => {
                setInputValue(field, peritaje[field]);
            });

            // Configurar formulario para actualización
            const form = document.getElementById('peritajeForm');
            form.action = 'peritaje_basico/Update.php';

            // Agregar campo oculto para ID
            if (!form.querySelector('input[name="id"]')) {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = peritaje.id;
                form.appendChild(idInput);
            }
        });

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
    </script>


</div>

<?php include 'layouts/footer.php'; ?>