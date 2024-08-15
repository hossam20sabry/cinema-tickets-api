<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/login.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <title>Cinema Tickets</title>
</head>
<body>
    <div class="container center min_height">
    
        <div class="form_shape p-sm-3 m-sm-5 p-2">
            <a href="{{ route('admin.dashboard')}}" class="logo p-3">
                <img src="{{asset('/home/img/logo 102.png')}}" alt="">
                {{-- <h1>Movies Tickets</h1> --}}
            </a>
            
            <h3 class="text-uppercase text-center">Create Admin</h3>


        <form method="POST" action="{{ route('admin.register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label" >Name</label>
                <input type="text" class="form-control" id="name" name="name" :value="old('name')"  autofocus autocomplete="username" aria-describedby="emailHelp">
            </div>
            @error('name')
            <div class="form-error">
                <p class="text-danger mb-3">{{$message}}</p>
            </div>
            @enderror

            
            <div class="mb-3">
                <label for="email" class="form-label" >Email address</label>
                <input type="email" class="form-control" id="email" name="email" :value="old('email')"  autofocus autocomplete="username" aria-describedby="emailHelp">
                {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
            </div>
            @error('email')
            <div class="form-error">
                <p class="text-danger mb-3">{{$message}}</p>
            </div>
            @enderror


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"  autocomplete="current-password">
            </div>
            @error('password')
            <div class="form-error">
                <p class="text-danger mb-3">{{$message}}</p>
            </div>
            @enderror
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"  autocomplete="current-password">
            </div>
            @error('password_confirmation')
            <div class="form-error">
                <p class="text-danger mb-3">{{$message}}</p>
            </div>
            @enderror

            <button type="submit" class="btn btn-primary w-100 spiner">Create</button>

            

            <div class="center mt-2">
                <a href="{{ route('admin.admins.index') }}" class="mx-3">All Admin</a>
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
    $('.spiner').on('click', function(){
        $('#mainSpinner').removeClass('d-none');
    });
</script>
</body>
</html>