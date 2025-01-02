<?php
class Conexion {
    private $host = 'localhost';
    private $db_name = 'ventas_gaseosas';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn; // Retorna el objeto PDO si es exitoso
        } catch (PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage()); // Registra el error en el log del servidor
            return false; // Retorna false si hay error
        }
    }
}
