<?php

namespace App\Models;

use ModeloConection;

class ModeloProducto
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

    function create_producto($nombre, $tipo, $precio, $tipo_descuento, $descuento, $descripcion)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM producto where nombre = ? and tipo = ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $tipo);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "INSERT INTO producto (nombre,tipo,precio,tipo_descuento,descuento,descripcion) VALUES (?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $tipo);
                $querya->bindParam(3, $precio);
                $querya->bindParam(4, $tipo_descuento);
                $querya->bindParam(5, $descuento);
                $querya->bindParam(6, $descripcion);
                if ($querya->execute()) {
                    $res = $c->lastInsertId();
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

    function RegistrarImagen($id, $imagen)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $res = 0;
            $sql_a = "INSERT INTO img_producto (idproducto, imagen) VALUES (?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id);
            $querya->bindParam(2, $imagen);
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

    function listado_producto($id)
    {
        if ($id == 0) {
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,nombre,tipo,precio,tipo_descuento,descuento,descripcion,stock, (SELECT count(*) as valor FROM img_producto where idproducto = p.id) as valor from producto p where estado = 1 ORDER BY nombre ASC";
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
                $sql = "SELECT id,nombre,tipo,precio,tipo_descuento,descuento,descripcion,stock from producto where id = ? AND estado = 1 LIMIT 1";
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

    function imagen_producto($id)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT id,idproducto,imagen as img FROM img_producto where idproducto = ?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_BOTH);
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $result;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function eliminar_imagen($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "DELETE FROM img_producto WHERE id = ?";
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

    function update_producto($nombre, $tipo, $precio, $tipo_descuento, $descuento, $descripcion, $id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM producto where nombre=? and tipo=? and estado=1 AND id!=?";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $tipo);
            $query->bindParam(3, $id);
            $query->execute();
            $data_u = $query->fetch();
            if (empty($data_u)) {
                $sql_a = "UPDATE producto SET nombre=?,tipo=?,precio=?,tipo_descuento=?,descuento=?,descripcion=? WHERE id=?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $tipo);
                $querya->bindParam(3, $precio);
                $querya->bindParam(4, $tipo_descuento);
                $querya->bindParam(5, $descuento);
                $querya->bindParam(6, $descripcion);
                $querya->bindParam(7, $id);
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

    function eliminar_producto($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE producto SET estado = 0 WHERE id = ?";
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
}
