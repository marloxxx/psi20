@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <section id="hero" class="background-image" data-background="url({{ asset('frontend/img/header_bg.jpg') }})">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h3 class="animated fadeInDown">Event<strong id="js-rotating">Balige, Toba Samosir</strong></h3>
                <p class="animated fadeInDown">Temukan Event Terbaikmu di Balige</p>
            </div>
        </div>
        <!-- End opacity-mask-->
    </section>
    <!-- End section -->

    <main>
        <div class="container margin_60">

            <div class="main_title">
                <h2>Events <span>Terbaru</span></h2>
            </div>

            <div class="row">
                <aside class="col-lg-3">
                    <p>
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">Lihat
                            Peta</a>
                    </p>

                    <div id="filters_col">
                        <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseFilters" id="filters_col_bt">
                            <i class="icon_set_1_icon-65"></i>Filters
                        </a>
                        <div class="collapse show" id="collapseFilters">
                            <div class="filter_type">
                                <h6>Start > End Date</h6>
                                <div class="form-group">
                                    <input class="date-pick form-control" type="text" placeholder="Select dates"
                                        name="dates">
                                </div>

                            </div>
                        </div>
                        <!--End collapse -->
                    </div>
                    <!--End filters col-->
                    <div class="box_style_2 d-none d-sm-block">
                        <i class="icon_set_1_icon-57"></i>
                        <h4>Butuh <span>Bantuan?</span></h4>
                        <a href="tel://{{ getSettings('site_phone') }}" class="phone">+{{ getSettings('site_phone') }}</a>
                        <small>Silahkan hubungi kami jika anda memiliki pertanyaan seputar homestay</small>
                    </div>
                </aside>
                <!--End aside -->
                <div class="col-lg-9">
                    <div class="row mt-0 custom-search-input-2 mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control pac-target-input" type="text" placeholder="Judul Event"
                                    autocomplete="off" name="search">
                            </div>
                        </div>
                    </div>
                    <div id="list_result"></div>
                </div>
            </div><!-- End row -->

            <p class="text-center nopadding">

            </p>
        </div><!-- End container -->
    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            $('input.date-pick').daterangepicker({
                autoUpdateInput: false,
                opens: 'left',
                minDate: new Date(),
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            $('input.date-pick').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM-DD-YY') + ' > ' + picker.endDate
                    .format('MM-DD-YY'));
                load_data(1);
            });
            $('input.date-pick').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                load_data(1);
            });

            $('input[name="search"]').keyup(function() {
                load_data(1);
            });
        });

        function load_data(page) {
            $.get("?page=" + page, {
                date: $('input[name="dates"]').val(),
                title: $('input[name="search"]').val()
            }, function(data) {
                $("#list_result").html(data);
            });
        }
        load_data(1);
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
