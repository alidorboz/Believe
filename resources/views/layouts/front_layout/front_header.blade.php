<?php
use App\Models\Section;
$sections = Section::sections();
//echo "<pre>";print_r($sections);die;
?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Winkel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                @foreach ($sections as $section)
                    @if (count($section['categories']) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{ $section['name'] }}</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown04">
                                @foreach ($section['categories'] as $category)
                                    <a class="dropdown-item"
                                        href="{{ url('/' . $category['url']) }}">{{ $category['categoryName'] }}</a>
                                    @foreach ($category['subcategories'] as $subcategory)
                                        <a class="dropdown-item"
                                            href="{{ url('/' . $subcategory['url']) }}">{{ $subcategory['categoryName'] }}</a>
                                    @endforeach
                                @endforeach
                            </div>
                        </li>
                    @endif
                @endforeach

                <li class="nav-item"><a href="{{url('about')}}" class="nav-link">About</a></li>
                <li class="nav-item"><a href="{{ url('orders') }}" class="nav-link">Orders</a></li>
                <li class="nav-item cta cta-colored"><a href="{{ url('cart') }}" class="nav-link">Cart[<span
                            class="totalCartItems">{{ totalCartItems() }}</span>]</a></li>
                @if (Auth::check())
                    <li class="nav-item"><a href="{{ url('account') }}" class="nav-link">My Account</a></li>
                    <li class="nav-item"><a href="{{ url('logout') }}" class="nav-link">LogOut</a></li>
                @else
                    <li class="nav-item"><a href="{{ url('login-register') }}" class="nav-link">Login / Register</a></li>
                @endif
                
             
            </ul>
        </div>
    </div>
</nav>
