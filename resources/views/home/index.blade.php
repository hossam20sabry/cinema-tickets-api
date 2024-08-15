@extends('home.layout')
@section('css', '/home/css/main.css')
@section('content')
<section class="banner">
    @if(session('error'))
    <div class="row mb-5" id="msg">
        <div class="col-12">
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        </div>
    </div>
    @endif
    <h2>Welcome to our Cinemas</h2>
    <p>Book your favorite movies now and enjoy your time at our cinemas.</p>
    <!-- <a href="./movie-page.html">View Movies</a> -->
</section>
<section class="container-fluid px-lg-5 my-3">
    
    <div class="row mt-2">
        <div class="col-sm-6">
            <h2 class="mt-2 text-uppercase movie_title_responsive">MOVIES</h2>
        </div>
        <div class="col-sm-6  d-flex justify-content-end">
            @error('search')
                    <p class="text-danger m-2 p-1">{{ $message }}</p>
            @enderror
            <form class="d-flex box_shadow p-2 rounded" role="search" action="{{ route('movies.search') }}" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row mb-3 border-bottom">
        @foreach ($explores as $key => $movie)
        <div class="col-sm-3 my-3">
            <div class="movie_card">
                <div class="head">
                    <img src="/posters/{{ $movie['poster_url'] }}">
                </div>
                <div class="tail"> 
                    <div class="left">
                        <h2 class="hh2 text-uppercase">{{ $movie['name'] }}</h2>
                        <p>Duration: {{ $movie['duration'] }}</p>
                        <p class="text-capitalize">Director: {{ $movie['director'] }}</p>
                    </div>
                    <div class="right">
                        <form action="{{ route('bookings.store', $movie->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                            <button type="submit" class="btn btn-info tickets-btn-position" >
                                <img src="{{asset('home/img/logo 102.png')}}" class="img-fluid" alt="...">
                                <p class="pt-3">Tickets</p>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    {{-- //theaters// --}}
    <div class="row mt-2">
        <div class="col-sm-6">
            <h2 class="mt-2 text-uppercase movie_title_responsive">theaters</h2>
        </div>
        <div class="col-sm-6  d-flex justify-content-end">
            @error('search')
                    <p class="text-danger m-2 p-1">{{ $message }}</p>
            @enderror
            <form class="d-flex box_shadow p-2 rounded" role="search" action="{{ route('theaters.index') }}" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class="row mb-3">
        @foreach ($theaters as $key => $theater)
        <div class="col-sm-4 my-3">
            <div class="movie_card">
                <a href="{{ route('theaters.show', $theater->id)}}">
                <div class="head_theater">
                    <img src="/cinema_photos/{{$theater->img}}">
                </div>
                <div class="tail">
                    <div class="left">
                        <h2 class="hh2 text-uppercase">{{ $theater->name }}</h2>
                        <p class="card-text">Address: <span class="text-uppercase">{{$theater->city}} - {{$theater->location}}</span></p>
                    </div>
                    <div class="right">
                        
                    </div>
                </div>
                </a>
            </div>
        </div>
        @endforeach
        <div class="col-12 d-flex justify-content-center">
            {{ $theaters->links() }} 
        </div>
    </div>
</section>

@endsection
@section('script')
<script>

    $(document).ready(function(){
        setTimeout(() => {
            $('#msg').hide();
        }, 5000);
    })

</script>
@endsection