<header id="plain">
    <div id="top_line">
        <div class="container">
            <div class="row">
                <div class="col-6"><i class="icon-phone"></i>
                    <strong>+{{ getSettings('site_phone') }}</strong>
                </div>
                <div class="col-6">
                    <ul id="top_links">
                        @guest
                            <li><a href="{{ route('index') }}">
                                    <i class="icon-login"></i>
                                    Sign in
                                </a>
                            </li>
                        @endguest
                        @auth
                            <li>
                                <a href="{{ route('logout') }}">
                                    <i class="icon-logout"></i>
                                    {{ auth()->user()->first_name }}
                                    Sign out
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.index') }}">
                                    <i class="icon-user"></i>
                                    My Profile
                                </a>
                            </li>
                            @role('owner')
                                <li>
                                    <a href="{{ route('backend.dashboard') }}">
                                        <i class="icon-home"></i>
                                        Dashboard Owner</a>
                                </li>
                            @endrole
                        @endauth
                    </ul>
                </div>
            </div><!-- End row -->
        </div><!-- End container-->
    </div><!-- End top line-->

    <div class="container">
        <div class="row">
            <div class="col-2">
                <div id="logo_home"
                    style="background-image: url({{ asset('images/' . getSettings('site_logo')) }}); background-repeat: no-repeat; background-position: center; background-size: contain;">
                    <h1><a href="{{ route('home') }}" title="City tours travel template">City Tours travel template</a>
                    </h1>
                </div>
            </div>
            <nav class="col-8">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);">
                    <span>Menu mobile</span></a>
                <div class="main-menu d-flex justify-content-between">
                    <div id="header_menu">
                        <img src="{{ asset('images/' . getSettings('site_logo')) }}" width="160" height="34"
                            alt="City tours">
                    </div>
                    <a href="#" class="open_close" id="close_in">
                        <i class="icon_set_1_icon-77"></i>
                    </a>
                    <ul>
                        <li class="submenu">
                            <a href="{{ route('home') }}">Home
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="{{ route('homestays') }}">Homestays
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="{{ route('events') }}">Events
                            </a>
                        </li>
                    </ul>
                </div><!-- End main-menu -->
            </nav>
        </div>
    </div><!-- container -->
</header>
