@extends('layouts.backend.master')
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
            <a href="{{ route('backend.facilities.index') }}" class="text-white">Facilities</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">Edit Facility</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('title', 'Edit Facility')
@section('content')
    <form id="form_input" class="form d-flex flex-column flex-lg-row"
        data-kt-redirect="{{ route('backend.facilities.index') }}"
        action="{{ route('backend.facilities.update', $facility->id) }}" method="PUT">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>General</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Name</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="name" class="form-control form-control-solid"
                            placeholder="Enter name" value="{{ $facility->name }}" />
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Enter the name for the menu.
                        </div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            <!--end::General options-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="javascript:;" data-kt-element="cancel" class="btn btn-light me-5">Cancel</a>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" class="btn btn-primary" data-kt-element="submit">
                    <span class="indicator-label">Save Changes</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
@endsection
@push('custom-scripts')
    <script src="{{ asset('js/FormControls.js') }}"></script>
    <script>
        const formEl = $('#form_input');
        formEl.on('submit', function(e) {
            e.preventDefault();
            KTFormControls.onSubmitForm(formEl);
        });
        const btnCancelEl = formEl.find('[data-kt-element="cancel"]');
        btnCancelEl.on('click', function(e) {
            e.preventDefault();
            KTFormControls.onCancelForm(formEl);
        });
    </script>
@endpush
