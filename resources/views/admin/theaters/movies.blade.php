@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="" class="decoration_none"><h3 class="text-uppercase">{{$theater->name}} Movies</h3></a>
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
    @if($movies->count() > 0)
    <form action="{{route('admin.theaters.addMovies', $theater->id)}}" method="post">
        @csrf
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Select</th>
                    <th>Add ShowTimes</th>
                    <th>Avilable Showtimes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <td class="text-capitalize">{{$movie->name}}</td>
                        <td>
                            @if ($theater->movies->contains($movie))
                            <a href="{{route('admin.theaters.deleteMovies', [$theater->id ,$movie->id])}}" class="btn btn-danger">Delete</a>
                            @else
                                <input type="checkbox" name="movies[]" value="{{$movie->id}}">
                            @endif
                        </td>
                        <td>
                            @if ($theater->movies->contains($movie))
                                <a href="{{route('admin.showtimes.create', [$theater->id ,$movie->id])}}" class="btn btn-primary">Add ShowTimes</a>
                            @endif
                        </td>
                        <td>
                            @if ($theater->movies->contains($movie))
                                <a href="{{route('admin.showtimes.index', [$theater->id,$movie->id])}}" class="btn btn-warning">ShowTimes</a>
                            @endif
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-12 d-flex justify-content-center align-items-center">
            <button type="submit" id="submit" class="btn btn-success w-25" id="submit">Submit Selected Movies</button>
        </div>
    </form>
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