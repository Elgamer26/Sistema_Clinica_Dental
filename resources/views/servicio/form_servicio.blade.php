@include('layout.header')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos del servicio</h3>
                    </div>

                    <div style="padding: 15px;">
                        <form id="FrmProductoCreate">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input id="nombre_producto" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Precio del servicio</label>
                                        <input id="precio_producto" type="number" class="form-control" placeholder="Ingrese precio" max="999" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de promoción</label>
                                        <select id="tipo_descuento" class="form-control">
                                            <option value="no">--- Sin promoción ---</option>
                                            <option value="proc">Procentaje %</option>
                                            <option value="desc">Descuento</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Descuento</label>
                                        <input id="descuento" disabled value="0" type="number" class="form-control" max="99" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Descripción del servicio</label>
                                        <textarea class="form-control" id="descripcion"></textarea>
                                    </div>
                                </div>

                            </div>

                            <a class="btn btn-success ms-auto" onclick="RegistraServicio()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Registrar Servicio
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
    const RoutesSer = {
        Url_CreateSer: "{{ route('servicio.create') }}",
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

<script src="{{ asset('js/servicio.js') }}"></script>
