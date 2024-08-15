@extends('home.layout')
@section('css', '/home/css/movies-page.css')

@section('content')
<div class="container-fluid px-lg-5 ">

    <h1 class="head-title text-center text-sm-start py-1 mb-3 border-bottom">{{$kind->title}} movies </h1>
        @if($movies->count() > 0)
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
            <p class="text-center">No Movies found</p>
        @endif
</div>
@endsection