@include('layout.header')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Clientes
                </div>
                <h2 class="page-title">
                    Listado
                </h2>
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
                        <h3 class="card-title">Clientes</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px;">Acción</th>
                                    <th style="font-size: 15px;">Nombre</th>
                                    <th style="font-size: 15px;">Apellido</th>
                                    <th style="font-size: 15px;">Correo</th>
                                    <th style="font-size: 15px;">Teléfono</th>
                                    <th style="font-size: 15px;">Sexo</th>
                                    <th style="font-size: 15px;">Cédula</th>
                                </tr>
                            </thead>
                            <tbody id="HtmlBody">
                                @foreach ($lista as $cliente)
                                <tr>
                                    <th style="font-size: 10px;">
                                        <a class="btn btn-primary" href="{{ route('cliente.editar', $cliente['id']) }}" >
                                            Editar
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarCliente({{ $cliente['id'] }});">
                                            Eliminar
                                        </a>
                                    </th>
                                    <th style="font-size: 15px;">{{ $cliente["nombre"] }}</th>
                                    <th style="font-size: 15px;">{{ $cliente["apellido"] }}</th>
                                    <th style="font-size: 15px;">{{ $cliente["correo"] }}</th>
                                    <th style="font-size: 15px;">{{ $cliente["telefono"] }}</th>
                                    @if ($cliente["sexo"] == 'M')
                                    <th style="font-size: 15px;">MASCULINO</th>
                                    @else
                                    <th style="font-size: 15px;">FEMENINO</th>
                                    @endif
                                    <th style="font-size: 15px;">{{ $cliente["cedula"] }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

@include('layout.footer')

<script>
    const Routes = {
        Url_EliminarCliente: "{{ route('cliente.eliminar') }}",
    };

    function EliminarCliente(id) {
        Swal.fire({
            title: "Eliminar Cliente?",
            text: "Desea eliminar el Cliente!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: Routes.Url_EliminarCliente,
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                title: "Cliente eliminado con exito!",
                                text: response.success,
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Ok!"
                            }).then((result) => {
                                window.location.reload();
                            });
                        } else if (response.status == 400) {
                            Swal.fire({
                                title: "No se puede eliminar el Cliente!",
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
        });


    }
</script>
