@include('layout.header')



<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos de empresa</h3>
                    </div>

                    <div style="padding: 15px;">

                        <form id="FrmUsuarioCreate">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Razon social</label>
                                        <input id="nombre_usu" type="text" value="{{ $data['nombre'] }}" class="form-control" placeholder="Razon social" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input id="apellido_usu" type="text" value="{{ $data['direccion'] }}" class="form-control" placeholder="Dirección" maxlength="100">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Correo</label>
                                        <input id="correo_usu" type="text" value="{{ $data['correo'] }}" class="form-control" placeholder="Correo" maxlength="60">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Telefono</label>
                                        <input onkeypress='return soloNumeros(event);' id="rol_usu" type="text" value="{{ $data['telefono'] }}" class="form-control" placeholder="Telefono" maxlength="13">
                                    </div>
                                </div>

                            </div>

                            <br>

                            <a href="{{ route('admin') }}" class="btn btn-danger">
                                Cancel
                            </a>
                            <a class="btn btn-primary ms-auto" onclick="ActualizarEmpresa()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Editar datos
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
        Url_UpdateEmpresa: "{{ route('usuario.update_empresa') }}"
    };
</script>

<script src="{{ asset('js/usuario.js') }}"></script>
