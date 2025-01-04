@include('layout.header')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Perfil Usuario</h3>
                    </div>

                    <div style="padding: 15px;">

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
                                        <input readonly id="rol_usu" type="text" class="form-control" placeholder="rol de usuario" maxlength="60">
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

                                <input type="hidden" id="foto_antigua">

                                <div class="col-lg-10">
                                    <div class="mb-3">
                                        <label class="form-label">Foto usuario</label>
                                        <input id="foto_usu" type="file" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">.</label>
                                        <a onclick="CambiarImagen();" class="btn btn-success ms-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 5l0 14" />
                                                <path d="M5 12l14 0" />
                                            </svg>
                                            Cambiar imagen
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <br>

                            <a href="{{ route('admin') }}" class="btn btn-danger">
                                Cancel
                            </a>

                            <a class="btn btn-primary ms-auto" onclick="UpdateUsuarioPerfil()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Editar usuario
                            </a>

                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    const Routes = {
        Url_UpdatePerfil: "{{ route('usuario.update_perfil') }}",
        Url_UpdatePerfilFoto: "{{ route('usuario.update_perfil_foto') }}"
    };
</script>

<script src="{{ asset('js/usuario.js') }}"></script>

<script>
    function ObtenerUsuarioPefil() {
        $.ajax({
            type: "GET",
            url: "{{ route('usuario.info_user') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {

                    $("#nombre_usu").val(response.success[0]["nombre"]);
                    $("#apellido_usu").val(response.success[0]["apellido"]);
                    $("#correo_usu").val(response.success[0]["correo"]);
                    $("#rol_usu").val(response.success[0]["rol"]);
                    $("#password_usu").val(response.success[0]["password_usu"]);
                    $("#usuario_usu").val(response.success[0]["usuario_usu"]);
                    $("#foto_antigua").val(response.success[0]["foto"]);

                } else if (response.status == 400) {
                    Swal.fire({
                        title: "No se puede procesar!",
                        text: response.error,
                        icon: "error"
                    });
                } else if (response.status == 403) {
                    Swal.fire({
                        title: "No se puede procesar!",
                        text: response.error,
                        icon: "error"
                    });
                }
            }
        });
    }

    ObtenerUsuarioPefil();
</script>
