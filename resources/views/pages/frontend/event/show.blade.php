@extends('layouts.frontend.master')
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

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->

        <div class="container margin_60">
            <div class="row">
                <div class="col-lg-12" id="single_tour_desc">
                    <p class="d-block d-lg-none">
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on
                            map</a>
                    </p>
                    <!-- Map button for tablets/mobiles -->
                    <div id="Img_carousel" class="slider-pro">
                        <div class="sp-slides">
                            @foreach ($event->images->where('is_primary', 0) as $image)
                                <div class="sp-slide">
                                    <img alt="Image" class="sp-image" src="{{ asset('frontend/css/images/blank.gif') }}"
                                        data-src="{{ asset($image->image_path) }}" style="width: 50%;" />
                                </div>
                            @endforeach
                        </div>
                        <div class="sp-thumbnails">
                            @foreach ($event->images->where('is_primary', 0) as $image)
                                <img alt="Image" class="sp-thumbnail" src="{{ asset($image->image_path) }}" />
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
                    </div>
                    <!-- End row  -->
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
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script>
        let map, activeInfoWindow, markers = [];
        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: 2.333712,
                    lng: 99.083252
                },
                zoom: 15
            });

            map.addListener("click", function(event) {
                mapClicked(event);
            });
            initMarkers();
        }
        initMap();

        function initMarkers() {
            const initialMarkers = @json($initialMarkers);

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
