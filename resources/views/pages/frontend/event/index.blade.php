@extends('layouts.frontend.master')
@section('content')
    <section id="hero" class="background-image" data-background="url(img/header_bg.jpg)">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h3 class="animated fadeInDown">Super <strong id="js-rotating">Simple,Customizable,Light Weight,Easy</strong>
                    Text Rotator</h3>
                <p class="animated fadeInDown">CITY TOURS / TOUR TICKETS / TOUR GUIDES</p>
                <a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#"
                    class="animated fadeInUp button_intro outline">View Tickets</a>
            </div>
        </div>
        <!-- End opacity-mask-->
    </section>
    <!-- End section -->

    <main>
        <div class="container margin_60">

            <div class="main_title">
                <h2>Balige <span>Top</span> Events</h2>
            </div>

            <div class="row" id="list_result">


            </div><!-- End row -->

            <p class="text-center nopadding">

            </p>
        </div><!-- End container -->
    </main>
    <!-- End main -->s
@endsection
@push('custom-scripts')
    <script>
        function load_data(page) {
            $.get("?page=" + page, {

            }, function(data) {
                $("#list_result").html(data);
            });
        }
        load_data(1);
    </script>
@endpush
