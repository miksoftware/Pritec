<?php
// filepath: c:\laragon\www\Pritec\usuarios\usuarios_class.php
require_once __DIR__ . '/../conexion/conexion.php';

class UsuariosManager {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    /**
     * Lista todos los usuarios en el sistema
     * @return array Lista de usuarios
     */
    public function listarUsuarios() {
        try {
            $conn = $this->conexion->conectar();
            
            $query = "SELECT * FROM usuarios ORDER BY id DESC";
            $resultado = $conn->query($query);
            
            $usuarios = [];
            while ($row = $resultado->fetch_assoc()) {
                $usuarios[] = $row;
            }
            
            return $usuarios;
        } catch (Exception $e) {
            error_log("Error al listar usuarios: " . $e->getMessage());
            return [];
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    /**
     * Obtiene un usuario por su ID
     * @param int $id ID del usuario
     * @return array|null Datos del usuario o null si no existe
     */
    public function obtenerUsuarioPorId($id) {
        try {
            $conn = $this->conexion->conectar();
            
            $query = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows === 0) {
                return null;
            }
            
            return $resultado->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error al obtener usuario: " . $e->getMessage());
            return null;
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    /**
     * Crea un nuevo usuario en el sistema
     * @param array $datos Datos del usuario
     * @return array Resultado de la operación
     */
    public function crearUsuario($datos) {
        try {
            $conn = $this->conexion->conectar();
            
            // Verificar si el usuario o email ya existen
            $checkQuery = "SELECT * FROM usuarios WHERE usuario = ? OR (email = ? AND email IS NOT NULL AND email != '')";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("ss", $datos['usuario'], $datos['email']);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            
            if ($checkResult->num_rows > 0) {
                $existente = $checkResult->fetch_assoc();
                if ($existente['usuario'] === $datos['usuario']) {
                    return [
                        'status' => false,
                        'message' => 'El nombre de usuario ya está en uso'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'El correo electrónico ya está registrado'
                    ];
                }
            }
            
            // Encriptar la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
            
            // Insertar nuevo usuario
            $query = "INSERT INTO usuarios (usuario, nombre_completo, email, password, activo) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $activo = isset($datos['activo']) ? 1 : 0;
            $stmt->bind_param("ssssi", $datos['usuario'], $datos['nombre_completo'], $datos['email'], $passwordHash, $activo);
            
            $resultado = $stmt->execute();
            
            if ($resultado) {
                return [
                    'status' => true,
                    'message' => 'Usuario creado exitosamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el usuario'
                ];
            }
        } catch (Exception $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ];
        } finally {
            if (isset($checkStmt)) $checkStmt->close();
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    /**
     * Actualiza los datos de un usuario existente
     * @param array $datos Datos del usuario
     * @return array Resultado de la operación
     */
    public function actualizarUsuario($datos) {
        $checkStmt = null;
        $emailCheckStmt = null;
        $stmt = null;
        
        try {
            $conn = $this->conexion->conectar();
            
            // Verificar que el usuario existe
            $checkQuery = "SELECT * FROM usuarios WHERE id = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("i", $datos['id']);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            
            if ($checkResult->num_rows === 0) {
                return [
                    'status' => false,
                    'message' => 'El usuario no existe'
                ];
            }
            
            // Verificar email único si se está actualizando
            if (!empty($datos['email'])) {
                $emailCheckQuery = "SELECT * FROM usuarios WHERE email = ? AND id != ? AND email IS NOT NULL AND email != ''";
                $emailCheckStmt = $conn->prepare($emailCheckQuery);
                $emailCheckStmt->bind_param("si", $datos['email'], $datos['id']);
                $emailCheckStmt->execute();
                $emailCheckResult = $emailCheckStmt->get_result();
                
                if ($emailCheckResult->num_rows > 0) {
                    return [
                        'status' => false,
                        'message' => 'El correo electrónico ya está registrado por otro usuario'
                    ];
                }
                
                // Eliminar este cierre manual, ya se hará en el bloque finally
                // $emailCheckStmt->close();
            }
            
            // Si hay contraseña nueva, actualizarla
            if (!empty($datos['password'])) {
                $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
                
                $query = "UPDATE usuarios SET nombre_completo = ?, email = ?, password = ?, activo = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $activo = isset($datos['activo']) ? 1 : 0;
                $stmt->bind_param("sssii", $datos['nombre_completo'], $datos['email'], $passwordHash, $activo, $datos['id']);
            } else {
                // Actualizar sin cambiar la contraseña
                $query = "UPDATE usuarios SET nombre_completo = ?, email = ?, activo = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $activo = isset($datos['activo']) ? 1 : 0;
                $stmt->bind_param("ssii", $datos['nombre_completo'], $datos['email'], $activo, $datos['id']);
            }
            
            $resultado = $stmt->execute();
            
            if ($resultado) {
                return [
                    'status' => true,
                    'message' => 'Usuario actualizado exitosamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al actualizar el usuario'
                ];
            }
        } catch (Exception $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ];
        } finally {
            // Cerramos los statements solo si existen
            if (isset($checkStmt) && $checkStmt) $checkStmt->close();
            if (isset($emailCheckStmt) && $emailCheckStmt) $emailCheckStmt->close();
            if (isset($stmt) && $stmt) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    /**
     * Elimina un usuario del sistema
     * @param int $id ID del usuario a eliminar
     * @return array Resultado de la operación
     */
    public function eliminarUsuario($id) {
        try {
            $conn = $this->conexion->conectar();
            
            // Verificar que el usuario no sea el último administrador
            $countQuery = "SELECT COUNT(*) as total FROM usuarios WHERE activo = 1";
            $countResult = $conn->query($countQuery);
            $countData = $countResult->fetch_assoc();
            
            if ($countData['total'] <= 1) {
                return [
                    'status' => false,
                    'message' => 'No se puede eliminar el último usuario activo del sistema'
                ];
            }
            
            // Eliminar usuario (soft delete cambiando activo a 0)
            $query = "UPDATE usuarios SET activo = 0 WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            
            $resultado = $stmt->execute();
            
            if ($resultado) {
                return [
                    'status' => true,
                    'message' => 'Usuario eliminado exitosamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al eliminar el usuario'
                ];
            }
        } catch (Exception $e) {
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ];
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }
}