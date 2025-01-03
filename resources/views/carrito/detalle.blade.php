@include('carrito.header')

<div class="section">
    <div class="container">
        <div class="row">
            <!-- Product main img -->
            <div class="col-md-5 col-md-push-2">
                <div id="product-main-img">

                    @if (!empty($imgs))
                    @foreach ($imgs as $img)

                    <div class="product-preview">
                        <img style="object-fit: cover; height: 500px;" src="{{ asset('img/producto/' . $img['img']) }}" alt="Imagen producto">
                    </div>

                    @endforeach
                    @else
                    <div class="product-preview">
                        <img style="object-fit: cover; height: 500px;" src="{{ asset('img/default.png') }}" alt="Imagen producto">
                    </div>
                    @endif
                </div>
            </div>
            <!-- /Product main img -->

            <!-- Product thumb imgs -->
            <div class="col-md-2  col-md-pull-5">
                <div id="product-imgs">

                @if (!empty($imgs))
                    @foreach ($imgs as $img)

                    <div class="product-preview">
                        <img style="object-fit: cover; height: 165px;" src="{{ asset('img/producto/' . $img['img']) }}" alt="Imagen producto">
                    </div>

                    @endforeach
                    @else

                    <div class="product-preview">
                        <img style="object-fit: cover; height: 165px;" src="{{ asset('img/default.png') }}" alt="Imagen producto">
                    </div>

                    @endif
                </div>
            </div>

            <div class="col-md-5">
                <div class="product-details">
                    <h2 class="product-name"></h2>
                    <div>
                        <h3 class="product-price">$
                            <!-- <del class="product-old-price">$990.00</del> -->
                        </h3>
                    </div>
                    <p><b>Tecnología:</b> </p>
                    <p><b>Lenguaje:</b> </p>
                    <p><b>Tipo proyecto:</b> </p>
                    <p><b>Detalle:</b> </p>
                    <!-- <div class="add-to-cart">
								<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> AÑADIR A LA CESTA</button>
							</div> -->

                    <div class="add-to-cart">
                        <button class="add-to-cart-btn" onclick=""><i class="fa fa-eye"></i> Ver proyecto</button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

@include('carrito.footer')
