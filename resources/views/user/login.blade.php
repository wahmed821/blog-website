@extends('layout.app')

@section('content')

<div class="row tm-row tm-mb-120">
    <div class="col-12">
        <h2 class="tm-color-primary tm-post-title tm-mb-60">Login</h2>
    </div>
    <!--Alert file-->
    @include('include.alert')

    <div class="col-lg-7 tm-contact-left">
        <p>Enter the login credentials to login</p>
        <form method="POST" action="{{ route('user.login-submit') }}" class="tm-contact-form">
            @csrf
            <div class="form-group row mb-4">
                <label for="email" class="col-sm-3 col-form-label text-left tm-color-primary">Email</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="email" id="email" type="email" required>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="subject" class="col-sm-3 col-form-label text-left tm-color-primary">Password</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="password" id="password" type="password" required>
                </div>
            </div>

            <div class="form-group row text-left">
                <div class="col-12">
                    <button type="submit" class="tm-btn tm-btn-primary tm-btn-small">Login</button>
                </div>
            </div>
        </form>

        <p><a href="{{ route('user.forgot-password') }}">Forgot Password?</a></p>

        <hr>

        <p>Don't have an account? <a href="{{ route('user.signup') }}">Register now</a></p>
    </div>
</div>
@endsection
