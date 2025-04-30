<?php
session_start();
require_once 'Enums/SeguroEnum.php';
require_once 'Enums/ImprontaEnum.php';
include 'layouts/header.php';

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
    'NO APLICA'
];

$fields = [
    'estado_cauchos_suspension' => 'Estado cauchos suspensión',
    'estado_tanque_catalizador_gases' => 'Estado tanque catalizador gases',
    'estado_tubo_exhosto' => 'Estado tubo de escape',
    'estado_radiador' => 'Estado radiador',
    'estado_externo_bateria' => 'Estado externo batería',
    'estado_cables_instalacion_alta' => 'Estado cables instalación alta',
    'estado_tanque_silenciador' => 'Estado tanque silenciador',
    'estado_filtro_aire' => 'Estado filtro aire',
    'estado_brazos_direccion_rotulas' => 'Estado brazos dirección rótulas',
    'fugas_tanque_combustible' => 'Fugas tanque combustible',
    'fugas_aceite_amortiguadores' => 'Fugas aceite amortiguadores',
    'fugas_liquido_bomba_embrague' => 'Fugas líquido bomba embrague',
    'fuga_aceite_direccion_hidraulica' => 'Fuga aceite dirección hidráulica',
    'fuga_liquido_frenos' => 'Fuga líquido frenos',
    'fuga_aceite_caja_transmision' => 'Fuga aceite caja transmisión',
    'fuga_aceite_caja_velocidades' => 'Fuga aceite caja velocidades',
    'tension_correas' => 'Tensión correas',
    'estado_correas' => 'Estado correas',
    'estado_mangueras_radiador' => 'Estado mangueras radiador',
    'estado_tuberias_frenos' => 'Estado tuberías frenos',
    'estado_guardapolvo_caja_direccion' => 'Estado guardapolvo caja dirección',
    'estado_protectores_inferiores' => 'Estado protectores inferiores',
    'estado_carter' => 'Estado cárter',
    'fuga_aceite_motor' => 'Fuga aceite motor',
    'estado_guardapolvos_ejes' => 'Estado guardapolvos ejes',
    'estado_tijeras' => 'Estado tijeras',
    'estado_radiador_aa' => 'Estado radiador A/A',
    'estado_soporte_motor' => 'Estado soporte motor',
    'estado_carcasa_caja_velocidades' => 'Estado carcasa caja velocidades',
    'viscosidad_aceite_motor' => 'Viscosidad aceite motor',
    'nivel_refrigerante_motor' => 'Nivel refrigerante motor',
    'nivel_liquido_frenos' => 'Nivel líquido frenos',
    'nivel_agua_limpiavidrios' => 'Nivel agua limpiavidrios',
    'nivel_aceite_direccion_hidraulica' => 'Nivel aceite dirección hidráulica',
    'nivel_liquido_embrague' => 'Nivel líquido embrague',
    'nivel_aceite_motor' => 'Nivel aceite motor',
    'funcionamiento_aa' => 'Funcionamiento A/A',
    'soporte_caja_velocidades' => 'Soporte caja velocidades'
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
        <h2 class="text-center mb-4">Nuevo Peritaje Completo</h2>
        <form id="peritajeForm" action="peritaje_completo/create.php" method="POST" enctype="multipart/form-data">

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
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" id="email" class="form-control" name="email">
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
                            <input type="text" class="form-control" id="tipo_vehiculo_display" readonly>
                            <input type="hidden" class="form-control" name="tipo_vehiculo" id="tipo_vehiculo_input" required>
                        </div>
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
                        <div class="col-md-4 mb-3">
                            <label for="kilometraje" class="form-label">Kilometraje</label>
                            <input type="number" id="kilometraje" class="form-control" name="kilometraje">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="codigo_fasecolda" class="form-label">Código fasecolda</label>
                            <input type="text" id="codigo_fasecolda" class="form-control" name="codigo_fasecolda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_fasecolda" class="form-label">Valor fasecolda</label>
                            <input type="number" id="valor_fasecolda" class="form-control" name="valor_fasecolda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_sugerido" class="form-label">Valor sugerido</label>
                            <input type="number" id="valor_sugerido" class="form-control" name="valor_sugerido">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_accesorios" class="form-label">Valor accesorios</label>
                            <input type="number" id="valor_accesorios" class="form-control" name="valor_accesorios">
                        </div>
                    </div>
                </div>
            </div>

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
                            <textarea id="observaciones_inspeccion" class="form-control" name="observaciones_inspeccion" rows="3"></textarea>
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
                            <textarea id="observaciones_estructura" class="form-control" name="observaciones_estructura" rows="3"></textarea>
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
                            <textarea id="observaciones_chasis" class="form-control" name="observaciones_chasis" rows="3"></textarea>
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
                            <input type="number" class="form-control" name="llanta_anterior_izquierda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior derecha</label>
                            <input type="number" class="form-control" name="llanta_anterior_derecha">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior izquierda</label>
                            <input type="number" class="form-control" name="llanta_posterior_izquierda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior derecha</label>
                            <input type="number" class="form-control" name="llanta_posterior_derecha">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="observaciones_llantas" class="form-label">Observaciones</label>
                            <textarea id="observaciones_llantas" class="form-control" name="observaciones_llantas" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Amortiguadores</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior izquierdo</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_izquierdo">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje anterior derecho</label>
                            <input type="number" class="form-control" name="amortiguador_anterior_derecho">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior izquierdo</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_izquierdo">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Porcentaje posterior derecho</label>
                            <input type="number" class="form-control" name="amortiguador_posterior_derecho">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Batería</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prueba de batería (%)</label>
                            <input type="number" class="form-control" name="prueba_bateria" min="0" max="100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prueba de arranque (%)</label>
                            <input type="number" class="form-control" name="prueba_arranque" min="0" max="100">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Carga de batería (%)</label>
                            <input type="number" class="form-control" name="carga_bateria" min="0" max="100">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="observaciones_bateria" class="form-label">Observaciones</label>
                            <textarea id="observaciones_bateria" class="form-control" name="observaciones_bateria" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Selects -->
            <div class="card">
                <div class="card-header">Estados</div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($fields as $name => $label): ?>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label"><?php echo $label; ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="<?php echo $name; ?>" required />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- fotografias -->
            <div class="card">
                <div class="card-header">Fijación fotográfica</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 1</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_1" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 2</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_2" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 3</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_3" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 4</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_4" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 5</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_5" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fotografía 6</label>
                            <input type="file" class="form-control" name="fijacion_fotografica_6" accept="image/*">
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
        // Funcionalidad para Inspección Visual Externa
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar fila de inspección
            document.getElementById('agregarFilaInspeccion').addEventListener('click', function() {
                const tbody = document.querySelector('#tablaInspeccionVisual tbody');
                const nuevaFila = document.createElement('tr');
                nuevaFila.className = 'fila-inspeccion';
                nuevaFila.innerHTML = `
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
                `;
                tbody.appendChild(nuevaFila);

                // Agregar evento al nuevo botón de eliminar
                nuevaFila.querySelector('.eliminar-fila').addEventListener('click', function() {
                    eliminarFila(this);
                });
            });

            // Inicializar botones de eliminar existentes
            document.querySelectorAll('.eliminar-fila').forEach(function(boton) {
                boton.addEventListener('click', function() {
                    eliminarFila(this);
                });
            });

            // Función para eliminar fila
            function eliminarFila(boton) {
                const fila = boton.closest('tr');
                // Verificar que no sea la única fila
                const todasLasFilas = document.querySelectorAll('.fila-inspeccion');
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
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // === FUNCIONALIDAD PARA ESTRUCTURA ===
        // Agregar fila de inspección de estructura
        document.getElementById('agregarFilaEstructura').addEventListener('click', function() {
            const tbody = document.querySelector('#tablaInspeccionEstructura tbody');
            const nuevaFila = document.createElement('tr');
            nuevaFila.className = 'fila-estructura';
            nuevaFila.innerHTML = `
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
            `;
            tbody.appendChild(nuevaFila);
            
            // Agregar evento al nuevo botón de eliminar
            nuevaFila.querySelector('.eliminar-fila-estructura').addEventListener('click', function() {
                eliminarFilaEstructura(this);
            });
        });
        
        // Inicializar botones de eliminar existentes para estructura
        document.querySelectorAll('.eliminar-fila-estructura').forEach(function(boton) {
            boton.addEventListener('click', function() {
                eliminarFilaEstructura(this);
            });
        });
        
        // Función para eliminar fila de estructura
        function eliminarFilaEstructura(boton) {
            const fila = boton.closest('tr');
            const todasLasFilas = document.querySelectorAll('.fila-estructura');
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
        
        // === FUNCIONALIDAD PARA CHASIS ===
        // Agregar fila de inspección de chasis
        document.getElementById('agregarFilaChasis').addEventListener('click', function() {
            const tbody = document.querySelector('#tablaInspeccionChasis tbody');
            const nuevaFila = document.createElement('tr');
            nuevaFila.className = 'fila-chasis';
            nuevaFila.innerHTML = `
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
            `;
            tbody.appendChild(nuevaFila);
            
            // Agregar evento al nuevo botón de eliminar
            nuevaFila.querySelector('.eliminar-fila-chasis').addEventListener('click', function() {
                eliminarFilaChasis(this);
            });
        });
        
        // Inicializar botones de eliminar existentes para chasis
        document.querySelectorAll('.eliminar-fila-chasis').forEach(function(boton) {
            boton.addEventListener('click', function() {
                eliminarFilaChasis(this);
            });
        });
        
        // Función para eliminar fila de chasis
        function eliminarFilaChasis(boton) {
            const fila = boton.closest('tr');
            const todasLasFilas = document.querySelectorAll('.fila-chasis');
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
    });
</script>
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

        // Mostrar el modal automáticamente al cargar la página si no hay tipo seleccionado
        if (!inputEl.value) {
            tipoVehiculoModal.show();
            // Ocultar el botón de cerrar para forzar la selección inicial
            closeModalBtn.style.display = 'none';
        }

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