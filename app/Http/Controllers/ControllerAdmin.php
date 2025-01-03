<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ControllerAdmin extends BaseController
{

    protected $usuario;
    public function __construct()
    {
        $this->usuario = new ModeloUsuario();
        session_start();
    }

    // VISTAS **************************************
    public function index()
    {
        if (!isset($_SESSION["iduser"])) {
            return view('login/index'); // login
        } else {
            return redirect()->route('admin');
        }
    }

    public function admin()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('admin/index');
        }
    }

    public function usuario_salir()
    {
        session_destroy();
        return redirect()->route('/');  // login
    }

    public function rol()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('admin/gestionRol');
        }
    }

    public function usuario()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $rol = $this->usuario->rol_lista();
            $data = [
                'rol' =>  $rol
            ];
            return view('admin/gestionUsuario', $data);
        }
    }

    public function usuario_perfil()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('admin/perfil_usuario');
        }
    }

    // ******************************************

    // PROCESO DE LOGIN
    public function validar_usuario(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $usuario = $request->usuario;
                $password = $request->password;
                $repuesta = $this->usuario->validar_usuario($usuario, $password);
                return response()->json(['success' => $repuesta, 'error' => '', 'status' => 200], 200);
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function token_usuario(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $_SESSION["iduser"] = $request->id_usu;
                echo 1;
                exit();
            }
        }
    }


    // PROCESO DE ROL
    public function register_rol(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre = $request->NombreRol;
                $repuesta_create = $this->usuario->RegistraRol($nombre);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Dato ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Dato ingresado ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function rol_lista(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                $repuesta_lista = $this->usuario->rol_lista();
                return response()->json(['success' => $repuesta_lista, 'error' => '', 'status' => 200], 200);
            }
        }
    }

    public function eliminar_rol(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id = $request->id;
                $repuesta_create = $this->usuario->eliminar_rol($id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'El rol se elimino con exito', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar el rol', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function editar_rol(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id = $request->id;
                $nombre = $request->NombreRol;
                $repuesta_create = $this->usuario->editar_rol($nombre, $id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Dato editado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Dato ha editar ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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


    // PROCESO DE USUARIO
    public function usuario_create(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre_usu = $request->nombre_usu;
                $apellido_usu = $request->apellido_usu;
                $correo_usu = $request->correo_usu;
                $rol_usu = $request->rol_usu;
                $password_usu = $request->password_usu;
                $usuario_usu = $request->usuario_usu;
                $file  = $request->file('foto');
                $nombrearchivo = $request->nombrearchivo;

                if (!empty($file)) {
                    $repuesta_create = $this->usuario->usuario_create($nombre_usu, $apellido_usu, $correo_usu, $rol_usu, $password_usu, $usuario_usu, $nombrearchivo);
                    if ($repuesta_create == 1) {
                        $filePath = public_path('img/usuario'); // Ruta a la carpeta public/img/usuario
                        $file->move($filePath, $nombrearchivo);
                    }
                } else {
                    $imagen = "admin.jpg";
                    $repuesta_create = $this->usuario->usuario_create($nombre_usu, $apellido_usu, $correo_usu, $rol_usu, $password_usu, $usuario_usu, $imagen);
                }

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Usuario ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Usuario ' . $usuario_usu . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function usuario_lista(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                $repuesta_lista = $this->usuario->listar_usuario();
                return response()->json(['success' => $repuesta_lista, 'error' => '', 'status' => 200], 200);
            }
        }
    }

    public function usuario_eliminar(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id = $request->id;
                $repuesta_create = $this->usuario->usuario_eliminar($id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'El usuario se elimino con exito', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar el usuario', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function usuario_editar(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre_usu = $request->nombre_usu;
                $apellido_usu = $request->apellido_usu;
                $correo_usu = $request->correo_usu;
                $rol_usu = $request->rol_usu;
                $id = $request->id;
                $usuario_usu = $request->usuario_usu;

                $repuesta_create = $this->usuario->usuario_editar($nombre_usu, $apellido_usu, $correo_usu, $rol_usu, $usuario_usu, $id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Usuario editado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Usuario ' . $usuario_usu . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function info_user(Request $request)
    {
        if ($request->isMethod('get')) {
            if ($request->ajax()) {
                $id = $_SESSION["iduser"];
                $repuesta = $this->usuario->info_user($id);
                return response()->json(['success' => $repuesta, 'error' => '', 'status' => 200], 200);
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function update_perfil(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $nombre_usu = $request->nombre_usu;
                $apellido_usu = $request->apellido_usu;
                $correo_usu = $request->correo_usu;
                $usuario_usu = $request->usuario_usu;
                $id = $_SESSION["iduser"];
                $password_usu = $request->password_usu;

                $repuesta_create = $this->usuario->update_perfil($nombre_usu, $apellido_usu, $correo_usu, $usuario_usu, $id, $password_usu);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Usuario editado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == 2) {
                    return response()->json(['success' => 'Usuario ' . $usuario_usu . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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
