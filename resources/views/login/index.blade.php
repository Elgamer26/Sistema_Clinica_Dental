<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inicia sesión</title>
</head>

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<style>
    .divider:after,
    .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }

    .h-custom {
        height: calc(100% - 73px);
    }

    @media (max-width: 450px) {
        .h-custom {
            height: 100%;
        }
    }
</style>

<body>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form id="myForm">
                        <br>
                        <center>
                            <h4> <b>Inicia sesión </p>
                            </h4>
                        </center>

                        <br>

                        <div style="text-align: center;
                                background: #ff000094;
                                padding: 10px;
                                color: white;
                                display: none; border-radius: 15px; " id="none_usu">
                            <span><b> Ingrese un usuario para continuar</b></span>
                        </div>

                        <div style="text-align: center;
                                background: #ff000094;
                                padding: 10px;
                                color: white;
                                display: none; border-radius: 15px;" id="none_pass">
                            <span><b> Ingrese un password para continuar</b></span>
                        </div>

                        <br>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="usuario_usu">Usuario</label>
                            <input type="text" id="usuario_usu" class="form-control form-control-lg" placeholder="Ingrese el usuario" />
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="password_usu">Password</label>
                            <input type="password" id="password_usu" class="form-control form-control-lg" placeholder="Ingrese el password" />
                        </div>

                        <div class="alert alert-danger text-center" id="error_logeo" style="color: white; display:none; text-align: center; background: red; border-radius: 15px; padding: 10px;  text-align: center;">
                            <span> Usuario o contraseña incorrectos</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" id="recordar" type="checkbox" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Acuérdate de mí
                                </label>
                            </div>
                            <a href="#!" class="text-body">¿Has olvidado tu contraseña?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" style="margin-bottom: 100px;" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Acceso</button>
                        </div>

                </div>
            </div>
        </div>
        <div style="position: fixed;
                left: 0;
                width: 100%;
                background-color: lightblue;
                text-align: center;
                padding: 10px;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.3);
                z-index: 10;" class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2025. Todos los derechos reservados.
            </div>
        </div>
    </section>

</body>

</html>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/dist/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('template/dist/js/sweetalert2@11.js') }}"></script>

<script>
    function RecordaPasswordAdmin() {

        const rmcheck = document.getElementById("recordar");
        const password = document.getElementById("password_usu");
        const usuario = document.getElementById("usuario_usu");

        if (rmcheck.checked == true) {
            if (rmcheck.checked || usuario.value != "" || password.value != "") {

                localStorage.usuario = usuario.value;
                localStorage.password = password.value;
                localStorage.checkbox = rmcheck.checked;
            } else {
                localStorage.usuario = "";
                localStorage.password = "";
                localStorage.checkbox = "";
            }
        } else {
            localStorage.clear();
        }
    }

    $(document).ready(function() {

        const rmcheck = document.getElementById("recordar");
        const password = document.getElementById("password_usu");
        const usuario = document.getElementById("usuario_usu");

        if (localStorage.checkbox && localStorage.checkbox != "") {
            rmcheck.setAttribute("checked", "checked");
            password.value = localStorage.password;
            usuario.value = localStorage.usuario;
        } else {
            rmcheck.removeAttribute("checked");
            password.value = "";
            usuario.value = "";
        }

    })

    $(document).on("submit", "#myForm", function(e) {
        e.preventDefault();
        ValidarCredencialesUsuario();
    });

    function ValidarCredencialesUsuario() {
        var usuario = $("#usuario_usu").val();
        var password = $("#password_usu").val();
        if (parseInt(usuario.length) <= 0 || usuario == "") {
            $("#none_pass").hide();
            $("#none_usu").hide();
            $("#none_usu").show(2000);
        } else if (parseInt(password.length) <= 0 || password == "") {
            $("#none_usu").hide();
            $("#none_pass").hide();
            $("#none_pass").show(2000);
        } else {
            $("#none_usu").hide();
            $("#none_pass").hide();
            $.ajax({
                type: "POST",
                url: "{{ route('usuario.login') }}",
                data: {
                    usuario: usuario,
                    password: password
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }).done(function(response) {
                if (response.status == 200) {
                    if (response.success == false) {
                        $("#none_usu").hide();
                        $("#none_pass").hide();
                        $("#error_logeo").show(2000);
                        return false;
                    } else {
                        $.ajax({
                            url: "{{ route('usuario.token') }}",
                            type: "POST",
                            data: {
                                id_usu: response.success[0],
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        }).done(function(res) {
                            RecordaPasswordAdmin();
                            if (res == 1) {
                                let timerInterval;
                                Swal.fire({
                                    icon: "info",
                                    title: "Bienvenido al sistema!",
                                    html: "Usted sera redireccionado en <b></b> mi.",
                                    allowOutsideClick: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        const b = Swal.getHtmlContainer().querySelector("b");
                                        timerInterval = setInterval(() => {
                                            b.textContent = Swal.getTimerLeft();
                                        }, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                    },
                                }).then((result) => {
                                    /* Read more about handling dismissals below */
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                } else {
                    $("#none_usu").hide();
                    $("#none_pass").hide();
                    $("#error_logeo").hide();
                    Swal.fire({
                        title: "No se puede procesar!",
                        text: response.error,
                        icon: "error"
                    });
                }
            });
        }
    }
</script>
