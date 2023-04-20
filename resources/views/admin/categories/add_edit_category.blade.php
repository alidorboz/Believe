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
              <li class="breadcrumb-item active">Categories</li>
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
        <form name="categoryForm" id="CategoryForm" @if(empty($categorydata['id'])) action="{{url('admin/add-edit-category')}}" @else action="{{url('admin/add-edit-category/'.$categorydata['id'])}}" @endif method="post"enctype="multipart/form-data">@csrf
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{$title}}</h3>

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
                    <label for="categoryName">Category Name</label>
                    <input type="text" id="categoryName"name="categoryName" placeholder="Enter Category Name"class="form-control"@if(!empty($categorydata['categoryName'])) value="{{$categorydata['categoryName']}}"@else value="{{old('categoryName')}}")@endif>
                </div>
              <div id="appendCategoriesLevel">
                @include('admin.categories.append_categories_level')
              </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Section</label>
                      <select class="form-control select2" name="sid" id="sid" style="width: 100%;">
                        <option value="">Select</option>
                          @foreach($getSections as $s)
                          <option value="{{$s->id}}" @if(!empty($categorydata['sid'])&& $categorydata['sid']==$s->id) selected @endif>{{$s->name}}</option>
                          @endforeach
                      </select>
                </div>
                <div class="form-group">
                  <label for="categoryImage">Category Image</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input"name="categoryImage" id="categoryImage">
                      <label class="custom-file-label"for=" categoryImage ">Choose File</label>
                    </div>
                    <div class="input-group-append">
                      <span class ="input-group-text"id="">Upload</span>
                    </div>
                    @if(!empty($categorydata['categoryImage']))
                      <img src="{{asset('images/category_images/'.$categorydata['categoryImage'])}}">
                    @endif  
                  </div>
               
            
                </div> 
                
                  
                     
                
              </div>                      
              <!-- /.col -->
            </div>
            <!-- /.row -->

          
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="categoryDiscount">Category Discount</label>
                    <input type="text" class="form-control"id="categoryDiscount"name="categoryDiscount"placeholder="Enter Category Discount"@if(!empty($categorydata['categoryDiscount'])) value="{{$categorydata['categoryDiscount']}}"@else value="{{old('categoryDiscount')}}")@endif>
                </div>
                <div class="form-group">
                    <label for="description">Category Description</label>
                    <input type="text" class="form-control"id="description"name="description"placeholder="Enter Category Name"@if(!empty($categorydata['description'])) value="{{$categorydata['description']}}"@else value="{{old('description')}}")@endif>
                </div>
              </div>
              <div class="col-12 col-sm-6">  
                <div class="form-group">
                  <label for="url">Category URL</label>
                  <input type="text" class="form-control"id="url"name="url"placeholder="Enter Category URL"@if(!empty($categorydata['url'])) value="{{$categorydata['url']}}"@else value="{{old('url')}}")@endif>
                </div>
                <div class="form-group">
                  <label for="metaTitle">Meta Title</label>
                  <textarea  class="form-control" id="metaTitle"name="metaTitle"placeholder="Enter Category meta title" rows="3">@if(!empty($categorydata['metaTitle'])) {{$categorydata['metaTitle']}}@else {{old('metaTitle')}})@endif</textarea>
                </div>
              </div>
              <div class="col-12 col-sm-6">  
                <div class="form-group">
                  <label for="metaDescription">Meta Description</label>
                  <textarea  class="form-control" id="metaDescription"name="metaDescription"placeholder="Enter Category meta description"  rows="3">@if(!empty($categorydata['metaDescription'])) {{$categorydata['metaDescription']}}@else value={{old('metaDescription')}})@endif</textarea>
                </div>
              </div> 
              <div class="col-12 col-sm-6">   
                <div class="form-group">
                  <label for="metaKeywords">Meta Keywords</label>
                  <textarea  class="form-control"id="metaKeywords"name="metaKeywords"rows="3"placeholder="Enter Category meta keywords">@if(!empty($categorydata['metaKeywords'])){{$categorydata['metaKeywords']}}@else {{old('metaKeywords')}})@endif</textarea>
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