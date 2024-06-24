@extends('layouts.frontend.master')
@section('content')
    <main>
        <section id="hero" class="login"
            style="background: url({{ asset('frontend/img/auth_bg.jpg') }}) no-repeat center center;  background-size: cover;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                        <div id="login">
                            <div class="text-center">
                                <img src="{{ asset('images/' . getSettings('site_logo')) }}" alt="Image" />
                            </div>
                            <hr>
                            <form method="POST" action="{{ route('login') }}" id="login-form">
                                <a href="#0" class="social_bt facebook">Login with Facebook</a>
                                <a href="#0" class="social_bt google">Login with Google</a>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" />
                                </div>
                                <p class="small">
                                    <a href="#">Forgot Password?</a>
                                </p>
                                <button type="submit" class="btn_full">Masuk</button>
                                <a href="{{ route('register') }}" class="btn_full_outline">Daftar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End main -->
@endsection
@push('scripts')
    <script src="{{ asset('js/FormControls.js') }}"></script>
    <script>
        "use strict";
        const formEl = $('#login-form');
        formEl.on('submit', function(e) {
            e.preventDefault();
            KTFormControls.onSubmitForm(formEl);
        });
    </script>
@endpush
