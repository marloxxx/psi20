@extends('layouts.backend.master')
@section('title', 'Edit Event')
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
            <a href="{{ route('backend.events.index') }}" class="text-white">Events</a>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <i class="ki-outline ki-right fs-4 text-white mx-n1"></i>
        </li>
        <!--end::Item-->
        <!--begin::Item-->
        <li class="breadcrumb-item text-white fw-bold lh-1">Edit Event</li>
        <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
@endsection
@section('title', 'Edit Event')
@section('content')
    <form id="form_input" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{ route('backend.events.index') }}"
        action="{{ route('backend.events.update', $event->id) }}" method="PUT" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="event_id">
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
                    <div class="image-input image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                        <!--begin::Preview existing primary image-->
                        <div class="image-input-wrapper w-150px h-150px"
                            style="background-image: url('{{ asset($event->images->first()->image_path) }}')">

                        </div>
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
            <!--begin::Start Date-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Start Date</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Start Date</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Select date" value="{{ $event->start_date }}" />
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Start Date-->
            <!--begin::End Date-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>End Date</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">End Date</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="end_date" class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="Select date" value="{{ $event->end_date }}" />
                        <!--end::Input-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::End Date-->
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
                            <label class="required form-label">Title</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control mb-2" placeholder="Title"
                                value="{{ $event->title }}" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A title is required and recommended to be unique.
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
                            <textarea name="address" class="form-control mb-2" placeholder="Address">
                                {{ $event->address }}
                            </textarea>
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
                            <input type="text" name="latitude" class="form-control mb-2" placeholder="Latitude"
                                value="{{ $event->latitude }}" />
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
                            <input type="text" name="longitude" class="form-control mb-2" placeholder="Longitude"
                                value="{{ $event->longitude }}" />
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">A longitude is required for the homestay.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div>
                            <!--begin::Label-->
                            <label class="form-label">Description</label>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <div id="description" class="min-h-200px mb-2">
                                {!! $event->description !!}
                            </div>
                            <input type="hidden" name="description" value="{{ $event->description }}" />
                            <!--end::Editor-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Set a description to the product for better visibility.
                            </div>
                            <!--end::Description-->
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
@push('scripts')
    <script src="{{ asset('js/FormControls.js') }}"></script>
    <script>
        $('input[name="start_date"]').flatpickr({
            dateFormat: "Y-m-d",
            minDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                $('input[name="end_date"]').flatpickr({
                    dateFormat: "Y-m-d",
                    minDate: dateStr,
                    defaultDate: dateStr,
                });
            }
        });
        $('input[name="end_date"]').flatpickr({
            dateFormat: "Y-m-d",
            minDate: "today",
            time_24hr: true,
        });
        const formEl = $('#form_input');
        const token = $('meta[name="csrf-token"]').attr('content');
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('backend.events.storeImage') }}",
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
                $.get("{{ route('backend.events.getImages', $event->id) }}", function(data) {
                    $.each(data, function(key, value) {
                        var mockFile = {
                            name: value.name,
                            size: value.size
                        };
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile,
                            "{{ asset('images/events') }}/" + value.name);
                        myDropzone.emit("complete", mockFile);
                        myDropzone.files.push(mockFile);
                    });
                });
                //form submit
                formEl.on('submit', function(event) {
                    const btn = formEl.find('[data-kt-element="submit"]');
                    const action = formEl.attr("action");
                    const method = formEl.attr("method");
                    const enctype = formEl.attr("enctype");
                    const data = new FormData(formEl[0]);
                    data.append("_method", method);
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
                                $('[name="event_id"]').val(response.id);
                                if (myDropzone.getQueuedFiles().length > 0) {
                                    myDropzone.processQueue();
                                } else {
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
                                                "{{ route('backend.events.index') }}";
                                        }
                                    });
                                }
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
                    formData.append('event_id', $('[name="event_id"]').val());
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
                            window.location.href = "{{ route('backend.events.index') }}";
                        }
                    });
                });

                this.on("errormultiple", function(files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            }
        });
        // Class definition
        const EventForm = function() {
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
            EventForm.init();
        });
        const btnCancelEl = formEl.find('[data-kt-element="cancel"]');
        btnCancelEl.on('click', function(e) {
            e.preventDefault();
            KTFormControls.onCancelForm(formEl);
        });
    </script>
@endpush
