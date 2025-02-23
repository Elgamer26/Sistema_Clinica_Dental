<?php

class ModeloConection
{
    private $host;
    private $db;
    private $contraseña;
    private $usuario;
    public $pdo;
    public $puerto;

    //esto es para la conexion habrir la conexion la base de datos
    public function conexionPDO()
{
    $this->host = "172.17.0.2"; // 172.17.0.2 - IP del Mysql en Docker // 127.0.0.1 Host de Xampp sin Docker
    $this->usuario = "root";
    $this->contraseña = "elgamer1";
    $this->db = "clinicadental";

    try {
        $pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->usuario, $this->contraseña);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");
        return $pdo;
    } catch (Exception $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}


    //esto es para cerrar la conexion de la base de datos
    public function cerrar_conexion()
    {
        $this->pdo = null;
    }
}
