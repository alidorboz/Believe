<?php use App\Models\Product;
use App\Models\User;
?>

@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    @if (Session::has('success_message'))
                        <div class='alert alert-success alert-dismissable fade show' role='alert'>
                            {{ Session::get('success_message') }}
                            <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                        {{ Session::forget('success_message') }}
                    @endif
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Order #{{ $orderDetails['id'] }} Detail</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Order Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">

                                    <tbody>
                                        <tr class="text-center">
                                            <td><strong>Order Details</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Order Date</td>
                                            <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Status</td>
                                            <td>{{ $orderDetails['order_status'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Total</td>
                                            <td>{{ $orderDetails['grand_total'] }} TND</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Charges</td>
                                            <td>7 TND</td>
                                        </tr>
                                        <tr>
                                            <td>Coupon Code</td>
                                            <td>{{ $orderDetails['coupon_code'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Coupon Amount</td>
                                            <td>{{ $orderDetails['coupon_amount'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td>{{ $orderDetails['payment_method'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Gateway</td>
                                            <td>{{ $orderDetails['payment_gateway'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>


                            </div>
                            <!-- /.card-header -->
                            <table class="table">
                                <tr class="text-center">
                                    <td><strong>Customer Details</strong></td>
                                </tr>
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>{{ $userDetails['name'] }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td>E-Mail</td>
                                    <td>{{ $userDetails['email'] }}</td>
                                </tr>


                            </table>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card">

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Billing Details</h3>


                            </div>
                            <!-- /.card-header -->
                            <table class="table">
                                <tr class="text-center">
                                    <td>Name</td>
                                    <td>{{ $userDetails['name'] }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td>Address</td>
                                    <td>{{ $userDetails['address'] }}</td>
                                </tr>

                                <tr class="text-center">
                                    <td>Pincode</td>
                                    <td>{{ $userDetails['pincode'] }}</td>
                                </tr>
                                <tr class="text-center">
                                    <td>Mobile</td>
                                    <td>{{ $userDetails['mobile'] }}</td>
                                </tr>


                            </table>
                            <!-- /.card-body -->
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Update Order Status</h3>


                                </div>
                                <!-- /.card-header -->
                                <table class="table">
                                    <tr class="text-center">
                                        <td>
                                            <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                                                <input type="hidden"name="order_id"value="{{ $orderDetails['id'] }}">
                                                <select name="order_status"required=""id="order_status">
                                                    <option>Select Status</option>
                                                    @foreach ($orderStatuses as $status)
                                                        <option value="{{ $status['name'] }}"
                                                            @if (isset($orderDetails['order_status']) && $orderDetails['order_status'] == $status['name']) selected="" @endif>
                                                            {{ $status['name'] }}</option>
                                                    @endforeach

                                                </select>
                                                <input style="width:120px;" type="text" name="courier_name" id="courier_name" placeholder="Courier Name">
                                                <input style="width:120px;" type="text" name="tracking_number" id="tracking_number" placeholder=" Tracking Number">
                                                <button type="submit">Update</button>
                                                
                                                <script>
                                                    // Hide courier_name and tracking_number inputs initially
                                                    $("#courier_name, #tracking_number").hide();
                                                    
                                                    // Attach change event listener to the order_status select element
                                                    $("#order_status").on("change", function() {
                                                        // Show courier_name and tracking_number inputs if order_status is "shipped"
                                                        if (this.value === "shipped") {
                                                            $("#courier_name, #tracking_number").show();
                                                        } else {
                                                            $("#courier_name, #tracking_number").hide();
                                                        }
                                                    });
                                                </script>
                                                
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            @foreach ($orderLog as $log)
                                                <strong>{{ $log['order_status'] }}</strong> <br>
                                                {{ date('F j, Y, g:i a', strtotime($log['created_at'])) }}
                                                <br><br>
                                            @endforeach
                                        </td>
                                    </tr>


                                </table>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <div class="card">

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Delivery Address</h3>


                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table">
                                        <tbody>
                                            <tr class="text-center">
                                                <td><strong>Delivery Address</strong></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Name</td>
                                                <td>{{ $orderDetails['name'] }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Address</td>
                                                <td>{{ $orderDetails['address'] }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Governorate</td>
                                                <td>{{ $orderDetails['governorate'] }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Delegation</td>
                                                <td>{{ $orderDetails['delegation'] }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Pincode</td>
                                                <td>{{ $orderDetails['pincode'] }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Mobile</td>
                                                <td>{{ $orderDetails['mobile'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Ordered Products</h3>

                                    <div class="card-tools">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
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
                                            @foreach ($orderDetails['orders_products'] as $product)
                                                <tr class="text-center">
                                                    <td><?php $getProductImage = Product::getProductImage($product['product_id']); ?>
                                                        <a href="{{ url('product/' . $product['product_id']) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('images/product_images/small/' . $getProductImage) }}"></a>
                                                    </td>
                                                    <td>{{ $product['product_code'] }}</td>
                                                    <td>{{ $product['product_name'] }}</td>
                                                    <td>{{ $product['product_size'] }}</td>
                                                    <td>{{ $product['product_color'] }}</td>
                                                    <td>{{ $product['product_qty'] }}</td>

                                                </tr><!-- END TR-->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->

                    <!-- /.row -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
