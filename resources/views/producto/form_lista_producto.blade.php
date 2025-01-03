<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }} ">

@include('layout.header')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Productos
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
                        <h3 class="card-title">Productos</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th style="font-size: 15px;">Acción</th>
                                    <th style="font-size: 15px;">Nombre</th>
                                    <th style="font-size: 15px;">Tipo</th>
                                    <th style="font-size: 15px;">Precio venta</th>
                                    <th style="font-size: 15px;">Tipo Descuento</th>
                                    <th style="font-size: 15px;">Descuento</th>
                                    <th style="font-size: 15px;">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lista as $producto)
                                <tr>
                                    <th>
                                        <a class="btn btn-primary" href="{{ route('producto.frm_editar_producto', $producto['id']) }}">
                                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarProducto({{ $producto['id'] }})">
                                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </a>
                                        @if ($producto["valor"] > 0)
                                        -
                                        <a class="btn btn-warning" href="{{ route('producto.imagen_producto', $producto['id']) }}">
                                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-photo">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 8h.01" />
                                                <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                                                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                                <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                                            </svg>
                                        </a>
                                        @else
                                        -
                                        <a class="btn btn-success" onclick="ModalOpen({{ $producto['id'] }})">
                                            +<svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-photo">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M15 8h.01" />
                                                <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                                                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                                <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                                            </svg>
                                        </a>
                                        @endif
                                    </th>
                                    <th style="font-size: 15px;">{{ $producto["nombre"] }}</th>
                                    <th style="font-size: 15px;">{{ $producto["tipo"] }}</th>
                                    <th style="font-size: 15px;">$ {{ $producto["precio"] }}</th>

                                    @if ($producto["tipo_descuento"] == 'no')
                                    <th style="font-size: 15px;">Sin descuento</th>
                                    @elseif ($producto["tipo_descuento"] == 'proc')
                                    <th style="font-size: 15px;">Porcentaje %</th>
                                    @else
                                    <th style="font-size: 15px;">Descuento</th>
                                    @endif

                                    @if ($producto["tipo_descuento"] == 'no')
                                    <th style="font-size: 15px;">{{ $producto["descuento"] }}</th>
                                    @elseif ($producto["tipo_descuento"] == 'proc')
                                    <th style="font-size: 15px;">{{ $producto["descuento"] }} %</th>
                                    @else
                                    <th style="font-size: 15px;">$ {{ $producto["descuento"] }}</th>
                                    @endif

                                    <th style="font-size: 15px;">{{ $producto["stock"] }}</th>
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

<div class="modal modal-blur fade" id="modal_imagen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Imagen de Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <input type="hidden" id="id_producto">

                    <div class="col-md-12">
                        <div id="wrapper">
                            <h3 style="padding: 20px 0; text-align: center;">Cargar Imágenes <b><label style="color: red;" id="foto_ogligg"></label></b></h3>
                            <div id="container-input">
                                <div class="wrap-file">
                                    <div class="content-icon-camera">
                                        <input type="file" id="file" name="file[]" accept="image/*" multiple />
                                        <div class="icon-camera"></div>
                                    </div>
                                    <div id="preview-images">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div><br>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cancel
                </a>
                <a class="btn btn-primary ms-auto" onclick="IngresarImagenList()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Ingresar imagen
                </a>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/producto.js') }}"></script>

<script>
    function ModalOpen(id) {
        $("#id_producto").val(id);
        $('#modal_imagen').modal('show')
    }

    function IngresarImagenList() {
        let id = $("#id_producto").val();
        IngresarImagen(id);
    }

    (function() {
        var file = document.getElementById("file");
        var preload = document.querySelector(".preload");
        var publish = document.getElementById("publish");
        var formData = new FormData();

        file.addEventListener("change", function(e) {
            for (var i = 0; i < file.files.length; i++) {
                var thumbnail_id = Math.floor(Math.random() * 30000) + "_" + Date.now();
                createThumbnail(file, i, thumbnail_id);
                formData.append(thumbnail_id, file.files[i]);
            }
        });

        var createThumbnail = function(file, iterator, thumbnail_id) {
            var thumbnail = document.createElement("div");
            thumbnail.classList.add("thumbnail", thumbnail_id);
            thumbnail.dataset.id = thumbnail_id;

            thumbnail.setAttribute(
                "style",
                `background-image: url(${URL.createObjectURL(file.files[iterator])})`
            );

            var nombre = file.files[iterator].name;
            var ext = nombre.substring(nombre.lastIndexOf("."));
            if (ext != ".png" && ext != ".jpg" && ext != ".jpeg") {
                var valida = false;
            } else {
                var valida = true;
            }

            if (!valida) {
                //en caso de que no sean validos las extensiones manda alert y limpio el file
                return alert(
                    "este archivo: " +
                    nombre +
                    " no es valido o no se ha seleccionado archvio"
                );
            }

            document.getElementById("preview-images").appendChild(thumbnail);
            createCloseButton(thumbnail_id);
        };

        var createCloseButton = function(thumbnail_id) {
            var closeButton = document.createElement("div");
            closeButton.classList.add("close-button");
            closeButton.innerText = "x";
            document.getElementsByClassName(thumbnail_id)[0].appendChild(closeButton);
        };

        document.body.addEventListener("click", function(e) {
            if (e.target.classList.contains("close-button")) {
                e.target.parentNode.remove();
                formData.delete(e.target.parentNode.dataset.id);
            }
        });
    })();

    const Routes = {
        Url_EliminarProducto: "{{ route('producto.eliminar') }}",
        Url_CargarImagenPlus: "{{ route('producto.cargar_imagen') }}",
    };

    function EliminarProducto(id) {
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
                    url: Routes.Url_EliminarProducto,
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                title: "Producto eliminado con exito!",
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
                                title: "No se puede eliminar el Producto!",
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
