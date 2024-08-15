<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/login.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <title>Verify Email</title>
</head>
<body>
    <div class="container center min_height">
        
        <div class="form_shape p-3">
            <a href="/" class="logo p-3">
                <img src="{{asset('/home/img/logo 102.png')}}" alt="">
                {{-- <h1>Movies Tickets</h1> --}}
            </a>
            <p>We have emailed your password reset link!</p>
            <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.</p>
            @if(session('status') == 'verification-link-sent')
                <p class="text-green-600">A new verification link has been sent to the email address you provided during registration.</p>
            @endif
            <div class="mt-4 flex items-center justify-between">
                <div class="row">
                    <div class="col-md-8">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                
                            <div>
                                <button class="btn btn-primary" type="submit">Resend Verification Email</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                
                            <button type="submit" class="btn btn-danger">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
                
        
                
            </div>
        </div>
        
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>

