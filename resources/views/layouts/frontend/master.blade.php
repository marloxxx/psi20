<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEO::generate(true) !!}
    <link rel="icon" href="{{ asset('images/' . getSettings('site_favicon')) }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('images/' . getSettings('site_favicon')) }}" type="image/x-icon" />

    <!-- GOOGLE WEB FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Gochi+Hand&amp;family=Montserrat:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="{{ asset('guests/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('guests/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('guests/css/vendors.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}" type="text/css" />

</head>

<body>
    <div id="preloader">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <!-- End Preload -->

    <div class="layer"></div>
    <!-- Mobile menu overlay mask -->

    @include('layouts.frontend.header')

    @yield('content')

    @include('layouts.frontend.footer')
    <div id="toTop"></div><!-- Back to top button -->
    @include('layouts.frontend.script')
</body>

</html>
