@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <section id="hero" class="background-image" data-background="url({{ asset('guests/img/header_bg.jpg') }})">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="intro_title">
                <h3 class="animated fadeInDown">Event<strong id="js-rotating">Balige, Toba Samosir</strong></h3>
                <p class="animated fadeInDown">Temukan Event Terbaikmu di Balige</p>
            </div>
        </div>
        <!-- End opacity-mask-->
    </section>
    <!-- End section -->

    <main>
        <div class="container margin_60">

            <div class="main_title">
                <h2>Events <span>Terbaru</span></h2>
            </div>

            <div class="row">
                <aside class="col-lg-3">
                    <p>
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">Lihat
                            Peta</a>
                    </p>

                    <div id="filters_col">
                        <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseFilters" id="filters_col_bt">
                            <i class="icon_set_1_icon-65"></i>Filters</a>
                        <div class="collapse show" id="collapseFilters">
                            <div class="filter_type">
                                <h2>Waktu</h2>
                                <div class="input-group">
                                    <input type="text" id="date_filter" class="form-control" placeholder="Pilih Tanggal"
                                        name="date_filter">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>

                            </div>

                        </div>
                        <!--End collapse -->
                    </div>
                    <!--End filters col-->
                    <div class="box_style_2 d-none d-sm-block">
                        <i class="icon_set_1_icon-57"></i>
                        <h4>Butuh <span>Bantuan?</span></h4>
                        <a href="tel://{{ getSettings('site_phone') }}" class="phone">+{{ getSettings('site_phone') }}</a>
                        <small>Silahkan hubungi kami jika anda memiliki pertanyaan seputar homestay</small>
                    </div>
                </aside>
                <!--End aside -->
                <div class="col-lg-9">
                    <div id="list_result"></div>
                </div>
            </div><!-- End row -->

            <p class="text-center nopadding">

            </p>
        </div><!-- End container -->
    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
            $("#date_filter").flatpickr({
                dateFormat: "Y-m-d",
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    load_data(1);
                }
            });
        });

        function load_data(page) {
            $.get("?page=" + page, {
                date: $("#date_filter").val()
            }, function(data) {
                $("#list_result").html(data);
            });
        }
        load_data(1);
    </script>
@endpush
