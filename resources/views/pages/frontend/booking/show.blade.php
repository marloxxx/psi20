@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
    <section id="hero_2" class="background-image" data-background="url(img/slide_hero_2.jpg)">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h1>Place your order</h1>
                <div class="bs-wizard row">
                    <div class="col-6 bs-wizard-step complete">
                        <div class="text-center bs-wizard-stepnum">Your details</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="javascript:;" class="bs-wizard-dot"></a>
                    </div>

                    <div class="col-6 bs-wizard-step complete">
                        <div class="text-center bs-wizard-stepnum">Finish!</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="#" class="bs-wizard-dot"></a>
                    </div>

                </div>
                <!-- End bs-wizard -->
            </div>
            <!-- End intro-title -->
        </div>
        <!-- End opacity-mask-->
    </section>
    <!-- End Section hero_2 -->
    <main>
        <div id="position">
            <div class="container">
                <ul>
                    <li><a href="#">Booking</a>
                    </li>
                    <li><a href="#">Place your order</a>
                    </li>
                    <li><a href="#">Finish!</a>
                </ul>
            </div>
        </div>
        <!-- End position -->

        <div class="container margin_60">
            <div class="row">
                <div class="col-12 add_bottom_15">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <div class="col-lg-8 add_bottom_15">
                    <div class="form_title">
                        <h3><strong><i class="icon-tag-1"></i></strong>Booking summary</h3>
                        <p>
                            Booking completed!
                        </p>
                    </div>
                    <div class="step">
                        <table class="table table-striped confirm">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>Name</strong>
                                    </td>
                                    <td>
                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Check in</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Check out</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Adults</strong>
                                    </td>
                                    <td>
                                        {{ $booking->adults }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Children</strong>
                                    </td>
                                    <td>
                                        {{ $booking->children }}
                                        <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Nights</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }}
                                        nights
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>TOTAL COST</strong>
                                    </td>
                                    <td>
                                        <strong>Rp. {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Status</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->status }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if ($booking->payment_proof == null || $booking->status != 'canceled')
                            <div class="row mt-5">
                                <!-- list rekening -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">DANA</h5>
                                            <p class="card-text">
                                            <ul class="list-unstyled">
                                                <li>Atas Nama: Horas Marolop Amsal Siregar</li>
                                                <li>No Rekening: 082386143124</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">OVO</h5>
                                            <p class="card-text">
                                            <ul class="list-unstyled">
                                                <li>Atas Nama: Horas Marolop Amsal Siregar</li>
                                                <li>No Rekening: 082386143124</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">GOPAY</h5>
                                            <p class="card-text">
                                            <ul class="list-unstyled">
                                                <li>Atas Nama: Horas Marolop Amsal Siregar</li>
                                                <li>No Rekening: 082386143124</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- form-group -->
                            <form action="{{ route('booking.update', $booking->id) }}" method="POST"
                                enctype="multipart/form-data" class="dropzone" id="dropzone">
                                @csrf
                                @method('PUT')
                            </form>
                            <div class="mt-3">
                                <button type="submit" id="submit-all" class="btn_full">Upload Bukti
                                    Pembayaran</button>
                            </div>
                        @endif
                    </div>
                    <!--End step -->
                </div>
                <!--End col -->

                <aside class="col-lg-4">
                    <div class="box_style_1">
                        <h3 class="inner">Terima kasih!</h3>
                        @if ($booking->status != 'canceled')
                            @if ($booking->status == 'pending' && $booking->payment_proof != null)
                                <p>
                                    Anda telah berhasil melakukan booking homestay. Silahkan lakukan pembayaran dan
                                    konfirmasi
                                </p>
                                <hr>
                                <a class="btn_full_outline mb-3" target="_blank"
                                    href="https://api.whatsapp.com/send?phone={{ $booking->homestay->owner->phone_number }}&text=Halo%20Admin%20Saya%20Mau%20Konfirmasi%20Pembayaran%20Booking%20Saya%20Dengan%20ID%20{{ $booking->code }}%20dan%20nama%20{{ Auth::user()->first_name }}%20{{ Auth::user()->last_name }}%20">
                                    <i class="icon-whatsapp"></i>
                                    Konfirmasi Pembayaran
                                </a>
                                <a class="btn_full_outline mb-3" href="javascript:;"
                                    onclick="cancel({{ $booking->id }})">Batalkan
                                </a>
                            @endif
                            @if ($booking->status == 'approved' && \Carbon\Carbon::now()->format('Y-m-d') >= $booking->check_out)
                                <a class="btn_full_outline mb-3" href="javascript:;"
                                    onclick="complete({{ $booking->id }})">
                                    Selesaikan
                                </a>
                            @endif
                        @endif
                        <a class="btn_full_outline" href="{{ route('booking.invoice', $booking->id) }}"
                            target="_blank">View
                            your invoice
                        </a>
                    </div>
                </aside>
            </div>
            <!--End row -->
        </div>
        <!--End container -->
    </main>
    <!-- Modal Review -->
@endsection
@push('custom-scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.dropzone = {
            autoProcessQueue: false,
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            dictRemoveFile: "Remove",
            init: function() {
                var submitButton = document.querySelector("#submit-all");
                myDropzone = this;
                submitButton.addEventListener("click", function() {
                    myDropzone.processQueue();
                });
                this.on("success", function(file, response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                        }
                    })
                });
                this.on("error", function(file, response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                    // remove file
                    this.removeFile(file);
                });
            },
            removedfile: function(file) {
                var name = file.name;
                var fileRef;
                return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(
                    file.previewElement) : void 0;
            }
        };
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
