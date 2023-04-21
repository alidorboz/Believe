@extends('layouts.front_layout.front_layout')

@section('content')
<section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                style="background-image:url(images/front_images/believe.png); width: 475px; height: 250px;">
                <!-- Set width and height to actual size of logo image -->
            </div>
            <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                <div class="heading-section-bold mb-4 mt-md-5">
                    <div class="ml-md-0">
                        <h2 class="mb-4">Believe</h2>
                    </div>
                </div>
                <div class="pb-md-5">
                    <p>Believe is not a T-Shirt or a hoodie, Believe is a mindset and a lifestyle. Founded By ambitious
                        young people with a hunger of a success, we aim to implement the strong drive for greatness and
                        to motivate others to believe in themselves and go after their dreams
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


    <style>
        p {
            font-size: 18px;
            /* Adjust this value to make the paragraph size bigger or smaller */
        }
    </style>





<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <h2 class="mb-4">Our Team</h2>
                <p>Meet the amazing people who made Believe possible</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 ftco-animate">
                <div class="testimony-wrap p-4 pb-5">
                    <div class="user-img mb-5" style="background-image:url(images/front_images/seif.gif); border-radius: 50%; width: 200px; height: 200px;"></div>
                    <div class="text">
                        <p class="name">Seif Eddine JLIDI</p>
                        <span class="position">CEO of Believe</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="testimony-wrap p-4 pb-5">
                    <div class="user-img mb-5" style="background-image:url(images/front_images/ali.jpg); border-radius: 50%; width: 200px; height: 200px;"></div>
                    <div class="text">
                        <p class="name">Ali DORBOZ</p>
                        <span class="position">CTO of Believe</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ftco-animate">
                <div class="testimony-wrap p-4 pb-5">
                    <div class="user-img mb-5" style="background-image:url(images/front_images/anas.jpg); border-radius: 50%; width: 200px; height: 200px;"></div>
                    <div class="text">
                        <p class="name">Anas LABYEDH</p>
                        <span class="position">Photographer of Believe</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



    <hr>

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
                                        <input type="text" class="form-control" placeholder="Enter email address">
                                        <input type="submit" value="Subscribe" class="submit px-3">
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
