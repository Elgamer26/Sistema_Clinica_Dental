<?php

namespace App\Models;

use ModeloConection;

class ModeloCompras
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

    function crear_compra($usu, $fecha, $tipo_comprabante, $iva, $numero_factura, $subtotal, $impuesto_sub, $total_pagar)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql_a = "INSERT INTO compra (fecha,tipo_comprabante,iva,numero_factura,subtotal,impuesto_sub,total_pagar,id_usu) VALUES (?,?,?,?,?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $fecha);
            $querya->bindParam(2, $tipo_comprabante);
            $querya->bindParam(3, $iva);
            $querya->bindParam(4, $numero_factura);
            $querya->bindParam(5, $subtotal);
            $querya->bindParam(6, $impuesto_sub);
            $querya->bindParam(7, $total_pagar);
            $querya->bindParam(8, $usu);
            if ($querya->execute()) {
                $res = $c->lastInsertId();
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

    function detalle_compra($id_compra, $id_pro, $precio, $cantidad)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql_a = "INSERT INTO detalle_compra (id_compra,id_pro,precio,cantidad) VALUES (?,?,?,?)";
            $querya = $c->prepare($sql_a);
            $querya->bindParam(1, $id_compra);
            $querya->bindParam(2, $id_pro);
            $querya->bindParam(3, $precio);
            $querya->bindParam(4, $cantidad);
            if ($querya->execute()) {

                $sql_m = "UPDATE producto SET stock = stock + ? where id = ?";
                $query_m = $c->prepare($sql_m);
                $query_m->bindParam(1, $cantidad);
                $query_m->bindParam(2, $id_pro);
                if ($query_m->execute()) {
                    $res = 1;
                } else {
                    $result = 0;
                }
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

    function listado_compras($id)
    {
        if ($id == 0) {
            try {
                $c = $this->conexion->conexionPDO();
                $sql = "SELECT id,fecha,tipo_comprabante,numero_factura,subtotal,impuesto_sub,total_pagar,
                (SELECT nombre FROM clinicadental.usuario u WHERE u.id = p.id_usu LIMIT 1) as usuario
                from compra p where estado = 1 ORDER BY fecha ASC";
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
                $sql = "SELECT id,fecha,tipo_comprabante,numero_factura,subtotal,impuesto_sub,total_pagar,
                (SELECT nombre FROM clinicadental.usuario u WHERE u.id = p.id_usu LIMIT 1) as usuario
                from compra p where id = ? AND estado = 1 LIMIT 1";
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

    function listado_compras_detalle($id)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT d.id_compra, d.id_pro, d.precio, d.cantidad, p.nombre
                    FROM detalle_compra d inner join producto p on d.id_pro = p.id where d.id_compra = ?";
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
}
