<?php

namespace App\Models;

use ModeloConection;

class ModeloUsuario
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

    function validar_usuario($usuario, $passs)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT
            id,
            estado
            FROM
            usuario where usuario_usu = ? and password_usu = ? AND estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario);
            $query->bindParam(2, $passs);
            $query->execute();
            $result = $query->fetch();
            $this->conexion->cerrar_conexion();
            return $result;
            //cerramos la conexion
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }
        exit();
    }

    function RegistraRol($nombres)
    {

        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM roles where nombre = ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombres);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "INSERT INTO roles (nombre) VALUES (?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombres);

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

    function rol_lista()
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT * FROM roles WHERE estado = 1 ORDER BY nombre ASC";
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
        exit();
    }

    function eliminar_rol($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE roles SET estado = 0 WHERE id = ?";
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

    function editar_rol($nombre, $id)
    {

        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM roles where nombre = ? and id != ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $nombre);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "UPDATE roles SET nombre = ? WHERE id = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre);
                $querya->bindParam(2, $id);

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

    function usuario_create($nombre_usu,$apellido_usu,$correo_usu,$rol_usu,$password_usu,$usuario_usu,$foto_usu)
    {

        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM usuario where usuario_usu = ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario_usu);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "INSERT INTO usuario (nombre,apellido,correo,rolid,password_usu,usuario_usu,foto) VALUES (?,?,?,?,?,?,?)";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre_usu);
                $querya->bindParam(2, $apellido_usu);
                $querya->bindParam(3, $correo_usu);
                $querya->bindParam(4, $rol_usu);
                $querya->bindParam(5, $password_usu);
                $querya->bindParam(6, $usuario_usu);
                $querya->bindParam(7, $foto_usu);

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

    function listar_usuario()
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT s.id, s.nombre, s.apellido, s.correo, s.usuario_usu, s.password_usu, s.foto, r.nombre as rol, r.id as rol_id
            FROM usuario s inner join roles r on s.rolid = r.id where s.estado = 1
            ORDER BY s.nombre ASC";
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
        exit();
    }

    function usuario_eliminar($id)
    {
        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();
            $sql_a = "UPDATE usuario SET estado = 0 WHERE id = ?";
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

    function usuario_editar($nombre_usu, $apellido_usu, $correo_usu, $rol_usu, $usuario_usu, $id)
    {

        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM usuario where usuario_usu = ? and id != ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario_usu);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "UPDATE usuario SET nombre = ?,apellido = ?,correo = ?,rolid = ?,usuario_usu = ? WHERE id = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre_usu);
                $querya->bindParam(2, $apellido_usu);
                $querya->bindParam(3, $correo_usu);
                $querya->bindParam(4, $rol_usu);
                $querya->bindParam(5, $usuario_usu);
                $querya->bindParam(6, $id);

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

    function info_user($id)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $sql = "SELECT s.id, s.nombre, s.apellido, s.correo, s.usuario_usu, s.password_usu, s.foto, r.nombre as rol, r.id as rol_id
            FROM usuario s inner join roles r on s.rolid = r.id where s.estado = 1 AND s.id = ?
            ORDER BY s.nombre ASC";
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


    function update_perfil($nombre_usu, $apellido_usu, $correo_usu, $usuario_usu, $id, $password_usu)
    {

        try {
            $res = 0;
            $c = $this->conexion->conexionPDO();

            $sql = "SELECT * FROM usuario where usuario_usu = ? and id != ? and estado = 1";
            $query = $c->prepare($sql);
            $query->bindParam(1, $usuario_usu);
            $query->bindParam(2, $id);
            $query->execute();
            $data_u = $query->fetch();

            if (empty($data_u)) {

                $sql_a = "UPDATE usuario SET nombre = ?, apellido = ?, correo = ?, usuario_usu = ?, password_usu = ? WHERE id = ?";
                $querya = $c->prepare($sql_a);
                $querya->bindParam(1, $nombre_usu);
                $querya->bindParam(2, $apellido_usu);
                $querya->bindParam(3, $correo_usu);
                $querya->bindParam(4, $usuario_usu);
                $querya->bindParam(5, $password_usu);
                $querya->bindParam(6, $id);

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
