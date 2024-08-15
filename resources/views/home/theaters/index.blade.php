@extends('home.layout')
@section('css', '/home/css/movies-page.css')

@section('content')
<div class="container-fluid px-lg-5 ">

    
    <div class="row mb-2 border_bottom">
        <div class="col-sm-6">
            <h1 class="head-title text-center text-sm-start mt-2">theaters</h1>
        </div>
        <div class="col-sm-6  d-flex justify-content-end">
            @error('search')
                    <p class="text-danger m-2 p-1">{{ $message }}</p>
            @enderror
            <form class="d-flex box_shadow m-2 p-1 rounded" role="search" action="{{ route('theaters.index') }}" method="get">
                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                <button class="btn btn-outline-info" type="submit">Search</button>
            </form>
        </div>
    </div>

    @if(count($theaters) > 0)
        <div class="row row-cols-1 row-cols-md-3 row-cols-sm-2 g-4" id="movies-page">

            @foreach($theaters as $theater)
            <div class="col relative">
                <a href="{{route('theaters.show', $theater->id)}}" class="card" style="border: none">
                    <img src="/cinema_photos/{{$theater->img}}" class="card-img-top" alt="...">
                    <div class="card-body" style="--bs-card-spacer-y: 1rem; --bs-card-spacer-x: 0rem">
                        <h5 class="card-title">{{$theater->name}}</h5>
                        <p class="card-text">Address: <span class="text-uppercase">{{$theater->city}} - {{$theater->location}}</span></p>
                    </div>
                </a>    
            </div>
            @endforeach
            
        </div>
        <div class="d-flex justify-content-center">
            {{ $theaters->withQueryString()->links() }}
        </div>
    @else
        <p class="text-center">No Theaters found</p>
    @endif
</div>
@endsection