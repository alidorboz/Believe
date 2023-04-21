@extends('layouts.front_layout.front_layout')
@section('content')
    <?php use App\Models\Banner;
    $getBanners = Banner::getBanners();
    use App\Models\Product ;
    ?>
    <section id="home-section" class="hero">
        <div class="home-slider js-fullheight owl-carousel">
            <div class="slider-item js-fullheight">
                <div class="overlay"></div>
                @foreach ($getBanners as $key => $banner)
                    <div class="container-fluid p-0">
                        <div class="row d-md-flex no-gutters slider-text js-fullheight align-items-center justify-content-end"
                            data-scrollax-parent="true">
                            <div class="one-third order-md-last img js-fullheight"
                                style="background-image:url(images/banner_images/banner1.jpg);">
                            </div>
                            <div class="one-forth d-flex js-fullheight align-items-center ftco-animate"
                                data-scrollax=" properties: { translateY: '70%' }">
                                <div class="text">
                                    <span class="subheading">Winkel eCommerce Shop</span>
                                    <div class="horizontal">
                                        <h3 class="vr" style="background-image: url(images/front_images/divider.jpg);">
                                            Stablished Since 2000</h3>
                                        <h1 class="mb-4 mt-3">Catch Your Own <br><span>Stylish &amp; Look</span></h1>
                                        <p>A small river named Duden flows by their place and supplies it with the necessary
                                            regelialia. It is a paradisematic country.</p>

                                        <p><a href="#lproducts" class="btn btn-primary px-5 py-3 mt-3">Discover Now</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Our Best Sellers</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                </div>
            </div>
            <div class="row">
                @foreach ($featuredItemsChunk as $key => $featuredItem)
                    @foreach ($featuredItem as $item)
                        <div class="col-md-4 ftco-animate">
                            <div class="product">
                                <a href="{{url('product/'.$item['id'])}}">
                                    <?php $product_image_path = 'images/product_images/small/' . $item['main_image']; ?>
                                    @if (!empty($item['main_image']) && file_exists($product_image_path))
                                        <img src="{{ asset('images/product_images/small/' . $item['main_image']) }}"
                                            alt="" style="display: block; margin: 0 auto;">
                                    @endif
                                </a>
                                <div class="text py-3 px-3">
                                    <h3><a href="{{url('product/'.$item['id'])}}">{{ $item['product_name'] }}</a></h3>
                                    <h6><i class="fas fa-barcode"></i> {{ $item['product_code'] }}</h6>
                                    <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                                    <div class="d-flex">
                                        <p class="price">
                                            @if($discounted_price > 0)
                                                <span class="mr-2 price-dc">{{ $item['product_price'] }} TND</span>
                                                <span class="price-sale">{{ $discounted_price }} TND</span>
                                            @else
                                                <span class="price-sale">{{ $item['product_price'] }} TND</span>
                                            @endif
                                        </p>
                                    </div>
                                    <p class="bottom-area d-flex px-3">
                                        <a href="{{url('product/'.$item['id'])}}" class="add-to-cart text-center py-2 mr-1"><i class="fas fa-eye"></i>View</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    








    <section class="ftco-section ftco-choose ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-8 d-flex align-items-stretch">
                    <div class="img" style="background-image: url(images/front_images/about-1.jpg);"></div>
                </div>
                <div class="col-md-4 py-md-5 ftco-animate">
                    <div class="text py-3 py-md-5">
                        <h2 class="mb-4">New Women's Clothing Summer Collection 2019</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                            live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics,
                            a large language ocean.</p>
                        <p><a href="#lproducts" class="btn btn-white px-4 py-3">Shop now</a></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 order-md-last d-flex align-items-stretch">
                    <div class="img img-2" style="background-image: url(images/front_images/about-2.jpg);"></div>
                </div>
                <div class="col-md-7 py-3 py-md-5 ftco-animate">
                    <div class="text text-2 py-md-5">
                        <h2 class="mb-4">New Men's Clothing Summer Collection 2019</h2>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                            live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics,
                            a large language ocean.</p>
                        <p><a href="#lproducts" class="btn btn-white px-4 py-3">Shop now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section bg-light" id="lproducts">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Our Latest Products</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                </div>
            </div>
            <div class="row">
                @foreach ($newProducts as $product)
                    <div class="col-sm-4 ftco-animate">
                        <div class="product">
                            <a href="{{url('product/'.$product['id'])}}">
                                <?php $product_image_path = 'images/product_images/small/' . $product['main_image']; ?>
                                @if (!empty($product['main_image']) && file_exists($product_image_path))
                                    <img src="{{ asset('images/product_images/small/' . $product['main_image']) }}"
                                        alt="" style="display: block; margin: 0 auto;">
                                @endif
                            </a>
                            <div class="text py-3 px-3">
                                <h3><a href="{{url('product/'.$product['id'])}}">{{ $product['product_name'] }}</a></h3>
                                <h6><a href="{{url('product/'.$product['id'])}}">{{ $product['product_code'] }}</a></h6>
                                <?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
        
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price">
                                            @if($discounted_price > 0)
                                                <span class="mr-2 price-dc">{{ $product['product_price'] }} TND</span>
                                                <span class="price-sale">{{ $discounted_price }} TND</span>
                                            @else
                                                <span class="price-sale">{{ $product['product_price'] }} TND</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <p class="bottom-area d-flex px-3">
                                    <a href="{{url('product/'.$product['id'])}}" class="add-to-cart text-center py-2 mr-1"><span><i class="fas fa-eye"></i> View</span></a>
        
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </section>
    




    <?php
    /*  <section class="ftco-section ftco-counter img" id="section-counter"
        style="background-image: url(images/front_images/bg_4.jpg);">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="10000">0</strong>
                                    <span>Happy Customers</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="100">0</strong>
                                    <span>Branches</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="1000">0</strong>
                                    <span>Partner</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="100">0</strong>
                                    <span>Awards</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section testimony-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section ftco-animate">
                    <h2 class="mb-4">Our satisfied customer says</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                        the blind texts. Separated they live in</p>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12">
                    <div class="carousel-testimony owl-carousel">
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5"
                                    style="background-image: url(images/front_images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <p class="name">Garreth Smith</p>
                                    <span class="position">Marketing Manager</span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5"
                                    style="background-image: url(images/front_images/person_2.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <p class="name">Garreth Smith</p>
                                    <span class="position">Interface Designer</span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5"
                                    style="background-image: url(images/front_images/person_3.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <p class="name">Garreth Smith</p>
                                    <span class="position">UI Designer</span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5"
                                    style="background-image: url(images/front_images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <p class="name">Garreth Smith</p>
                                    <span class="position">Web Developer</span>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5"
                                    style="background-image: url(images/front_images/person_1.jpg)">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-5 pl-4 line">Far far away, behind the word mountains, far from the
                                        countries Vokalia and Consonantia, there live the blind texts.</p>
                                    <p class="name">Garreth Smith</p>
                                    <span class="position">System Analyst</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>
*/
    ?>
    <section class="ftco-section-parallax">
        <div class="parallax-img d-flex align-items-center">
            <div class="container">
                <div class="row d-flex justify-content-center py-5">
                    <div class="col-md-7 text-center heading-section ftco-animate">
                        <h2>Subcribe to our Newsletter</h2>
                        <div class="row d-flex justify-content-center mt-5">
                            <div class="col-md-8">
                                <form action="#" class="subscribe-form">
                                    <div class="form-group d-flex">
                                        <input type="email" class="form-control" placeholder="Enter email address"name="subscriber_email"id="subscriber_email"required="">
                                        <input type="submit" value="Subscribe" class="submit px-3"onclick="addSubscriber();">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
