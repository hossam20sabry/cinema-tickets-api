@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="{{ route('admin.theaters.index') }}" class="decoration_none"><h3 class="m_r text-capitalize">Theater </h3></a><h3>. create</h3>
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

        <form class="forms-sample" method="POST" action="{{ route('admin.theaters.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row box_shadow p-3">
                
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="name">Name</label>
                        <input  type="text"  class="form-control mystyle" name="name" id="name" placeholder="Name" value="{{old('name')}}">
                        
                    </div>
                    @error('name')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="location">location</label>
                        <input  type="text"  class="form-control mystyle" name="location" id="location" placeholder="location" value="{{old('location')}}">
                    </div>
                    @error('location')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="city">city</label>
                        <input  type="text"  class="form-control mystyle" name="city" id="city" placeholder="city" value="{{old('city')}}">
                    </div>
                    @error('city')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="phone">phone</label>
                        <input  type="text"  class="form-control mystyle" name="phone" id="phone" placeholder="phone" value="{{old('phone')}}">
                    </div>
                    @error('phone')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="email">email</label>
                        <input  type="email"  class="form-control mystyle" name="email" id="email" placeholder="email"  value="{{old('email')}}">
                    </div>
                    @error('email')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="img">Image</label>
                        <input  type="file"  class="form-control mystyle" id="img" name="img"  value="{{old('img')}}">
                    </div>
                    @error('img')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <div class="form-group">
                        <label class="p-1" for="wide_img">Wide Image</label>
                        <input  type="file"  class="form-control mystyle" id="wide_img" name="wide_img"  value="{{old('wide_img')}}">
                    </div>
                    @error('wide_img')
                    <div class="form-error">
                        <p class="text-danger mb-3">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                <div class="col-6 my-2">
                    <label class="p-1" for=""></label>
                    <button type="submit" id="submit" class="btn btn-primary w-100 mt-1">Submit</button>
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