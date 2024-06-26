@extends('layouts.frontend.master')
@push('custom-styles')
    <!-- REVOLUTION SLIDER CSS -->
    <link href="{{ asset('frontend/rs-plugin/css/settings.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/extralayers.css') }}" rel="stylesheet">
@endpush
@section('content')
    <main>
        <div id="carousel-home">
            <div class="owl-carousel owl-theme">
                <div class="owl-slide cover"
                    style="background-image: url({{ asset('frontend/img/slides/slide_home_3.jpg') }});">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-start">
                                <div class="col-lg-12 static">
                                    <div class="slide-text text-center white">
                                        <h2 class="owl-slide-animated owl-slide-title">Escape to the Serenity<br>of Lake
                                            Toba
                                        </h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Book Your Dream Homestay with Tobatabo Stay Web App Today!
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta">
                                            <a class="btn_1" href="{{ route('homestays') }}" role="button">Book Now!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
                <div class="owl-slide cover"
                    style="background-image: url({{ asset('frontend/img/slides/slide_home_2.jpg') }});">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-end">
                                <div class="col-lg-6 static">
                                    <div class="slide-text text-end white">
                                        <h2 class="owl-slide-animated owl-slide-title">Unwind in Paradise<br>at Captivating
                                            Lake Toba</h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Embark on Your Perfect Getaway with Tobatabo Retreats
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta"><a class="btn_1"
                                                href="{{ route('homestays') }}" role="button">Book Now!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
                <div class="owl-slide cover"
                    style="background-image: url({{ asset('frontend/img/slides/slide_home_1.jpg') }});">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-start">
                                <div class="col-lg-6 static">
                                    <div class="slide-text white">
                                        <h2 class="owl-slide-animated owl-slide-title">Discover Tranquility<br>at Stunning
                                            Lake Toba</h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Experience the Beauty with Tobatabo Homestay Reservation Agency
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta"><a class="btn_1"
                                                href="{{ route('homestays') }}" role="button">Book Now!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
            </div>
            <div id="icon_drag_mobile"></div>
        </div>
        <!--/carousel-->

        <div class="container margin_60">

            <div class="main_title">
                <h2>Homestays <span>terbaik</span> di Balige</h2>
                <p>Temukan homestay terbaik di Balige</p>
            </div>

            <div class="owl-carousel owl-theme list_carousel add_bottom_30">
                @foreach ($popular_homestays as $popular)
                    <div class="item">
                        <div class="hotel_container">
                            <div class="ribbon_3 popular"><span>Populer</span></div>
                            <div class="img_container">
                                <a href="{{ route('homestays.show', $popular->id) }}">
                                    <img src="{{ asset($popular->images->first()->image_path) }}" width="800"
                                        height="533" class="img-fluid" alt="image">
                                    <div class="short_info">
                                        <span class="price"><sup>Rp.
                                            </sup>{{ number_format($popular->price_per_night) }}</span>
                                    </div>
                                </a>
                            </div>
                            <div class="hotel_title">
                                <h3><strong>{{ $popular->name }}</strong> </h3>
                                <div class="rating">
                                    @for ($i = 0; $i < $popular->rating; $i++)
                                        <i class="icon-star voted"></i>
                                    @endfor
                                    @for ($i = 0; $i < 5 - $popular->rating; $i++)
                                        <i class="icon-star-empty"></i>
                                    @endfor
                                </div>
                                <!-- end rating -->
                                @auth
                                    <div
                                        class="{{ auth()->user()->wishlists->contains($popular->id)? 'wishlist': 'wishlist_close' }} position-absolute">
                                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"
                                            onclick="toggleWishlist({{ $popular->id }})">
                                            {{ auth()->user()->wishlists->contains($popular->id)? '-': '+' }}
                                            <span class="tooltip-content-flip">
                                                <span class="tooltip-back">
                                                    {{ auth()->user()->wishlists->contains($popular->id)? 'Remove from wishlist': 'Add to wishlist' }}
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                @endauth
                                <!-- End wish list-->
                            </div>
                        </div>
                        <!-- End box tour -->
                    </div>
                @endforeach
            </div>
            <p class="text-center add_bottom_30">
                <a href="{{ route('homestays') }}" class="btn_1">Lihat semua homestay</a>
            </p>
        </div>
        <!-- /carousel -->



        <hr class="mt-5 mb-5">

        <div class="main_title">
            <h2>Acara <span>terbaru</span> di Balige</h2>
            <p>Temukan acara terbaru di Balige</p>
        </div>

        <div class="container margin_60">
            <div class="owl-carousel owl-theme list_carousel add_bottom_30">

                @foreach ($events as $event)
                    <div class="item">
                        <div class="tour_container">
                            <div class="img_container">
                                <a href="{{ route('events.show', $event->id) }}">
                                    <img src="{{ asset($event->images->first()->image_path) }}" width="800"
                                        height="533" class="img-fluid" alt="image">
                                </a>
                            </div>
                            <div class="tour_title">
                                <i class="fa fa-calendar"></i> {{ $event->start_date->format('d M Y') }} -
                                {{ $event->end_date->format('d M Y') }}
                                <h3><strong>{{ $event->title }}</strong></h3>
                                <small>{{ $event->address }}</small>
                            </div>
                        </div>
                        <!-- End box -->
                    </div>
                @endforeach
            </div>
            <!-- /carousel -->
            <p class="text-center nopadding">
                <a href="{{ route('events') }}" class="btn_1">Lihat semua acara</a>
            </p>
        </div>

        <div class="container margin_60">

            <div class="main_title">
                <h2>Fasilitas <span>terbaik</span> di Balige</h2>
                <p>Dilengkapi dengan fasilitas terbaik</p>
            </div>

            <div class="row">
                @foreach ($facilities as $facility)
                    <div class="col-md-4 wow zoomIn" data-wow-delay="0.2s">
                        <div class="feature_home">
                            <i class="{{ $facility->icon }}"></i>
                            <h3>{{ $facility->name }}</h3>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </main>
@endsection
@push('scripts')
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/js/revolution_func.js') }}"></script>
@endpush
