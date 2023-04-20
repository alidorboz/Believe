@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><a href="{{ url('/') }}">Home</a> / <span>Checkout</span></p>
                    <h1 class="mb-0 bread">Checkout</h1>
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
<form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf                            <div class="row justify-content-center">

    <table class="table table-bordered">
        <tr>
            <td> <strong>DELIVERY ADDRESSES</strong> | <a href="{{ url('add-edit-delivery-address') }}">ADD</a> </td>
        </tr>
        @foreach ($deliveryAddresses as $address)
            <tr>
                <td>
                    <div class="control-group text-center">
                        <div style="float:left; margin-top:-2px; margin-right:5px;">
                            <input type="radio" id="address{{ $address['id'] }}" name="address_id"
                                value="{{ $address['id'] }}">
                        </div>
                        <div>
                            <label class="control-label">{{ $address['name'] }}, {{ $address['address'] }},
                                {{ $address['governorate'] }},
                                {{ $address['delegation'] }}, {{ $address['pincode'] }}
                            </label>
                        </div>
                    </div>
                </td>
                <td><a href="{{ url('/add-edit-delivery-address/' . $address['id']) }}">Edit</a> <a
                        href="{{ url('/delete-delivery-address/' . $address['id']) }}"class="addressDelete">Delete</a></td>
            </tr>
        @endforeach
    </table>


    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div id="AppendCartItems">
                        <?php use App\Models\Cart;
                        use App\Models\Product;
                        ?>
                        @php
                            $delivery_tax = 4;
                        @endphp


                      
                                <table class="table">
                                    <thead class="thead-primary">
                                        <tr class="text-center">
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <th>Product</th>
                                            <th>Unit Price</th>
                                            <th>Category/Product <br> Discount</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
        $total_price = 0; 
        foreach ($userCartItems as $item) {
            $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']); 
            $item_total = $attrPrice['final_price'] * $item['quantity']; 
            $total_price += $item_total;
        ?>
                                        <tr class="text-center">

                                            <td class="image-prod">
                                                <img src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}"
                                                    width="100%">
                                            </td>
                                            <td class="product-name">
                                                <h3>{{ $item['product']['product_name'] }}
                                                    ({{ $item['product']['product_code'] }})
                                                </h3>
                                                <p>Color : {{ $item['product']['product_color'] }}</p>
                                                <p>Size : {{ $item['size'] }}</p>
                                            </td>
                                            <td class="price">{{ $attrPrice['product_price'] * $item['quantity']}} TND</td>
                                            <td class="price">{{ $attrPrice['discount'] * $item['quantity']}} TND</td>
                                            <td class="quantity">
                                                {{ $item['quantity'] }}
                                            </td>




                                            <td class="total">{{ $item_total }} TND</td>
                                        </tr><!-- END TR-->
                                        <?php } ?>



                                    </tbody>
                                </table>
                              
                            </div>
                    </div>
                </div>

                <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Cart Totals</h3>
                        <p class="d-flex">
                            <span>Subtotal</span>
                            <span>{{ $total_price }} TND</span>
                        </p>
                        <p class="d-flex">
                            <span>Delivery</span>
                            <span>{{ $delivery_tax }} TND</span>
                        </p>

                        <p class="d-flex">
                            <span>Coupon Discount</span>
                            <span class="couponAmount">
                                @if (Session::has('couponAmount'))
                                    {{ Session::get('couponAmount') }} TND
                                @else
                                    0 TND
                                @endif

                            </span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Total</span>
                            <span class="grand_total">
                                {{ $grand_total=$total_price + $delivery_tax - (Session::has('couponAmount') ? Session::get('couponAmount') : 0) }}
                                TND
                            </span>
                        </p>
                        @php
                            Session::put('grand_total', $grand_total);
                        @endphp
                        

                    </div>

                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        <div class="coupon my-2">
            <form id="ApplyCoupon" action="javascript:void(0);" method="post"
                @if (Auth::check()) user="1" @endif>
                @csrf
                <div class="form-group text-center">
                    <label class="control-label"><strong>PAYMENT METHODS:</strong></label>
                    <div class="controls">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="CashOnDelivery" name="payment_gateway" value="CashOnDelivery"
                                class="custom-control-input" checked>
                            <label class="custom-control-label" for="CashOnDelivery">Cash On Delivery</label>
                        </div>

                        <!-- add more payment options as needed -->
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <p class="text-center"><a href="{{ url('/cart') }}" class="btn btn-primary py-3 px-4">Back to
                                Cart</a></p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center"><button type="submit" class="btn btn-primary btn-block py-3 px-4">Place
                                Order</button>
                        </p>
                    </div>

                </div>
            </form>
        </div>
</form>      


    </section>
@endsection
