<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/login.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <title>login</title>
</head>
<body>
    @if (session('status'))
    <div class="container mt-4">
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    </div>
    @endif
    <div class="container center min_height">
        <div class="form_shape p-3">
            <a href="/" class="logo p-3">
                <img src="{{asset('/home/img/logo 102.png')}}" alt="">
                {{-- <h1>Movies Tickets</h1> --}}
            </a>
            <form method="POST" action="{{ route('login') }}" class="p-2">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label" >Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required autofocus autocomplete="username" aria-describedby="emailHelp">
                    @error('email')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 spiner">Log in</button>
                
                
                <div class="center mt-2">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <a href="{{ route('register') }}" class="mx-3 spiner">Register?</a>
                </div>

            </form>
        </div>
        
    </div>

    <div class="mainSpinner d-none" id="mainSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        $('.spiner').click( function(){
            $('#mainSpinner').removeClass('d-none');
        });
    </script>
</body>
</html>