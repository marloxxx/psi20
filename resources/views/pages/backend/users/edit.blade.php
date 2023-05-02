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
            <a href="{{ route('backend.users.index') }}" class="text-white">Users</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">Edit User</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('title', 'Edit User')
@section('content')
    <form id="form_input" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{ route('backend.users.index') }}"
        action="{{ route('backend.users.update', $user->id) }}" method="PUT">
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-5">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                        value="{{ $user->first_name }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the first name of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        value="{{ $user->last_name }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the last name of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>

                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Email</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="email" class="form-control" placeholder="Email"
                                        value="{{ $user->email }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the email of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Phone Number</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="phone_number" class="form-control"
                                        placeholder="Phone Number" value="{{ $user->phone_number }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the phone number of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Date of Birth</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="date_of_birth" class="form-control"
                                        placeholder="Date of Birth" value="{{ $user->date_of_birth }}" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the phone number of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Roles</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="roles[]" class="form-select" multiple="multiple" data-control="select2"
                                        data-placeholder="Select Roles">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }} "
                                                {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the roles of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <div class="mb-5 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="required form-label">Password</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="password" name="password" class="form-control" placeholder="Password" />
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">
                                        This is the password of the user.
                                    </div>
                                    <!--end::Description-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::General options-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <a href="{{ route('backend.users.index') }}" data-kt-element="cancel" class="btn btn-light me-5">Cancel</a>
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
    </form>
@endsection
@push('custom-scripts')
    <script src="{{ asset('js/FormControls.js') }}"></script>
    <script>
        $('input[name="date_of_birth"]').flatpickr({
            dateFormat: "Y-m-d",
            allowInput: true,
        });
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
