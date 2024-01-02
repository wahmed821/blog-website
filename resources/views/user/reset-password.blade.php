@extends('layout.app')

@section('content')

<div class="row tm-row tm-mb-120">
    <div class="col-12">
        <h2 class="tm-color-primary tm-post-title tm-mb-60">Reset Password</h2>
    </div>

    <!--Alert file-->
    @include('include.alert')

    <div class="col-lg-12 tm-contact-left">
        <p>Reset your account your account</p>
        <form method="POST" action="{{ route('user.reset-password-submit') }}" class="tm-contact-form">
            @csrf
            <div class="form-group row mb-4">
                <label for="name" class="col-sm-3 col-form-label text-left tm-color-primary">Verification Code</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="code" id="code" type="text">
                </div>
            </div>

            <div class="form-group row mb-4">
                <label for="subject" class="col-sm-3 col-form-label text-left tm-color-primary">New Password</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="password" id="password" type="password">
                </div>
            </div>

            <div class="form-group row mb-4">
                <label for="subject" class="col-sm-3 col-form-label text-left tm-color-primary">Confirm Password</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="confirm_password" id="confirm-password" type="password">
                </div>
            </div>

            <div class="form-group row text-left">
                <div class="col-12">
                    <button type="submit" class="tm-btn tm-btn-primary tm-btn-small">Submit</button>
                </div>
            </div>
        </form>
        <hr>
        <p>Already have an account? <a href="{{ route('user.login') }}">Login now</a></p>
    </div>
</div>
@endsection
