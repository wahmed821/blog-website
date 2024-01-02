@extends('layout.app')

@section('content')

<div class="row tm-row tm-mb-120">
    <div class="col-12">
        <h2 class="tm-color-primary tm-post-title tm-mb-60">Signup</h2>
    </div>

    <div class="col-lg-12 tm-contact-left">
        <p>Enter the details to create your account</p>
        <form method="POST" action="{{ route('user.register') }}" class="tm-contact-form">
            @csrf
            <div class="form-group row mb-4">
                <label for="name" class="col-sm-3 col-form-label text-left tm-color-primary">Name</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="name" id="name" type="text" value="{{ old('name') }}">

                    @error('name')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="email" class="col-sm-3 col-form-label text-left tm-color-primary">Email</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="email" id="email" type="email" value="{{ old('email') }}">

                    @error('email')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-4">
                <label for="subject" class="col-sm-3 col-form-label text-left tm-color-primary">Password</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="password" id="password" type="password">

                    @error('password')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4">
                <label for="subject" class="col-sm-3 col-form-label text-left tm-color-primary">Confirm Password</label>
                <div class="col-sm-9">
                    <input class="form-control mr-0 ml-auto" name="confirm_password" id="confirm-password" type="password">
                    @error('confirm_password')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
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
