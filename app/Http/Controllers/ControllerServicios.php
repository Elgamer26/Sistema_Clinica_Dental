<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Echo_;

class ControllerServicios extends BaseController
{

    protected $servicio;
    public function __construct()
    {
        $this->servicio = new ModeloServicio();
        session_start();
    }

    // VISTAS **************************************
    public function nuevo_servicio()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('servicio/form_servicio');
        }
    }

    public function crear_servicio(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre  = $request->nombre_producto;
                $precio  = $request->precio_producto;
                $tipo_descuento = $request->tipo_descuento;
                $descuento = $request->descuento;
                $descripcion = $request->descripcion;

                $repuesta_create = $this->servicio->crear_servicio($nombre, $precio, $tipo_descuento, $descuento, $descripcion);

                if ($repuesta_create > 0) {
                    return response()->json(['success' => 'Servicio ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == -1) {
                    return response()->json(['success' => 'Servicio ' . $nombre . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function lista_servicios(Request $request)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            if ($request->isMethod('get')) {
                $repuesta_lista = $this->servicio->lista_servicios(0);
                $data = [
                    'lista' =>  $repuesta_lista
                ];
                return view('servicio/form_lista_servicio', $data);
            }
        }
    }

    public function eliminar_servicio(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $id = $request->id;
                $repuesta_create = $this->servicio->eliminar_servicio($id);
                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'El servicio se elimino con exito', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar el servicio', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function editar_servicio($id)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->servicio->lista_servicios($id);
            if (!empty($repuesta_lista)) {
                $data = [
                    'lista' =>  $repuesta_lista,
                ];
                return view('servicio/frm_editar_servicio', $data);
            } else {
                return redirect()->route('servicio.frm_lista_servicios');
            }
        }
    }

    public function update_servicio(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id  = $request->id;
                $nombre  = $request->nombre_producto;
                $precio  = $request->precio_producto;
                $tipo_descuento = $request->tipo_descuento;
                $descuento = $request->descuento;
                $descripcion = $request->descripcion;

                $repuesta_create = $this->servicio->update_servicio($id,$nombre, $precio, $tipo_descuento, $descuento, $descripcion);

                if ($repuesta_create > 0) {
                    return response()->json(['success' => 'Servicio actualizado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == -1) {
                    return response()->json(['success' => 'Servicio ' . $nombre . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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
