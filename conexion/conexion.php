<?php
class Conexion {
    private $host = 'localhost';
    private $usuario = 'root';
    private $password = '';
    private $database = 'pritec';
    private $conn;

    public function conectar() {
        $this->conn = new mysqli(
            $this->host,
            $this->usuario,
            $this->password,
            $this->database
        );

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        return $this->conn;
    }
}
?>