function RegistraCompra() {

    var validar_datos = "";
    var cliente = $("#cliente_select").val();
    var fecha = $("#fecha_compra").val();
    var tipo_comprabante = $("#tipo_comprabante").val();
    var iva = $("#iva").val();
    var numero_factura = $("#numero_factura").val();

    var subtotal = $("#subtotal").html();
    var impuesto_sub = $("#impuesto_sub").html();
    var total_pagar = $("#total_pagar").html();
    var count = 0;
    var cant_cer = 0;
    var pre_cer = 0;

    if (fecha.trim() == "" || parseInt(fecha.length) <= 0) {
        validar_datos = "* Ingrese un fecha para continuar <br>"
    }

    if (tipo_comprabante.trim() == "" || parseInt(tipo_comprabante.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un tipo comprobante para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un tipo comprobante para continuar <br>"
        }
    }

    if (cliente.trim() == "" || parseInt(cliente.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un cliente para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un cliente para continuar <br>"
        }
    }

    if (iva.trim() == "" || parseInt(iva.length) <= 0 || parseInt(iva) < 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese el IVA para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese el IVA para continuar <br>"
        }
    }

    if (numero_factura.trim() == "" || parseInt(numero_factura.length) <= 0 || parseInt(numero_factura) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese el N. de comprobante para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese el N. de comprobante para continuar <br>"
        }
    }

    if (total_pagar.trim() == "" || parseInt(total_pagar.length) <= 0 || parseInt(total_pagar) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* El total a pgar no puede ser 0 o menor a 0 <br>"
        } else {
            validar_datos = validar_datos + "* El total a pgar no puede ser 0 o menor a 0 <br>"
        }
    }

    $("#detalle_compra tbody#tbody_detalle_compra tr").each(
        function () {
            count++;
        }
    );

    if (count == 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* No hay producto en el detalle de venta <br>"
        } else {
            validar_datos = validar_datos + "* No hay producto en el detalle de venta <br>"
        }
    }

    var arrego_id_producto = new Array();
    var arreglo_precio = new Array();
    var arreglo_cantidad = new Array();

    $("#detalle_compra tbody#tbody_detalle_compra tr").each(
        function () {
            arrego_id_producto.push($(this).find("td").eq(0).text());
            arreglo_precio.push($(this).find("#precio_a").val());
            arreglo_cantidad.push($(this).find("#cantida_a").val());
            if ($(this).find("#precio_a").val() <= 0) {
                pre_cer++;
            }
            if ($(this).find("#cantida_a").val() <= 0) {
                cant_cer++;
            }
        }
    );

    if (pre_cer > 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Hay productos que tienen precio de cero <br>"
        } else {
            validar_datos = validar_datos + "* Hay productos que tienen precio de cero <br>"
        }
    }

    if (cant_cer > 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Hay productos que tienen cantidad de cero <br>"
        } else {
            validar_datos = validar_datos + "* Hay productos que tienen cantidad de cero <br>"
        }
    }

    if (parseInt(validar_datos.length) > 0) {
        Swal.fire({
            title: "No ha ingresado datos!",
            html: validar_datos,
            icon: "warning"
        });
        return false;
    }

    //aqui combierto el arreglo a un string
    var id_p = arrego_id_producto.toString();
    var precio = arreglo_precio.toString();
    var cantidad = arreglo_cantidad.toString();

    var formdata = new FormData();

    formdata.append("cliente", cliente);
    formdata.append("fecha", fecha);
    formdata.append("tipo_comprabante", tipo_comprabante);
    formdata.append("iva", iva);
    formdata.append("numero_factura", numero_factura);
    formdata.append("subtotal", subtotal);
    formdata.append("impuesto_sub", impuesto_sub);
    formdata.append("total_pagar", total_pagar);

    formdata.append("id_p", id_p);
    formdata.append("precio", precio);
    formdata.append("cantidad", cantidad);

    $.ajax({
        type: "POST",
        url: RoutesVenta.Url_CreateCompra,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                Swal.fire({
                    title: "Registro ok!",
                    text: response.success,
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
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

    return false;
}
