function RegistraServicio() {

    var validar_datos = "";
    var nombre_producto = $("#nombre_producto").val().trim();
    var precio_producto = $("#precio_producto").val();
    var tipo_descuento = $("#tipo_descuento").val().trim();
    var descuento = $("#descuento").val();
    var descripcion = $("#descripcion").val().trim();

    if (nombre_producto.trim() == "" || parseInt(nombre_producto.length) <= 0) {
        validar_datos = "* Ingrese un nombre para continuar <br>"
    }

    if (precio_producto.trim() == "" || parseInt(precio_producto.length) <= 0 || parseInt(precio_producto) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un precio para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un precio para continuar <br>"
        }
    }

    if (tipo_descuento.trim() != "no") {
        if (descuento.trim() == "" || parseInt(descuento.length) <= 0 || parseInt(descuento) <= 0) {
            if (validar_datos.trim == "") {
                validar_datos = "* Ingrese un descuento para continuar <br>"
            } else {
                validar_datos = validar_datos + "* Ingrese un descuento para continuar <br>"
            }
        }
    }

    if (descripcion.trim() == "" || parseInt(descripcion.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una descripción para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese una descripción para continuar <br>"
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

    var formdata = new FormData();
    formdata.append("nombre_producto", nombre_producto);
    formdata.append("precio_producto", precio_producto);
    formdata.append("tipo_descuento", tipo_descuento);
    formdata.append("descuento", descuento);
    formdata.append("descripcion", descripcion);

    $.ajax({
        type: "POST",
        url: RoutesSer.Url_CreateSer,
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
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Servicio ya existe!",
                    text: response.success,
                    icon: "warning"
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


}

function EditarServicio() {

    var validar_datos = "";
    var id = $("#id_servicio").val().trim();
    var nombre_producto = $("#nombre_producto").val().trim();
    var precio_producto = $("#precio_producto").val();
    var tipo_descuento = $("#tipo_descuento").val().trim();
    var descuento = $("#descuento").val();
    var descripcion = $("#descripcion").val().trim();

    if (nombre_producto.trim() == "" || parseInt(nombre_producto.length) <= 0) {
        validar_datos = "* Ingrese un nombre para continuar <br>"
    }

    if (precio_producto.trim() == "" || parseInt(precio_producto.length) <= 0 || parseInt(precio_producto) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un precio para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un precio para continuar <br>"
        }
    }

    if (tipo_descuento.trim() != "no") {
        if (descuento.trim() == "" || parseInt(descuento.length) <= 0 || parseInt(descuento) <= 0) {
            if (validar_datos.trim == "") {
                validar_datos = "* Ingrese un descuento para continuar <br>"
            } else {
                validar_datos = validar_datos + "* Ingrese un descuento para continuar <br>"
            }
        }
    }

    if (descripcion.trim() == "" || parseInt(descripcion.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una descripción para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese una descripción para continuar <br>"
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

    var formdata = new FormData();
    formdata.append("id", id);
    formdata.append("nombre_producto", nombre_producto);
    formdata.append("precio_producto", precio_producto);
    formdata.append("tipo_descuento", tipo_descuento);
    formdata.append("descuento", descuento);
    formdata.append("descripcion", descripcion);

    $.ajax({
        type: "POST",
        url: RoutesSer.Url_CreateUpdate,
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
                        window.location.href = RoutesSer.Url_CreateListado;
                    }
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Servicio ya existe!",
                    text: response.success,
                    icon: "warning"
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


}
