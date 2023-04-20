@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><a href="{{ url('/') }}">Home</a> / <span>Cart</span></p>
                    <h1 class="mb-0 bread">My Cart</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div  id="AppendCartItems">
                        @include('front.Products.cart_items')
                    </div>
                </div>
            </div>
        </div>
        <div class="coupon my-2">
            <form id="ApplyCoupon" action="javascript:void(0);" method="post"
                @if (Auth::check()) user="1" @endif>
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="text" name="code" id="code" class="form-control"
                                placeholder="Coupon Code" required>
                            <div class="input-group-append">
                                <button type="submit" form="ApplyCoupon" class="btn btn-primary py-3 px-4">APPLY</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p class="text-center"><a href="{{ url('checkout') }}" class="btn btn-primary py-3 px-4">Proceed to
                                Checkout</a></p>
                    </div>
                </div>
            </form>
        </div>


    </section>
@endsection
