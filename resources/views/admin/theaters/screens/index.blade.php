@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="" class="decoration_none text-capitalize"><h3 class="m_r text-capatalize">{{$theater->name}} Screens</h3></a>
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
<div class="container my-4 ">
    <div class="row center flex-space-between mx-1">
    
        <div class="col-md-4 box_shadow p-3 my-1">
            <a href="{{ route('admin.screens.create', $theater->id)}}" class="btn btn-primary w-100 text-capitalize">add new Screen</a>
        </div>
        
    </div>
</div>
<div class="container">
    @if($screens->count() > 0)
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th>screen number</th>
                <th>total rows</th>
                <th>total columns</th>
                <th>Seat Price</th>
                <th>screen</th>
                <th>update</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($screens as $screen)
            <tr>
                <td>{{$screen->screen_number}}</td>
                <td>{{$screen->total_rows}}</td>
                <td>{{$screen->total_columns}}</td>
                <td>{{$screen->seats->first()->price}}</td>
                <td>
                    <a href="{{ route('admin.screens.show', [$theater->id, $screen->id])}}" class="btn btn-primary">show</a>
                </td>
                <td><a href="{{ route('admin.screens.edit', [$theater->id, $screen->id])}}" class="btn btn-success">update</a></td>
                <td>
                    <form action="{{ route('admin.screens.destroy', [$theater->id, $screen->id])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="submit" class="btn btn-danger">delete</button>
                    </form>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    @else
    <h1 class="text-center">there is no screen</h1>
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