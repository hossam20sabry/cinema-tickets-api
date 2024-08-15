<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href={{asset('/home/css/index.css')}}>   
    <link rel="stylesheet" href="@yield('css')">
    <link rel="icon" href="{{asset('home/img/logo 102.png')}}">
    <title>Cinema Tickets</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar_color box_shadow" style="width: 100%; z-index: 100;">
        <div class="container-fluid px-lg-5">

            <a href="/" style="width: 40px; height: 40px;">
                    <img src="{{asset('/home/img/logo 102.png')}}" style="width: 40px; height: 40px;" 
                    class="img-fluid" alt="img logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse " id="navbarNavDropdown">

                <ul class="navbar-nav me-auto mb-2 mt-3">
                    <li class="nav-item">
                        <a href="{{ route('theaters.index') }}" class="nav-link text-capitalize">Theaters</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('movies.index') }}" class="nav-link text-capitalize">Movies</a>  
                    </li>

                    @if(Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('bookings.index') }}" class="nav-link text-capitalize">Bookings</a>  
                        </li>
                    @endauth
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-capitalize  text-center " style="color: black !important" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kinds
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($kinds as $kind)
                            <li><a class="dropdown-item" href="{{ route('kinds.show', $kind->id)}}">{{$kind->title}}</a></li>
                            @endforeach
                        </ul>
                    </li>       
                </ul>
                
                @if(Route::has('login'))
                @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-capitalize nav_item text-center box_shadow" style="color: black !important" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                            $userNameParts = explode(' ', Auth::user()->name, 2);
                            $displayName = $userNameParts[0];
                        ?>
                        {{ $displayName }}
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a></li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">log out</button>
                        </form>
                    </ul>
                </div>
                @else
                <div class="d-flex">   
                    <a class="btn btn-outline-light m-2" aria-current="page" href="{{ route('login') }}">Log in</a>
                    <a class="btn btn-light m-2" aria-current="page" href="{{ route('register') }}">Register</a>
                </div>  
                @endauth
                @endif
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