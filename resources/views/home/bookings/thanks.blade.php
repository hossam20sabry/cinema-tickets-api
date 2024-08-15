@extends('home.layout')
@section('css', '/home/css/index.css')
@section('content')
<div class="container d-flex justify-content-center my-5 py-5 min_hei">
        <div class="row  box_shadow p-4" style="width: 400px; height: 400px">
            {{-- <div class="col-12">
                <a href="/" class="logo p-3">
                    <img src="{{asset('/home/img/logo 102.png')}}" alt="">
                    <h1>Movies Tickets</h1>
                </a>
            </div> --}}
            @if(isset($error))
                <div class="col-12 mt-4">
                    <h2 class="text-center text-danger">Error</h2>
                    <p class="text-danger">{{$error}}</p>
                </div>
            @else
                <div class="col-12 mt-4">
                    <h2 class="text-center text-success">Thank you for booking with us!</h2>
                    <p class="">Your booking has been confirmed. Check your email for more details about your booking and payment to get your Booking code.</p>
                    <p class="text-danger">Do not Share the code in your email with anyone</p>
                </div>
            @endif


            <div class="col-6">
                <a href="{{route('bookings.index')}}" class="btn btn-primary w-100">View Bookings</a>
            </div>
            <div class="col-6 mb-5">
                <a href="{{route('index')}}" class="btn btn-success w-100">Home</a>
            </div>
        </div>
</div>
@endsection