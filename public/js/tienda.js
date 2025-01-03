function paginartienda(partida, valor) {
    $.ajax({
        url: RouteTienda.Url_ListaProducto,
        type: "POST",
        data: {
            partida: partida,
            valor: valor,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (response) {
        var array = eval(response);
        if (array[0]) {
            $("#unir_listado").html(array[0]);
            $("#unir_paguinador_").html(array[1]);
        } else {
            $("#unir_listado")
                .html(`<div class="col-12" style="text-align: center; justify-content: center; align-items: center"><br>
                <label style="font-size: 20px;"></i>.:No se encontro producto:.<label>
            </div>`);
            $("#unir_paguinador_").html("");
        }
    });
}

$(document).on("keyup", "#buscar_producto", function () {
    let valor = $(this).val();
    if (valor != "") {
        paginartienda(1, valor);
    } else {
        paginartienda(1);
    }
});

//***************************//

function paginartiendaServicio(partida, valor) {
    $.ajax({
        url: RouteTienda.Url_ListaServicio,
        type: "POST",
        data: {
            partida: partida,
            valor: valor,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).done(function (response) {
        var array = eval(response);
        if (array[0]) {
            $("#unir_listado_servicios").html(array[0]);
            $("#unir_paguinador_servicios").html(array[1]);
        } else {
            $("#unir_listado_servicios")
                .html(`<div class="col-12" style="text-align: center; justify-content: center; align-items: center"><br>
                <label style="font-size: 20px;"></i>.:No se encontro servicio:.<label>
            </div>`);
            $("#unir_paguinador_servicios").html("");
        }
    });
}
