@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{url('/')}}">Home</a></span> <span>Products</span></p>
                    <h1 class="mb-0 bread">{{ $categoryDetails['catDetails']['categoryName'] }}</h1>
                </div>
            </div>
        </div>
    </div>


    <section class="ftco-section bg-light">
        <div class="container">
            <form name="sortProducts" id="sortProducts" class="row g-3">
                <div class="row g-3">
                    <input type="hidden" name="url" id="url" value="{{$url}}">
                    <div class="col-12 col-md-3">
                        <label class="form-label">Sort By</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <select name="sort" id="sort" class="form-select">
                            <option value="">Select</option>
                            <option value="product_latest" @if (isset($_GET['sort']) && $_GET['sort'] == 'product_latest') selected="" @endif>Latest Products</option>
                            <option value="product_name_a_z" @if (isset($_GET['sort']) && $_GET['sort'] == 'product_name_a_z') selected="" @endif>Product name A - Z</option>
                            <option value="product_name_z_a" @if (isset($_GET['sort']) && $_GET['sort'] == 'product_name_z_a') selected="" @endif>Product name Z - A</option>
                          <?php //  <option value="price_lowest" @if (isset($_GET['sort']) && $_GET['sort'] == 'price_lowest') selected="" @endif>Lowest Price first</option>
                          ?>
                            <option value="price_highest" @if (isset($_GET['sort']) && $_GET['sort'] == 'price_highest') selected="" @endif>Highest Price first</option>
                            <option value="discounted_price" @if(isset($_GET['sort']) && $_GET['sort'] == 'discounted_price') selected @endif>Lowest Price first</option>


                        </select>
                    </div>
                </div>
            </form>@include('front.Products.ajax_products_listing')
            <div class="row">
                <div class="col-md-8 col-lg-10 order-md-last">
                   
                    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                                @if (isset($_GET['sort']) && !empty($_GET['sort']))
                                    {{ $categoryProducts->appends(['sort' => $_GET['sort']])->links() }}
                                @else
                                    {{ $categoryProducts->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        </div>
    </section>
    <style>
        select {
            font-size: 16px;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: none;
            outline: none;
            margin-bottom: 20px;
        }
    </style>
    
@endsection
