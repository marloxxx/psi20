@extends('layouts.frontend.master')
@section('content')
    <main>
        <section id="hero" class="login">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                        <div id="login">
                            <div class="text-center"><img src="img/logo_sticky.png" alt="Image" width="160"
                                    height="34"></div>
                            <hr>
                            <form>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First name" name="first_name" />
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
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
                                <button class="btn_full">Create an account</button>
                                <a href="{{ route('login') }}" class="btn_full_outline">Login</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End main -->
@endsection
