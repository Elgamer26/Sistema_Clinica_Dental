<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// LLAMO EL MODELO USUARIO
use App\Models\ModeloProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\Echo_;

class ControllerProducto extends BaseController
{

    protected $producto;
    public function __construct()
    {
        $this->producto = new ModeloProducto();
        session_start();
    }

    // VISTAS **************************************
    public function nuevo_producto()
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            return view('producto/form_producto');
        }
    }

    public function listado_producto(Request $request)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            if ($request->isMethod('get')) {
                $repuesta_lista = $this->producto->listado_producto(0);
                $data = [
                    'lista' =>  $repuesta_lista
                ];
                return view('producto/form_lista_producto', $data);
            }
        }
    }

    public function create_producto(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $nombre  = $request->nombre_producto;
                $tipo  = $request->tipo_producto;
                $precio  = $request->precio_producto;
                $tipo_descuento = $request->tipo_descuento;
                $descuento = $request->descuento;
                $descripcion = $request->descripcion;
                if (!$request->hasFile('img_extra')) {
                    $repuesta_create = $this->producto->create_producto($nombre, $tipo, $precio, $tipo_descuento, $descuento, $descripcion);
                } else {
                    $repuesta_create = $this->producto->create_producto($nombre, $tipo, $precio, $tipo_descuento, $descuento, $descripcion);
                    if ($repuesta_create > 0) {
                        foreach ($request->file('img_extra') as $archivo) {
                            // Generar un nombre único
                            $nombreFinal = sha1($archivo->getClientOriginalName() . time()) . '.' . $archivo->getClientOriginalExtension();
                            // Guardar en la base de datos (opcional)
                            $valor = $this->producto->RegistrarImagen($repuesta_create, $nombreFinal);
                            // Guardar el archivo en el sistema de almacenamiento (carpeta 'public/img/producto')
                            if ($valor == 1) {
                                $filePath = public_path('img/producto'); // Ruta a la carpeta public/img/producto
                                $archivo->move($filePath, $nombreFinal);
                            }
                        }
                    }
                }
                if ($repuesta_create > 0) {
                    return response()->json(['success' => 'Producto ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == -1) {
                    return response()->json(['success' => 'Producto ' . $nombre . ' - ' . $tipo . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function imagen_producto($id)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->producto->imagen_producto($id);
            if (!empty($repuesta_lista)) {
                $data = [
                    'lista' =>  $repuesta_lista,
                    'id' =>  $id
                ];
                return view('producto/form_imagen_producto', $data);
            } else {
                return redirect()->route('producto.formList_producto');
            }
        }
    }

    public function eliminar_imagen(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id  = $request->id;
                $img  = $request->img;
                $repuesta_create = 0;

                if ($img != "producto.jpg") {
                    $repuesta_create = $this->producto->eliminar_imagen($id);
                    if ($repuesta_create  == 1) {
                        $filePath = public_path('img/producto'); // Ruta a la carpeta public/img/producto
                        $fullPath = $filePath . '/' . $img;
                        if (file_exists($fullPath)) {
                            unlink($fullPath);
                        }
                    }
                }

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'Producto ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar la imagen', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function cargar_imagen(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {
                $valor = 0;
                $id  = $request->id;
                if ($request->hasFile('img_extra')) {
                    foreach ($request->file('img_extra') as $archivo) {
                        // Generar un nombre único
                        $nombreFinal = sha1($archivo->getClientOriginalName() . time()) . '.' . $archivo->getClientOriginalExtension();
                        // Guardar en la base de datos (opcional)
                        $valor = $this->producto->RegistrarImagen($id, $nombreFinal);
                        // Guardar el archivo en el sistema de almacenamiento (carpeta 'public/img/producto')
                        if ($valor == 1) {
                            $filePath = public_path('img/producto'); // Ruta a la carpeta public/img/producto
                            $archivo->move($filePath, $nombreFinal);
                        }
                    }
                }
            }
            if ($valor == 1) {
                return response()->json(['success' => 'Imagen ingresado de forma correcta', 'error' => '', 'status' => 200], 200);
            } else {
                return response()->json(['success' => '', 'error' => 'No se ha podido cargar la imagen', 'status' => 401], 401);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }

    public function editar_producto($id)
    {
        if (!isset($_SESSION["iduser"])) {
            return redirect()->route('/');  // login
        } else {
            $repuesta_lista = $this->producto->listado_producto($id);
            if (!empty($repuesta_lista)) {
                $data = [
                    'lista' =>  $repuesta_lista,
                ];
                return view('producto/frm_editar_producto', $data);
            } else {
                return redirect()->route('producto.formList_producto');
            }
        }
    }

    public function update_producto(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id  = $request->id;
                $nombre  = $request->nombre_producto;
                $tipo  = $request->tipo_producto;
                $precio  = $request->precio_producto;
                $tipo_descuento = $request->tipo_descuento;
                $descuento = $request->descuento;
                $descripcion = $request->descripcion;

                $repuesta_create = $this->producto->update_producto($nombre, $tipo, $precio, $tipo_descuento, $descuento, $descripcion, $id);

                if ($repuesta_create > 0) {
                    return response()->json(['success' => 'Producto actualizado de forma correcta', 'error' => '', 'status' => 200], 200);
                } else if ($repuesta_create == -1) {
                    return response()->json(['success' => 'Producto ' . $nombre . ' - ' . $tipo . ' ya se encuentra registrado', 'error' => '', 'status' => 201], 201);
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

    public function eliminar_producto(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->ajax()) {

                $id = $request->id;
                $repuesta_create = $this->producto->eliminar_producto($id);

                if ($repuesta_create == 1) {
                    return response()->json(['success' => 'El producto se elimino con exito', 'error' => '', 'status' => 200], 200);
                } else {
                    return response()->json(['success' => '', 'error' => 'No se puede eliminar el producto', 'status' => 400], 400);
                }
            } else {
                return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
            }
        } else {
            return response()->json(['success' => '', 'error' => 'Bad Request', 'status' => 403], 403);
        }
    }
}
