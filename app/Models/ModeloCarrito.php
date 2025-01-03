<?php

namespace App\Models;

use ModeloConection;

class ModeloCarrito
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

    function listar_producto($partida, $valor)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $paginaactual = htmlspecialchars($partida, ENT_QUOTES, 'UTF-8');
            if (!empty($valor)) {
                $datos = $valor;
                $sql = "SELECT count(*) FROM
                        producto
                        where (nombre LIKE '%" . $datos . "%' OR tipo LIKE '%" . $datos . "%') AND estado = 1 AND stock > 0";
            } else {
                $sql = "SELECT count(*) FROM
                        producto
                        where estado = 1
                        AND stock > 0";
            }

            $query = $c->prepare($sql);
            $query->execute();
            $data = $query->fetch();
            $arreglo = array();

            foreach ($data as $respuesta) {
                $arreglo[] = $respuesta;
            }

            $numlotes = 12;
            $nropaguinas = ceil($arreglo[0] / $numlotes);
            $lista = "";
            $tabla = "";

            if ($paginaactual > 1) {
                $lista = $lista . ' <li class="page-item">
                                        <a class="page-link" href="javascript:paginartienda(' . ($paginaactual - 1) . ');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>';
            }

            for ($i = 1; $i <= $nropaguinas; $i++) {
                if ($i == $paginaactual) {
                    $lista = $lista . '<li class="page-item active"><a class="page-link" href="javascript:paginartienda(' . ($i) . ');">' . $i . '</a></li>';
                } else {
                    $lista = $lista . '<li class="page-item"><a class="page-link" href="javascript:paginartienda(' . ($i) . ');">' . $i . '</a></li>';
                }
            }

            if ($paginaactual < $nropaguinas) {
                $lista = $lista . ' <li class="page-item">
                            <a class="page-link" href="javascript:paginartienda(' . ($paginaactual + 1) . ');" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </li>';
            }

            if ($paginaactual <= 1) {
                $limit = 0;
            } else {
                $limit = $numlotes * ($paginaactual - 1);
            }

            if (!empty($valor)) {
                $datos = $valor;
                $sql_p = "SELECT id, nombre, tipo, precio, tipo_descuento, descuento, descripcion, stock,
                         (SELECT imagen FROM img_producto i where i.idproducto = p.id limit 1) as imagen
                          FROM producto p
                          where (p.nombre LIKE '%" . $datos . "%' OR p.tipo LIKE '%" . $datos . "%')
                          AND p.estado = 1
                          GROUP BY p.id
                          ORDER BY p.nombre
                          LIMIT $limit, $numlotes";
            } else {
                $sql_p = "SELECT id, nombre, tipo, precio, tipo_descuento, descuento, descripcion, stock,
                        (SELECT imagen FROM img_producto i where i.idproducto = p.id limit 1) as imagen
                        FROM producto p
                        where p.estado = 1
                        GROUP BY p.id
                        ORDER BY p.nombre
                        LIMIT $limit, $numlotes";
            }

            //
            $query_p = $c->prepare($sql_p);
            $query_p->execute();
            $result = $query_p->fetchAll();
            $descuento = "";
            foreach ($result as $respuesta) {

                $imagePath = $respuesta[8] ? 'img/producto/' . $respuesta[8] : null;
                if ($imagePath && file_exists(public_path($imagePath))) {
                    $imageUrl = asset($imagePath);
                } else {
                    $imageUrl = asset('img/default.png');
                }

                if ($respuesta[4] == "desc") {
                    $descuento =       "<span class='sale'>- $" . $respuesta[5] . "</span>";
                } else if ($respuesta[4] == "proc") {
                    $descuento = "<span class='sale'>- %" . $respuesta[5] . "</span>";
                } else {
                    $descuento = "";
                }

                $tabla = $tabla . '<div class="col-md-3" style="width: 30%;">
                <div class="product">
                <a href="' . route('carrito.detalle_producto', $respuesta[0]) . '">
                        <div class="product-img">
                        <img style="height: 256px;" src="' . $imageUrl . '" alt="">
                            <div class="product-label">
                                ' . $descuento . '
                            </div>
                        </div>
                    </a>
                    <div class="product-body">
                        <p class="product-category">' . $respuesta[2] . '</p>
                        <h3 class="product-name"><a>' . $respuesta[1] . '</a></h3>
                        <h4 class="product-price">$980.00 </h4>
                    </div>
                    <div class="add-to-cart">
                        <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Agregar al carrito </button>
                    </div>
                </div>
            </div>';
            }

            $array = array(0 => $tabla, 1 => $lista);
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $array;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }


        exit();
    }

    function listar_servicios($partida, $valor)
    {
        try {
            $c = $this->conexion->conexionPDO();
            $paginaactual = htmlspecialchars($partida, ENT_QUOTES, 'UTF-8');
            if (!empty($valor)) {
                $datos = $valor;
                $sql = "SELECT count(*) FROM
                        servicios
                        where (nombre LIKE '%" . $datos . "%') AND estado = 1";
            } else {
                $sql = "SELECT count(*) FROM
                        servicios
                        where estado = 1";
            }

            $query = $c->prepare($sql);
            $query->execute();
            $data = $query->fetch();
            $arreglo = array();

            foreach ($data as $respuesta) {
                $arreglo[] = $respuesta;
            }

            $numlotes = 12;
            $nropaguinas = ceil($arreglo[0] / $numlotes);
            $lista = "";
            $tabla = "";

            if ($paginaactual > 1) {
                $lista = $lista . ' <li class="page-item">
                                        <a class="page-link" href="javascript:paginartiendaServicio(' . ($paginaactual - 1) . ');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>';
            }

            for ($i = 1; $i <= $nropaguinas; $i++) {
                if ($i == $paginaactual) {
                    $lista = $lista . '<li class="page-item active"><a class="page-link" href="javascript:paginartiendaServicio(' . ($i) . ');">' . $i . '</a></li>';
                } else {
                    $lista = $lista . '<li class="page-item"><a class="page-link" href="javascript:paginartiendaServicio(' . ($i) . ');">' . $i . '</a></li>';
                }
            }

            if ($paginaactual < $nropaguinas) {
                $lista = $lista . ' <li class="page-item">
                            <a class="page-link" href="javascript:paginartiendaServicio(' . ($paginaactual + 1) . ');" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Próximo</span>
                            </a>
                        </li>';
            }

            if ($paginaactual <= 1) {
                $limit = 0;
            } else {
                $limit = $numlotes * ($paginaactual - 1);
            }

            if (!empty($valor)) {
                $datos = $valor;
                $sql_p = "SELECT id, nombre, precio, tipo_descuento, descuento, descripcion
                          FROM servicios p
                          where (p.nombre LIKE '%" . $datos . "%')
                          AND p.estado = 1
                          GROUP BY p.id
                          ORDER BY p.nombre
                          LIMIT $limit, $numlotes";
            } else {
                $sql_p = "SELECT id, nombre, precio, tipo_descuento, descuento, descripcion
                        FROM servicios p
                        where p.estado = 1
                        GROUP BY p.id
                        ORDER BY p.nombre
                        LIMIT $limit, $numlotes";
            }

            //
            $query_p = $c->prepare($sql_p);
            $query_p->execute();
            $result = $query_p->fetchAll();
            $descuento = "";
            foreach ($result as $respuesta) {

                if ($respuesta[3] == "desc") {
                    $descuento =       "<span class='sale'>- $" . $respuesta[4] . "</span>";
                } else if ($respuesta[3] == "proc") {
                    $descuento = "<span class='sale'>- %" . $respuesta[4] . "</span>";
                } else {
                    $descuento = "";
                }

                $tabla = $tabla . '<div class="col-md-3" style="width: 30%;">
                    <div class="product">
                        <a href="' . route('carrito.detalle_producto', $respuesta[0]) . '">
                            <div class="product-img">
                                <img style="height: 50px;" src=" " alt="">
                                <div class="product-label">
                                    ' . $descuento . '
                                </div>
                            </div>
                        </a>
                        <div class="product-body">
                            <p class="product-category">' . $respuesta[2] . '</p>
                            <h3 class="product-name"><a>' . $respuesta[1] . '</a></h3>
                            <h4 class="product-price">$980.00</h4>
                        </div>
                        <div class="add-to-cart">
                            <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Agregar al carrito </button>
                        </div>
                    </div>
                </div>';
            }

            $array = array(0 => $tabla, 1 => $lista);
            //cerramos la conexion
            $this->conexion->cerrar_conexion();
            return $array;
        } catch (\Exception $e) {
            $this->conexion->cerrar_conexion();
            echo "Error: " . $e->getMessage();
        }


        exit();
    }
}
