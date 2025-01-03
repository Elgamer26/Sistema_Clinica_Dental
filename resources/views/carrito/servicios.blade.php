@include('carrito.header')

<div class="section">
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="section-title">
                    <h3 class="title">Servicios</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="section-title">
                    <div class="header-search">
                        <input class="input" id="buscar_servicios" placeholder="Buscar aquí">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row" id="unir_listado_servicios">
                </div>
            </div>

        </div>

        <br>
        <br>

    </div>
</div>

<div class="container" style="text-align: center;">
    <nav aria-label="...">
        <ul class="pagination_" style="position: relative; left: 15px;" id="unir_paguinador_servicios">
        </ul>
    </nav>
</div>

@include('carrito.footer')

<script>
    const RouteTienda = {
        Url_ListaServicio: "{{ route('carrito.listar_servicios') }}",
    };
    paginartiendaServicio(1);
</script>
