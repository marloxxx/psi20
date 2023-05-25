@extends('layouts.frontend.master')
@section('content')
    <section id="hero_2" class="background-image" data-background="url(img/slide_hero_2.jpg)">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h1>Buat Pesanan</h1>
                <div class="bs-wizard row">

                    <div class="col-6 bs-wizard-step active">
                        <div class="text-center bs-wizard-stepnum">Detail Pesanan</div>
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>
                        <a href="javascript:;" class="bs-wizard-dot"></a>
                    </div>

                    <div class="col-6 bs-wizard-step disabled">
                        <div class="text-center bs-wizard-stepnum">Selesai!</div>
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
                    <li><a href="#">Pemesanan</a>
                    </li>
                    <li><a href="#">Buat Pesanan</a>
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
            <input type="hidden" name="adults" value="{{ $adults }}">
            <input type="hidden" name="children" value="{{ $children }}">
            <div class="container margin_60">
                <div class="row">
                    <div class="col-lg-8 add_bottom_15">
                        <div class="form_title">
                            <h3>Detail Anda</h3>
                            {{-- <p>
                            Mussum ipsum cacilds, vidis litro abertis.
                        </p> --}}
                        </div>
                        <div class="step">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Depan</label>
                                        <input type="text" class="form-control" name="firstname"
                                            value="{{ Auth::user()->first_name }}" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Nama Belakang</label>
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
                                        <label>Nomor Telepon</label>
                                        <input type="text" name="phone_number" class="form-control"
                                            value="{{ Auth::user()->phone_number }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End step -->
                    </div>

                    <aside class="col-lg-4">
                        <div class="box_style_1">
                            <h3 class="inner">- Ringkasan Pesanan -</h3>
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
                                            Tamu
                                        </td>
                                        <td class="text-end">
                                            {{ $adults }} Dewasa, {{ $children }} Anak
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Malam
                                        </td>
                                        <td class="text-end">
                                            {{ $homestay->getDays($checkin, $checkout) }}
                                        </td>
                                    </tr>
                                    <tr class="total">
                                        <td>
                                            Total
                                        </td>
                                        <td class="text-end">
                                            <span class="text-danger">Rp. {{ number_format($total) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="btn_full">Buat Pesanan</button>

                            <a class="btn_full_outline" href="{{ route('homestays.show', $homestay->id) }}">
                                <i class="icon-right"></i> Kembali
                            </a>
                        </div>
                        <div class="box_style_4">
                            <i class="icon_set_1_icon-57"></i>
                            <h4>Butuh <span>Bantuan?</span></h4>
                            <a href="tel://{{ getSettings('site_phone') }}"
                                class="phone">+{{ getSettings('site_phone') }}</a>
                            <small>Silahkan hubungi kami jika anda memiliki pertanyaan seputar homestay</small>
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
