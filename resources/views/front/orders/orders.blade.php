@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
            <li class="active">Orders</li>
        </ul>
      
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead class="thead-primary">
                        <tr class="text-center">
                        
                            <th>Order ID</th>
                            <th>Order Products</th>
                            <th>Payment Methods</th>
                            <th>Grand Total</th>
                            <th>Created on</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order )
                        <tr class="text-center">
                            <td><a style="text-decoration: underline;"href="{{url('orders/'.$order['id'])}}">#{{$order['id']}}</a></td>
                            <td>
                                @foreach ($order['orders_products'] as $pro)
                                    {{$pro['product_code']}}
                                @endforeach
                            </td>
                            <td>{{$order['payment_method']}}</td>
                            <td>{{$order['grand_total']}} TND</td>
                            <td>{{date('d-m-Y',strtotime($order['created_at']))}}</td>
                            <td><a style="text-decoration: underline;"href="{{url('orders/'.$order['id'])}}">View Details</a></td>
                        </tr><!-- END TR-->
                        @endforeach
                    </tbody>
                </table>
            </div>         
        </div>
    </div>
</div>
@endsection
