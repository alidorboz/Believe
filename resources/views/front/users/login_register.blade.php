@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Login</li>
        </ul>
        @if (Session::has('success_message'))
            <div class='alert alert-success' role='alert'>
                {{ Session::get('success_message') }}
                <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                    <spana aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif
        @if (Session::has('error_message'))
            <div class='alert alert-danger' role='alert'>
                {{ Session::get('error_message') }}
                <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                    <spana aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">CREATE YOUR ACCOUNT</h5>
                        <p class="card-text"></p>
                        <form id="registerForm" action="{{ url('/register') }}" method="post">@csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile">
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Create Your Account</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-5">
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h5 class="card-title">ALREADY REGISTERED ?</h5>
                        <form id="loginForm" action="{{ url('/login') }}" method="post">@csrf
                            <div class="form-group">
                                <label for="email">E-mail address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                            <a href="{{url('forgot-password')}}" class="ml-2">Forgot password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
