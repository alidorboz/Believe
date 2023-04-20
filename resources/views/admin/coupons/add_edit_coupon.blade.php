@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>



        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form name="couponForm" id="CouponForm"
                    @if (empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}" 
                @else action="{{ url('admin/add-edit-coupon/' . $coupon['id']) }}" @endif
                    method="post" enctype="multipart/form-data">@csrf
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    @if (empty($coupon['coupon_code']))
                                        <div class="form-group">
                                            <label for="coupon_option">Coupon Option</label>
                                            <div class="radio-btn-container">
                                                <label class="radio-btn-label">
                                                    <input type="radio" class="form-control" id="AutomaticCoupon"
                                                        name="coupon_option" value="Automatic" checked>
                                                    <span class="radio-btn-text">Automatic</span>
                                                </label>
                                                <label class="radio-btn-label">
                                                    <input type="radio" class="form-control" id="ManualCoupon"
                                                        name="coupon_option" value="Manual">
                                                    <span class="radio-btn-text">Manual</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none;" id="couponField">
                                            <label for="coupon_code">Coupon Code</label>
                                            <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                                placeholder="Enter Coupon Code" required>
                                        </div>
                                    @else
                                        <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                                        <div class="form-group" id="couponField">
                                            <label for="coupon_code">Coupon Code</label>
                                            <span>{{ $coupon['coupon_code'] }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>




                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="coupon_type">Coupon Type</label>
                                    <div class="radio-btn-container">
                                        <label class="radio-btn-label">
                                            <input type="radio" name="coupon_type"
                                                value="Multiple Times"@if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == 'Multiple Times') checked required @elseif(!isset($coupon['coupon_type']))checked @endif>
                                            <span class="radio-btn-text">Multiple Times</span>
                                        </label>
                                        <label class="radio-btn-label">
                                            <input type="radio" name="coupon_type"
                                                value="Single Time"@if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == 'Single Time') checked=""required @endif>
                                            <span class="radio-btn-text">Single Time</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="amount_type">Amount Type</label>
                                <div class="radio-btn-container">
                                    <label class="radio-btn-label">
                                        <input type="radio" name="amount_type" value="Percentage"
                                            @if (isset($coupon['amount_type']) && $coupon['amount_type'] == 'Percentage') checked @elseif(!isset($coupon['amount_type']))checked @endif
                                            required>
                                        <span class="radio-btn-text">Percentage (in %)</span>
                                    </label>
                                    <label class="radio-btn-label">
                                        <input type="radio" name="amount_type" value="Fixed"
                                            @if (isset($coupon['amount_type']) && $coupon['amount_type'] == 'Fixed') checked @endif>
                                        <span class="radio-btn-text">Fixed (in TND)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <style>
                        .radio-btn-container {
                            display: flex;
                            align-items: center;
                        }

                        .radio-btn-label {
                            display: flex;
                            align-items: center;
                            margin-right: 15px;
                        }

                        .radio-btn-label input[type="radio"] {
                            margin-right: 5px;
                        }

                        .radio-btn-label .radio-btn-text {
                            font-size: 16px;
                            font-weight: 500;
                            color: #444;
                        }
                    </style>



                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="Enter Amount" required=""
                                    @if (isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @endif>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="categories">Select Categories</label>
                                <select multiple="" class="form-control select2" name="categories[]" size="5">
                                    <option value="">Select</option>
                                    @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}">
                                            @foreach ($section['categories'] as $category)
                                                <option value="{{ $category['id'] }}"
                                                    @if (in_array($category['id'], $selCats)) selected="" @endif>
                                                    {{ $category['categoryName'] }}
                                                </option>
                                                @foreach ($category['subcategories'] as $subcategory)
                                                    <option value="{{ $subcategory['id'] }}"
                                                        @if (in_array($subcategory['id'], $selCats)) selected="" @endif>
                                                        -- {{ $subcategory['categoryName'] }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="users">Select Users</label>
                            <select name="users[]" id="users" class="form-control select2" multiple>
                                <option value="">Select User(s)</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user['email'] }}"
                                        @if (in_array($user['email'], $selUsers)) selected @endif>{{ $user['email'] }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="text" class="form-control" name="expiry_date" id="expiry_date"
                                placeholder="Enter Expiry Date" data-inputmask-alias="datetime"
                                data-inputmask-inputformat="yyyy/mm/dd" data-mask required=""
                                @if (isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @endif>
                        </div>
                    </div>
            </div>

            <style>
                .select2-selection__choice {
                    color: black !important;
                }
            </style>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
            <!-- /.form-group -->
    </div>
    <!-- /.col -->

    <!-- /.row -->

    <!-- /.card-body -->

    <!-- /.card -->
    </section>
    <!-- /.content -->
    </div>
@endsection
