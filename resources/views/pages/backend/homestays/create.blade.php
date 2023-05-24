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
            <a href="{{ route('backend.homestays.index') }}" class="text-white">Homestays</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">Add Homestay</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('title', 'Add Homestay')
@section('content')
    <form id="form_input" class="form d-flex flex-column flex-lg-row"
        data-kt-redirect="{{ route('backend.homestays.index') }}" action="{{ route('backend.homestays.store') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="homestay_id">
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Thumbnail</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <!--begin::Image input-->
                    <!--begin::Image input placeholder-->
                    <style>
                        .image-input-placeholder {
                            background-image: url('{{ asset('backend/media/svg/files/blank-image.svg') }}');
                        }

                        [data-bs-theme="dark"] .image-input-placeholder {
                            background-image: url('{{ asset('backend/media/svg/files/blank-image-dark.svg') }}');
                        }
                    </style>
                    <!--end::Image input placeholder-->
                    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                        data-kt-image-input="true">
                        <!--begin::Preview existing primary image-->
                        <div class="image-input-wrapper w-150px h-150px"></div>
                        <!--end::Preview existing primary image-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change image">
                            <i class="ki-outline ki-pencil fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg" />
                            <input type="hidden" name="image_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel image">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove image">
                            <i class="ki-outline ki-cross fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files
                        are accepted</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Thumbnail settings-->
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" data-bs-toggle="tooltip" title="Online"
                            id="status"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                        data-placeholder="Select an option" id="status" name="is_available">
                        <option value="1">Available</option>
                        <option value="0">Unavailable</option>
                    </select>
                    <!--end::Select2-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Category & tags-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Homestay Facilities</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="form-label">Facilities</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-placeholder="Select an option"
                        data-allow-clear="true" multiple="multiple" name="facilities[]">
                        <option></option>
                        @foreach ($facilities as $facility)
                            <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-7">Add product to a category.</div>
                    <!--end::Description-->
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Category & tags-->
        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <div class="d-flex flex-column gap-7 gap-lg-10">
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
                            <input type="text" name="name" class="form-control mb-2" placeholder="Name" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A name is required and recommended to be unique.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="required form-label">Total Room</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="total_rooms" class="form-control mb-2" placeholder="Total Room" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A total room is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="required form-label">Price Per Night</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="price_per_night" class="form-control mb-2"
                                placeholder="Price Per Night" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A price is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="required form-label">Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="address" class="form-control mb-2" placeholder="Address"></textarea>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A address is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="required form-label">Latitude</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="latitude" class="form-control mb-2" placeholder="Latitude" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A latitude is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="required form-label">Longitude</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="longitude" class="form-control mb-2" placeholder="Longitude" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A longitude is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Description</label>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <div id="description" class="min-h-200px mb-2">
                            </div>
                            <input type="hidden" name="description" />
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Set a description to the product for better visibility.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Owner Phone Number</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="owner_phone_number" class="form-control mb-2"
                                placeholder="Owner Phone Number" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Owner Phone Number is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class="form-label">Owner Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="owner_name" class="form-control mb-2"
                                placeholder="Owner Name" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Owner Name is required for the homestay.
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::General options-->
                <!--begin::Media-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Media</h2>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Input group-->
                        <div class="fv-row mb-2">
                            <!--begin::Dropzone-->
                            <div class="dropzone" id="dropzone">
                                <!--begin::Message-->
                                <div class="dz-message needsclick">
                                    <!--begin::Icon-->
                                    <i class="ki-outline ki-file-up text-primary fs-3x"></i>
                                    <!--end::Icon-->
                                    <!--begin::Info-->
                                    <div class="ms-4">
                                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to
                                            upload.</h3>
                                        <span class="fs-7 fw-semibold text-gray-400">Upload up to 10 files</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                            </div>
                            <!--end::Dropzone-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Set the homestay media gallery.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::Media-->
            </div>
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
        $('select[name="is_available"]').on('change', function() {
            // change badge color
            if ($(this).val() == 1) {
                console.log('available');
                $('#status').removeClass('bg-danger');
            } else {
                $('#status').addClass('bg-danger');
            }
        });
        const formEl = $('#form_input');
        const token = $('meta[name="csrf-token"]').attr('content');
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('backend.homestays.storeImage') }}",
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 20,
            maxFilesize: 2, // MB
            autoProcessQueue: false,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': token
            },
            init: function() {
                var myDropzone = this;
                //form submit
                formEl.on('submit', function(event) {
                    const btn = formEl.find('[data-kt-element="submit"]');
                    const action = formEl.attr("action");
                    const method = formEl.attr("method");
                    const enctype = formEl.attr("enctype");
                    const data = new FormData(formEl[0]);
                    event.preventDefault();
                    $.ajax({
                        url: action,
                        method: "POST",
                        data: data,
                        dataType: "json",
                        enctype: enctype,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            btn.attr("data-kt-indicator", "on");
                            btn.prop("disabled", true);
                        },
                        success: function(response) {
                            if (response.status == "error") {
                                Swal.fire({
                                    text: response.message,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                                btn.removeAttr("data-kt-indicator");
                                btn.prop("disabled", false);
                            } else {
                                $('[name="homestay_id"]').val(response.id);
                                myDropzone.processQueue();
                            }

                        }
                    });
                });
                this.on('sending', function(file, xhr, formData) {

                });
                this.on("success", function(file, response) {

                });
                this.on("queuecomplete", function() {

                });

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function(files, xhr, formData) {
                    formData.append('homestay_id', $('[name="homestay_id"]').val());
                });

                this.on("successmultiple", function(files, response) {
                    Swal.fire({
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            window.location.href =
                                "{{ route('backend.homestays.index') }}";
                        }
                    });
                });

                this.on("errormultiple", function(files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            },
            removedfile: function(file) {
                var fileRef;
                return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(
                    file.previewElement) : void 0;
            }
        });
        // Class definition
        const HomestayForm = function() {
            // Base elements
            const editorEl = $('#description');
            const toolbar = [
                [{
                    'font': []
                }, {
                    'size': []
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'script': 'super'
                }, {
                    'script': 'sub'
                }],
                [{
                    'header': [false, 1, 2, 3, 4, 5, 6]
                }, 'blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }, {
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                ['direction', {
                    'align': []
                }],
                ['link', 'image', 'video', 'formula'],
                ['clean']
            ];
            var editor;
            // Private functions
            const _initEditor = function() {
                editor = new Quill(editorEl.get(0), {
                    placeholder: 'Enter the description...',
                    theme: 'snow',
                    modules: {
                        'toolbar': toolbar
                    }
                });
            }
            const _autoSave = function() {
                editor.on('text-change', function(delta, oldDelta, source) {
                    if (source == 'user') {
                        $('input[name="description"]').val(editor.root.innerHTML);
                    }
                });
            }

            return {
                // public functions
                init: function() {
                    _initEditor();
                    _autoSave();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            HomestayForm.init();
        });
        const btnCancelEl = formEl.find('[data-kt-element="cancel"]');
        btnCancelEl.on('click', function(e) {
            e.preventDefault();
            KTFormControls.onCancelForm(formEl);
        });
    </script>
@endpush
