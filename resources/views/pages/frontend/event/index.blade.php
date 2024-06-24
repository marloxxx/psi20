@extends('layouts.frontend.master')
@push('custom-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('content')
    <section id="hero" class="background-image" data-background="url({{ asset('frontend/img/header_bg.jpg') }})">
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
                    <div id="filters_col">
                        <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseFilters" id="filters_col_bt">
                            <i class="icon_set_1_icon-65"></i>Filters
                        </a>
                        <div class="collapse show" id="collapseFilters">
                            <div class="filter_type">
                                <h6>Start > End Date</h6>
                                <div class="form-group">
                                    <input class="date-pick form-control" type="text" placeholder="Select dates"
                                        name="dates">
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
                    <div class="row mt-0 custom-search-input-2 mb-3">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input class="form-control pac-target-input" type="text" placeholder="Judul Event"
                                    autocomplete="off" name="search">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="list_result"></div>
                </div>
            </div><!-- End row -->

            <p class="text-center nopadding">

            </p>
        </div><!-- End container -->
    </main>
    <!-- End main -->
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function() {
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
                load_data(1);
            });
            $('input.date-pick').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                load_data(1);
            });

            $('input[name="search"]').keyup(function() {
                load_data(1);
            });
        });

        function load_data(page) {
            $.get("?page=" + page, {
                date: $('input[name="dates"]').val(),
                title: $('input[name="search"]').val()
            }, function(data) {
                $("#list_result").html(data);
            });
        }
        load_data(1);

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    load_list(page);
                }
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.paginasi', function(event) {
                event.preventDefault();
                $('.paginasi').removeClass('active');
                $(this).parent('.paginasi').addClass('active');
                // var myurl = $(this).attr('href');
                page = $(this).attr('halaman').split('page=')[1];
                load_data(page);
            });
        });
    </script>
@endpush
