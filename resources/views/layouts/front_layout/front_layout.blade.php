<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Winkel - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token"content="{{csrf_token()}}"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="{{url('css/front_css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/animate.css')}}">
    
    <link rel="stylesheet" href="{{url('css/front_css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{url('css/front_css/aos.css')}}">

    <link rel="stylesheet" href="{{url('css/front_css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{url('css/front_css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/jquery.timepicker.css')}}">

    
    <link rel="stylesheet"  href="{{url('css/front_css/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/icomoon.css')}}">
    <link rel="stylesheet" href="{{url('css/front_css/style.css')}}">
    <style>
      form.cmxform label.error, label.error {
        color:red;
        font-style: italic
      }
    </style>
  </head>
  <body class="goto-here">
	@include('layouts.front_layout.front_header')
    @yield('content')

    @include('layouts.front_layout.front_footer')
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{url('js/front_js/jquery.min.js')}}"></script>
  <script src="{{url('js/front_js/front_script.js')}}"></script>
  <script src="{{url('js/front_js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{url('js/front_js/popper.min.js')}}"></script>
  <script src="{{url('js/front_js/bootstrap.min.js')}}"></script>
  <script src="{{url('js/front_js/jquery.easing.1.3.js')}}"></script>
  <script src="{{url('js/front_js/jquery.waypoints.min.js')}}"></script>
  <script src="{{url('js/front_js/jquery.stellar.min.js')}}"></script>
  <script src="{{url('js/front_js/owl.carousel.min.js')}}"></script>
  <script src="{{url('js/front_js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{url('js/front_js/aos.js')}}"></script>
  <script src="{{url('js/front_js/jquery.animateNumber.min.js')}}"></script>
  <script src="{{url('js/front_js/bootstrap-datepicker.js')}}"></script>
  <script src="{{url('js/front_js/scrollax.min.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{url('js/front_js/google-map.js')}}"></script>
  <script src="{{url('js/front_js/main.js')}}"></script>
  <script src="{{url('js/front_js/jquery.validate.min.js')}}"></script>
  

  </body>
</html>