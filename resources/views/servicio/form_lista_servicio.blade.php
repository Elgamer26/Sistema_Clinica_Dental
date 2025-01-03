@include('layout.header')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Servicios
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
                        <h3 class="card-title">Servicios</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px;">Acción</th>
                                    <th style="font-size: 15px;">Nombre</th>
                                    <th style="font-size: 15px;">Precio venta</th>
                                    <th style="font-size: 15px;">Tipo Descuento</th>
                                    <th style="font-size: 15px;">Descuento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lista as $servicio)
                                <tr>
                                    <th>
                                        <a class="btn btn-primary" href="{{ route('servicio.frm_editar_servicio', $servicio['id']) }}">
                                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarProducto({{ $servicio['id'] }})">
                                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </a>
                                    </th>
                                    
                                    <th style="font-size: 15px;">{{ $servicio["nombre"] }}</th>
                                    <th style="font-size: 15px;">$ {{ $servicio["precio"] }}</th>

                                    @if ($servicio["tipo_descuento"] == 'no')
                                    <th style="font-size: 15px;">Sin descuento</th>
                                    @elseif ($servicio["tipo_descuento"] == 'proc')
                                    <th style="font-size: 15px;">Procentaje %</th>
                                    @else
                                    <th style="font-size: 15px;">Descuento</th>
                                    @endif

                                    @if ($servicio["tipo_descuento"] == 'no')
                                    <th style="font-size: 15px;">{{ $servicio["descuento"] }}</th>
                                    @elseif ($servicio["tipo_descuento"] == 'proc')
                                    <th style="font-size: 15px;">{{ $servicio["descuento"] }} %</th>
                                    @else
                                    <th style="font-size: 15px;">$ {{ $servicio["descuento"] }}</th>
                                    @endif

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

<script src="{{ asset('js/servicio.js') }}"></script>

<script>
    const Routes = {
        Url_EliminarServicio: "{{ route('servicio.eliminar') }}",
    };

    function EliminarProducto(id) {
        Swal.fire({
            title: "Eliminar Servicio?",
            text: "Desea eliminar el Servicio!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: Routes.Url_EliminarServicio,
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                title: "Servicio eliminado con exito!",
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
                                title: "No se puede eliminar el Servicio!",
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
