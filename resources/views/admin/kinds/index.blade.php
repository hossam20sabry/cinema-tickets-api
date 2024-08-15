@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.kinds.index') }}" class="decoration_none"><h3 class="m_r text-capatalize">Kinds</h3></a>
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
<div class="container my-4">
    <div class="row center flex-space-between mx-1">
    
        <div class="col-md-4 box_shadow p-3 my-1">
            <a href="{{ route('admin.kinds.create') }}" class="btn btn-primary w-100 text-capitalize">add new kind</a>
        </div>
        <div class="col-md-4 box_shadow p-3 my-1">
            <form class="d-flex" action="{{ route('admin.kinds.search')}}" method="get" role="search">
                
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</div>
<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<div class="container">
    @if($kinds->count() > 0)
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Movies</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kinds as $kind)
            <tr>
                <td>{{$kind->title}}</td>
                <td><a href="{{ route('admin.kinds.movies', $kind->id)}}" class="btn btn-primary">Movies</a></td>
                <td><a href="{{ route('admin.kinds.edit', $kind->id)}}" class="btn btn-success">Update</a></td>
                <td>
                    <form action="{{ route('admin.kinds.destroy', $kind->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
                
            @endforeach
        </tbody>
    </table>
    @else
    <h1 class="text-center text-capitalize">there is no kinds</h1>
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