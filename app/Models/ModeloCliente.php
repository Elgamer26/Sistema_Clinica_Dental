<?php

namespace App\Models;

use ModeloConection;

class ModeloCliente
{
    private $conexion;
    function __construct()
    {
        require_once 'ModeloConection.php';
        $this->conexion = new ModeloConection();
        //abrir conexion
        $this->conexion->conexionPDO();
        //cerra conexion
        $this->conexion->cerrar_conexion();
    }

    function cliente_create($nombre_clie, $apellido_clie, $correo_clie, $telefono_clie, $sexo_clie, $cedula_clie, $direccion_clie, $nombrearchivo)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM cliente where nombre = ? and apellido = ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre_clie);
            $query->bindParam(2, $apellido_clie);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "INSERT INTO cliente (nombre,apellido,correo,telefono,sexo,cedula,direccion,foto) VALUES (?,?,?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre_clie);
                $querya->bindParam(2, $apellido_clie);
                $querya->bindParam(3, $correo_clie);
                $querya->bindParam(4, $telefono_clie);
                $querya->bindParam(5, $sexo_clie);
                $querya->bindParam(6, $cedula_clie);
                $querya->bindParam(7, $direccion_clie);
                $querya->bindParam(8, $nombrearchivo);

                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
            }

            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo response()->json(['success' => '', 'error' => 'Error: ' . $e->getMessage(), 'status' => 403], 403);
        }
        exit();
    }

    function listar_clientes($id)
    {
        if ($id == 0){
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,nombre,apellido,correo,telefono,sexo,cedula,direccion,foto from cliente where estado = 1 ORDER BY nombre ASC";
                $query = $c->prepare($sql);
                $query->execute();
                $result = $query->fetchAll(\PDO::FETCH_BOTH);
                //cerramos la conexion
                $this->conexion->cerrar_conexion();
                return $result;
            } catch (\Exception $e) {
                $this->conexion->cerrar_conexion();
                echo "Error: " . $e->getMessage();
            }
        }else{
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,nombre,apellido,correo,telefono,sexo,cedula,direccion,foto from cliente where estado = 1 AND id = ? LIMIT 1";
                $query = $c->prepare($sql);
                $query->bindParam(1, $id);
                $query->execute();
                $result = $query->fetch(\PDO::FETCH_BOTH);
                //cerramos la conexion
                $this->conexion->cerrar_conexion();
                return $result;
            } catch (\Exception $e) {
                $this->conexion->cerrar_conexion();
                echo "Error: " . $e->getMessage();
            }
        }

        exit();
    }

    function eliminar_cliente($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE cliente SET estado = 0 WHERE id = ?";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            if ($querya->execute()) {
                $res = 1;
            } else {
                $res = 0;
            }
            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo response()->json(['success' => '', 'error' => 'Error: ' . $e->getMessage(), 'status' => 403], 403);
        }
        exit();
    }

    function cliente_update($nombre_clie, $apellido_clie, $correo_clie, $telefono_clie, $sexo_clie, $cedula_clie, $direccion_clie, $id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM cliente where nombre = ? and apellido = ? and estado = 1 and id != ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre_clie);
            $query->bindParam(2, $apellido_clie);
            $query->bindParam(3, $id);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "UPDATE cliente SET nombre = ?,apellido = ?,correo = ?,telefono = ?,sexo = ?,cedula = ?,direccion = ? WHERE id = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre_clie);
                $querya->bindParam(2, $apellido_clie);
                $querya->bindParam(3, $correo_clie);
                $querya->bindParam(4, $telefono_clie);
                $querya->bindParam(5, $sexo_clie);
                $querya->bindParam(6, $cedula_clie);
                $querya->bindParam(7, $direccion_clie);
                $querya->bindParam(8, $id);
                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = 2;
            }
            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo response()->json(['success' => '', 'error' => 'Error: ' . $e->getMessage(), 'status' => 403], 403);
        }
        exit();
    }

}
