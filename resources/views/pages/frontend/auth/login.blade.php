@extends('layouts.frontend.master')
@section('content')
    <main>
        <section id="hero" class="login">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                        <div id="login">
                            <div class="text-center">
                                <img src="{{ asset('images/' . getSettings('site_logo')) }}" alt="Image" width="160"
                                    height="34">
                            </div>
                            <hr>
                            <form method="POST" action="{{ route('login') }}" id="login-form">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" />
                                </div>
                                <p class="small">
                                    <a href="#">Lupa password?</a>
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
@push('custom-scripts')
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
