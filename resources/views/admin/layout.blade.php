<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('/home/css/index.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <link rel="stylesheet" href="@yield('css')">
    <title>Cinema Dashboard</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd;">
        <div class="container space_between">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a href="{{ route('admin.categories.index') }}" class="nav-link text-capitalize">categories</a>
                <a href="{{ route('admin.kinds.index') }}" class="nav-link text-capitalize">kinds</a>
                <a href="{{ route('admin.theaters.index') }}" class="nav-link text-capitalize">Theaters</a>
                <a href="{{ route('admin.movies.index') }}" class="nav-link text-capitalize">Movies</a>            
                <a href="{{ route('admin.bookings.index') }}" class="nav-link text-capitalize">bookings</a>            
                <a href="{{ route('admin.admins.index') }}" class="nav-link text-capitalize">Admins</a>            
            </ul>
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-capitalize nav_item text-center box_shadow" style="color: black !important" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                        $userNameParts = explode(' ', Auth::guard('admin')->user()->name, 2);
                        $displayName = $userNameParts[0];
                    ?>
                    {{ $displayName }}
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profile</a></li>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">log out</button>
                    </form>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
    crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>

    @yield('script')
</body>
</html>