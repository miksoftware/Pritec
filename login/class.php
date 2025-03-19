<?php
require_once('./conexion/conexion.php');

class Login {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function iniciarSesion($usuario, $password) {
        try {
            $conn = $this->conexion->conectar();
            
            // Encriptar la contraseña ingresada para comparar con la BD
            $passwordMd5 = md5($password);
            
            // Preparar la consulta
            $query = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $usuario, $passwordMd5);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if($resultado->num_rows == 1) {
                $datos = $resultado->fetch_assoc();
                // Iniciar sesión
                session_start();
                $_SESSION['id_usuario'] = $datos['id'];
                $_SESSION['usuario'] = $datos['usuario'];
                $_SESSION['rol'] = $datos['rol'];
                return true;
            } else {
                return false;
            }
            
        } catch (Exception $e) {
            echo $e;
            return false;
        } finally {
            if($conn) {
                $conn->close();
            }

            if($stmt) {
                $stmt->close();
            }
        }
    }

    public function cerrarSesion() {
        session_start();
        session_destroy();
        return true;
    }
}
?>