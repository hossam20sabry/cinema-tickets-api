@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.theaters.index') }}" class="decoration_none"><h3 class="m_r text-capatalize">Theaters</h3></a>
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
            <a href="{{ route('admin.theaters.create') }}" class="btn btn-primary w-100 text-capitalize">add new Theater</a>
        </div>
        <div class="col-md-4 box_shadow p-3 my-1">
            <form class="d-flex" action="{{ route('admin.theaters.search')}}" method="get" role="search">
                
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
    @if($theaters->count() > 0)
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>screens</th>
                <th>add movies</th>
                <th>update</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($theaters as $theater)
                <tr>
                    <td>{{$theater->name}}</td>
                    
                    <td>
                        <a href="{{ route('admin.screens.index', $theater->id)}}" class="btn btn-warning">screens</a>
                    </td>
                    <td>
                        <a href="{{ route('admin.theaters.movies', $theater->id)}}" class="btn btn-info">avilable movies</a>
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.theaters.edit', $theater->id)}}" class="btn btn-success">update</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.theaters.destroy', $theater->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="submit"  class="btn btn-danger">delete</button>
                        </form>
                    </td> 
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h1 class="text-center text-capitalize">there is no theaters</h1>
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