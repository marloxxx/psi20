@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                        @if ($booking->payment_proof == null || $payment->status != 2)
                            <!-- form-group -->
                            <form action="{{ route('booking.update', $booking->id) }}" method="POST"
                                enctype="multipart/form-data" class="dropzone" id="dropzone">
                                @csrf
                                @method('PUT')
                            </form>
                            <div class="mt-3">
                                <button type="submit" id="submit-all" class="btn_full">Upload Bukti Pembayaran</button>
                            </div>
                        @endif
                    </div>
                    <!--End step -->
                </div>
                <!--End col -->

                <aside class="col-lg-4">
                    <div class="box_style_1">
                        <h3 class="inner">Terima kasih!</h3>
                        <p>
                            Anda telah berhasil melakukan booking homestay. Silahkan lakukan pembayaran dan konfirmasi
                        </p>
                        <hr>
                        {{-- contact to wa --}}
                        @if ($booking->status == 'pending')
                            <a class="btn_full_outline mb-3" target="_blank"
                                href="https://api.whatsapp.com/send?phone={{ $booking->homestay->owner->phone_number }}&text=Halo%20Admin%20Saya%20Mau%20Konfirmasi%20Pembayaran%20Booking%20Saya%20Dengan%20ID%20{{ $booking->code }}%20dan%20nama%20{{ Auth::user()->first_name }}%20{{ Auth::user()->last_name }}%20">
                                <i class="icon-whatsapp"></i>
                                Konfirmasi Pembayaran
                            </a>
                        @endif
                        <a class="btn_full_outline" href="{{ route('booking.invoice', $booking->id) }}"
                            target="_blank">View
                            your invoice</a>
                    </div>
                </aside>
            </div>
            <!--End row -->
        </div>
        <!--End container -->
    </main>
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
                    });
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
@endpush
