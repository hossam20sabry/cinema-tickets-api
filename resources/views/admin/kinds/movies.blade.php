@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.movies.index') }}" class="decoration_none"><h3 class="m_r text-capatalize">Movies</h3></a>
        </div>
    </div>
</div>
<div class="container my-4">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
</div>

<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<div class="container">
    <h3 class="text-uppercase text-center border-bottom p-2 m-1">{{ $kind->title }} Movies</h3>
    @if($movies->count() > 0)
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Revenue</th>
                <th>Explore</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td class="text-capitalize">{{$movie->name}}</td>
                    <td>${{$movie->movie_renevues}}</td>
                    <td>
                        @if($movie->explore == 0)
                        <a href="{{route('admin.movies.explore', $movie->id)}}" class="btn btn-warning">Explore</a>
                        @else
                        <a href="{{route('admin.movies.unexplore', $movie->id)}}" class="btn btn-danger">Unexplore</a>
                        @endif
                    </td>
                    <td><a href="{{route('admin.movies.edit', $movie->id)}}" class="btn btn-info">Update</a></td>
                    <td>
                        <form action="{{route('admin.movies.destroy', $movie->id)}}" class="d-inline" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger text-upercase">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h1 class="text-center text-capitalize">there is no movies</h1>
    @endif
</div>

<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#submit').on('click', function(){
            $('#mainSpinner').removeClass('d-none');
        });
    })
</script>
@endsection