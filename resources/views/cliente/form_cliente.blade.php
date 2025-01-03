@include('layout.header')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos del cliente</h3>
                    </div>

                    <div style="padding: 15px;">

                        <form id="FrmUsuarioCreate">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombres</label>
                                        <input id="nombre_clie" type="text" class="form-control" placeholder="Ingrese nombre" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Apellidos</label>
                                        <input id="apellido_clie" type="text" class="form-control" placeholder="Ingrese apellido" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Correo</label>
                                        <input id="correo_clie" type="text" class="form-control" placeholder="Ingrese correo" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input id="telefono_clie" type="number" class="form-control" placeholder="Ingrese un telefono" maxlength="60" onkeypress="return soloNumeros(event)">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sexo</label>
                                        <select id="sexo_clie" class="form-control">
                                            <option value="">--- Seleccione sexo ---</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cédula &nbsp;&nbsp; <label style="color:red;" id="cedula_cliente"></label> </label>
                                        <input id="cedula_clie" type="text" class="form-control" placeholder="Ingrese cedula" maxlength="10" onkeypress="return soloNumeros(event)">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input id="direccion_clie" type="text" class="form-control" placeholder="Ingrese dirección">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group text-center">
                                        <label><b>Foto del cliente</b></label>
                                        <br>
                                        <img id="img_clieario" height="200" width="250" style="border-radius: 50px;" src="{{ asset('img/clientes/cliente.png') }}" />
                                        <br><br>
                                        <input type="file" class="form-control" id="foto_cli" onchange="mostrar_imagen(this)" />
                                    </div>
                                </div>

                            </div>

                            <br>

                            <a class="btn btn-success ms-auto" onclick="RegistrarCliente()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Registrar Cliente
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

    function mostrar_imagen(input) {
        var filename = document.getElementById("foto_cli").value;
        var idxdot = filename.lastIndexOf(".") + 1;
        var extfile = filename.substr(idxdot, filename.length).toLowerCase();
        if (extfile == "jpg" || extfile == "jpeg" || extfile == "png") {

            if (input.files) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#img_clieario").attr("src", e.target.result).height(200).width(250);
                }
                reader.readAsDataURL(input.files[0]);
            }

        } else {
            swal.fire(
                "Mensaje de alerta",
                "Solo se aceptan imagenes - USTED SUBIO UN ARCHIVO CON LA EXTENCIO ." + extfile,
                "warning"
            );
            $("#img_clieario").attr("src", "{{ asset('img/clientes/cliente.png') }}").height(200).width(250);
            return document.getElementById("foto_cli").value = "";
        }
    }

</script>

<script>
    var cedula_valida = false

    $("#cedula_clie").keyup(function() {

        cedula_valida = false

        if (this.value != "") {
            var cad = document.getElementById("cedula_clie").value.trim();
            var total = 0;
            var longitud = cad.length;
            var longcheck = longitud - 1;

            if (cad != "") {
                if (cad !== "" && longitud === 10) {
                    for (i = 0; i < longcheck; i++) {
                        if (i % 2 === 0) {
                            var aux = cad.charAt(i) * 2;
                            if (aux > 9) aux -= 9;
                            total += aux;
                        } else {
                            total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
                        }
                    }
                    total = total % 10 ? 10 - total % 10 : 0;
                    if (cad.charAt(longitud - 1) == total) {
                        // $(this).css("border", "1px solid green");
                        // $("#cedula_cliente").html("");

                        var digitos = String(cad).split('').map(d => parseInt(d));
                        var digito = digitos[0];
                        var veri = digitos.every((d) => d == digito);

                        if (!veri) {
                            $(this).css("border", "1px solid green");
                            $("#cedula_cliente").html("");
                            cedula_valida = true

                        } else {
                            document.getElementById("cedula_cliente").innerHTML = ("cédula Inválida");
                            $(this).css("border", "1px solid red");
                        }

                    } else {
                        document.getElementById("cedula_cliente").innerHTML = ("cédula Inválida");
                        $(this).css("border", "1px solid red");
                    }
                } else {
                    document.getElementById("cedula_cliente").innerHTML = ("La cédula no tiene 10 digitos");
                    $(this).css("border", "1px solid red");
                }
            } else {
                document.getElementById("cedula_cliente").innerHTML = ("Debe ingresar una cédula");
                $(this).css("border", "1px solid red");
            }
        } else {
            $(this).css("border", "1px solid green");
            $("#cedula_cliente").html("");
        }
    });

    const RoutesClie = {
        Url_CreateClie: "{{ route('cliente.create') }}",
        Url_NuevoCliente: "{{ route('cliente.form_cliente') }}",
    };


    function ListarUsuario() {
        $.ajax({
            type: "GET",
            url: Routes.Url_ListarUsu,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    $("HtmlBody").html("");
                    let HtmlLista = "";
                    response.success.forEach(e => {
                        HtmlLista = HtmlLista + `<tr>
                                    <td><a class="btn btn-primary" onclick="EditarUsuarioo(${e["id"]}, '${e["nombre"]}', '${e["apellido"]}', '${e["correo"]}', '${e["usuario_clie"]}', ${e["rol_id"]})">
                                            Editar
                                        </a>
                                        -
                                        <a class="btn btn-danger" onclick="EliminarUsuario(${e["id"]})">
                                            Eliminar
                                        </a>
                                    </td>
                                    <td>${e["nombre"]}</td>
                                    <td>${e["apellido"]}</td>
                                    <td>${e["correo"]}</td>
                                    <td>${e["usuario_clie"]}</td>
                                    <td>${e["rol"]}</td>
                                </tr>`
                    });
                    $("#HtmlBody").html(HtmlLista);
                }
            }
        });
    }
</script>

<script src="{{ asset('js/cliente.js') }}"></script>
