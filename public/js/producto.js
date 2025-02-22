function RegistraProducto() {

    var validar_datos = "";
    var nombre_producto = $("#nombre_producto").val().trim();
    var tipo_producto = $("#tipo_producto").val().trim();
    var precio_producto = $("#precio_producto").val();
    var tipo_descuento = $("#tipo_descuento").val().trim();
    var descuento = $("#descuento").val();
    var descripcion = $("#descripcion").val().trim();

    if (nombre_producto.trim() == "" || parseInt(nombre_producto.length) <= 0) {
        validar_datos = "* Ingrese un nombre para continuar <br>"
    }

    if (tipo_producto.trim() == "" || parseInt(tipo_producto.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un tipo para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un tipo para continuar <br>"
        }
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

    let descoferta = 0;
    if (tipo_descuento.trim() == "no") {
        descoferta = precio_producto;
    } else if (tipo_descuento.trim() == "desc") {
        descoferta = parseFloat(precio_producto - descuento).toFixed(2);
    } else if (tipo_descuento.trim() == "proc") {
        descoferta = parseFloat(precio_producto * descuento / 100).toFixed(2);
    }

    if (parseInt(descoferta) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Se ha detectado que el valor a pagar por el producto es negativo " + descoferta + ". <br>"
        } else {
            validar_datos = validar_datos +  "* Se ha detectado que el valor a pagar por el producto es negativo " + descoferta + ". <br>"
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

    let archivo = document.getElementById("file").files.length;

    var formdata = new FormData();

    //este for es para obtener las imagenes del del input file[]
    for (let i = 0; i < archivo; i++) {
        var img = document.getElementById("file").files[i];
        formdata.append("img_extra[" + i + "]", img);
    }

    formdata.append("nombre_producto", nombre_producto);
    formdata.append("tipo_producto", tipo_producto);
    formdata.append("precio_producto", precio_producto);
    formdata.append("tipo_descuento", tipo_descuento);
    formdata.append("descuento", descuento);
    formdata.append("descripcion", descripcion);

    $.ajax({
        type: "POST",
        url: RoutesProd.Url_CreateProd,
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
                    title: "Producto ya existe!",
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

function IngresarImagen(id) {

    let archivo = document.getElementById("file").files.length;

    if (parseInt(archivo) <= 0) {
        Swal.fire({
            title: "No hay ingresado imagen!",
            html: "No hay imagen para cargar",
            icon: "warning"
        });
        return false;
    }

    var formdata = new FormData();

    //este for es para obtener las imagenes del del input file[]
    for (let i = 0; i < archivo; i++) {
        var img = document.getElementById("file").files[i];
        formdata.append("img_extra[" + i + "]", img);
    }

    formdata.append("id", id);

    $.ajax({
        type: "POST",
        url: Routes.Url_CargarImagenPlus,
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
                    title: "Producto ya existe!",
                    text: response.success,
                    icon: "warning"
                });
            } else if (response.status == 401) {
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

function EditarProducto() {

    var validar_datos = "";
    var id = $("#id_prod").val().trim();
    var nombre_producto = $("#nombre_producto").val().trim();
    var tipo_producto = $("#tipo_producto").val().trim();
    var precio_producto = $("#precio_producto").val();
    var tipo_descuento = $("#tipo_descuento").val().trim();
    var descuento = $("#descuento").val();
    var descripcion = $("#descripcion").val().trim();

    if (nombre_producto.trim() == "" || parseInt(nombre_producto.length) <= 0) {
        validar_datos = "* Ingrese un nombre para continuar <br>"
    }

    if (tipo_producto.trim() == "" || parseInt(tipo_producto.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un tipo para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un tipo para continuar <br>"
        }
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
    formdata.append("tipo_producto", tipo_producto);
    formdata.append("precio_producto", precio_producto);
    formdata.append("tipo_descuento", tipo_descuento);
    formdata.append("descuento", descuento);
    formdata.append("descripcion", descripcion);

    $.ajax({
        type: "POST",
        url: RoutesProd.Url_CreateUpdate,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                Swal.fire({
                    title: "Registro actualizado!",
                    text: response.success,
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = RoutesProd.Url_CreateLista;
                    }
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Producto ya existe!",
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
