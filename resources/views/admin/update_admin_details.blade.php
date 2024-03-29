  @extends('layouts.admin_layout.admin_layout')
  @section('content')  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Admin Details</h3>
              </div>
              <!-- /.card-header -->
              @if(Session::has('error_message'))
                <div class='alert alert-danger alert-dismissable fade show' role='alert'>
                  {{Session::get('error_message')}}
                  <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                </div>
              @endif
              @if(Session::has('success_message'))
                <div class='alert alert-success alert-dismissable fade show' role='alert'>
                  {{Session::get('success_message')}}
                  <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                </div>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

              
              @endif
              <!-- form start -->
              <form role="form" method="post"action="{{url('/admin/update-admin-details')}}"name="updateAdminDetails"id="updateAdminDetails"enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Admin E-Mail Address</label>
                    <input  class="form-control" readonly=""value="{{Auth::guard('admin')->user()->email;}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Enter Admin's Name" value="{{Auth::guard('admin')->user()->name;}}" required="">
                    <span id="chkCurrentPwd"></span>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" class="form-control" id="admin_mobile" name="admin_mobile" placeholder="Enter Admin's Phone Number" required=""value="{{Auth::guard('admin')->user()->mobile;}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Image</label>
                    <input type="file" class="form-control" id="admin_image" name="admin_image" placeholder="Confirm New Password"accept="images/*">
                    @if(!empty(Auth::guard('admin')->user()->image))
                      <a target="_blank" href="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}">View Image </a>
                      <input type="hidden" name="current_admin_image"value="{{Auth::guard('admin')->user()->image}}">
                    @endif
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
            <!-- Form Element sizes -->
    
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection