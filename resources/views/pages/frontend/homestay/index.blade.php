@extends('layouts.frontend.master')
@section('content')
    <section class="parallax-window" data-parallax="scroll" data-image-src="{{ asset('guests/img/hotels_bg.jpg') }}"
        data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1 opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="animated fadeInDown">
                <h1>Homestay Balige</h1>
                <p>Temukan homestay terbaik dibalige</p>
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
                    <li><a href="#">Category</a>
                    </li>
                    <li>Page active</li>
                </ul>
            </div>
        </div>
        <!-- Position -->

        <div class="collapse" id="collapseMap">
            <div id="map" class="map"></div>
        </div>
        <!-- End Map -->

        <div class="container margin_60">

            <div class="row">
                <aside class="col-lg-3">
                    <p>
                        <a class="btn_map" data-bs-toggle="collapse" href="#collapseMap" aria-expanded="false"
                            aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on
                            map</a>
                    </p>

                    <div id="filters_col">
                        <a data-bs-toggle="collapse" href="#collapseFilters" aria-expanded="false"
                            aria-controls="collapseFilters" id="filters_col_bt"><i
                                class="icon_set_1_icon-65"></i>Filters</a>
                        <div class="collapse show" id="collapseFilters">
                            <div class="filter_type">
                                <h6>Price</h6>
                                <input type="text" id="range" name="range" value="">
                            </div>
                            <div class="filter_type">
                                <h6>Star Category</h6>
                                <ul>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i>
                                            </span>(15)
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i>
                                            </span>(10)
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i>
                                            </span>(22)
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81 voted"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i>
                                            </span>(08)
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            <span class="rating">
                                                <i class="icon_set_1_icon-81 voted"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i><i class="icon_set_1_icon-81"></i><i
                                                    class="icon_set_1_icon-81"></i>
                                            </span>(08)
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="filter_type">
                                <h6>Facility</h6>
                                <ul>
                                    <li>
                                        <label class="container_check">
                                            Pet allowed
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Wifi
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Spa
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Restaurant
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Pool
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Parking
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="container_check">
                                            Fitness center
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--End collapse -->
                    </div>
                    <!--End filters col-->
                    <div class="box_style_2 d-none d-sm-block">
                        <i class="icon_set_1_icon-57"></i>
                        <h4>Need <span>Help?</span></h4>
                        <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                        <small>Monday to Friday 9.00am - 7.30pm</small>
                    </div>
                </aside>
                <!--End aside -->

                <div class="col-lg-9">

                    <div id="tools">
                        <div class="row justify-content-between">
                            <div class="col-md-3 col-sm-4">
                                <div class="styled-select-filters">
                                    <select name="sort_price" id="sort_price">
                                        <option value="" selected>Sort by price</option>
                                        <option value="lower">Lowest price</option>
                                        <option value="higher">Highest price</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 d-none d-sm-block text-end">
                                <a href="#" class="bt_filters"><i class="icon-th"></i></a> <a
                                    href="all_hotels_list.html" class="bt_filters"><i class=" icon-list"></i></a>
                            </div>
                        </div>
                    </div>
                    <!--End tools -->

                    <div id="list_result"></div>

                </div>
                <!-- End col lg-9 -->
            </div>
            <!-- End row -->
        </div>
        <!-- End container -->
    </main>
    <!-- End main -->
@endsection
@push('custom-scripts')
    <script>
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
                        } else {
                            toastr.warning(response.message);
                        }
                        load_data(1);
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        }
    </script>
@endpush
