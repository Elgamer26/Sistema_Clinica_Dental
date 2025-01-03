@include('layout.header')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Roles
                </div>
                <h2 class="page-title">
                    Listado
                </h2>
            </div>

            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a class="btn btn-primary d-none d-sm-inline-block" onclick="ModalOpen()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Crear nuevo rol
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
                        <h3 class="card-title">Roles</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px;">Acción</th>
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

<div class="modal modal-blur fade" id="modal_rol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Nombre Rol</label>
                            <input id="NombreRol" type="text" class="form-control" placeholder="Ingrese el rol" maxlength="35">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </a>
                <a class="btn btn-primary ms-auto" onclick="RegistrarRol()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Registrar rol
                </a>
            </div>

        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal_rol_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Nombre Rol</label>
                            <input type="number" hidden id="idRol">
                            <input id="NombreRolEdit" type="text" class="form-control" placeholder="Ingrese el rol" maxlength="35">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </a>
                <a class="btn btn-primary ms-auto" onclick="UpdateRol()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Editar rol
                </a>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    const Routes = {
        Url_CreateRol: "{{ route('rol.create') }}",
        Url_ListarRol: "{{ route('rol.lista') }}",
        Url_EliminarRol: "{{ route('rol.eliminar') }}",
        Url_UpdateRol: "{{ route('rol.editar') }}",
    };

    ListarRoles();

    function ListarRoles() {
        $.ajax({
            type: "GET",
            url: Routes.Url_ListarRol,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    $("HtmlBody").html("");
                    let HtmlLista = "";
                    response.success.forEach(e => {
                        HtmlLista = HtmlLista + `<tr>
                                    <td><a class="btn btn-primary" onclick="EditarRol(${e["id"]}, '${e["nombre"]}')">
                                            Editar
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarRol(${e["id"]})">
                                            Eliminar
                                        </a>
                                    </td>
                                    <td>${e["nombre"]}</td>
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
    function ModalOpen() {
        $('#modal_rol').modal('show')
    }
</script>
