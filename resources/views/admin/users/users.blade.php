@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
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
                                <h3 class="card-title">Users </h3>
                                <table align="right">
                                    <tr>
                                        <td>
                                            <a href="{{('admin/add-edit-user')}}" style="max-width: 150px;float:right;display:inline-block;"class="btn btn-block btn-success">Add USER</a>
                                        </td>
                                        <td>
                                            <a href="{{url('admin/export-users')}}"style="max-width: 150px;float:right;display:inline-block;" class="btn btn-primary btn-mini">Export Users</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="users" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Postal Code</th>
                                            <th>Mobile</th>
                                            <th>E-Mail</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->address }}</td>
                                                <td>{{ $user->city }}</td>
                                                <td>{{ $user->pincode }}</td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td> 
                                                    @if ($user->status == 1)
                                                        <a class="updateUserStatus"
                                                            id="user-{{ $user['id'] }}"user_id="{{ $user['id'] }}"href="javascript:void(0)">Active</a>
                                                    @else
                                                        <a class="updateUserStatus"
                                                            id="user-{{ $user['id'] }}"user_id="{{ $user['id'] }}"href="javascript:void(0)">InActive</a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
