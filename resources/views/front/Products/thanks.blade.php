@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><a href="{{ url('/') }}">Home</a> / <span>Thanks</span></p>
                    <h1 class="mb-0 bread">Thanks</h1>
                </div>
            </div>
        </div>
    </div>   
   
    <div align="center">
        <h3>YOUR ORDER HAS BEEN PLACED SUCCESSFULLY</h3>
        <p>Your order number is {{Session::get('order_id')}} and the total is {{Session::get('grand_total')}} TND</p>
    </div>


    </section>
@endsection
<?php 

Session::forget('grand_total');
Session::forget('order_id');

?>