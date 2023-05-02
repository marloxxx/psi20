<!-- Header================================================== -->
<header>
    <div id="top_line">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <i class="icon-phone"></i>
                    <strong>{{ getSettings('site_phone') }}</strong>
                </div>
                <div class="col-6">
                    <ul id="top_links">
                        @guest
                            <li><a href="">
                                    <i class="icon-login"></i>
                                    Sign in
                                </a>
                            </li>
                        @endguest
                        @auth
                            <li><a href="">
                                    <i class="icon-logout"></i>
                                    {{ auth()->user()->name }}
                                    Sign out</a></li>
                            <li><a href="wishlist.html">
                                    <i class="icon-heart"></i>
                                    Wishlist</a>
                            </li>
                            @role('owner')
                                <li>
                                    <a href="">
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
            <div class="col-3">
                <div id="logo_home"
                    style="background-image: url({{ asset('images/' . getSettings('site_logo')) }}); background-repeat: no-repeat; background-position: center; background-size: contain;">
                    <h1><a href="index-2.html" title="City tours travel template">City Tours travel template</a>
                    </h1>
                </div>
            </div>
            <nav class="col-9">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);">
                    <span>Menu mobile</span></a>
                <div class="main-menu">
                    <div id="header_menu">
                        <img src="{{ asset('images/' . getSettings('site_logo')) }}" width="160" height="34"
                            alt="City tours">
                    </div>
                    <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                    <ul>
                        <li class="submenu">
                            <a href="">Home
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="">Homestays
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="">Events
                            </a>
                        </li>
                    </ul>
                </div><!-- End main-menu -->
            </nav>
        </div>
    </div><!-- container -->
</header><!-- End Header -->
