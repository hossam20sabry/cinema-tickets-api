<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/login.css')}}">
    <title>Confirm Password</title>
</head>
<body>
    <div class="container center min_height">
        
        <div class="form_shape p-3">
            <a href="/" class="logo p-3">
                <img src="{{asset('/home/img/logo 102.png')}}" alt="...">
                {{-- <h1>Movies Tickets</h1> --}}
            </a>
            <form method="POST" action="{{ route('password.confirm') }}" class="p-2">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label" >Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" aria-describedby="emailHelp">
                </div>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
                <button type="submit" class="btn btn-primary w-100">Confirm</button>
                
            </form>
        </div>
        
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>

