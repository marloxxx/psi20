@extends('layouts.frontend.master')
@section('content')
    <section id="hero_2" class="background-image" data-background="url(img/slide_hero_2.jpg)">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h1>Place your order</h1>
                <div class="bs-wizard row">

                    <div class="col-6 bs-wizard-step active">
                        <div class="text-center bs-wizard-stepnum">Your details</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="javascript:;" class="bs-wizard-dot"></a>
                    </div>

                    <div class="col-6 bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Finish!</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="javascript:;" class="bs-wizard-dot"></a>
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
                </ul>
            </div>
        </div>
        <!-- End position -->
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="homestay_id" value="{{ $homestay->id }}">
            <input type="hidden" name="checkin" value="{{ $checkin }}">
            <input type="hidden" name="checkout" value="{{ $checkout }}">
            <input type="hidden" name="total" value="{{ $total }}">
            <div class="container margin_60">
                <div class="row">
                    <div class="col-lg-8 add_bottom_15">
                        <div class="form_title">
                            <h3>Your Details</h3>
                            {{-- <p>
                            Mussum ipsum cacilds, vidis litro abertis.
                        </p> --}}
                        </div>
                        <div class="step">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input type="text" class="form-control" name="firstname"
                                            value="{{ Auth::user()->first_name }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" class="form-control" name="lastname"
                                            value="{{ Auth::user()->last_name }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ Auth::user()->email }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telephone</label>
                                        <input type="text" id="telephone_booking" name="telephone_booking"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End step -->
                    </div>

                    <aside class="col-lg-4">
                        <div class="box_style_1">
                            <h3 class="inner">- Summary -</h3>
                            <table class="table table_summary">
                                <tbody>
                                    <tr>
                                        <td>
                                            Check in
                                        </td>
                                        <td class="text-end">
                                            {{ $checkin }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Check out
                                        </td>
                                        <td class="text-end">
                                            {{ $checkout }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nights
                                        </td>
                                        <td class="text-end">
                                            {{ $homestay->getDays($checkin, $checkout) }}
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td>
                                            Total cost
                                        </td>
                                        <td class="text-end">
                                            <span class="text-danger">Rp. {{ number_format($total) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="btn_full">Book now</button>

                            <a class="btn_full_outline" href="{{ route('homestays.show', $homestay->id) }}">
                                <i class="icon-right"></i> Modify your search
                            </a>
                        </div>
                        <div class="box_style_4">
                            <i class="icon_set_1_icon-57"></i>
                            <h4>Need <span>Help?</span></h4>
                            <a href="tel://{{ $homestay->owner->phone_number }}"
                                class="phone">{{ $homestay->owner->phone_number }}</a>
                            <small>Monday to Friday 9.00am - 7.30pm</small>
                        </div>
                    </aside>

                </div>
                <!--End row -->
            </div>
            <!--End container -->
        </form>
    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
@endpush
