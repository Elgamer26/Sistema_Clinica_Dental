@include('layout.header')

<style>
    /* Personalizar el cuadro de búsqueda */
    .select2-container .select2-search--dropdown .select2-search__field {
        color: #000;
        /* Color del texto del filtro */
        background-color: #f0f0f0;
        /* Fondo del filtro */
    }

    /* Personalizar el listado de opciones */
    .select2-container .select2-results__option {
        color: #000;
        /* Color del texto de las opciones */
        background-color: #fff;
        /* Fondo de las opciones */
    }

    /* Estilo para la opción seleccionada al pasar el ratón */
    .select2-container .select2-results__option--highlighted {
        background-color: #d9edf7;
        /* Fondo resaltado */
        color: #000;
        /* Texto resaltado */
    }
</style>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Datos de la venta</h3>
    </div>

    <div style="padding: 15px;">
        <form id="FrmProductoCreate">
            <div class="row">

                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <select id="cliente_select" class="form-control">
                            <option value="">--- Seleccione el cliente ---</option>
                            @foreach ($cliente as $cli)
                            <option value="{{ $cli["id"] }}">Cliente: {{ $cli["nombre"] }} {{ $cli["apellido"] }} - Cédula: {{ $cli["cedula"] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input id="fecha_compra" type="date" value="{{ $fecha }}" class="form-control">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="form-label">Tipo de comprobante</label>
                        <select id="tipo_comprabante" class="form-control">
                            <option value="">--- Seleccione comprobante ---</option>
                            <option value="fac">Factura</option>
                            <option value="nota">Nota de venta</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-1">
                    <div class="mb-3">
                        <label class="form-label">Iva</label>
                        <input readonly id="iva" value="0" type="text" class="form-control" placeholder="Ingrese Iva" maxlength="5">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="form-label">N. de comprobante</label>
                        <input id="numero_factura" type="number" class="form-control" placeholder="N. de comprobante" min="0">
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="mb-3">
                        <label class="form-label">Buscar producto</label>
                        <button id="btn_buscar" class="btn btn-warning ms-auto">+ Buscar producto</button>
                    </div>
                </div>

                <div class="col-md-9">

                    <div class="card">
                        <div class="table-responsive">
                            <table id="detalle_compra" class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th style="font-size: 15px;">Nombre</th>
                                        <th style="font-size: 15px;">Tipo</th>
                                        <th style="font-size: 15px;">Precio</th>
                                        <th style="font-size: 15px;">Cantidad</th>
                                        <th style="font-size: 15px;">Descuento $</th>
                                        <th style="font-size: 15px;">Tipo descuento</th>
                                        <th style="font-size: 15px;">Valor descuento</th>
                                        <th style="font-size: 15px;">Total</th>
                                        <th style="font-size: 15px;">Quitar</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody_detalle_compra">

                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card">
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th style="font-size: 15px;">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th>
                                            SubTotal: <span id="subtotal">0.00</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>
                                            Iva%: <span id="impuesto_sub">0.00</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>
                                            Total: <span id="total_pagar">0.00</span>
                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <br>

            <a class="btn btn-success ms-auto" onclick="RegistraVenta()">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Registrar Compra
            </a>

        </form>

    </div>

</div>

@include('layout.footer')

<div class="modal modal-blur fade" id="modal_producto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 15px;">Acción</th>
                                            <th hidden>.</th>
                                            <th style="font-size: 15px;">Nombre</th>
                                            <th style="font-size: 15px;">Tipo</th>
                                            <th style="font-size: 15px;">Stock</th>
                                            <th style="font-size: 15px;">Precio</th>
                                            <th style="font-size: 15px;">Tipo descuento</th>
                                            <th style="font-size: 15px;">Descuento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lista as $producto)
                                        <tr>
                                            <td>
                                                <a class="Enviar btn btn-success">
                                                    <svg style='margin: 0;' xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 14l11 -11" />
                                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td hidden>{{ $producto["id"] }}</td>
                                            <td style="font-size: 15px;">{{ $producto["nombre"] }}</td>
                                            <td style="font-size: 15px;">{{ $producto["tipo"] }}</td>
                                            <td style="font-size: 15px;">{{ $producto["stock"] }}</td>

                                            <td style="font-size: 15px;">$ {{ $producto["precio"] }}</td>

                                            @if ($producto["tipo_descuento"] == 'no')
                                            <td style="font-size: 15px;">Sin descuento</td>
                                            @elseif ($producto["tipo_descuento"] == 'proc')
                                            <td style="font-size: 15px;">Porcentaje %</td>
                                            @else
                                            <td style="font-size: 15px;">Descuento</td>
                                            @endif

                                            @if ($producto["tipo_descuento"] == 'no')
                                            <td style="font-size: 15px;">{{ $producto["descuento"] }}</td>
                                            @elseif ($producto["tipo_descuento"] == 'proc')
                                            <td style="font-size: 15px;">{{ $producto["descuento"] }} %</td>
                                            @else
                                            <td style="font-size: 15px;">$ {{ $producto["descuento"] }}</td>
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

            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">
                    Cerrar
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    $('#cliente_select').select2();

    const RoutesVenta= {
        Url_CreateCompra: "{{ route('venta.crear_venta') }}",
    };

    $("#btn_buscar").click(function(e) {
        e.preventDefault();
        ModalOpen();
    });

    function ModalOpen() {
        $('#modal_producto').modal('show');
    }

    $("#tipo_comprabante").change(function() {
        if ($(this).val() == "fac") {
            $("#iva").removeAttr("readonly", "readonly");
            $("#iva").val("12");
        } else {
            $("#iva").attr("readonly", "readonly");
            $("#iva").val("0");
        }
        sumartotalneto();
    });

    $(".Enviar").on("click", function() {
        var iva = $("#iva").val();
        var id = $(this).parents("tr").find("td")[1].innerHTML;
        var nombre = $(this).parents("tr").find("td")[2].innerHTML;
        var tipo = $(this).parents("tr").find("td")[3].innerHTML;

        var stock = $(this).parents("tr").find("td")[4].innerHTML;
        var precio = $(this).parents("tr").find("td")[5].innerHTML.replace("$ ", "");
        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var descuento = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");
        var valor_descuento = $(this).parents("tr").find("td")[7].innerHTML;

        if (iva.trim() == "" || iva.length == 0) {
            return Swal.fire(
                "Campo vacío",
                "Ingrese un valor en el campos iva",
                "warning"
            );
        }

        if (validar_producto_id(id)) {
            return Swal.fire(
                "Mensaje de advertencia",
                "El producto: '" + nombre + "' - '" + tipo + "' , ya fue agregado al detalle",
                "warning"
            );
        }

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = parseFloat(precio).toFixed(2);
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - descuento).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * descuento / 100).toFixed(2);
        }

        var datos_agg = "<tr>";
        datos_agg += "<td hidden for='id'>" + id + "</td>";
        datos_agg += "<td>" + nombre + "</td>";
        datos_agg += "<td>" + tipo + "</td>";
        datos_agg += "<td><input id='precio_a' style='width: 100px;' type='text' class='form-control' value='" + precio + "' placeholder='precio' onkeypress='return filterfloat(event, this);' /></td>";
        datos_agg += "<td><input id='cantida_a' style='width: 100px;' type='number' min='1' onkeypress='return soloNumeros(event);' class='form-control' value='1' placeholder='cantidad' /></td>";
        datos_agg += "<td><input id='descuento_a' style='width: 100px;' type='text' class='form-control' value='0' placeholder='descuento' onkeypress='return soloNumeros(event);' /></td>";
        datos_agg += "<td>" + tipo_descuento + "</td>";
        datos_agg += "<td>" + valor_descuento + "</td>";
        datos_agg += "<td>" + descoferta + "</td>";
        datos_agg += "<td> <button class='remover btn btn-danger'> <svg style='margin: 0;' xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-trash'> <path stroke='none' d='M0 0h24v24H0z' fill='none' /><path d='M4 7l16 0' /> <path d='M10 11l0 6' /> <path d='M14 11l0 6' /> <path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' /> <path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' /> </svg> </button></td>";
        datos_agg += "</tr>";

        //esto me ayuda a enviar los datos a la tabla
        $("#tbody_detalle_compra").append(datos_agg);
        $("#modal_producto").modal("hide");
        sumartotalneto();
    });

    function validar_producto_id(id) {
        let idverificar = document.querySelectorAll(
            "#tbody_detalle_compra td[for='id']"
        );
        return [].filter.call(idverificar, (td) => td.textContent == id).length == 1;
    }

    $("#tbody_detalle_compra").on("click", ".remover", function() {
        var td = this.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
        sumartotalneto();
    });

    // para la cantidad del producto
    $("#tbody_detalle_compra").on("keyup", "#cantida_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    $("#tbody_detalle_compra").on("change", "#cantida_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    //para el precio del producto
    $("#tbody_detalle_compra").on("keyup", "#precio_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    $("#tbody_detalle_compra").on("change", "#precio_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    //para el descuento del producto
    $("#tbody_detalle_compra").on("keyup", "#descuento_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    $("#tbody_detalle_compra").on("change", "#descuento_a", function() {

        var cantidad = $(this).parents("tr").find('input[type="number"]').val();
        var precio = $(this).parents("tr").find('#precio_a').val();
        var descuento = $(this).parents("tr").find('#descuento_a').val();

        var tipo_descuento = $(this).parents("tr").find("td")[6].innerHTML;
        var valor_oferta = $(this).parents("tr").find("td")[7].innerHTML.replace("$ ", "").replace(" %", "");

        let descoferta = 0;
        if (tipo_descuento.trim() == "Sin descuento") {
            descoferta = precio;
        } else if (tipo_descuento.trim() == "Descuento") {
            descoferta = parseFloat(precio - valor_oferta).toFixed(2);
        } else if (tipo_descuento.trim() == "Porcentaje %") {
            descoferta = parseFloat(precio * valor_oferta / 100).toFixed(2);
        }

        var total = ((parseFloat(descoferta).toFixed(2) * parseInt(cantidad)) - descuento);
        console.log(descoferta);
        console.log(total);

        $(this).parents("tr").find("td")[8].innerHTML = parseFloat(total).toFixed(2);
        sumartotalneto();

    });

    function sumartotalneto() {

        let arreglo_total = new Array();
        let count = 0;
        let total = 0;
        let impuestototal = (0.00).toFixed(2);
        let subtotal = (0.00).toFixed(2);
        let impuesto = document.getElementById("iva").value;

        $("#detalle_compra tbody#tbody_detalle_compra tr").each(
            function() {
                arreglo_total.push($(this).find("td").eq(8).text());
                count++;
            }
        );

        for (var i = 0; i < count; i++) {
            var suma = arreglo_total[i];
            subtotal = (parseFloat(subtotal) + parseFloat(suma)).toFixed(2);
            impuestototal = parseFloat(subtotal * impuesto / 100).toFixed(2);
        }

        total = (parseFloat(subtotal) + parseFloat(impuestototal)).toFixed(2);

        $("#subtotal").html(subtotal);
        $("#impuesto_sub").html(impuestototal);
        $("#total_pagar").html(total);

    }
    0
</script>

<script src="{{ asset('js/venta.js') }}"></script>
