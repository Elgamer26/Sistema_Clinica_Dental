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

                            <input hidden id="id_prod" value="{{ $lista['id'] }}">

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input id="nombre_producto" value="{{ $lista['nombre'] }}" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de producto</label>
                                        <input id="tipo_producto" value="{{ $lista['tipo'] }}" type="text" class="form-control" placeholder="Ingrese tipo" maxlength="40">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Precio venta</label>
                                        <input id="precio_producto" value="{{ $lista['precio'] }}" type="number" class="form-control" placeholder="Ingrese precio" max="999" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de promoción</label>
                                        <select id="tipo_descuento" class="form-control">
                                            <option value="no" {{ $lista['tipo_descuento'] == 'no' ? 'selected' : '' }} >--- Sin promoción ---</option>
                                            <option value="proc" {{ $lista['tipo_descuento'] == 'proc' ? 'selected' : '' }} >Porcentaje %</option>
                                            <option value="desc" {{ $lista['tipo_descuento'] == 'desc' ? 'selected' : '' }} >Descuento</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Descuento</label>
                                        <input id="descuento" {{ $lista['tipo_descuento'] == 'no' ? 'disabled' : '' }} value="{{ $lista['descuento'] }}" type="number" class="form-control" max="99" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Descripción del producto</label>
                                        <textarea class="form-control" id="descripcion">{{ $lista['descripcion'] }} </textarea>
                                    </div>
                                </div>

                            </div>

                            <a class="btn btn-success ms-auto" onclick="EditarProducto()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Actualizar Producto
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
        Url_CreateUpdate: "{{ route('producto.update_producto') }}",
        Url_CreateLista: "{{ route('producto.formList_producto') }}",
    };

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
