<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloCompras;
use App\Models\ModeloProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Echo_;

class ControllerCompras extends BaseController
{
    protected $producto;
    protected $compra;
    public function __construct()
    {
        date_default_timezone_set('America/Guayaquil'); // Cambia a tu zona horaria
        $this->compra = new ModeloCompras();
        $this->producto = new ModeloProducto();
        session_start();
    }

    // VISTAS **************************************
    public function nueva_compra()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->producto->listado_producto(0);
            $data = [
                'fecha' => date('Y-m-d'),
                'lista' =>  $repuesta_lista
            ];
            return view('compra/form_nueva_compra', $data);
        }
    }

    public function lista_compras()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->compra->listado_compras(0);
            $data = [
                'fecha' => date('Y-m-d'),
                'lista' =>  $repuesta_lista
            ];
            return view('compra/form_lista_compra', $data);
        }
    }

    public function crear_compra(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $fecha  = $request->fecha;
                $tipo_comprabante  = $request->tipo_comprabante;
                $iva  = $request->iva;
                $numero_factura = $request->numero_factura;
                $subtotal = $request->subtotal;
                $impuesto_sub = $request->impuesto_sub;
                $total_pagar = $request->total_pagar;

                $id_p = (string)$request->id_p;
                $precio = (string)$request->precio;
                $cantidad = (string)$request->cantidad;

                $arraglo_id_p = explode(",", $id_p); //aqui separo los datos
                $arraglo_precio = explode(",", $precio); //aqui separo los datos
                $arraglo_cantidad = explode(",", $cantidad); //aqui separo los datos

                $repuesta_create = $this->compra->crear_compra($_SESSION["iduser"], $fecha, $tipo_comprabante, $iva, $numero_factura, $subtotal, $impuesto_sub, $total_pagar);

                if ($repuesta_create > 0) {

                    for ($i = 0; $i < count($arraglo_id_p); $i++) {
                        $repuesta_create = $this->compra->detalle_compra($repuesta_create, $arraglo_id_p[$i], $arraglo_precio[$i], $arraglo_cantidad[$i]);
                    }

                    return response()->json(['success' => 'Comprar ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }
}
