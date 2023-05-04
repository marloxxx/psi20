@extends('layouts.frontend.master')
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
                        <a href="payment_hotel.html" class="bs-wizard-dot"></a>
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
                    </div>
                    <!--End step -->
                </div>
                <!--End col -->

                <aside class="col-lg-4">
                    <div class="box_style_1">
                        <h3 class="inner">Thank you!</h3>
                        <p>
                            You will receive a confirmation email shortly. Please check your email and follow the
                            instructions. If you don't receive anything, please be sure to check your spam folder.
                        </p>
                        <hr>
                        @if ($booking->payment_status == '1')
                            <button type="button" class="btn_full" id="pay-button">Pay now</button>
                        @endif

                        <a class="btn_full_outline" href="{{ route('booking.invoice', $booking->id) }}" target="_blank">View
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
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });
    </script>
@endpush
