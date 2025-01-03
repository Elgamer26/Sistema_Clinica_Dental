function RegistrarCliente() {

    var validar_datos = ""
    let nombre_clie = $("#nombre_clie").val();
    let apellido_clie = $("#apellido_clie").val();
    let correo_clie = $("#correo_clie").val();
    let telefono_clie = $("#telefono_clie").val();
    let sexo_clie = $("#sexo_clie").val();
    let cedula_clie = $("#cedula_clie").val();
    let direccion_clie = $("#direccion_clie").val();

    var foto = $("#foto_cli").val();

    if (nombre_clie.trim() == "" || parseInt(nombre_clie.length) <= 0) {

        validar_datos = "* Ingrese un nombre para continuar <br>"

    }

    if (apellido_clie.trim() == "" || parseInt(apellido_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un apellido para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un apellido para continuar <br>"
        }

    }

    if (correo_clie.trim() == "" || parseInt(correo_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un correo para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un correo para continuar <br>"
        }

    }

    if (telefono_clie.trim() == "" || parseInt(telefono_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Seleccione un teléfono para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Seleccione un teléfono para continuar <br>"
        }

    }

    if (sexo_clie.trim() == "" || parseInt(sexo_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un sexo para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un sexo para continuar <br>"
        }

    }

    if (cedula_clie.trim() == "" || parseInt(cedula_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una cédula para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una cédula para continuar <br>"
        }

    }

    if (direccion_clie.trim() == "" || parseInt(direccion_clie.length) <= 0) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una dirección para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una dirección para continuar <br>"
        }

    }

    if (cedula_valida == false) {

        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una cédula valida <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una cédula valida <br>"
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

    //para scar la fecha para la foto
    var f = new Date();
    //este codigo me captura la extenion del archivo
    var extecion = foto.split(".").pop();
    //renombramoso el archivo con las hora minutos y segundos
    var nombrearchivo = "IMG" + f.getDate() + "" + (f.getMonth() + 1) + "" + f.getFullYear() + "" + "" + "" + f.getSeconds() + "." + extecion;

    var formdata = new FormData();
    foto = $("#foto_cli")[0].files[0];

    var formdata = new FormData();
    formdata.append("nombre_clie", nombre_clie);
    formdata.append("apellido_clie", apellido_clie);
    formdata.append("correo_clie", correo_clie);
    formdata.append("telefono_clie", telefono_clie);
    formdata.append("sexo_clie", sexo_clie);
    formdata.append("cedula_clie", cedula_clie);
    formdata.append("direccion_clie", direccion_clie);
    formdata.append("foto", foto);
    formdata.append("nombrearchivo", nombrearchivo);

    $.ajax({
        type: "POST",
        url: RoutesClie.Url_CreateClie,
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
                        window.location.href = RoutesClie.Url_NuevoCliente
                    }
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Cliente ya existe!",
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

function EditarCliente() {

    var validar_datos = ""
    let id = $("#idcliente").val();
    let nombre_clie = $("#nombre_clie").val();
    let apellido_clie = $("#apellido_clie").val();
    let correo_clie = $("#correo_clie").val();
    let telefono_clie = $("#telefono_clie").val();
    let sexo_clie = $("#sexo_clie").val();
    let cedula_clie = $("#cedula_clie").val();
    let direccion_clie = $("#direccion_clie").val();

    if (nombre_clie.trim() == "" || parseInt(nombre_clie.length) <= 0) {
        validar_datos = "* Ingrese un nombre para continuar <br>"
    }

    if (apellido_clie.trim() == "" || parseInt(apellido_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un apellido para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un apellido para continuar <br>"
        }
    }

    if (correo_clie.trim() == "" || parseInt(correo_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un correo para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un correo para continuar <br>"
      }
    }

    if (telefono_clie.trim() == "" || parseInt(telefono_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Seleccione un teléfono para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Seleccione un teléfono para continuar <br>"
        }
    }

    if (sexo_clie.trim() == "" || parseInt(sexo_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un sexo para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese un sexo para continuar <br>"
        }
    }

    if (cedula_clie.trim() == "" || parseInt(cedula_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una cédula para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una cédula para continuar <br>"
        }
    }

    if (direccion_clie.trim() == "" || parseInt(direccion_clie.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una dirección para continuar <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una dirección para continuar <br>"
        }
    }

    if (cedula_valida == false) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una cédula valida <br>"
        }
        else {
            validar_datos = validar_datos + "* Ingrese una cédula valida <br>"
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
    formdata.append("nombre_clie", nombre_clie);
    formdata.append("apellido_clie", apellido_clie);
    formdata.append("correo_clie", correo_clie);
    formdata.append("telefono_clie", telefono_clie);
    formdata.append("sexo_clie", sexo_clie);
    formdata.append("cedula_clie", cedula_clie);
    formdata.append("direccion_clie", direccion_clie);

    $.ajax({
        type: "POST",
        url: RoutesClie.Url_EditarClie,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                Swal.fire({
                    title: "Actualización ok!",
                    text: response.success,
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = RoutesClie.Url_ListarClie
                    }
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Cliente ya existe!",
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
