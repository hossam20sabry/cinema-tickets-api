@extends('home.layout')
@section('css', '/home/css/movies-page.css')

@section('content')
<div class="container-fluid px-sm-5 ">

    <div class="row mb-2 border_bottom">
        <div class="col-sm-6">
            <h1 class="head-title text-center text-sm-start mt-2">movies</h1>
        </div>
        <div class="col-sm-6  d-flex justify-content-end">
            @error('search')
                    <p class="text-danger m-2 p-1">{{ $message }}</p>
            @enderror
            <form class="d-flex box_shadow m-2 p-1 rounded" role="search" action="{{ route('movies.index') }}" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>

    @if(count($movies) > 0)
        <div class="row row-cols-1 row-cols-md-3 row-cols-sm-2 g-4" id="movies-page">

            @foreach ($movies as $movie)
            <div class="col relative">
                <div class="card" style="border: none">
                    <img src="{{asset('/photos/' . $movie->photo_url)}}" class="card-img-top" alt="...">
                    <div class="card-body" style="--bs-card-spacer-y: 1rem; --bs-card-spacer-x: 0rem">
                        <h5 class="card-title">{{$movie->name}}</h5>
                        <p class="card-text capi">Duration: {{$movie->duration}}<br>Director: {{$movie->director}}</p>
                        <form action="{{ route('bookings.store', $movie->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
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

        @else
            <h1 class="text-center">No movies found</h1>
        @endif
</div>
@endsection