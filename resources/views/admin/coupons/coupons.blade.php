@extends('layouts.admin_layout.admin_layout')
@section('content')



    <div class="content-wrapper">
        <section class="control-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catalogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success_message'))
                        <div class="alert alert-success alert-dismissable fade show " role="alert"
                            style="margin-top:10px;">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Coupons</h3>
                            <a href="{{ url('admin/add-edit-coupon') }}"
                                style="max-width: 150px; float:right;
                        display: inline-block;"
                                class="btn btn-block btn-success">Add Coupon</a>
                        </div>
                        <div class="card-body">
                            <table id="coupons" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Code</th>
                                        <th>Coupon Type</th>
                                        <th>Amount</th>
                                        <th>Expiry Date</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon['id'] }}</td>
                                            <td>{{ $coupon['coupon_code'] }}</td>
                                            <td>{{ $coupon['coupon_type'] }}</td>
                                            <td>{{ $coupon['amount'] }}
                                                @if ($coupon['amount_type'] == 'Percentage')
                                                    %
                                                @else
                                                    TND
                                                @endif

                                            </td>
                                            <td>{{ $coupon['expiry_date'] }}</td>
                                            <td>
                                                <a
                                                    title="Edit Coupon"href="{{ url('admin/add-edit-coupon/' . $coupon['id']) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                &nbsp;&nbsp;
                                                <a title="Delete Coupon" href="javascript:void(0)" class="confirmDelete"
                                                    data-record="coupon" data-recordid="{{ $coupon['id'] }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                &nbsp;&nbsp;
                                                @if ($coupon['status'] == 1)
                                                    <a class="updateCouponStatus"
                                                        id="coupon-{{ $coupon['id'] }}"coupon_id="{{ $coupon['id'] }}"href="javascript:void(0)">Active</a>
                                                @else
                                                    <a class="updateCouponStatus"
                                                        id="coupon-{{ $coupon['id'] }}"coupon_id="{{ $coupon['id'] }}"href="javascript:void(0)">InActive</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
