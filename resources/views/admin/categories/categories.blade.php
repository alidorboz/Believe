@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
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
          @if(Session::has('success_message'))
                <div class='alert alert-success alert-dismissable fade show' role='alert'>
                  {{Session::get('success_message')}}
                  <button type="button" class="close"data-dismiss="alert" aria-label="Close">
                    <spana aria-hidden="true">&times;</span>
                  </button>

                </div>
              @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
                <a href="{{url('admin/add-edit-category')}}"class="btn btn-block btn-success" style="max-width:150px;float:right;display:inline-block;">Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="Categories" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Section</th>
                    <th>Parent Category</th>
                    <th>Category</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Actions</th>
                   
                  </tr>
                  </thead>
                  <tbody>
                      @foreach($categories as $c)
                      @if(!isset($c->parentcategory->categoryName))
                        <?php $pid = "Root"; ?>
                      @else
                        <?php $pid = $c->parentcategory->categoryName;?>
                      @endif
                  <tr>
                    <td>{{$c->id}}</td>
                    <td>{{$c->section->name}}</td>
                    <td>{{$pid}}</td>
                    <td>{{$c->categoryName}}
                    </td>
                    <td>{{$c->url}}
                    </td>
                    <td>@if ($c->status ==1)
                        <a class="updatecategoryStatus" id="c-{{$c->id}}"c_id="{{$c->id}}"href="javascript:void(0)">Active</a>
                        @else
                        <a class="updatecategoryStatus" id="c-{{$c->id}}"c_id="{{$c->id}}"href="javascript:void(0)">InActive</a>

                        @endif
                    </td>
                    <td><a href="{{ url('admin/add-edit-category/'.$c->id)}}">Edit</a></td>
                    &nbsp;&nbsp;
                    <td><a class="confirmDelete"name="Category"href="{{ url('admin/delete-category/'.$c->id)}}">Delete</a></td>
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