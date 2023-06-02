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
                    style="background-image: url({{ asset('frontend/img/slides/slide_home_1.jpg') }});">
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
                                            <a class="btn_1" href="all_tours_list.html" role="button">Book Now!</a>
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
                                                href="all_tours_list.html" role="button">Book Now!</a></div>
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
                                                href="all_tours_list.html" role="button">Book Now!</a></div>
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

            </div>

        </div>
        <!-- /carousel -->



        <hr class="mt-5 mb-5">

        <div class="main_title">
            <h2>Acara <span>terbaru</span> di Balige</h2>
            <p>Temukan acara terbaru di Balige</p>
        </div>

        <div class="owl-carousel owl-theme list_carousel add_bottom_30">


        </div>
        <!-- /carousel -->



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
@push('custom-scripts')
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/js/revolution_func.js') }}"></script>
@endpush
