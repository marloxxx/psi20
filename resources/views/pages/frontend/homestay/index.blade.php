@extends('layouts.frontend.master')
@section('content')
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('frontend/img/hotels_bg.jpg') }}"
        data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1 opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="animated fadeInDown">
                <h1>Homestay Balige</h1>
                <p>Temukan homestay terbaik dibalige</p>
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
                    <li><a href="#">Category</a>
                    </li>
                    <li>Page active</li>
                </ul>
            </div>
        </div>
        <!-- Position -->

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->

        <div class="container margin_60">
            <div class="row">
                <aside class="col-lg-3">
                    <p>
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Tutup Peta"
                            data-text-original="Lihat
                            Peta">Lihat
                            Peta</a>
                    </p>

                    <div id="filters_col">
                        <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseFilters" id="filters_col_bt">
                            <i class="icon_set_1_icon-65"></i>Filters</a>
                        <div class="collapse show" id="collapseFilters">
                            <div class="filter_type">
                                <h6>Harga</h6>
                                <input type="text" id="range" name="range" value="">
                            </div>
                            <div class="filter_type">
                                <h6>Penilaian</h6>
                                <ul>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i>
                                                <i class="icon_set_1_icon-81 voted"></i>
                                                <i class="icon_set_1_icon-81 voted"></i>
                                                <i class="icon_set_1_icon-81 voted"></i>
                                                <i class="icon_set_1_icon-81 voted"></i>
                                            </span>
                                            <input type="checkbox" name="rating[]" value="5">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i>
                                            </span>
                                            <input type="checkbox" name="rating[]" value="4">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i>
                                            </span>
                                            <input type="checkbox" name="rating[]" value="3">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i>
                                            </span>
                                            <input type="checkbox" name="rating[]" value="2">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i>
                                            </span>
                                            <input type="checkbox" name="rating[]" value="1">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="filter_type">
                                <h6>Fasiitas</h6>
                                <ul>
                                    @foreach ($facilities as $facility)
                                        <li>
                                            <label class="container_check">
                                                {{ $facility->name }}
                                                <input type="checkbox" name="facilities[]" value="{{ $facility->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!--End collapse -->
                    </div>
                    <!--End filters col-->
                    <div class="box_style_2 d-none d-sm-block">
                        <i class="icon_set_1_icon-57"></i>
                        <h4>Butuh <span>Bantuan?</span></h4>
                        <a href="tel://{{ getSettings('site_phone') }}"
                            class="phone">+{{ getSettings('site_phone') }}</a>
                        <small>Silahkan hubungi kami jika anda memiliki pertanyaan seputar homestay</small>
                    </div>
                </aside>
                <!--End aside -->

                <div class="col-lg-9">


                    <div class="row justify-content-end" style="margin-bottom: 28px">

                        <div class="col-md-6 col-sm-4 d-none d-sm-block text-end">
                            <!-- Tambah homestay -->
                            <a href="{{ route('backend.homestays.index') }}" class="btn_1 py-2 px-4">Tambah
                                Homestay</a>

                        </div>
                    </div>

                    <!--End tools -->

                    <div id="list_result"></div>

                </div>
                <!-- End col lg-9 -->
            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
    <script>
        $("#range").ionRangeSlider({
            hide_min_max: !0,
            keyboard: !0,
            min: {{ $min_price }},
            max: {{ $max_price }},
            from: 0,
            to: {{ $max_price }},
            type: "double",
            step: 1,
            prefix: "Rp",
            grid: !0,
            onStart: function(data) {
                $("#range").val(data.from + ";" + data.to);
            },
            onChange: function(data) {
                $("#range").val(data.from + ";" + data.to);
                load_data(1);
            },
        });

        $("#sort_price").change(function() {
            load_data(1);
        });

        $("input[name='rating[]']").change(function() {
            load_data(1);
        });

        $("input[name='facilities[]']").change(function() {
            load_data(1);
        });

        function load_data(page) {
            $.get("?page=" + page, {
                facilities: $("input[name='facilities[]']:checked").map(function() {
                    return $(this).val();
                }).get(),
                sort_price: $("#sort_price").val(),
                range: $("#range").val(),
                rating: $("input[name='rating[]']:checked").map(function() {
                    return $(this).val();
                }).get(),
            }, function(data) {
                $("#list_result").html(data);
            });
        }
        load_data(1);

        function toggleWishlist(id) {
            // console.log(el);
            // change icon

            $.ajax({
                url: "{{ route('whislist.toggle') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    homestay_id: id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        if (response.action == 'add') {
                            toastr.success(response.message);
                        } else {
                            toastr.warning(response.message);
                        }
                        load_data(1);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    load_list(page);
                }
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.paginasi', function(event) {
                event.preventDefault();
                $('.paginasi').removeClass('active');
                $(this).parent('.paginasi').addClass('active');
                // var myurl = $(this).attr('href');
                page = $(this).attr('halaman').split('page=')[1];
                load_data(page);
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBR4PDxBIpinD2cg0_vpjeNkbP1TCppsI0&callback=initMap"
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
