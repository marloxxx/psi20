@extends('layouts.frontend.master')
@push('custom-styles')
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
@endpush
@section('content')
    <section class="parallax-window" data-parallax="scroll"
        data-image-src="{{ asset($homestay->images->first()->image_path) }}" data-natural-width="1400"
        data-natural-height="470">
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <span class="rating">
                            @for ($i = 0; $i < $homestay->rating; $i++)
                                <i class="icon-star voted"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - $homestay->rating; $i++)
                                <i class="icon-star-empty"></i>
                            @endfor
                        </span>
                        <h1>{{ $homestay->name }}</h1>
                        <span>{{ $homestay->address }}</span>
                    </div>
                    <div class="col-md-4">
                        <div id="price_single_main" class="hotel">
                            <span><sup>Rp</sup>{{ number_format($homestay->price_per_night) }}</span>/malam
                        </div>
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
                    <li><a href="#">Homestays</a>
                    </li>
                    <li>{{ $homestay->name }}</li>
                </ul>
            </div>
        </div>
        <!-- End Position -->

        <div class="margin_60" style="margin: 0 150px 0 150px;">
            <div class="row">
                <div class="col-lg-8" id="single_tour_desc">
                    <div id="single_tour_feat">
                        <ul>
                            @foreach ($homestay->facilities as $facility)
                                <li><i class="{{ $facility->icon }}"></i>{{ $facility->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div id="Img_carousel" class="slider-pro">
                        <div class="sp-slides">
                            @foreach ($homestay->images->where('is_primary', 0) as $image)
                                <div class="sp-slide">
                                    <img alt="Image" class="sp-image" src="{{ asset('frontend/css/images/blank.gif') }}"
                                        data-src="{{ asset($image->image_path) }}" style="width: 50%;" />
                                </div>
                            @endforeach
                        </div>
                        <div class="sp-thumbnails">
                            @foreach ($homestay->images->where('is_primary', 0) as $image)
                                <img alt="Image" class="sp-thumbnail" src="{{ asset($image->image_path) }}" />
                            @endforeach
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-justify">
                                {!! $homestay->description !!}
                            </div>
                            <br />
                            <br />
                            <h4>Fasilitas</h4>
                            <p>
                                Berikut adalah fasilitas yang tersedia di homestay ini
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list_ok">
                                        @foreach ($homestay->facilities->take(ceil($homestay->facilities->count() / 2)) as $facility)
                                            <li>{{ $facility->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list_ok">
                                        @foreach ($homestay->facilities->skip(ceil($homestay->facilities->count() / 2)) as $facility)
                                            <li>{{ $facility->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <!-- End row  -->
                        </div>
                        <!-- End col-md-9  -->
                    </div>
                    <!-- End row  -->

                    <hr>
                    <hr>
                    <div class="row">

                        <div class="col-lg-12">
                            @foreach ($homestay->reviews as $review)
                                <div class="review_strip_single">
                                    @if ($review->user->profile_picture)
                                        <img src="{{ asset('images/profile/' . $review->user->profile_picture) }}"
                                            alt="{{ $review->user->first_name }}" class="img-circle" width="80"
                                            height="80" />
                                    @else
                                        <img src="{{ asset('frontend/img/avatar1.jpg') }}" alt="Image"
                                            class="rounded-circle">
                                    @endif
                                    <small> - {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }} -</small>
                                    <h4>{{ $review->user->first_name }}</h4>
                                    <p>
                                        {{ $review->review }}
                                    </p>
                                    <div class="rating">
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            <i class="icon-star voted"></i>
                                        @endfor
                                        @for ($i = 0; $i < 5 - $review->rating; $i++)
                                            <i class="icon-star-empty"></i>
                                        @endfor
                                    </div>
                                </div>
                            @endforeach

                            <!-- End review strip -->
                        </div>
                    </div>
                    <div class="mt-5 mb-5">
                        <h3>Location</h3>
                        <div id="map"></div>
                    </div>

                </div>
                <!--End  single_tour_desc-->

                <aside class="col-lg-4">

                    <div class="box_style_1 expose">
                        @auth
                            @if ($homestay->is_available)
                                <form method="POST" action="{{ route('booking.create', $homestay->id) }}">
                                    @csrf
                                    <h3 class="inner">Cek Ketersediaan</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Adults</label>
                                                <div class="numbers-row">
                                                    <input type="text" value="1" class="qty2 form-control"
                                                        name="adults">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Children</label>
                                                <div class="numbers-row">
                                                    <input type="text" value="0" class="qty2 form-control"
                                                        name="children">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><i class="icon-calendar-7"></i> Check in / Check out</label>
                                                <input class="date-pick form-control" type="text" placeholder="Select dates"
                                                    name="dates">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <button type="submit" class="btn_full" id="btn_check">
                                        Pesan Sekarang
                                    </button>
                                </form>
                            @else
                                <h3>Ulasan</h3>
                                <p>
                                    Homestay ini tidak tersedia untuk dipesan
                                </p>
                            @endif

                            @if (auth()->user()->wishlists->contains($homestay->id))
                                <a class="btn_full_outline" href="javascript:void(0)"
                                    onclick="toggleWishlist({{ $homestay->id }})">
                                    <i class="fa fa-heart"></i>
                                    Hapus dari Favorit
                                </a>
                            @else
                                <a class="btn_full_outline" href="javascript:void(0)"
                                    onclick="toggleWishlist({{ $homestay->id }})">
                                    <i class="fa fa-heart-o"></i>
                                    Tambah ke Favorit
                                </a>
                            @endif
                        @endauth

                    </div>
                    <!--/box_style_1 -->

                    <div class="box_style_4">
                        <i class="icon_set_1_icon-90"></i>
                        <h4><span>Pesan</span> lewat telepon</h4>
                        <a href="tel://{{ $homestay->owner_phone_number }}"
                            class="phone">{{ $homestay->owner_phone_number }}</a>
                        <small>Senin - Jumat 9.00 - 18.00 WIB</small>
                    </div>
                    @auth

                    @endauth

                </aside>
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
    <script>
        let available = {{ $homestay->is_available }};
        $(function() {
            'use strict';
            // disable button
            $('#btn_check').prop('disabled', true);
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
                // check homestay status is available or not
                if (available == 0) {
                    return;
                }
                checkAvailability();
            });
            $('input.date-pick').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });

        function checkAvailability() {
            var dates = $('input.date-pick').val().split(' > ');
            var check_in = dates[0];
            var check_out = dates[1];
            var homestay_id = "{{ $homestay->id }}";
            $.ajax({
                url: "{{ route('booking.check') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    check_in: check_in,
                    check_out: check_out,
                    homestay_id: homestay_id
                },
                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        $("#btn_check").prop('disabled', false);
                    } else {
                        $("#btn_check").prop('disabled', true);
                        toastr.error(response.message);
                    }
                }
            });
        }

        function load_data(page) {
            $.get("?page=" + page, {

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
                            // set timeout to wait for toastr to finish
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            toastr.warning(response.message);
                            // set timeout to wait for toastr to finish
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async>
    </script>
    <script>
        let map, activeInfoWindow, markers = [];
        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: {{ $homestay->latitude }},
                    lng: {{ $homestay->longitude }}
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
