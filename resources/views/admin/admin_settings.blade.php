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
                <h3 class="card-title">Update Password</h3>
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
              <!-- form start -->
              <form role="form" method="post"action="{{url('/admin/update-current-pwd')}}"name="updatePasswordForm"id="updatePasswordForm">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Admin E-Mail Address</label>
                    <input  class="form-control" readonly=""value="{{Auth::guard('admin')->user()->email;}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Current Password</label>
                    <input type="password" class="form-control" id="current_pwd" name="current_pwd" placeholder="Enter Current Password" required="">
                    <span id="chkCurrentPwd"></span>
                  </div>
                  <div class="form-group">3
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="Enter new Password" required="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm New Password"required="">
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