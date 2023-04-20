@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">My Account</li>
        </ul>
        @if (Session::has('success_message'))
            <div class='alert alert-success' role='alert'>
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::has('error_message'))
            <div class='alert alert-danger' role='alert'>
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">MY ACCOUNT</h5>
                        <p class="card-text"></p>
                        <form id="accountForm" action="{{ url('/account') }}" method="post">@csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value={{$userDetails['name']}} pattern="[A-Za-z]+">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Enter Address"value={{$userDetails['address']}}>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    placeholder="Enter City"value={{$userDetails['city']}}>
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" id="pincode" name="pincode"
                                    placeholder="Enter Pincode"value={{$userDetails['pincode']}}>
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile"value={{$userDetails['mobile']}}>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail address</label>
                                <input type="email" class="form-control" id="email" name="email" readonly=""value={{$userDetails['email']}}>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-5">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">UPDATE PASSWORD</h5>
                        <form id="passwordForm" action="{{ url('/update-password') }}" method="post">@csrf
                            
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                placeholder="Enter Current Password">
                                 <span id="chkPwd"></span>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Enter New Password">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Confirm New Password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
