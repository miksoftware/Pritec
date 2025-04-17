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
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    $_SESSION['error'] = "Error al cargar el peritaje: " . $e->getMessage();
    header('Location: L_peritajeC.php');
    exit;
}

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
                <div class="card-header">Datos del Vehículo</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Placa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="placa" value="<?php echo $peritaje['placa']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Clase</label>
                            <input type="text" class="form-control" name="clase" value="<?php echo $peritaje['clase']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" name="marca" value="<?php echo $peritaje['marca']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Línea</label>
                            <input type="text" class="form-control" name="linea" value="<?php echo $peritaje['linea']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cilindraje</label>
                            <input type="text" class="form-control" name="cilindraje" value="<?php echo $peritaje['cilindraje']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Servicio</label>
                            <input type="text" class="form-control" name="servicio" value="<?php echo $peritaje['servicio']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" name="modelo" value="<?php echo $peritaje['modelo']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" class="form-control" name="color" value="<?php echo $peritaje['color']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Chasis</label>
                            <input type="text" class="form-control" name="no_chasis" value="<?php echo $peritaje['no_chasis']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Motor</label>
                            <input type="text" class="form-control" name="no_motor" value="<?php echo $peritaje['no_motor']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">No de Serie</label>
                            <input type="text" class="form-control" name="no_serie" value="<?php echo $peritaje['no_serie']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Carrocería</label>
                            <input type="text" class="form-control" name="tipo_carroceria" value="<?php echo $peritaje['tipo_carroceria']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Organismo de Tránsito</label>
                            <input type="text" class="form-control" name="organismo_transito" value="<?php echo $peritaje['organismo_transito']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kilometraje" class="form-label">Kilometraje</label>
                            <input type="number" id="kilometraje" class="form-control" name="kilometraje" value="<?php echo $peritaje['kilometraje']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="codigo_fasecolda" class="form-label">Código fasecolda</label>
                            <input type="text" id="codigo_fasecolda" class="form-control" name="codigo_fasecolda" value="<?php echo $peritaje['codigo_fasecolda']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_fasecolda" class="form-label">Valor fasecolda</label>
                            <input type="number" id="valor_fasecolda" class="form-control" name="valor_fasecolda" value="<?php echo $peritaje['valor_fasecolda']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_sugerido" class="form-label">Valor sugerido</label>
                            <input type="number" id="valor_sugerido" class="form-control" name="valor_sugerido" value="<?php echo $peritaje['valor_sugerido']; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="valor_accesorios" class="form-label">Valor accesorios</label>
                            <input type="number" id="valor_accesorios" class="form-control" name="valor_accesorios" value="<?php echo $peritaje['valor_accesorios']; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Observaciones</label>
                            <textarea class="form-control" name="observaciones" rows="3"><?php echo $peritaje['observaciones']; ?></textarea>
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
                    </div>
                </div>
            </div>

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
            
            <!-- Estado/Documentos Selects -->
            <div class="card">
                <div class="card-header">Estados</div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($fields as $name => $label): ?>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label"><?php echo $label; ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="<?php echo $name; ?>" value="<?php echo $peritaje[$name]; ?>" required />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Estado/Documentos Selects -->
            <div class="card">
                <div class="card-header">Fijación fotográfica</div>
                <div class="card-body">
                    <div class="row">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fotografía <?php echo $i; ?></label>
                                <?php $field = "fijacion_fotografica_".$i; ?>
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

<?php include 'layouts/footer.php'; ?>