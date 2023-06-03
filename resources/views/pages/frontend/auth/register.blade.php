@extends('layouts.frontend.master')
@section('content')
    <main>
        <section id="hero" class="login"
            style="background: url({{ asset('frontend/img/slides/slide_home_1.jpg') }}) no-repeat center center;  background-size: cover;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                        <div id="login">
                            <div class="text-center">
                                <img src="{{ asset('images/' . getSettings('site_logo')) }}" alt="Image" />
                            </div>
                            <hr>
                            <form method="POST" action="{{ route('register') }}" id="register-form">
                                <div class="form-group">
                                    <label>Nama Depan</label>
                                    <input type="text" class="form-control" placeholder="First name" name="first_name" />
                                </div>
                                <div class="form-group">
                                    <label>Nama Belakang</label>
                                    <input type="text" class="form-control" placeholder="Last name" name="last_name" />
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" />
                                </div>
                                <div class="form-group">
                                    <label>Confirm password</label>
                                    <input type="password" class="form-control" placeholder="Confirm password"
                                        name="password_confirmation" />
                                </div>
                                <div id="pass-info" class="clearfix"></div>
                                <button class="btn_full">Buat Akun</button>
                                <a href="{{ route('login') }}" class="btn_full_outline">Masuk</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End main -->
@endsection
@push('custom-scripts')
    <script src="{{ asset('js/FormControls.js') }}"></script>
    <script>
        "use strict";
        const formEl = $('#register-form');
        formEl.on('submit', function(e) {
            e.preventDefault();
            KTFormControls.onSubmitForm(formEl);
        });
    </script>
@endpush
