<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Swopers</title>
        <!-- favicon icon -->
        <link rel="shortcut icon" href="{{asset('assets/front/images/favicon.ico')}}" />
        <!-- inject css start -->
    @if (request()->segment(1) !== 'admin' && request()->segment(2) !== 'admin' && request()->segment(3) !== 'admin')
        <!--== theme plugin -->
        <link href="{{asset('assets/front/css/theme-plugin.css')}}" rel="stylesheet" type="text/css" />

        <!--== style -->
        <link href="{{asset('assets/front/css/style.css')}}" rel="stylesheet" type="text/css" />

        <!--== responsive -->
        <link href="{{asset('assets/front/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <!-- inject css end -->
    @else
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
         <link rel="stylesheet" href="{{asset('assets/admin/css/admin.css')}}"/>
    @endif
</head>
<body class="nav-md">


<div id="app">
   <!-- preloader start -->
   <div id="ht-preloader">
       <div class="clear-loader">
           <div class="loader"></div>
       </div>
   </div>
   <!-- preloader end -->

   <div class="mouse-cursor cursor-outer"></div>
   <div class="mouse-cursor cursor-inner"></div>

   <input id="asset" type="hidden" value="{{asset('')}}" />
    @if (request()->segment(1) === 'admin' || request()->segment(2) === 'admin' || request()->segment(3) === 'admin')
        <div class="container body" >
            <div class="main_container">
    @endif
    <app asset="{{asset('')}}"></app>
    @if (request()->segment(1) === 'admin' || request()->segment(2) === 'admin' || request()->segment(3) === 'admin')
        </div>
        </div>
    @endif

<!--back-to-top start-->

<div class="scroll-top"><a class="smoothscroll" href="#top"><i class="fas fa-chevron-up"></i></a></div>

<!--back-to-top end-->
</div>

<script src="{{asset('js/app.js')}}"></script>
<!-- inject js start -->
    @if (request()->segment(1) === 'admin' || request()->segment(2) === 'admin' || request()->segment(3) === 'admin')

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/admin/js/custom.js')}}"></script>

    @else

        <!--== jquery -->
        <script src="{{asset('assets/front/js/theme.js')}}"></script>
        <!--== jquery-ui -->
        <script src="{{asset('assets/front/js/jquery-ui.js')}}"></script>
        <!--== owl-carousel -->
        <script src="{{asset('assets/front/js/owl-carousel/owl.carousel.min.js')}}"></script>
        <!--== contact-form -->
        <script src="{{asset('assets/front/js/contact-form/contact-form.js')}}"></script>
        <!--== wow -->
        <script src="{{asset('assets/front/js/wow.min.js')}}"></script>
        <!--== theme-script -->
        <script src="{{asset('assets/front/js/theme-script.js')}}"></script>
        <!-- inject js end -->

    @endif

</body>
</html>
