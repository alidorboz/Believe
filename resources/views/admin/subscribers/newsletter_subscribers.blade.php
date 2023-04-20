@extends('layouts.admin_layout.admin_layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Newsletter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Newsletter Subscriber</li>
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


                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Newsletter Subscribers</h3>
                               
                            
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="newsletter_subscribers" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>E-Mail</th>
                                            <th>Subscribed on</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($newsletter_subscribers as $subscriber)
                                            <tr>
                                                <td>{{ $subscriber['id'] }}</td>
                                                <td>{{ $subscriber['email'] }}</td>
                                                <td>{{ $subscriber['created_at'] }}</td>

                                                <td>
                                                    @if ($subscriber['status'] == 1)
                                                        <a class="updateSubscriberStatus"
                                                            id="subscriber-{{ $subscriber['id'] }}"subscriber_id="{{ $subscriber['id'] }}"href="javascript:void(0)">Active</a>
                                                    @else
                                                        <a class="updateSubscriberStatus"
                                                            id="subscriber-{{ $subscriber['id'] }}"subscriber_id="{{ $subscriber['id'] }}"href="javascript:void(0)">InActive</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="confirmDelete"name="Subscriber"href="{{ url('admin/delete-subscriber/' . $subscriber['id']) }}"record="subscriber"
                                                        recordid="{{ $subscriber['id'] }}">Delete</a>
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
