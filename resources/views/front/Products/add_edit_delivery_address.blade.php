@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Delivery Addresses</li>
        </ul>
        @if (Session::has('success_message'))
            <div class='alert alert-success' role='alert'>
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php Session::forget('success_message'); ?>
        @endif
        @if (Session::has('error_message'))
            <div class='alert alert-danger' role='alert'>
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php Session::forget('error_message'); ?>

        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        <p class="card-text"></p>
                        <form id="deliveryAddressForm" @if (!empty($address['id']))
                            action="{{ url('/add-edit-delivery-address') }}"
                            @else
                            action="{{ url('/add-edit-delivery-address/' . $address['id']) }}"@endif method="post">@csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" @if(isset($address['name']))value="{{ $address['name'] }}" 
                                    @else value="{{old('name')}}" @endif required="">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address"@if(isset($address['address']))value="{{ $address['address'] }}" 
                                    @else value="{{old('address')}}" @endif value="{{ $address['address'] }}">
                            </div>
                            <div class="form-group">
                                <label for="governorate">Governorate</label>
                                <input type="text" class="form-control" id="governorate" name="governorate"
                                    placeholder="Enter Governorate"@if(isset($address['governorate']))value="{{ $address['governorate'] }}" 
                                    @else value="{{old('governorate')}}" @endif value="{{ $address['governorate'] }}">
                            </div>
                            <div class="form-group">
                                <label for="delegation">Delegation</label>
                                <input type="text" class="form-control" id="delegation" name="delegation"
                                    placeholder="Enter Delegation"@if(isset($address['delegation']))value="{{ $address['delegation'] }}" 
                                    @else value="{{old('delegation')}}" @endif value="{{ $address['delegation'] }}">
                            </div>

                            <div class="form-group">
                                <label for="pincode">Postal Code</label>
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                    placeholder="Enter Postal Code" @if(isset($address['pincode']))value="{{ $address['pincode'] }}" 
                                    @else value="{{old('pincode')}}" @endif value="{{ $address['pincode'] }}">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile"@if(isset($address['mobile']))value="{{ $address['mobile'] }}" 
                                    @else value="{{old('mobile')}}" @endif value="{{ $address['mobile'] }}">
                            </div>


                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            <a class="btn block" href="{{ url('checkout') }}">Back</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>


        </div>
    </div>
@endsection
