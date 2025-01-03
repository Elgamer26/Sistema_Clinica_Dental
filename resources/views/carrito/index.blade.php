@include('carrito.header')

<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">

            <!-- section title -->
            <div class="col-md-8">
                <div class="section-title">
                    <h3 class="title">Productos</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="section-title">
                    <div class="header-search">
                        <input class="input" id="buscar_producto" placeholder="Buscar aquí">
                    </div>
                </div>
            </div>
            <!-- /section title -->

            <!-- Products tab & slick -->
            <div class="col-md-12">
                <div class="row" id="unir_listado">
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->



        </div>
        <!-- /SECTION -->

        <br>
        <br>
    </div>
</div>

<div class="container" style="text-align: center;">
    <nav aria-label="...">
        <ul class="pagination" style="position: relative; left: 15px;" id="unir_paguinador_">
        </ul>
    </nav>
</div>

@include('carrito.footer')

<script>
    const RouteTienda = {
        Url_ListaProducto: "{{ route('carrito.listar_producto') }}",
    };

    paginartienda(1);
</script>
