@extends('layouts.frontend.master')
@push('custom-styles')
    <!-- REVOLUTION SLIDER CSS -->
    <link href="{{ asset('frontend/rs-plugin/css/settings.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/extralayers.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/finaltilesgallery.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/lightbox2.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset($event->images->first()->image_path) }}"
        data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>{{ $event->title }}</h1>
                        <span>{{ $event->address }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End section -->

    <main>
        <div id="position">
            <div class="container">
                <ul>
                    <li><a href="#">Home</a>
                    </li>
                    <li><a href="#">Events</a>
                    </li>
                    <li>{{ $event->name }}</li>
                </ul>
            </div>
        </div>
        <!-- End Position -->

        <div class="container margin_60" style="margin: 0 150px 0 150px;">
            <div class="row">
                <div class="col-lg-12" id="single_tour_desc">
                    <div class="owl-carousel owl-theme list_carousel add_bottom_30">
                        @foreach ($event->images->where('is_primary', 0) as $image)
                            <div class="tile">
                                <a class="tile-inner" data-lightbox="gallery" href="{{ asset($image->image_path) }}">
                                    <img class="item" src="{{ asset($image->image_path) }}" data-src=""
                                        alt="Gallery image" />
                                </a>
                            </div>
                            <!-- End image -->
                        @endforeach
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-justify">
                                {!! $event->description !!}
                            </div>
                            <!-- End row  -->

                        </div>
                        <!-- End col-md-9  -->
                        <!-- End row  -->
                    </div>
                    <div class="mt-5 mb-5">
                        <h3>Location</h3>
                        <div id="map"></div>
                    </div>
                </div>
                <!--End  single_tour_desc-->
            </div>
            <!--End row -->
        </div>
        <!--End container -->

        <div id="overlay"></div>
        <!-- Mask on input focus -->

    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('frontend/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/js/revolution_func.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.sliderPro.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('#Img_carousel').sliderPro({
                width: 960,
                height: 500,
                fade: true,
                arrows: true,
                buttons: false,
                fullScreen: false,
                smallSize: 500,
                startSlide: 0,
                mediumSize: 1000,
                largeSize: 3000,
                thumbnailArrows: true,
                autoplay: false
            });
        });
    </script>
    <!-- Specific scripts - Grid gallery -->
    <script src="{{ asset('frontend/js/jquery.finaltilesgallery.js') }}"></script>
    <script src="{{ asset('frontend/js/lightbox2.js') }}"></script>
    <script>
        $(function() {
            'use strict';
            //we call Final Tiles Grid Gallery without parameters,
            //see reference for customisations: http://final-tiles-gallery.com/index.html#get-started
            $(".final-tiles-gallery").finalTilesGallery();
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxm2QMoIfo6njUl-Nl2RifVnidUsNcLgM&callback=initMap"
        async></script>
    <script>
        let map, activeInfoWindow, markers = [];
        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 2.333712,
                    lng: 99.083252
                },
                zoom: 13
            });

            map.addListener("click", function(event) {
                mapClicked(event);
            });

            initMarkers();
        }


        function initMarkers() {
            const initialMarkers = @json($initialMarkers)

            for (let index = 0; index < initialMarkers.length; index++) {

                const markerData = initialMarkers[index];
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    label: markerData.label,
                    draggable: markerData.draggable,
                    map
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
                });
                marker.addListener("click", (event) => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    markerClicked(marker, index);
                });

                marker.addListener("dragend", (event) => {
                    markerDragEnd(event, index);
                });
            }
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked(event) {
            console.log(map);
            console.log(event.latLng.lat(), event.latLng.lng());
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked(marker, index) {
            console.log(map);
            console.log(marker.position.lat());
            console.log(marker.position.lng());
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd(event, index) {
            console.log(map);
            console.log(event.latLng.lat());
            console.log(event.latLng.lng());
        }
    </script>
@endpush
