<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Incluir el header
include 'layouts/header.php';

// Incluir la clase de usuarios
require_once 'usuarios/usuarios_class.php';

// Instanciar la clase de usuarios
$usuariosManager = new UsuariosManager();

// Obtener la lista de usuarios
$usuarios = $usuariosManager->listarUsuarios();
?>

<div id="content" class="container-fluid py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-users me-2"></i> Administración de Usuarios
            </h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
                <i class="fas fa-plus me-1"></i> Nuevo Usuario
            </button>
        </div>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['mensaje']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo_mensaje']);
            ?>
        <?php endif; ?>

        <!-- Tabla de Usuarios -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Usuarios Registrados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Nombre Completo</th>
                                <th>Email</th>
                                <th>Fecha Creación</th>
                                <th>Último Login</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay usuarios registrados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?php echo $usuario['id']; ?></td>
                                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['nombre_completo'] ?? 'No especificado'); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['email'] ?? 'No especificado'); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])); ?></td>
                                        <td><?php echo $usuario['ultimo_login'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) : 'Nunca'; ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $usuario['activo'] ? 'success' : 'danger'; ?>">
                                                <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-primary editar-usuario" 
                                                        data-id="<?php echo $usuario['id']; ?>"
                                                        data-usuario="<?php echo htmlspecialchars($usuario['usuario']); ?>"
                                                        data-nombre="<?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?>"
                                                        data-email="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>"
                                                        data-activo="<?php echo $usuario['activo']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger eliminar-usuario" 
                                                        data-id="<?php echo $usuario['id']; ?>"
                                                        data-usuario="<?php echo htmlspecialchars($usuario['usuario']); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearUsuarioModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearUsuario" action="usuarios/procesar_usuario.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="accion" value="crear">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre_completo" name="nombre_completo">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_password" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label" for="activo">Usuario Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarUsuario" action="usuarios/procesar_usuario.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="accion" value="editar">
                    <input type="hidden" id="editar_id" name="id">
                    <div class="mb-3">
                        <label for="editar_usuario" class="form-label">Usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editar_usuario" name="usuario" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editar_nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="editar_nombre_completo" name="nombre_completo">
                    </div>
                    <div class="mb-3">
                        <label for="editar_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editar_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="editar_password" class="form-label">Nueva Contraseña <small class="text-muted">(dejar en blanco para mantener la actual)</small></label>
                        <input type="password" class="form-control" id="editar_password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="editar_confirmar_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="editar_confirmar_password" name="confirmar_password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editar_activo" name="activo" value="1">
                        <label class="form-check-label" for="editar_activo">Usuario Activo</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Usuario -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarUsuarioModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar al usuario <span id="eliminar_usuario_nombre" class="fw-bold"></span>?</p>
                <p class="text-danger">Esta acción no se puede deshacer.</p>
            </div>
            <form id="formEliminarUsuario" action="usuarios/procesar_usuario.php" method="POST">
                <input type="hidden" name="accion" value="eliminar">
                <input type="hidden" id="eliminar_id" name="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        $('#tablaUsuarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
            order: [[0, 'desc']]
        });

        // Validación del formulario de crear usuario
        $('#formCrearUsuario').on('submit', function(e) {
            const password = $('#password').val();
            const confirmarPassword = $('#confirmar_password').val();

            if (password !== confirmarPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Las contraseñas no coinciden',
                    confirmButtonColor: '#3085d6'
                });
            }
        });

        // Validación del formulario de editar usuario
        $('#formEditarUsuario').on('submit', function(e) {
            const password = $('#editar_password').val();
            const confirmarPassword = $('#editar_confirmar_password').val();

            if (password && password !== confirmarPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Las contraseñas no coinciden',
                    confirmButtonColor: '#3085d6'
                });
            }
        });

        // Evento para abrir el modal de editar usuario
        $('.editar-usuario').on('click', function() {
            const id = $(this).data('id');
            const usuario = $(this).data('usuario');
            const nombre = $(this).data('nombre');
            const email = $(this).data('email');
            const activo = $(this).data('activo');

            $('#editar_id').val(id);
            $('#editar_usuario').val(usuario);
            $('#editar_nombre_completo').val(nombre);
            $('#editar_email').val(email);
            $('#editar_activo').prop('checked', activo == 1);
            $('#editar_password').val('');
            $('#editar_confirmar_password').val('');

            $('#editarUsuarioModal').modal('show');
        });

        // Evento para abrir el modal de eliminar usuario
        $('.eliminar-usuario').on('click', function() {
            const id = $(this).data('id');
            const usuario = $(this).data('usuario');

            $('#eliminar_id').val(id);
            $('#eliminar_usuario_nombre').text(usuario);

            $('#eliminarUsuarioModal').modal('show');
        });
    });
</script>

<?php include 'layouts/footer.php'; ?>