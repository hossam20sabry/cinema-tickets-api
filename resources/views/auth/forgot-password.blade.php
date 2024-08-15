
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/login.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <title>Forget Password</title>
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
            <form method="POST" action="{{ route('password.email') }}" class="p-2">
                @csrf

                <div class="mb-3">
                    <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
                    <label for="email" class="form-label" >Email address</label>
                    <input type="email" class="form-control" id="email" name="email" :value="old('email')" required autofocus autocomplete="username" aria-describedby="emailHelp">
                    {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                </div>
                @error('email')
                <div class="form-error">
                    <p class="text-danger mb-3">{{$message}}</p>
                </div>
                @enderror
                
                <button type="submit" class="btn btn-primary w-100">Email Password Reset Link</button>

                
                
            </form>
        </div>
        
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
