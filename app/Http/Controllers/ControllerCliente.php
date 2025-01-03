<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControllerCliente extends BaseController
{

    protected $cliente;
    public function __construct()
    {
        $this->cliente = new ModeloCliente();
        session_start();
    }

    // VISTAS **************************************
    public function nuevo_cliente()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('cliente/form_cliente');
        }
    }

    public function editar_cliente($id)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->cliente->listar_clientes($id);
            if (!empty($repuesta_lista)) {
                $data = [
                    'lista' =>  $repuesta_lista
                ];
                return view('cliente/form_editar_cliente', $data);
            } else {
                return redirect()->route('cliente.formLista_cliente');
            }
        }
    }

    public function lista_cliente(Request $request)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            if ($request->isMethod('get')) {
                $repuesta_lista = $this->cliente->listar_clientes(0);
                $data = [
                    'lista' =>  $repuesta_lista
                ];
                return view('cliente/form_lista_cliente', $data);
            }
        }
    }

    public function cliente_create(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre_clie = $request->nombre_clie;
                $apellido_clie = $request->apellido_clie;
                $correo_clie = $request->correo_clie;
                $telefono_clie = $request->telefono_clie;
                $sexo_clie = $request->sexo_clie;
                $cedula_clie = $request->cedula_clie;
                $direccion_clie = $request->direccion_clie;
                $file  = $request->file('foto');
                $nombrearchivo = $request->nombrearchivo;

                if (!empty($file)) {
                    $repuesta_create = $this->cliente->cliente_create($nombre_clie, $apellido_clie, $correo_clie, $telefono_clie, $sexo_clie, $cedula_clie, $direccion_clie, $nombrearchivo);
                    if ($repuesta_create == 1) {
                        $filePath = public_path('img/clientes'); // Ruta a la carpeta public/img/usuario
                        $file->move($filePath, $nombrearchivo);
                    }
                } else {
                    $imagen = "cliente.png";
                    $repuesta_create = $this->cliente->cliente_create($nombre_clie, $apellido_clie, $correo_clie, $telefono_clie, $sexo_clie, $cedula_clie, $direccion_clie, $imagen);
                }

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Cliente ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Cliente ' . $nombre_clie . ' ' . $apellido_clie . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function eliminar_cliente(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $id = $request->id;
                $repuesta_create = $this->cliente->eliminar_cliente($id);
                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'El cliente se elimino con exito', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar el cliente', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function cliente_update(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre_clie = $request->nombre_clie;
                $apellido_clie = $request->apellido_clie;
                $correo_clie = $request->correo_clie;
                $telefono_clie = $request->telefono_clie;
                $sexo_clie = $request->sexo_clie;
                $cedula_clie = $request->cedula_clie;
                $direccion_clie = $request->direccion_clie;
                $id = $request->id;

                $repuesta_create = $this->cliente->cliente_update($nombre_clie, $apellido_clie, $correo_clie, $telefono_clie, $sexo_clie, $cedula_clie, $direccion_clie, $id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Cliente actualizado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Cliente ' . $nombre_clie . ' ' . $apellido_clie . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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
