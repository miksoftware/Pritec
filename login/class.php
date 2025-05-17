<?php
// filepath: c:\laragon\www\Pritec\login\class.php
require_once('./conexion/conexion.php');

class Login
{
    private Conexion $connection;

    public function __construct()
    {
        $this->connection = new Conexion();
    }

    /**
     * Inicia sesión de usuario verificando credenciales
     * 
     * @param string $usuario Usuario o email
     * @param string $password Contraseña
     * @return array Resultado con estado y mensaje
     */
    public function iniciarSesion($usuario, $password)
    {
        try {
            $conn = $this->connection->conectar();

            // Verificar si el usuario existe (por nombre de usuario o email)
            $query = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $usuario, $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows == 0) {
                return [
                    'status' => false,
                    'message' => 'El usuario no existe'
                ];
            }

            $datos = $resultado->fetch_assoc();

            // Verificar si la cuenta está activa
            if ($datos['activo'] != 1) {
                return [
                    'status' => false,
                    'message' => 'Esta cuenta ha sido desactivada'
                ];
            }

            // Verificar contraseña (usando password_verify si es hash moderno o md5 para compatibilidad)
            $passwordValida = false;

            if (strlen($datos['password']) == 32) {
                // Es MD5 (compatibilidad con cuentas antiguas)
                $passwordValida = (md5($password) === $datos['password']);
            } else {
                // Es hash moderno
                $passwordValida = password_verify($password, $datos['password']);
            }

            if (!$passwordValida) {
                return [
                    'status' => false,
                    'message' => 'Contraseña incorrecta'
                ];
            }

            // Actualizar último login
            $updateQuery = "UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("i", $datos['id']);
            $updateStmt->execute();
            $updateStmt->close();

            // Iniciar sesión
            session_start();
            $_SESSION['id_usuario'] = $datos['id'];
            $_SESSION['usuario'] = $datos['usuario'];
            $_SESSION['nombre_completo'] = $datos['nombre_completo'] ?? $datos['usuario'];
            $_SESSION['email'] = $datos['email'] ?? '';

            return [
                'status' => true,
                'message' => 'Inicio de sesión exitoso'
            ];
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ];
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    /**
     * Registra un nuevo usuario en el sistema
     * 
     * @param string $usuario Nombre de usuario
     * @param string $password Contraseña
     * @param string $nombre Nombre completo
     * @param string $email Correo electrónico
     * @return array Resultado con estado y mensaje
     */
    public function registrarUsuario($usuario, $password, $nombre, $email)
    {
        $checkStmt = null;
        $insertStmt = null;

        try {
            $conn = $this->connection->conectar();

            // Verificar si el usuario o email ya existen
            $checkQuery = "SELECT * FROM usuarios WHERE usuario = ? OR email = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ss", $usuario, $email);
            $checkStmt->execute();
            $resultado = $checkStmt->get_result();

            if ($resultado->num_rows > 0) {
                $datos = $resultado->fetch_assoc();
                if ($datos['usuario'] == $usuario) {
                    return [
                        'status' => false,
                        'message' => 'Este nombre de usuario ya está en uso'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'Este correo electrónico ya está registrado'
                    ];
                }
            }
            // Importante: NO cerramos el checkStmt aquí, lo hacemos en finally

            // Encriptar la contraseña con algoritmo moderno
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar nuevo usuario
            $insertQuery = "INSERT INTO usuarios (usuario, nombre_completo, email, password) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ssss", $usuario, $nombre, $email, $passwordHash);
            $resultado = $insertStmt->execute();

            if ($resultado) {
                return [
                    'status' => true,
                    'message' => 'Usuario registrado exitosamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al registrar el usuario'
                ];
            }
        } catch (Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ];
        } finally {
            // Cerrar statements solo si existen y no han sido cerrados
            if (isset($checkStmt) && $checkStmt instanceof mysqli_stmt) {
                try {
                    $checkStmt->close();
                } catch (Error $e) {
                    // Statement ya cerrado, ignoramos el error
                }
            }

            if (isset($insertStmt) && $insertStmt instanceof mysqli_stmt) {
                try {
                    $insertStmt->close();
                } catch (Error $e) {
                    // Statement ya cerrado, ignoramos el error
                }
            }

            if (isset($conn)) {
                $conn->close();
            }
        }
    }

    /**
     * Cierra la sesión actual
     * 
     * @return bool Resultado de la operación
     */
    public function cerrarSesion()
    {
        session_start();
        session_destroy();
        return true;
    }
}
