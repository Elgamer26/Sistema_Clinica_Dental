<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO
use App\Models\ModeloProducto;
use App\Models\ModeloCarrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControllerCarrito extends BaseController
{

    protected $producto;
    protected $carrito;
    public function __construct()
    {
        $this->producto = new ModeloProducto();
        $this->carrito = new ModeloCarrito();
        session_start();
    }

    // VISTAS **************************************
    public function tienda()
    {
        return view('carrito/index');
    }

    public function servicios()
    {
        return view('carrito/servicios');
    }

    public function detalle_producto($id)
    {
        $repuesta_lista = $this->producto->listado_producto($id);
        if (!empty($repuesta_lista)) {
            $repuesta_imagen = $this->producto->imagen_producto($id);
            $data = [
                'lista' => $repuesta_lista,
                'imgs' => $repuesta_imagen,
            ];
            return view('carrito/detalle', $data);
        } else {
            return redirect()->route('tienda');
        }
    }

    public function listar_producto(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $partida  = $request->partida;
                $valor  = $request->valor;
                $repuesta_create = $this->carrito->listar_producto($partida, $valor);
                echo json_encode($repuesta_create, JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
        exit();
    }

    public function listar_servicios(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $partida  = $request->partida;
                $valor  = $request->valor;
                $repuesta_create = $this->carrito->listar_servicios($partida, $valor);
                echo json_encode($repuesta_create, JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
        exit();
    }
}
