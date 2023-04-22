<?php use App\Models\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li class="active"><a href="{{url('/orders')}}">Orders</a></li>
        </ul>
        <h3>Order #{{$orderDetails['id']}}  Details</h3>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                        <tr class="text-center">
                            <td><strong>Order Details</strong></td>
                        </tr>
                        <tr>
                            <td>Order Date</td>
                            <td>{{date('d-m-Y',strtotime($orderDetails['created_at']))}}</td>
                        </tr>
                        <tr>
                            <td>Order Status</td>
                            <td>{{$orderDetails['order_status']}}</td>
                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td>{{$orderDetails['grand_total']}} TND</td>
                        </tr>
                        <tr>
                            <td>Shipping Charges</td>
                            <td>7 TND</td>
                        </tr>
                        <tr>
                            <td>Coupon Code</td>
                            <td>{{$orderDetails['coupon_code']}}</td>
                        </tr>
                        <tr>
                            <td>Coupon Amount</td>
                            <td>{{$orderDetails['coupon_amount']}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td>{{$orderDetails['payment_method']}}</td>
                        </tr>
                </table>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                        <tr class="text-center">
                            <td><strong>Delivery Address</strong></td>
                        </tr>
                        <tr class="text-center">
                            <td>Name</td>
                            <td>{{$orderDetails['name']}}</td>
                        </tr>
                        <tr class="text-center">
                            <td>Address</td>
                            <td>{{$orderDetails['address']}}</td>
                        </tr>
                        <tr class="text-center">
                            <td>Governorate</td>
                            <td>{{$orderDetails['governorate']}}</td>
                        </tr>                
                        <tr class="text-center">
                            <td>Delegation</td>
                            <td>{{$orderDetails['delegation']}}</td>
                        </tr>
                        <tr class="text-center">
                            <td>Pincode</td>
                            <td>{{$orderDetails['pincode']}}</td>
                        </tr>
                        <tr class="text-center">
                            <td>Mobile</td>
                            <td>{{$orderDetails['mobile']}}</td>
                        </tr>
                       
                </table>        
            </div>
        </div>                
       
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead class="thead-primary">
                        <tr class="text-center">
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Qty</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails['orders_products'] as $product )
                        <tr class="text-center">
                            <td><?php $getProductImage= Product::getProductImage($product['product_id']) ?>
                            <a href="{{url('product/'.$product['product_id'])}}" target="_blank"><img src="{{asset('images/product_images/small/'.$getProductImage)}}"></a>
                            </td>
                            <td>{{$product['product_code']}}</td>
                            <td>{{$product['product_name']}}</td>
                            <td>{{$product['product_size']}}</td>
                            <td>{{$product['product_color']}}</td>
                            <td>{{$product['product_qty']}}</td>
                            
                        </tr><!-- END TR-->
                        @endforeach
                    </tbody>
                </table>
            </div>         
        </div>
    </div>
</div>
@endsection
