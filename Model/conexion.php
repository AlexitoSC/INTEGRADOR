<?php
class Conexion {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "credito_hipotecario";
    private $port = 3307; // Asegúrate de que el puerto es el correcto
    public $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        if ($this->conexion->connect_error) {
            die("Error en la conexión: " . $this->conexion->connect_error);
        }
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>

