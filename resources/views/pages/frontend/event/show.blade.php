@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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

        <div class="container margin_60">
            <div class="row">
                <div class="col-lg-12" id="single_tour_desc">
                    <div id="gallery"
                        class="final-tiles-gallery effect-dezoom effect-fade-out caption-top social-icons-right">
                        <div class="ftg-items">
                            @foreach ($event->images->where('is_primary', 0) as $image)
                                <div class="tile">
                                    <a class="tile-inner" data-lightbox="gallery" href="{{ asset($image->image_path) }}">
                                        <img class="item"
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                            data-src="{{ asset($image->image_path) }}" alt="Gallery image" />
                                    </a>
                                </div>
                                <!-- End image -->
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-12">
                            {!! $event->description !!}
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let map, markers = [];
        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = L.map('map', {
                center: {
                    lat: 2.333712,
                    lng: 99.083252
                },
                zoom: 13
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap'
            }).addTo(map);


            map.on('click', mapClicked);
            initMarkers();
        }
        initMap();

        function initMarkers() {
            const initialMarkers = @json($initialMarkers);

            for (let index = 0; index < initialMarkers.length; index++) {

                const data = initialMarkers[index];
                const marker = generateMarker(data, index);
                marker.addTo(map).bindPopup(`<b>${data.position.lat},  ${data.position.lng}</b>`);
                map.panTo(data.position);
                markers.push(marker)
            }
        }

        function generateMarker(data, index) {
            return L.marker(data.position, {
                    draggable: data.draggable
                })
                .on('click', (event) => markerClicked(event, index))
                .on('dragend', (event) => markerDragEnd(event, index));
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
