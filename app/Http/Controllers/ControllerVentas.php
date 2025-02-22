<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloCliente;
use App\Models\ModeloCompras;
use App\Models\ModeloProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Echo_;
use setasign\Fpdi\Fpdi;

class ControllerVentas extends BaseController
{

    protected $cliente;
    protected $producto;
    protected $venta;
    public function __construct()
    {
        date_default_timezone_set('America/Guayaquil'); // Cambia a tu zona horaria
        $this->venta = new ModeloCompras();
        $this->producto = new ModeloProducto();
        $this->cliente = new ModeloCliente();
        session_start();
    }

    // VISTAS **************************************
    public function nueva_venta()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->producto->listado_producto(0);
            $lista_clientes = $this->cliente->listar_clientes(0);
            $data = [
                'fecha' => date('Y-m-d'),
                'lista' =>  $repuesta_lista,
                'cliente' => $lista_clientes,
            ];
            return view('venta/form_nueva_venta', $data);
        }
    }
}
