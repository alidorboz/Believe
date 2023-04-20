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
                            <li class="breadcrumb-item active">Banners</li>
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
                <form name="bannerForm" id="BannerForm"
                    @if (empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}" @else action="{{ url('admin/add-edit-banner/' . $banner['id']) }}" @endif
                    method="post"enctype="multipart/form-data">@csrf
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
                                
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                        <label for="image">Banner Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input"name="image"
                                                    id="image">
                                                <label class="custom-file-label"for=" image ">Choose File</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                        @if (!empty($bannerdata['image']))
                                            <div>
                                                <img style="width:80px;margin-top:5px;"
                                                    src="{{ asset('images/banner_images/small/' . $banner['image']) }}">&nbps
                                                <a
                                                    class="confirmDelete"href="javascript:void(0)"record="banner-image"record-id="{{ $banner['id'] }}">Delete
                                                    Image</a>
                                            </div>
                                        @endif
                                        <div>
                                            Recommanded Image Size: Width:1040px,Height:1200px
                                        </div>

                                    </div>




                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->


                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="link">Banner Link</label>
                                    <input type="text"
                                        class="form-control"id="link"name="link"placeholder="Enter Link"@if (!empty($banner['link'])) value="{{ $banner['link'] }}"@else value="{{ old('link') }}") @endif>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="alt">Alt Text</label>
                                    <input type="text" class="form-control" id="alt" name="alt" value="{{ $banner['alt'] ?? '' }}" placeholder="Enter alt text">
                                </div>
                                
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="alt">Banner Title</label>
                                    <input type="text"
                                        class="form-control"id="title"name="title"placeholder="Enter Title"@if (!empty($banner['title'])) value="{{ $banner['title'] }}"@else value="{{ old('title') }}") @endif>
                                </div>
                            </div>
                            
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
            </form>
            <!-- /.card -->
    </div>

    </section>
    <!-- /.content -->
    </div>


@endsection
