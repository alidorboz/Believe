@extends('layouts.front_layout.front_layout')
@section('content')
    <?php use App\Models\Product; ?>

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home</a></span> <span
                            class="mr-2"></p>
                    <h1 class="mb-0 bread">{{ $productDetails['category']['categoryName'] }}</h1>
                </div>
            </div>
        </div>
    </div>
    @if (Session::has('success_message'))
        <div class='alert alert-success' role='alert'>
            {{ Session::get('success_message') }}
            <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <?php Session::forget('success_message'); ?>
    @endif
    @if (Session::has('error_message'))
        <div class='alert alert-danger' role='alert'>
            {{ Session::get('error_message') }}
            <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <?php Session::forget('error_message'); ?>
    @endif
    <div class="container">
        <form action="{{ url('add-to-cart') }}" method="post"> {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
            <div class="row">
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ asset('images/product_images/large/' . $productDetails['main_image']) }}"
                        class="image-popup"><img
                            src="{{ asset('images/product_images/large/' . $productDetails['main_image']) }}"
                            class="img-fluid" alt="Colorlib Template"></a>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3>{{ $productDetails['product_name'] }}</h3>
                    <?php $discounted_price = Product::getDiscountedPrice($productDetails['id']); ?>
                    <p class="price getAttrPrice">
                        @if ($discounted_price > 0)
                            <span class="price-sale">{{ $discounted_price }} TND</span>
                        @else
                            <span class="price-sale">{{ $productDetails['product_price'] }} TND</span>
                        @endif
                    </p>
                    @if (count($groupProducts) > 0)
                        <div>
                            <div><strong>More Colors</strong></div>
                            <div style="margin-top:5px;">
                                @foreach ($groupProducts as $product)
                                    <a href="{{ url('product/' . $product['id']) }}"><span class="color-circle"
                                            style="background-color: {{ $product['product_color'] }};"></span></a>
                                @endforeach
                            </div>
                        </div>
                        <br>
                    @endif

                    <style>
                        .color-circle {
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            margin-right: 5px;
                            border-radius: 50%;
                            border: 1px solid #ccc;
                        }
                    </style>



                    <p>{{ $productDetails['description'] }}
                    </p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group d-flex">
                                <div class="select-wrap">
                                    <div class="icon"><span class="fas fa-chevron-down"></span></div>
                                    <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}"
                                        class="form-control">
                                        <option value="">Size</option>
                                        @foreach ($productDetails['attributes'] as $attribute)
                                            <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="input-group col-md-6 d-flex mb-3">
                            <span class="input-group-btn mr-2">
                                <button type="button" class="quantity-left-minus btn" onclick="updateQuantity(-1)">
                                    <span class="fas fa-minus"></span>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number"
                                value="1" min="1" max="100" onchange="validateQuantity()">
                            <span class="input-group-btn ml-2">
                                <button type="button" class="quantity-right-plus btn" onclick="updateQuantity(1)">
                                    <span class="fas fa-plus"></span>
                                </button>
                            </span>

                        </div>

                        <script>
                            // Initialize quantity variable
                            let quantity = 1;

                            // Function to update the quantity value
                            function updateQuantity(delta) {
                                quantity += delta;
                                if (quantity < 1) quantity = 1;
                                if (quantity > 100) quantity = 100;
                                document.getElementById('quantity').value = quantity;
                            }

                            // Function to validate the quantity value
                            function validateQuantity() {
                                if (isNaN(document.getElementById('quantity').value)) {
                                    document.getElementById('quantity').value = 1;
                                    quantity = 1;
                                } else {
                                    quantity = parseInt(document.getElementById('quantity').value);
                                    if (quantity < 1) quantity = 1;
                                    if (quantity > 100) quantity = 100;
                                    document.getElementById('quantity').value = quantity;
                                }
                            }
                        </script>
                        <div class="w-100"></div>
                        <div class="col-md-12">

                            <p style="color: #000;">{{ $total_stock }} piece available</p>

                        </div>
                    </div>
                    <p><input type="submit" class="btn btn-black py-3 px-5" value="Add to Cart"></p>
                </div>
            </div>
        </form>
    </div>
    </section>


    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Complete Your Style</h2>
                </div>
            </div>

            <div class="row">
                @foreach ($relatedProducts as $product)
                    <div class="col-sm-4 ftco-animate text-center">
                        <div class="product">
                            <a href="{{ url('product/' . $product['id']) }}" class="img-prod">
                                <img class="img-fluid"
                                    src="{{ asset('images/product_images/small/' . $product['main_image']) }}"
                                    alt="{{ $product['product_name'] }}">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 px-3">
                                <h3><a href="{{ url('product/' . $product['id']) }}">{{ $product['product_name'] }}</a>
                                </h3>


                                <h3 class="price"><span class="mr-2 price-dc"></span><span
                                        class="price-sale">{{ $product['product_price'] }} TND</span></h3>


                                <a href="{{ url('product/' . $product['id']) }}"
                                    class="add-to-cart text-center py-2 mr-1"><span><i class="fas fa-eye"></i>
                                        View</span></a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
