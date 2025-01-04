/// ROLES
function RegistrarRol() {

    let NombreRol = $("#NombreRol").val();

    if (NombreRol.trim() == "" || parseInt(NombreRol.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado un rol!",
            text: "Ingrese un rol para continuar",
            icon: "warning"
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: Routes.Url_CreateRol,
        data: { NombreRol: NombreRol },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                $('#modal_rol').modal('hide');
                ListarRoles();
                Swal.fire({
                    title: "Registro ok!",
                    text: response.success,
                    icon: "success"
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Registro ya existe!",
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

function EliminarRol(id) {

    Swal.fire({
        title: "Eliminar rol?",
        text: "Desea eliminar el rol!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: Routes.Url_EliminarRol,
                data: { id: id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status == 200) {
                        ListarRoles();
                        Swal.fire({
                            title: "Rol eliminado con exito!",
                            text: response.success,
                            icon: "success"
                        });
                    } else if (response.status == 400) {
                        Swal.fire({
                            title: "No se puede eliminar el rol!",
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

function EditarRol(id, nombre) {
    $("#idRol").val(id);
    $("#NombreRolEdit").val(nombre);
    $('#modal_rol_edit').modal('show')
}

function UpdateRol() {

    let NombreRol = $("#NombreRolEdit").val();
    let id = $("#idRol").val();

    if (NombreRol.trim() == "" || parseInt(NombreRol.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado un rol!",
            text: "Ingrese un rol para continuar",
            icon: "warning"
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: Routes.Url_UpdateRol,
        data: { NombreRol: NombreRol, id: id },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                $('#modal_rol_edit').modal('hide');
                ListarRoles();
                Swal.fire({
                    title: "Rol editado!",
                    text: response.success,
                    icon: "success"
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Registro ya existe!",
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

/// USUARIO
function RegistrarUsuario() {

    let nombre_usu = $("#nombre_usu").val();
    let apellido_usu = $("#apellido_usu").val();
    let correo_usu = $("#correo_usu").val();
    let rol_usu = $("#rol_usu").val();
    let password_usu = $("#password_usu").val();
    let usuario_usu = $("#usuario_usu").val();
    var foto = $("#foto_usu").val();

    if (nombre_usu.trim() == "" || parseInt(nombre_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado nombre!",
            text: "Ingrese un nombre para continuar",
            icon: "warning"
        });
        return false;
    } else if (apellido_usu.trim() == "" || parseInt(apellido_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado apellido!",
            text: "Ingrese un apellido para continuar",
            icon: "warning"
        });
        return false;
    } else if (correo_usu.trim() == "" || parseInt(correo_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado correo!",
            text: "Ingrese un correo para continuar",
            icon: "warning"
        });
        return false;
    } else if (rol_usu <= 0) {
        Swal.fire({
            title: "No ha seleccionado un rol!",
            text: "Seleccione un rol para continuar",
            icon: "warning"
        });
        return false;
    } else if (password_usu.trim() == "" || parseInt(password_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado password!",
            text: "Ingrese un password para continuar",
            icon: "warning"
        });
        return false;
    } else if (usuario_usu.trim() == "" || parseInt(usuario_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado usuario!",
            text: "Ingrese un usuario para continuar",
            icon: "warning"
        });
        return false;
    }

    //para scar la fecha para la foto
    var f = new Date();
    //este codigo me captura la extenion del archivo
    var extecion = foto.split(".").pop();
    //renombramoso el archivo con las hora minutos y segundos
    var nombrearchivo =
        "IMG" +
        f.getDate() +
        "" +
        (f.getMonth() + 1) +
        "" +
        f.getFullYear() +
        "" +
        f.getHours() +
        "" +
        f.getMinutes() +
        "" +
        f.getSeconds() +
        "." +
        extecion;

    var formdata = new FormData();
    foto = $("#foto_usu")[0].files[0];

    var formdata = new FormData();
    formdata.append("nombre_usu", nombre_usu);
    formdata.append("apellido_usu", apellido_usu);
    formdata.append("correo_usu", correo_usu);
    formdata.append("rol_usu", rol_usu);
    formdata.append("password_usu", password_usu);
    formdata.append("usuario_usu", usuario_usu);
    formdata.append("foto", foto);
    formdata.append("nombrearchivo", nombrearchivo);

    $.ajax({
        type: "POST",
        url: Routes.Url_CreateUsu,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                ListarUsuario();
                $('#modal_usuario').modal('hide');
                Swal.fire({
                    title: "Registro ok!",
                    text: response.success,
                    icon: "success"
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Usuario ya existe!",
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

function EliminarUsuario(id) {
    Swal.fire({
        title: "Eliminar usuario?",
        text: "Desea eliminar el usuario!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                type: "POST",
                url: Routes.Url_EliminarUsu,
                data: { id: id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status == 200) {
                        ListarUsuario();
                        Swal.fire({
                            title: "Usuario elimnado con exito!",
                            text: response.success,
                            icon: "success"
                        });
                    } else if (response.status == 400) {
                        Swal.fire({
                            title: "No se puede eliminar el Usuario!",
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

function EditarUsuarioo(id, nombre, apellido, correo, usuario_usu, rol_id) {
    $("#id_usuario").val(id);
    $("#nombre_usu_edit").val(nombre);
    $("#apellido_usu_edit").val(apellido);
    $("#correo_usu_edit").val(correo);
    $("#rol_usu_edit").val(rol_id);
    $("#usuario_usu_edit").val(usuario_usu);
    $('#modal_usuario_edit').modal('show')
}

function UpdateUsuario() {

    let id = $("#id_usuario").val();
    let nombre_usu = $("#nombre_usu_edit").val();
    let apellido_usu = $("#apellido_usu_edit").val();
    let correo_usu = $("#correo_usu_edit").val();
    let rol_usu = $("#rol_usu_edit").val();
    let usuario_usu = $("#usuario_usu_edit").val();

    if (nombre_usu.trim() == "" || parseInt(nombre_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado nombre!",
            text: "Ingrese un nombre para continuar",
            icon: "warning"
        });
        return false;
    } else if (apellido_usu.trim() == "" || parseInt(apellido_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado apellido!",
            text: "Ingrese un apellido para continuar",
            icon: "warning"
        });
        return false;
    } else if (correo_usu.trim() == "" || parseInt(correo_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado correo!",
            text: "Ingrese un correo para continuar",
            icon: "warning"
        });
        return false;
    } else if (rol_usu <= 0) {
        Swal.fire({
            title: "No ha seleccionado un rol!",
            text: "Seleccione un rol para continuar",
            icon: "warning"
        });
        return false;
    } else if (usuario_usu.trim() == "" || parseInt(usuario_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado usuario!",
            text: "Ingrese un usuario para continuar",
            icon: "warning"
        });
        return false;
    }

    var formdata = new FormData();
    formdata.append("nombre_usu", nombre_usu);
    formdata.append("apellido_usu", apellido_usu);
    formdata.append("correo_usu", correo_usu);
    formdata.append("rol_usu", rol_usu);
    formdata.append("usuario_usu", usuario_usu);
    formdata.append("id", id);

    $.ajax({
        type: "POST",
        url: Routes.Url_UpdateUsu,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                ListarUsuario();
                $('#modal_usuario_edit').modal('hide');
                Swal.fire({
                    title: "Usuario editado!",
                    text: response.success,
                    icon: "success"
                });
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Usuario ya existe!",
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

function UpdateUsuarioPerfil() {

    let nombre_usu = $("#nombre_usu").val();
    let apellido_usu = $("#apellido_usu").val();
    let correo_usu = $("#correo_usu").val();
    let usuario_usu = $("#usuario_usu").val();
    let password_usu = $("#password_usu").val();


    if (nombre_usu.trim() == "" || parseInt(nombre_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado nombre!",
            text: "Ingrese un nombre para continuar",
            icon: "warning"
        });
        return false;
    } else if (apellido_usu.trim() == "" || parseInt(apellido_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado apellido!",
            text: "Ingrese un apellido para continuar",
            icon: "warning"
        });
        return false;
    } else if (correo_usu.trim() == "" || parseInt(correo_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado correo!",
            text: "Ingrese un correo para continuar",
            icon: "warning"
        });
        return false;
    } else if (usuario_usu.trim() == "" || parseInt(usuario_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado usuario!",
            text: "Ingrese un usuario para continuar",
            icon: "warning"
        });
        return false;
    } else if (password_usu.trim() == "" || parseInt(password_usu.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado password!",
            text: "Ingrese un password para continuar",
            icon: "warning"
        });
        return false;
    }

    var formdata = new FormData();
    formdata.append("nombre_usu", nombre_usu);
    formdata.append("apellido_usu", apellido_usu);
    formdata.append("correo_usu", correo_usu);
    formdata.append("usuario_usu", usuario_usu);
    formdata.append("password_usu", password_usu);

    $.ajax({
        type: "POST",
        url: Routes.Url_UpdatePerfil,
        data: formdata,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status == 200) {
                Swal.fire({
                    title: "Usuario editado!",
                    text: response.success,
                    icon: "success"
                });
                ObtenerInfoUsuarioLogin();
            } else if (response.status == 201) {
                Swal.fire({
                    title: "Usuario ya existe!",
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

function CambiarImagen() {

    var foto = $("#foto_usu").val();
    var foto_antigua = $("#foto_antigua").val();

    if (foto.trim() == "" || parseInt(foto.length) <= 0) {
        Swal.fire({
            title: "No ha ingresado imagen!",
            text: "Ingrese una imagen para continuar",
            icon: "warning"
        });
        return false;
    }

    var formdata = new FormData();
    foto = $("#foto_usu")[0].files[0];

    var formdata = new FormData();
    formdata.append("foto_antigua", foto_antigua);
    formdata.append("img_extra", foto);

    $.ajax({
        type: "POST",
        url: Routes.Url_UpdatePerfilFoto,
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
                    icon: "success"
                });
                ObtenerInfoUsuarioLogin();
                ObtenerUsuarioPefil();
                $("#foto_usu").val("");
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

/// EMPRESA
function ActualizarEmpresa() {

    var validar_datos = "";
    var nombre_usu = $("#nombre_usu").val().trim();
    var apellido_usu = $("#apellido_usu").val().trim();
    var correo_usu = $("#correo_usu").val();
    var rol_usu = $("#rol_usu").val().trim();

    if (nombre_usu.trim() == "" || parseInt(nombre_usu.length) <= 0) {
        validar_datos = "* Ingrese una razon social para continuar <br>"
    }

    if (apellido_usu.trim() == "" || parseInt(apellido_usu.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese una dirección continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese una dirección continuar <br>"
        }
    }

    if (correo_usu.trim() == "" || parseInt(correo_usu.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un correo para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un correo para continuar <br>"
        }
    }

    if (rol_usu.trim() == "" || parseInt(rol_usu.length) <= 0) {
        if (validar_datos.trim == "") {
            validar_datos = "* Ingrese un telefono para continuar <br>"
        } else {
            validar_datos = validar_datos + "* Ingrese un telefono para continuar <br>"
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

    formdata.append("nombre_usu", nombre_usu);
    formdata.append("apellido_usu", apellido_usu);
    formdata.append("correo_usu", correo_usu);
    formdata.append("rol_usu", rol_usu);

    $.ajax({
        type: "POST",
        url: Routes.Url_UpdateEmpresa,
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
                    icon: "success"
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

///



