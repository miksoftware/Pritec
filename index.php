<?php
// filepath: c:\laragon\www\Pritec\index.php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit();
}

require_once './login/class.php';

// Proceso de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $login = new Login();
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    $resultado = $login->iniciarSesion($usuario, $password);
    
    if ($resultado['status']) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = $resultado['message'];
    }
}

// Proceso de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $login = new Login();
    $usuario = $_POST['reg_usuario'];
    $nombre = $_POST['reg_nombre'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];
    $confirmar = $_POST['reg_confirmar'];
    
    // Validaciones
    if (empty($usuario) || empty($nombre) || empty($email) || empty($password)) {
        $errorRegistro = "Todos los campos son obligatorios";
    } else if ($password !== $confirmar) {
        $errorRegistro = "Las contraseñas no coinciden";
    } else if (strlen($password) < 6) {
        $errorRegistro = "La contraseña debe tener al menos 6 caracteres";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorRegistro = "El correo electrónico no es válido";
    } else {
        $resultado = $login->registrarUsuario($usuario, $password, $nombre, $email);
        
        if ($resultado['status']) {
            $success = $resultado['message'];
        } else {
            $errorRegistro = $resultado['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRITEC - Sistema de Peritajes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
        }
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07);
            overflow: hidden;
        }
        .card-header {
            background-color:rgb(0, 0, 0);
            color: white;
            text-align: center;
            padding: 1.2rem;
        }
        .btn-primary {
            background-color:rgb(0, 0, 0);
            border-color:rgb(243, 244, 247);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #303f9f;
            border-color: #303f9f;
        }
        .form-control:focus {
            border-color:rgb(238, 190, 32);
            box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.25);
        }
        .logo {
            max-width: 150px;
            margin-bottom: 1rem;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .register-link {
            color: #3f51b5;
            cursor: pointer;
            text-decoration: underline;
        }
        .form-floating > label {
            padding-left: 1rem;
        }
        .input-group-text {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <h2 class="text-center">PRITEC</h2>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="" id="loginForm">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario o Email" required>
                            <label for="usuario"><i class="fas fa-user me-2"></i> Usuario o Email</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="input-group">
                            <div class="form-floating flex-grow-1">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                <label for="password"><i class="fas fa-lock me-2"></i> Contraseña</label>
                            </div>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" name="login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i> Ingresar
                        </button>
                    </div>
                    <div class="text-center">
                        <p class="mb-0">¿Nuevo usuario? <span class="register-link" data-bs-toggle="modal" data-bs-target="#registerModal">Regístrate aquí</span></p>
                    </div>
                </form>
            </div>
        </div>
        
        <p class="text-center mt-4 text-muted">&copy; <?php echo date('Y'); ?> PRITEC. Todos los derechos reservados.</p>
    </div>
    
    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-black text-white">
                    <h5 class="modal-title" id="registerModalLabel">Registro de Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="registerForm">
                        <div class="mb-3">
                            <label for="reg_nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="reg_nombre" name="reg_nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="reg_usuario" name="reg_usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="reg_email" name="reg_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="reg_password" name="reg_password" required>
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>
                        <div class="mb-3">
                            <label for="reg_confirmar" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="reg_confirmar" name="reg_confirmar" required>
                        </div>
                        <input type="hidden" name="register" value="1">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Registrarse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Mostrar/ocultar contraseña
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
        
        // Mostrar mensajes de error/éxito
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($error)): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo $error; ?>',
                });
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: '<?php echo $success; ?>',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Cerrar el modal de registro
                        var modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                        if (modal) modal.hide();
                    }
                });
            <?php endif; ?>
            
            <?php if (isset($errorRegistro)): ?>
                // Abrir automáticamente el modal de registro si hay error
                var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
                registerModal.show();
                
                setTimeout(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de registro',
                        text: '<?php echo $errorRegistro; ?>',
                    });
                }, 500);
            <?php endif; ?>
        });
        
        // Validación del formulario de registro
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('reg_password').value;
            const confirmar = document.getElementById('reg_confirmar').value;
            
            if (password !== confirmar) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Las contraseñas no coinciden',
                });
            } else if (password.length < 6) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La contraseña debe tener al menos 6 caracteres',
                });
            }
        });
    </script>
</body>
</html>