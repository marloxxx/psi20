@extends('layouts.frontend.master')
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
                            permalam
                            <span><sup>Rp</sup>{{ number_format($homestay->price) }}</span>
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

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->

        <div class="container margin_60">
            <div class="row">
                <div class="col-lg-8" id="single_tour_desc">
                    <div id="single_tour_feat">
                        <ul>
                            @foreach ($homestay->facilities as $facility)
                                <li><i class="{{ $facility->icon }}"></i>{{ $facility->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="d-block d-lg-none">
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">
                            Lihat Peta
                        </a>
                    </p>
                    <!-- Map button for tablets/mobiles -->
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
                        <div class="col-lg-3">
                            <h3>Deskripsi</h3>
                        </div>
                        <div class="col-lg-9">
                            {!! $homestay->description !!}
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
                        <div class="col-lg-3">
                            <h3>Ulasan</h3>
                            <a href="#" class="btn_1 add_bottom_30" data-bs-toggle="modal"
                                data-bs-target="#myReview">Tinggalkan Ulasan
                            </a>
                        </div>
                        <div class="col-lg-9">
                            @foreach ($reviews as $review)
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
                </div>
                <!--End  single_tour_desc-->

                <aside class="col-lg-4">
                    <p class="d-none d-xl-block d-lg-block">
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">
                            Lihat Peta
                        </a>
                    </p>
                    <div class="box_style_1 expose">
                        <form method="POST" action="{{ route('booking.create', $homestay->id) }}">
                            @csrf
                            <h3 class="inner">Cek Ketersediaan</h3>
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
                        @auth
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
                        <a href="tel://{{ $homestay->owner->phone_number }}"
                            class="phone">{{ $homestay->owner->phone_number }}</a>
                        <small>Senin - Jumat 9.00 - 18.00 WIB</small>
                    </div>

                </aside>
            </div>
            <!--End row -->
        </div>
        <!--End container -->

        <div id="overlay"></div>
        <!-- Mask on input focus -->

    </main>
    <!-- End main -->
    <!-- Modal Review -->
    <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myReviewLabel">Tuangkan Ulasanmu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="message-review">
                    </div>
                    <form method="post" action="" id="review">
                        <input name="homestay_id" id="homestay_id" type="hidden" value="{{ $homestay->id }}">
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Penilaian</label>
                                    <select class="form-select" name="rating" id="rating">
                                        <option value="">Pilih Penilaian</option>
                                        <option value="1">Sangat Buruk</option>
                                        <option value="2">Buruk</option>
                                        <option value="3">Cukup</option>
                                        <option value="4">Baik</option>
                                        <option value="5">Sangat Baik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="form-group">
                            <textarea name="review_text" id="review_text" class="form-control" style="height:100px"
                                placeholder="Write your review"></textarea>
                        </div>
                        <button type="submit" id="submit-review" class="btn_1">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal review -->
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
                if (picker.startDate.format('MM-DD-YY') == picker.endDate.format(
                        'MM-DD-YY')) {
                    toastr.error('Check in and check out date cannot be the same');
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

        $('#review').submit(function(e) {
            e.preventDefault();
            var homestay_id = $('#homestay_id').val();
            var rating = $('#rating').val();
            var review_text = $('#review_text').val();
            $.ajax({
                url: "{{ route('review') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    homestay_id: homestay_id,
                    rating: rating,
                    review: review_text
                },
                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        // set timeout to wait for toastr to finish
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
    </script>
@endpush
