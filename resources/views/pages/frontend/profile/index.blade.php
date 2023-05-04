@extends('layouts.frontend.master')
@push('custom-styles')
    <link href="{{ asset('guests/css/admin.css') }}" rel="stylesheet">
@endpush
@section('content')
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('guests/img/admin_top.jpg') }}"
        data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1 opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.4)">
            <div class="animated fadeInDown">
                <h1>Hello {{ Auth::user()->first_name }}</h1>
                <p>Update your profile</p>
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
                        <li><a href="#section-1" class="icon-booking"><span>Bookings</span></a>
                        </li>
                        <li><a href="#section-2" class="icon-wishlist"><span>Wishlist</span></a>
                        </li>
                        <li><a href="#section-3" class="icon-settings"><span>Settings</span></a>
                        </li>
                        <li><a href="#section-4" class="icon-profile"><span>Profile</span></a>
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
                                                nights</span>
                                        </h3>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <ul class="info_booking">
                                            <li><strong>Booking code</strong> {{ $booking->code }}</li>
                                            <li><strong>Booked on</strong> {{ $booking->created_at->format('d/m/Y') }}
                                        </ul>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="booking_buttons">
                                            <a href="{{ route('booking.show', $booking->id) }}" class="btn_2">View
                                                details</a>
                                            @if ($booking->status == 'pending')
                                                <a href="javascript:;" onclick="cancel({{ $booking->id }})"
                                                    class="btn_3">Cancel</a>
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
                                                <img src="{{ asset($wishlist->homestay->images->first()->image_path) }}"
                                                    width="800" height="533" class="img-fluid" alt="Image">
                                                <div class="ribbon top_rated">
                                                </div>
                                                <div class="short_info hotel">
                                                    <span
                                                        class="price"><sup>Rp</sup>{{ number_format($wishlist->homestay->price) }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="hotel_title">
                                            <h3><strong>{{ $wishlist->homestay->name }}</strong> </h3>
                                            <div class="rating">
                                                @for ($i = 0; $i < $wishlist->homestay->rating; $i++)
                                                    <i class="icon-star voted"></i>
                                                @endfor
                                                @for ($i = 0; $i < 5 - $wishlist->homestay->rating; $i++)
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
                                    <h4>Change your password</h4>
                                    <div class="form-group">
                                        <label>Old password</label>
                                        <input class="form-control" name="old_password" id="old_password" type="password">
                                    </div>
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input class="form-control" name="new_password" id="new_password" type="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm new password</label>
                                        <input class="form-control" name="confirm_new_password" id="confirm_new_password"
                                            type="password">
                                    </div>
                                    <button type="submit" class="btn_1 green">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <!-- End section 3 -->
                    <section id="section-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Your profile</h4>
                                <ul id="profile_summary">
                                    <li>First name <span>{{ $user->first_name }}</span>
                                    </li>
                                    <li>Last name <span>{{ $user->last_name }}</span>
                                    </li>
                                    <li>Phone number <span>{{ $user->phone_number }}</span>
                                    </li>
                                    <li>Date of birth <span>{{ $user->date_of_birth }}</span>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <img src="{{ asset('guests/img/avatar1.jpg') }}" alt="Image"
                                        class="img-fluid styled profile_pic">
                                </p>
                            </div>
                        </div>
                        <!-- End row -->

                        <div class="divider"></div>
                        <form id="update-profile">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Edit profile</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input class="form-control" name="first_name" id="first_name" type="text"
                                            value="{{ $user->first_name }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input class="form-control" name="last_name" id="last_name" type="text"
                                            value="{{ $user->last_name }}" />
                                    </div>
                                </div>
                            </div>
                            <!-- End row -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input class="form-control" name="phone_number" id="phone_number" type="text"
                                            value="{{ $user->phone_number }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date of birth <small>(dd/mm/yyyy)</small>
                                        </label>
                                        <input class="form-control" name="date_of_birth" id="date_of_birth"
                                            type="text" value="{{ $user->date_of_birth }}" />
                                    </div>
                                </div>
                            </div>
                            <!-- End row -->

                            <hr>
                            <h4>Upload profile photo</h4>
                            <div class="form-inline upload_1">
                                <div class="form-group">
                                    <input type="file" name="files[]" id="js-upload-files" multiple>
                                </div>
                                <button type="submit" class="btn_1 green" id="js-upload-submit">Upload file</button>
                            </div>
                            <!-- Drop Zone -->
                            <h5>Or drag and drop files below</h5>
                            <div class="upload-drop-zone" id="drop-zone">
                                Just drag and drop files here
                            </div>
                            <!-- Progress Bar -->
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 60%;">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                            <!-- Upload Finished -->
                            <div class="js-upload-finished">
                                <h5>Processed files</h5>
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-success"><span
                                            class="badge alert-success pull-right">Success</span>image-01.jpg</a>
                                </div>
                            </div>
                            <!-- End Hidden on mobiles -->

                            <hr>
                            <button type="submit" class="btn_1 green">Update Profile</button>
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
@push('custom-scripts')
    <!-- Specific scripts -->
    <script src="{{ asset('guests/js/tabs.js') }}"></script>
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
                title: 'Are you sure?',
                text: "You want to cancel this booking?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, cancel it!'
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
                        $('#update-password')[0].reset();
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#update-profile')[0].reset();
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
    </script>
@endpush
