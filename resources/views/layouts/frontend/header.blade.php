<style>
    @media (max-width: 767px) {
        #logo_home {
            display: none;
        }

        .py-10 {
            padding-top: 0 !important;
            padding-bottom: 25px !important;
        }

        #notification {
            display: none;
        }
    }

    @media (min-width: 768px) {
        .last {
            float: right !important;
        }

        #top_tools {
            display: none;
        }

    }
</style>
<header id="plain">
    <div class="container py-10">
        <div class="row">
            <div class="col-2">
                <div id="logo_home"
                    style="background-image: url({{ asset('images/' . getSettings('site_logo')) }}); background-repeat: no-repeat; background-position: center; background-size: contain;">
                    <h1><a href="{{ route('home') }}" title="City tours travel template">City Tours travel template</a>
                    </h1>
                </div>
            </div>
            <nav class="col-10">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);">
                    <span>Menu mobile</span>
                </a>
                <div class="main-menu">
                    <div id="header_menu">
                        <img src="{{ asset('images/' . getSettings('site_logo')) }}" alt="City tours">
                    </div>
                    <a href="#" class="open_close" id="close_in">
                        <i class="icon_set_1_icon-77"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('homestays') }}">Homestays
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('events') }}">Events
                            </a>
                        </li>
                        <!-- show if device is mobile -->
                        @guest
                            <li class="last">
                                <a href="{{ route('index') }}">
                                    <i class="icon-login"></i>
                                    Sign in
                                </a>
                            </li>
                        @endguest
                        @auth
                            <li class="last">
                                <a href="{{ route('logout') }}">
                                    <i class="icon-logout"></i>
                                    {{ auth()->user()->first_name }}
                                    Sign out
                                </a>
                            </li>
                            <li class="last">
                                <a href="{{ route('profile.index') }}">
                                    <i class="icon-user"></i>
                                    My Profile
                                </a>
                            </li>
                            @role('owner')
                                <li class="last">
                                    <a href="{{ route('backend.dashboard') }}">
                                        <i class="icon-home"></i>
                                        Dashboard Owner</a>
                                </li>
                            @endrole
                            @auth
                                <li class="last" id="notification">
                                    <!-- dropdown notification -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                        onmouseover="load_notif('{{ route('notification') }}');"><i class="icon-bell"></i>
                                        Notification
                                        <span class="badge badge-pill badge-danger count top-notification-number"
                                            id="top-notification-number"></span>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="notification_header">
                                                <h3>You have <span class="count"></span> new notification</h3>
                                            </div>
                                        </li>
                                        <div class="notification_body" id="notification_items">

                                        </div>
                                    </ul>
                                </li>
                            @endauth
                        @endauth
                    </ul>
                </div><!-- End main-menu -->
                <ul id="top_tools">
                    @auth
                        <li class="me-3">
                            <!-- notification -->
                            <!-- show modal notification -->
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#modal-notification"
                                onclick="load_notif('{{ route('notification') }}');">
                                <i class="icon-bell"></i>
                                <span class="badge badge-pill badge-danger top-notification-number"
                                    id="top-notification-number"></span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </div><!-- container -->
</header>
