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

                        <input id="idcliente" hidden value="{{ $lista['id'] }}">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nombres</label>
                                        <input id="nombre_clie" type="text" class="form-control" value="{{ $lista['nombre'] }}" placeholder="Ingrese nombre" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Apellidos</label>
                                        <input id="apellido_clie" type="text" class="form-control" value="{{ $lista['apellido'] }}" placeholder="Ingrese apellido" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Correo</label>
                                        <input id="correo_clie" type="text" class="form-control" value="{{ $lista['correo'] }}" placeholder="Ingrese correo" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input id="telefono_clie" type="number" class="form-control" value="{{ $lista['telefono'] }}" placeholder="Ingrese un telefono" maxlength="60" onkeypress="return soloNumeros(event)">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sexo</label>
                                        <select id="sexo_clie" class="form-control">
                                            <option value="">--- Seleccione sexo ---</option>
                                            <option value="M" {{ $lista['sexo'] == 'M' ? 'selected' : '' }}>Masculino</option>
                                            <option value="F" {{ $lista['sexo'] == 'F' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cédula &nbsp;&nbsp; <label style="color:red;" id="cedula_cliente"></label> </label>
                                        <input id="cedula_clie" type="text" class="form-control" value="{{ $lista['cedula'] }}" placeholder="Ingrese cedula" maxlength="10" onkeypress="return soloNumeros(event)">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input id="direccion_clie" type="text" class="form-control" value="{{ $lista['direccion'] }}" placeholder="Ingrese dirección">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <a class="btn btn-success ms-auto" onclick="EditarCliente()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Editar Cliente
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
    var cedula_valida = true
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
        Url_EditarClie: "{{ route('cliente.update') }}",
        Url_ListarClie: "{{ route('cliente.formLista_cliente') }}",
    };
</script>

<script src="{{ asset('js/cliente.js') }}"></script>
