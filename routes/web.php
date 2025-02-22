<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerCarrito;
use App\Http\Controllers\ControllerAdmin;
use App\Http\Controllers\ControllerCliente;
use App\Http\Controllers\ControllerProducto;
use App\Http\Controllers\ControllerServicios;
use App\Http\Controllers\ControllerCompras;
use App\Http\Controllers\ControllerVentas;

Route::get('/', function () { return redirect('/Tienda'); });
Route::get('/direccion', function () { return redirect('/Tienda'); })->name("/");
Route::get('/Tienda', [ControllerCarrito::class, 'tienda'])->name("tienda");
Route::get('/login', [ControllerAdmin::class, 'index'])->name("login");
Route::get('/admin', [ControllerAdmin::class, 'admin'])->name("admin");

// Agrupación de rutas para el controlador ControllerAdmin
Route::controller(ControllerAdmin::class)->group(function () {
    /// ROLES
    Route::get('/rol', 'rol')->name("usuario.rol");
    Route::post('/rol_register', 'register_rol')->name("rol.create");
    Route::post('/rol_edit', 'editar_rol')->name("rol.editar");
    Route::get('/rol_list', 'rol_lista')->name("rol.lista");
    Route::post('/rol_delete', 'eliminar_rol')->name("rol.eliminar");

    /// USUARIO
    Route::post('/validar_usuario', 'validar_usuario')->name("usuario.login");
    Route::post('/token_usuario', 'token_usuario')->name("usuario.token");
    Route::get('/usuario_salir', 'usuario_salir')->name("usuario.salir");
    Route::get('/usuario', 'usuario')->name("usuario.usuario");
    Route::post('/usuario_create', 'usuario_create')->name("usuario.create");
    Route::get('/usuario_lista', 'usuario_lista')->name("usuario.lista");
    Route::post('/usuario_eliminar', 'usuario_eliminar')->name("usuario.eliminar");
    Route::post('/usuario_editar', 'usuario_editar')->name("usuario.editar");
    Route::get('/info_user', 'info_user')->name("usuario.info_user");
    Route::get('/usuario_perfil', 'usuario_perfil')->name("usuario.perfil");
    Route::post('/update_perfil', 'update_perfil')->name("usuario.update_perfil");
    Route::get('/datos_empresa', 'datos_empresa')->name("usuario.empresa");
    Route::post('/update_empresa', 'update_empresa')->name("usuario.update_empresa");
    Route::post('/update_perfil_foto', 'update_perfil_foto')->name("usuario.update_perfil_foto");
});

// Agrupación de rutas para el controlador ControllerCliente
Route::controller(ControllerCliente::class)->group(function () {
    /// CLIENTES
    Route::get('/nuevo_cliente', 'nuevo_cliente')->name("cliente.form_cliente");
    Route::get('/editar_cliente/{id}', 'editar_cliente')->name("cliente.editar");
    Route::post('/cliente_create', 'cliente_create')->name("cliente.create");
    Route::get('/lista_cliente', 'lista_cliente')->name("cliente.formLista_cliente");
    Route::post('/cliente_delete', 'eliminar_cliente')->name("cliente.eliminar");
    Route::post('/cliente_update', 'cliente_update')->name("cliente.update");
});

// Agrupación de rutas para el controlador ControllerProductos
Route::controller(ControllerProducto::class)->group(function () {
    /// PRODUCTOS
    Route::get('/nuevo_producto', 'nuevo_producto')->name("producto.form_producto");
    Route::post('/create_producto', 'create_producto')->name("producto.create");
    Route::get('/listado_producto', 'listado_producto')->name("producto.formList_producto");
    Route::get('/imagen_producto/{id}', 'imagen_producto')->name("producto.imagen_producto");
    Route::post('/eliminar_imagen', 'eliminar_imagen')->name("producto.eliminar_imagen");
    Route::post('/cargar_imagen', 'cargar_imagen')->name("producto.cargar_imagen");
    Route::get('/editar_producto/{id}', 'editar_producto')->name("producto.frm_editar_producto");
    Route::post('/update_producto', 'update_producto')->name("producto.update_producto");
    Route::post('/eliminar_producto', 'eliminar_producto')->name("producto.eliminar");
});

// Agrupación de rutas para el controlador ControllerServicios
Route::controller(ControllerServicios::class)->group(function () {
    /// SERVICIO
    Route::get('/nuevo_servicio', 'nuevo_servicio')->name("servicio.form_servicio");
    Route::post('/crear_servicio', 'crear_servicio')->name("servicio.create");
    Route::get('/lista_servicios', 'lista_servicios')->name("servicio.frm_lista_servicios");
    Route::post('/eliminar_servicio', 'eliminar_servicio')->name("servicio.eliminar");
    Route::get('/editar_servicio/{id}', 'editar_servicio')->name("servicio.frm_editar_servicio");
    Route::post('/update_servicio', 'update_servicio')->name("servicio.update_servicio");
});

// Agrupación de rutas para el controlador ControllerCompras
Route::controller(ControllerCompras::class)->group(function () {
    /// COMPRAS
    Route::get('/nueva_compra', 'nueva_compra')->name("compra.form_nueva_compra");
    Route::post('/crear_compra', 'crear_compra')->name("compra.crear_compra");
    Route::get('/lista_compras', 'lista_compras')->name("compra.form_lista_compra");
    Route::get('/detalle_compra/{id}', 'detalle_compra')->name("compra.detalle_compra");
});

// Agrupación de rutas para el controlador ControllerTienda
Route::controller(ControllerCarrito::class)->group(function () {
    /// TIENDA
    Route::post('/listar_producto', 'listar_producto')->name("carrito.listar_producto");
    Route::post('/listar_servicios', 'listar_servicios')->name("carrito.listar_servicios");
    Route::get('/detalle_producto/{id}', 'detalle_producto')->name("carrito.detalle_producto");
    Route::get('/servicios', 'servicios')->name("carrito.servicios");
});

// Agrupación de rutas para el controlador ControllerVentas
Route::controller(ControllerVentas::class)->group(function () {
    /// VENTA
    Route::get('/nueva_venta', 'nueva_venta')->name("venta.nueva_venta");
});

