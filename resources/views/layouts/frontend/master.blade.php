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
    <script src="https://kit.fontawesome.com/07ad57e463.js" crossorigin="anonymous"></script>
    <!-- GOOGLE WEB FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Gochi+Hand&amp;family=Montserrat:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/vendors.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}" type="text/css" />
    <style>
        .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 10px;
            border-radius: 50%;
            background: red;
            color: white;
        }

        .notification {
            position: relative;
        }

        .notification .dropdown-menu {
            width: 320px;
            padding: 0;
            margin: 0;
            border-radius: 0;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .notification .dropdown-menu:before {
            content: "";
            position: absolute;
            top: -20px;
            right: 10px;
            border: 10px solid transparent;
            border-bottom: 10px solid #f5f5f5;
        }

        .notification_header {
            padding: 15px;
            text-align: center;
            background: #f5f5f5;
        }

        .notification_header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .notification_body {
            max-height: 250px;
            width: 320px;
            overflow-y: auto;
        }

        .notification_item {
            padding: 15px;
            border-bottom: 1px solid #f5f5f5;
        }

        .notification_item:last-child {
            border-bottom: none;
        }

        .notification_item .icon {
            float: left;
            margin-right: 10px;
        }

        .notification_item .text {
            overflow: hidden;
        }

        .notification_item .text small {
            color: #999;
        }

        .notification_footer {
            padding: 15px;
            text-align: center;
            background: #f5f5f5;
        }

        .notification_footer a {
            color: #333;
            font-weight: bold;
        }

        .notification_footer a:hover {
            text-decoration: underline;
        }
    </style>
    @stack('custom-styles')
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
    <!-- modal notification -->
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-notification">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="notification_body notification_items" id="notification_items">

                    </div>
                </div>
            </div>
        </div>
        <!-- modal content goes here -->
    </div>
    <div id="toTop"></div><!-- Back to top button -->
    @include('layouts.frontend.script')
    @stack('custom-scripts')
</body>

</html>
