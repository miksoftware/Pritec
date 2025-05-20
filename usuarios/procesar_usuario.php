<?php
// filepath: c:\laragon\www\Pritec\usuarios\procesar_usuario.php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

// Incluir la clase de usuarios
require_once 'usuarios_class.php';

// Instanciar la clase de usuarios
$usuariosManager = new UsuariosManager();

// Verificar que se recibió una acción
if (!isset($_POST['accion'])) {
    $_SESSION['mensaje'] = 'Acción no especificada';
    $_SESSION['tipo_mensaje'] = 'danger';
    header('Location: ../usuarios.php');
    exit;
}

// Procesar según la acción
switch ($_POST['accion']) {
    case 'crear':
        // Validar campos requeridos
        if (empty($_POST['usuario']) || empty($_POST['password']) || empty($_POST['confirmar_password'])) {
            $_SESSION['mensaje'] = 'Todos los campos marcados con * son obligatorios';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Validar que las contraseñas coincidan
        if ($_POST['password'] !== $_POST['confirmar_password']) {
            $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Preparar datos para crear usuario
        $datos = [
            'usuario' => trim($_POST['usuario']),
            'nombre_completo' => trim($_POST['nombre_completo']) ?: null,
            'email' => trim($_POST['email']) ?: null,
            'password' => $_POST['password'],
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        // Crear usuario
        $resultado = $usuariosManager->crearUsuario($datos);
        
        $_SESSION['mensaje'] = $resultado['message'];
        $_SESSION['tipo_mensaje'] = $resultado['status'] ? 'success' : 'danger';
        header('Location: ../usuarios.php');
        break;
    
    case 'editar':
        // Validar campos requeridos
        if (empty($_POST['id']) || empty($_POST['usuario'])) {
            $_SESSION['mensaje'] = 'ID y Usuario son campos obligatorios';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Validar que las contraseñas coincidan si se están actualizando
        if (!empty($_POST['password']) && $_POST['password'] !== $_POST['confirmar_password']) {
            $_SESSION['mensaje'] = 'Las contraseñas no coinciden';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Preparar datos para actualizar usuario
        $datos = [
            'id' => (int)$_POST['id'],
            'usuario' => trim($_POST['usuario']),
            'nombre_completo' => trim($_POST['nombre_completo']) ?: null,
            'email' => trim($_POST['email']) ?: null,
            'password' => $_POST['password'], // La función de actualización ya verifica si está vacía
            'activo' => isset($_POST['activo']) ? 1 : 0
        ];
        
        // Actualizar usuario
        $resultado = $usuariosManager->actualizarUsuario($datos);
        
        $_SESSION['mensaje'] = $resultado['message'];
        $_SESSION['tipo_mensaje'] = $resultado['status'] ? 'success' : 'danger';
        header('Location: ../usuarios.php');
        break;
    
    case 'eliminar':
        // Validar que se recibió un ID
        if (empty($_POST['id'])) {
            $_SESSION['mensaje'] = 'ID de usuario no especificado';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Evitar eliminar el propio usuario
        if ((int)$_POST['id'] === (int)$_SESSION['id_usuario']) {
            $_SESSION['mensaje'] = 'No puede eliminar su propio usuario';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: ../usuarios.php');
            exit;
        }
        
        // Eliminar usuario
        $resultado = $usuariosManager->eliminarUsuario((int)$_POST['id']);
        
        $_SESSION['mensaje'] = $resultado['message'];
        $_SESSION['tipo_mensaje'] = $resultado['status'] ? 'success' : 'danger';
        header('Location: ../usuarios.php');
        break;
    
    default:
        $_SESSION['mensaje'] = 'Acción no válida';
        $_SESSION['tipo_mensaje'] = 'danger';
        header('Location: ../usuarios.php');
}