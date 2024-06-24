@extends('layouts.frontend.master')
@push('custom-styles')
    <link href="{{ asset('frontend/css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('frontend/img/admin_top.jpg') }}"
        data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1 opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="animated fadeInDown">
                <h1>Hello {{ Auth::user()->first_name }}</h1>
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
                    <li><a href="#">Profile</a>
                    </li>
                    <li>Page active</li>
                </ul>
            </div>
        </div>
        <!-- End Position -->

        <div class="margin_60 container">
            <div id="tabs" class="tabs">
                <nav>
                    <ul>
                        <li><a href="#section-1" class="icon-booking"><span>Pesananku</span></a>
                        </li>
                        <li><a href="#section-2" class="icon-wishlist"><span>Favoritku</span></a>
                        </li>
                        <li><a href="#section-3" class="icon-settings"><span>Ganti Password</span></a>
                        </li>
                        <li><a href="#section-4" class="icon-profile"><span>Profil</span></a>
                        </li>
                    </ul>
                </nav>
                <div class="content">

                    <section id="section-1">
                        @foreach ($user->bookings as $booking)
                            <div class="strip_booking">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2">
                                        <div class="date">
                                            <span class="month">{{ $booking->created_at->format('M') }}</span>
                                            <span class="day"><strong>{{ $booking->created_at->format('d') }}</strong>
                                                {{ $booking->created_at->format('D') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-5">
                                        <h3 class="hotel_booking">{{ $booking->homestay->name }}
                                            <span>{{ $booking->homestay->getDays($booking->check_in, $booking->check_out) }}
                                                malam</span>
                                        </h3>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <ul class="info_booking">
                                            <li><strong>Kode Pesanan</strong> {{ $booking->code }}</li>
                                            <li><strong>Dipesan pada</strong> {{ $booking->created_at->format('d/m/Y') }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="booking_buttons">
                                            <a href="{{ route('booking.show', $booking->id) }}" class="btn_2">
                                                Lihat Detail
                                            </a>
                                            @if ($booking->status == 'pending')
                                                <a href="javascript:;" onclick="cancel({{ $booking->id }})"
                                                    class="btn_3">Batalkan</a>
                                            @endif
                                            @if ($booking->status == 'approved' && \Carbon\Carbon::now()->format('Y-m-d') >= $booking->check_out)
                                                <a href="javascript:;" onclick="complete({{ $booking->id }})"
                                                    href="javascript:;" class="btn_3">Selesai
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- End row -->
                            </div>
                            <!-- End strip booking -->
                        @endforeach

                    </section>
                    <!-- End section 1 -->

                    <section id="section-2">
                        <div class="row">
                            @foreach ($user->wishlists as $wishlist)
                                <div class="col-lg-4 col-md-6">
                                    <div class="hotel_container">
                                        <div class="img_container">
                                            <a href="single_hotel.html">
                                                <img src="{{ asset($wishlist->images->first()->image_path) }}"
                                                    width="800" height="533" class="img-fluid" alt="Image">
                                                <div class="ribbon top_rated">
                                                </div>
                                                <div class="short_info hotel">
                                                    <span
                                                        class="price"><sup>Rp</sup>{{ number_format($wishlist->price) }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="hotel_title">
                                            <h3><strong>{{ $wishlist->name }}</strong> </h3>
                                            <div class="rating">
                                                @for ($i = 0; $i < $wishlist->rating; $i++)
                                                    <i class="icon-star voted"></i>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $wishlist->rating; $i++)
                                                    <i class="icon-star-empty"></i>
                                                @endfor
                                            </div>
                                            <!-- end rating -->
                                            <div class="wishlist_close_admin">
                                                -
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End box tour -->
                                </div>
                                <!-- End col-md-6 -->
                            @endforeach
                        </div>
                    </section>
                    <!-- End section 2 -->

                    <section id="section-3">
                        <div class="row">
                            <form id="update-password">
                                <div class="col-md-12 add_bottom_30">
                                    <h4>Ganti password</h4>
                                    <div class="form-group">
                                        <label>Password lama</label>
                                        <input class="form-control" name="old_password" id="old_password" type="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Password baru</label>
                                        <input class="form-control" name="new_password" id="new_password" type="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi password baru</label>
                                        <input class="form-control" name="confirm_new_password" id="confirm_new_password"
                                            type="password">
                                    </div>
                                    <button type="submit" class="btn_1 green">Ganti Password</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <!-- End section 3 -->
                    <section id="section-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Profile Anda</h4>
                                <ul id="profile_summary">
                                    <li>Nama Depan <span>{{ $user->first_name }}</span>
                                    </li>
                                    <li>Nama Belakang <span>{{ $user->last_name }}</span>
                                    </li>
                                    <li>No Telepon <span>{{ $user->phone_number }}</span>
                                    </li>
                                    <li>Tanggal Lahir <span>{{ $user->date_of_birth }}</span>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    @if ($user->profile_picture)
                                        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" alt="Image"
                                            class="img-fluid styled profile_pic">
                                    @else<img src="{{ asset('frontend/img/avatar1.jpg') }}" alt="Image"
                                            class="img-fluid styled profile_pic">
                                    @endif
                                </p>
                            </div>
                        </div>
                        <!-- End row -->

                        <div class="divider"></div>
                        <form id="update-profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Edit profil</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Depan</label>
                                        <input class="form-control" name="first_name" id="first_name" type="text"
                                            value="{{ $user->first_name }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Belakang</label>
                                        <input class="form-control" name="last_name" id="last_name" type="text"
                                            value="{{ $user->last_name }}" />
                                    </div>
                                </div>
                            </div>
                            <!-- End row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Telepon</label>
                                        <input class="form-control" name="phone_number" id="phone_number" type="text"
                                            value="{{ $user->phone_number }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir <small>(dd/mm/yyyy)</small>
                                        </label>
                                        <input class="form-control" name="date_of_birth" id="date_of_birth"
                                            type="text" value="{{ $user->date_of_birth }}" />
                                    </div>
                                </div>
                            </div>
                            <!-- End row -->

                            <hr>
                            <h4>Unggah Foto Profil</h4>
                            <!-- Drop Zone -->

                            <div class="dropzone" id="drop-zone">
                            </div>
                            <!-- End Hidden on mobiles -->

                            <hr>
                            <button type="submit" class="btn_1 green">Simpan</button>
                        </form>
                    </section>
                    <!-- End section 4 -->

                </div>
                <!-- End content -->
            </div>
            <!-- End tabs -->
        </div>
        <!-- end container -->
    </main>
    <!-- End main -->
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr('#date_of_birth');
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#drop-zone", {
            autoProcessQueue: false,
            url: "{{ route('profile.upload-profile') }}",
            maxFiles: 1,
            maxFilesize: 2,
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {
                var myDropzone = this;
                $('#update-profile').on('submit', function(e) {
                    e.preventDefault();
                    let first_name = $('#first_name').val();
                    let last_name = $('#last_name').val();
                    let phone_number = $('#phone_number').val();
                    let date_of_birth = $('#date_of_birth').val();
                    $.ajax({
                        url: "{{ route('profile.update-profile') }}",
                        type: "POST",
                        data: {
                            first_name: first_name,
                            last_name: last_name,
                            phone_number: phone_number,
                            date_of_birth: date_of_birth,
                            _method: 'PUT'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                if (myDropzone.getQueuedFiles().length > 0) {
                                    myDropzone.processQueue();
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        }
                    });
                });
                this.on("complete", function(file) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Profil berhasil diubah',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        location.reload();
                    });
                    myDropzone.removeFile(file);
                    location.reload();
                });
            }
        });
    </script>
    <!-- Specific scripts -->
    <script src="{{ asset('frontend/js/tabs.js') }}"></script>
    <script>
        new CBPFWTabs(document.getElementById('tabs'));
    </script>
    <script>
        $('.wishlist_close_admin').on('click', function(c) {
            $(this).parent().parent().parent().fadeOut('slow', function(c) {});
        });
    </script>
    <script>
        function cancel(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak dapat mengembalikan pesanan yang sudah dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak, batal!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('booking.cancel', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            _method: 'PUT'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        }
                    });
                }
            });
        }

        $('#update-password').on('submit', function(e) {
            e.preventDefault();
            let old_password = $('#old_password').val();
            let new_password = $('#new_password').val();
            let confirm_new_password = $('#confirm_new_password').val();
            $.ajax({
                url: "{{ route('profile.update-password') }}",
                type: "POST",
                data: {
                    old_password: old_password,
                    new_password: new_password,
                    confirm_new_password: confirm_new_password,
                    _method: 'PUT'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                }
            });
        });

        function complete(id) {
            $('#myReview').modal('show');
            $('#review').submit(function(e) {
                e.preventDefault();
                var rating = $('input[name="rating"]:checked').val();
                var review_text = $('#review_text').val();
                $.ajax({
                    url: "{{ route('booking.review', ':id') }}".replace(':id', id),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
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
        }
    </script>
@endpush
