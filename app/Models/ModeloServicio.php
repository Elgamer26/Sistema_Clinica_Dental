<?php

namespace App\Models;

use ModeloConection;

class ModeloServicio
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

    function crear_servicio($nombre, $precio, $tipo_descuento, $descuento, $descripcion)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM servicios where nombre = ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "INSERT INTO servicios (nombre,precio,tipo_descuento,descuento,descripcion) VALUES (?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $precio);
                $querya->bindParam(3, $tipo_descuento);
                $querya->bindParam(4, $descuento);
                $querya->bindParam(5, $descripcion);
                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = -1;
            }
            $this->conexion->cerrar_conexion();
            return $res;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo response()->json(['success' => '', 'error' => 'Error: ' . $e->getMessage(), 'status' => 403], 403);
        }
        exit();
    }

    function lista_servicios($id)
    {
        if ($id == 0) {
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,nombre,precio,tipo_descuento,descuento,descripcion from servicios where estado = 1 ORDER BY nombre ASC";
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
        } else {
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,nombre,precio,tipo_descuento,descuento,descripcion from servicios where id = ? AND estado = 1 LIMIT 1";
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

    function eliminar_servicio($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE servicios SET estado = 0 WHERE id = ?";
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

    function update_servicio($id, $nombre, $precio, $tipo_descuento, $descuento, $descripcion)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM servicios where nombre=? AND estado=1 AND id!=?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "UPDATE servicios SET nombre=?,precio=?,tipo_descuento=?,descuento=?,descripcion=? WHERE id=?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $precio);
                $querya->bindParam(3, $tipo_descuento);
                $querya->bindParam(4, $descuento);
                $querya->bindParam(5, $descripcion);
                $querya->bindParam(6, $id);
                if ($querya->execute()) {
                    $res = 1;
                } else {
                    $res = 0;
                }
            } else {
                $res = -1;
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
