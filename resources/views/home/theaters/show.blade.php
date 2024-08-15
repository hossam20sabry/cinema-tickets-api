@extends('home.layout')
@section('css', '/home/css/cinema.css')
@section('content')

    <section class="main">
        <img src="/wide_img_cinema_photos/{{$theater->wide_img}}" class="img-fluid bg" alt="...">
        <div class="bbody">
            <h2 style="text-transform: capitalize">Welcome to {{$theater->name}}</h2>
            <p class="text-capitalize">Book your favorite movies now and enjoy your time at our cinema. <br>
            Address: {{$theater->location}} | City: {{$theater->city}}</p>
        </div>
    </section>
    
    @if(count($theater->movies) > 0)
    <div class="container-fluid px-lg-5 pt-2 minHeight">
        <h1 class="head-title text-center my-3 py-1">{{$theater->name}}  movies</h1>
        <div class="row row-cols-1 row-cols-md-3 row-cols-sm-2 g-4" id="movies-page">
            @php $ch = 0; @endphp
            @foreach($theater->movies as $movie)
            <div class="col relative">
                <div class="card" style="border: none">
                    <img src="{{asset('/photos/' . $movie->photo_url)}}" class="card-img-top" alt="...">
                    <div class="card-body" style="--bs-card-spacer-y: 1rem; --bs-card-spacer-x: 0rem">
                        <h5 class="card-title">{{$movie->name}}</h5>
                        <p class="card-text capi">Duration: {{$movie->duration}}<br>Director: {{$movie->director}}</p>
                        <form action="{{ route('bookings.store', $movie->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <input type="hidden" name="theater_id" value="{{ $theater->id }}">
                            <button type="submit" class="btn btn-info tickets-btn-position">
                                <img src="{{asset('home/img/logo 102.png')}}" class="img-fluid" alt="..." style="width: 40px;height: 40px">
                                {{-- <p class="pt-3">Tickets</p> --}}
                            </button>
                        </form>
                    </div>
                        
                </div>
            </div>
            
            @endforeach
        </div>
        
    </div>
    @else
        <div class="centerhead pt-5 mt5">
            <h1>There is No Movies to Show in {{$theater->name}}</h1>
        </div>
    @endif
@endsection