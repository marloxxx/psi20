@extends('layouts.backend.master')
@section('title', 'All Bookings')
@section('breadcrumb')
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-semibold">
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">
            <a href="{{ route('backend.dashboard') }}" class="text-white">
                <i class="ki-outline ki-home text-white fs-3"></i>
            </a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">
            <a href="{{ route('backend.bookings.index') }}" class="text-white">Bookings</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">All Bookings</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('content')
    <!--begin::role-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-filter="search" class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search Booking" />
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Export-->
                <a href="{{ route('backend.bookings.pdf') }}" target="_blank" class="btn btn-light-primary">
                    <i class="ki-outline ki-exit-up fs-2"></i> Export PDF
                </a>
                <!--end::Export-->
                <button type="button" onclick="delete_all();" class="btn btn-danger me-3" id="kt_toolbar_delete_button">
                    Delete All
                </button>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="datatables">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-250px">Customer</th>
                        <th class="min-w-250px">Homestay</th>
                        <th class="min-w-250px">Total Price</th>
                        <th class="min-w-70px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Menu-->
@endsection
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#kt_toolbar_delete_button').hide();
            $('#datatables').DataTable({
                serverSide: true,
                ajax: '{{ route('backend.bookings.index') }}',
                columns: [{
                        data: 'user',
                        name: 'user',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'homestay',
                        name: 'homestay',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'total_price',
                        name: 'total_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('[data-filter="search"]').on('keyup', function() {
                $('#datatables').DataTable().search(
                    $(this).val()
                ).draw();
            });
        });

        function check_all(el) {
            var is_checked = $(el).is(':checked');
            if (is_checked) {
                $('#datatables').find('tbody input[type="checkbox"]').prop('checked', true);
                $('#kt_toolbar_delete_button').show();
                $('#kt_toolbar_primary_button').hide();
            } else {
                $('#datatables').find('tbody input[type="checkbox"]').prop('checked', false);
                $('#kt_toolbar_delete_button').hide();
                $('#kt_toolbar_primary_button').show();
            }
        }

        function delete_all() {
            var ids = [];
            $('#datatables').find('tbody input[type="checkbox"]:checked').each(function(i) {
                ids[i] = $(this).val();
            });
            if (ids.length > 0) {
                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Data yang dipilih akan dihapus!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: {
                                ids: ids,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.alert) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        $('#datatables').DataTable().ajax.reload();
                                        $('#check-all').prop('checked', false);
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Terjadi kesalahan saat menghapus data',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Batal!',
                            text: 'Konfirmasi dibatalkan',
                            icon: 'info',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: "Pilih data yang akan dihapus!",
                    text: "",
                    icon: "warning",
                    confirmButtonText: 'Ok'
                });
            }
        }
    </script>
@endpush
