<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @include('email.style')
</head>

<body>
    <div id="box">
        <div class="text">
            <h1 class="title">Hello {{ $name }}</h1>
            <p>Welcome to {{ config('app.name') }}</p>
            <p>Please use the following code to activate your account.</p>
            <div class="button"><span>{{ $code }}</a></div>

            <br><br>
            <p>
                Thank you,<br>
                {{ config('app.name') }}
            </p>
        </div>
    </div>

</body>

</html>
