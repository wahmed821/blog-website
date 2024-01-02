<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>Hello {{ Auth::user()->name }}</h2>

    <a class="btn btn-primary" href="{{ route('user.logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fe-log-out"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</body>

</html>
