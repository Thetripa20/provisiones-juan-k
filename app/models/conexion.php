<?php
class Conexion {
    private $host = "localhost";
    private $usuario = "root"; // Tu usuario de MySQL en XAMPP
    private $contrasena = "";   // Tu contraseña de MySQL en XAMPP
    private $base_de_datos = "provisiones-juan-k";
    private $conexion;

    public function __construct() {
        try {
            $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_de_datos);
            if ($this->conexion->connect_error) {
                throw new Exception("Error de conexión: " . $this->conexion->connect_error);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>