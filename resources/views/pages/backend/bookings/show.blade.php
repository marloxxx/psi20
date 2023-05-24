@extends('layouts.backend.master')
@section('title', 'Detail Bookings')
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
        <li class="breadcrumb-item text-white fw-bold lh-1">Detail Booking</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('content')
    <!--begin::Order details page-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <!--begin::Order summary-->
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <!--begin::Order details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Booking Details #{{ $booking->code }}</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-calendar fs-2 me-2"></i>Date Added
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{ $booking->created_at }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-wallet fs-2 me-2"></i>Payment Status
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {!! $booking->payment_status() !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-check fs-2 me-2"></i>Booking Status
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {!! $booking->status() !!}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Order details-->
            <!--begin::Customer details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Details</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-profile-circle fs-2 me-2"></i>Customer
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin:: Avatar -->
                                            <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                <a href="../../demo30/dist/apps/ecommerce/customers/details.html">
                                                    <div class="symbol-label">
                                                        <img src="{{ asset('backend/media/avatars/300-23.jpg') }}"
                                                            alt="{{ $booking->user->first_name }} {{ $booking->user->last_name }}"
                                                            class="w-100" />
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Name-->
                                            <a href="../../demo30/dist/apps/ecommerce/customers/details.html"
                                                class="text-gray-600 text-hover-primary">{{ $booking->user->first_name }}
                                                {{ $booking->user->last_name }}</a>
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-sms fs-2 me-2"></i>Email
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="../../demo30/dist/apps/user-management/users/view.html"
                                            class="text-gray-600 text-hover-primary">{{ $booking->user->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-phone fs-2 me-2"></i>Phone
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">+{{ $booking->user->phone_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Customer details-->
            <!--begin::Booking details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Booking Details</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-calendar fs-2 me-2"></i>Check In
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span
                                                class="badge badge-light-primary">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-calendar fs-2 me-2"></i>Check Out
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span
                                                class="badge badge-light-primary">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            {{-- get nights --}}
                                            <i class="ki-outline ki-calendar fs-2 me-2"></i>Nights
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span
                                                class="badge badge-light-primary">{{ \Carbon\Carbon::parse($booking->check_out)->diffInDays(\Carbon\Carbon::parse($booking->check_in)) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Customer details-->
        </div>
        <!--end::Order summary-->
        <!--begin::Tab content-->
        <!--begin::Product List-->
        <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>#{{ $booking->code }}</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-175px">Homestay</th>
                                <th class="min-w-100px text-end">Price</th>
                                <th class="min-w-70px text-end">Nights</th>
                                <th class="min-w-100px text-end">Subtotal</th>
                                <th class="min-w-100px text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!--begin::Thumbnail-->
                                        <span class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url('{{ asset($booking->homestay->images[0]->image_path) }}')">
                                            </span>
                                        </span>
                                        <!--end::Thumbnail-->
                                        <!--begin::Title-->
                                        <div class="ms-5">
                                            <span
                                                class="fw-bold text-gray-600 text-hover-primary">{{ $booking->homestay->name }}</span>
                                            <div class="fs-7 text-muted">{{ $booking->homestay->address }}</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                </td>
                                <td class="text-end">Rp. {{ number_format($booking->homestay->price) }}</td>
                                <td class="text-end">
                                    {{ \Carbon\Carbon::parse($booking->check_out)->diffInDays(\Carbon\Carbon::parse($booking->check_in)) }}
                                </td>
                                <td class="text-end">Rp.
                                    {{ number_format($booking->homestay->price * \Carbon\Carbon::parse($booking->check_out)->diffInDays(\Carbon\Carbon::parse($booking->check_in))) }}
                                </td>
                                <td class="text-end">Rp. {{ number_format($booking->total_price) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="fs-3 text-dark text-end">Grand Total</td>
                                <td class="text-dark fs-3 fw-bolder text-end">Rp.
                                    {{ number_format($booking->total_price) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!--end::Table-->
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Product List-->
        <!--end::Tab content-->
    </div>
    <!--end::Order details page-->
@endsection
