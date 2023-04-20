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
                        <h5 class="card-title">Forgot Password?</h5>
                        <br/>
                        Enter Your E-Mail to get the new password.
                        <br/>
                        <p class="card-text"></p>
                        <form id="forgotPasswordForm" action="{{ url('/forgot-password') }}" method="post">@csrf
                            
                            <div class="form-group">
                                <label for="email">E-mail address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email">
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-1"></div>

            
        </div>
    </div>
@endsection
