@include('layout.header')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Usuarios
                </div>
                <h2 class="page-title">
                    Listado
                </h2>
            </div>

            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a class="btn btn-primary d-none d-sm-inline-block" onclick="ModalOpenUsuario()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Crear nuevo usuario
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Usuarios</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px;">Acción</th>
                                    <th style="font-size: 15px;">Nombre</th>
                                    <th style="font-size: 15px;">Apellido</th>
                                    <th style="font-size: 15px;">Correo</th>
                                    <th style="font-size: 15px;">Usuario</th>
                                    <th style="font-size: 15px;">Rol</th>
                                </tr>
                            </thead>
                            <tbody id="HtmlBody">

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_usuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FrmUsuarioCreate">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input id="nombre_usu" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="35">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Apellido</label>
                                <input id="apellido_usu" type="text" class="form-control" placeholder="Ingrese apellido" maxlength="35">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Correo</label>
                                <input id="correo_usu" type="text" class="form-control" placeholder="Ingrese correo" maxlength="40">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select id="rol_usu" class="form-control">
                                    <option value="0">- Seleccione el rol -</option>
                                    @foreach ($rol as $user)
                                    <option value="{{ $user['id'] }}">{{ $user["nombre"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input id="usuario_usu" type="text" class="form-control" placeholder="Ingrese usuario" maxlength="15">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input id="password_usu" type="text" class="form-control" placeholder="Ingrese password" maxlength="7">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Foto usuario</label>
                                <input id="foto_usu" type="file" class="form-control">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </a>
                <a class="btn btn-primary ms-auto" onclick="RegistrarUsuario()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Registrar usuario
                </a>
            </div>

        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_usuario_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FrmUsuarioCreate">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="number" id="id_usuario" hidden>
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input id="nombre_usu_edit" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="35">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Apellido</label>
                                <input id="apellido_usu_edit" type="text" class="form-control" placeholder="Ingrese apellido" maxlength="35">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Correo</label>
                                <input id="correo_usu_edit" type="text" class="form-control" placeholder="Ingrese correo" maxlength="40">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select id="rol_usu_edit" class="form-control">
                                    <option value="0">- Seleccione el rol -</option>
                                    @foreach ($rol as $user)
                                    <option value="{{ $user['id'] }}">{{ $user["nombre"] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Usuario</label>
                                <input id="usuario_usu_edit" type="text" class="form-control" placeholder="Ingrese usuario" maxlength="15">
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </a>
                <a class="btn btn-primary ms-auto" onclick="UpdateUsuario()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Editar usuario
                </a>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    const Routes = {
        Url_CreateUsu: "{{ route('usuario.create') }}",
        Url_ListarUsu: "{{ route('usuario.lista') }}",
        Url_EliminarUsu: "{{ route('usuario.eliminar') }}",
        Url_UpdateUsu: "{{ route('usuario.editar') }}",
    };

    ListarUsuario();

    function ListarUsuario() {
        $.ajax({
            type: "GET",
            url: Routes.Url_ListarUsu,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    $("HtmlBody").html("");
                    let HtmlLista = "";
                    response.success.forEach(e => {
                        HtmlLista = HtmlLista + `<tr>
                                    <td><a class="btn btn-primary" onclick="EditarUsuarioo(${e["id"]}, '${e["nombre"]}', '${e["apellido"]}', '${e["correo"]}', '${e["usuario_usu"]}', ${e["rol_id"]})">
                                            Editar
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarUsuario(${e["id"]})">
                                            Eliminar
                                        </a>
                                    </td>
                                    <td>${e["nombre"]}</td>
                                    <td>${e["apellido"]}</td>
                                    <td>${e["correo"]}</td>
                                    <td>${e["usuario_usu"]}</td>
                                    <td>${e["rol"]}</td>
                                </tr>`
                    });
                    $("#HtmlBody").html(HtmlLista);
                }
            }
        });
    }
</script>

<script src="{{ asset('js/usuario.js') }}"></script>

<script>
    function ModalOpenUsuario() {
        $('#FrmUsuarioCreate')[0].reset();
        $('#modal_usuario').modal('show')
    }
</script>
