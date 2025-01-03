<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }} ">

@include('layout.header')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos del producto</h3>
                    </div>

                    <div style="padding: 15px;">

                        <form id="FrmProductoCreate">

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input id="nombre_producto" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de producto</label>
                                        <input id="tipo_producto" type="text" class="form-control" placeholder="Ingrese tipo" maxlength="40">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Precio venta</label>
                                        <input id="precio_producto" type="number" class="form-control" placeholder="Ingrese precio" max="999" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de promoción</label>
                                        <select id="tipo_descuento" class="form-control">
                                            <option value="no">--- Sin promoción ---</option>
                                            <option value="proc">Porcentaje %</option>
                                            <option value="desc">Descuento</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Descuento</label>
                                        <input id="descuento" disabled value="0" type="number" class="form-control" max="99" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Descripción del producto</label>
                                        <textarea class="form-control" id="descripcion"></textarea>
                                    </div>
                                </div>

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

                            <a class="btn btn-success ms-auto" onclick="RegistraProducto()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Registrar Producto
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
    const RoutesProd = {
        Url_CreateProd: "{{ route('producto.create') }}",
    };

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

    $("#tipo_descuento").change(function() {
        if ($(this).val() == "no") {
            $("#descuento").attr("disabled", "disabled");
            $("#descuento").val("0");
        } else {
            $("#descuento").removeAttr("disabled", "disabled");
            $("#descuento").val("0");
        }
    });
</script>

<script src="{{ asset('js/producto.js') }}"></script>
