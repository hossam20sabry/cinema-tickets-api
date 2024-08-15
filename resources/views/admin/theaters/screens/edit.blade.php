@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.screens.index', $screen->theater->id) }}" class="decoration_none"><h3 class="m_r text-capitalize">{{$screen->theater->name}} screens</h3></a>
        </div>
    </div>
</div>
<div class="container my-4 ">
    <div class="row center">
        @if(session()->has('success'))
        <div class="col-md-12 box_shadow p-3 m-2">
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        </div>
        @endif

        <form class="forms-sample" method="POST" action="{{ route('admin.screens.update', [$screen->theater->id, $screen->id]) }}">
            @csrf
            @method('PUT')
            <div class="row box_shadow p-3">
                
                <div class="col-6 my-2">
                    <label class="my-1" for="screen_number">screen number</label>
                    <input  type="text"  class="form-control mystyle" name="screen_number" id="screen_number" placeholder="screen_number" value="{{$screen->screen_number}}">
                    @error('screen_number')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                
                <div class="col-6 my-2">
                    <label class="my-1" for="seat_price">seat price</label>
                    <input  type="text"  class="form-control mystyle" name="seat_price" id="seat_price" placeholder="seat_price" value="{{$seat_price}}">
                    
                    @error('seat_price')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                
                
                

                <div class="col-6 my-1">
                    {{-- <label class="p-1" for=""></label> --}}
                    <button type="submit" id="submit" class="btn btn-primary w-100 mt-1">Submit</button>
                </div>

                <div class="col-6 my-1">
                    {{-- <label class="p-1" for=""></label> --}}
                    <a href="{{ route('admin.screens.index', $screen->theater->id)}}" class="btn btn-dark w-100 mt-1">View {{$screen->theater->name}} Screens</a>
                </div>

            </div>
            
        </form>
    </div>
</div>
</form>
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