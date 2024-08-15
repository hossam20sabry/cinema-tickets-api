@extends('admin.layout')
@section('css', '/home/css/confirm-page.css')
@section('content')

<div class="container py-3 minHei" id="booking_details">
    @if(session('success'))
    <div class="row mb-3" >
        <div class="col-12 alert alert-success" id="msg">
            {{session('success')}}
        </div>
    </div>
@endif
@if(session('error'))
    <div class="row mb-3" >
        <div class="col-12 alert alert-danger" id="msg">
            {{session('error')}}
        </div>
    </div>
@endif
    <h3 class="pb-3"><a href="{{ route('admin.bookings.index') }}" class="decoration_none">Booking</a> . show</h3>
    <div class="row mt-3">
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/film-slate.png')}}" class="top-img" alt="">
                <p class="movie-name text-uppercase">{{$booking->showTime->movie->name}}</p>
            </div>
        </div>
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/clock.png')}}" class="top-img" alt="">
                <p>{{$booking->showTime->date}} <br>{{$booking->showTime->start_time}}</p>
            </div>
        </div>
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/location-pin.png')}}" class="top-img" alt="">
                <p class="text-uppercase">{{$booking->showTime->theater->location}} <br>{{$booking->showTime->theater->city}}</p>
            </div>
        </div>
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/film.png')}}" class="top-img" alt="">
                <p class="text-uppercase">{{$booking->showTime->theater->name}}</p>
            </div>
        </div>
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/ticket (1).png')}}" class="top-img" alt="">
            <p id="tickets_nums">{{$booking->total_seats}} Ticket <br>2D</p>
            </div>
        </div>
        <div class="col m-3">
            <div class="diiv">
                <img src="{{asset('/home/icon/chair.png')}}" class="top-img" alt="">
                <div id="ticket_num">
                    @foreach($booking->seats as $seat)
                        <p>{{$seat->row->letter}}{{$seat->number}}</p>
                    @endforeach
                </div>  
            </div>
        </div>
    </div>
    <div class="row py-3 ">

        <div class="col-md-6">
            <table class="table table-light table-striped-columns table-hover p-3">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td class="text-uppercase d-flex align-items-end justify-content-between">{{$user->name}} <a id="emailBtn" class="btn btn-primary btn-sm mx-1">Email</a></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <td>Booking Code</td>
                        <td>{{$booking->QRcode}}</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        
        <div class="col-md-6">
            <table class="table table-light table-striped-columns  p-3">
                <tbody>
                    <tr>
                        <td>Tickets</td>
                        <td>{{$booking->total_seats}}</td>
                        
                        <td rowspan="3" class="total text-center mt-3"><h4 class="my_padding">Total <br> <span>{{$booking->total_price}} EG</span></h4> </td>

                    </tr>
                    <tr>
                        <td class="smaler">Ticket Price</td>
                        <td>{{$booking->seats()->first()->price}} EG &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="smaler">Booking Fees</td>
                        <td>10 EG &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    
    </div>
    

    <form id="emailForm" action="{{route('admin.email')}}" method="post" class="d-flex justify-content-center d-none">
        @csrf
        <input type="hidden" id="id" name="id" value="{{$user->id}}">
        <div class="row py-3 d-flex justify-content-center box_shadow" style="width: 600px">
            <div class="col-md-12 mb-3">
                <h3 class="text-center">Send Email</h3>
            </div>
            <div class="col-md-12 mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" value="{{$user->email}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="body" class="form-label">Emai body</label>
                <textarea class="form-control" id="body" name="body" rows="3"></textarea>
            </div>
            <div class="col-md-12 mb-3">
                <button class="btn btn-primary w-100">Send</button>
            </div>
        </div>
    </form>
</div>
<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#emailBtn').click(function(){
            $('#emailForm').removeClass('d-none');
            scrollTo(0, 1000);
        });

        $('#emailForm').submit(function(e){
            $('#mainSpinner').removeClass('d-none');
        });

        // $('#emailForm').submit(function(e){
        //     e.preventDefault();
        //     $('#mainSpinner').removeClass('d-none');

        //     $.ajax({
        //         url: "{{route('admin.email')}}",
        //         method:'POST',
        //         data: {
        //             body: $('#body').val(),
        //             id: $('#id').val(),
        //             _token: $('input[name="_token"]').val(),
        //         },
        //         success: function(data){
        //             if(data.status == 200){
        //                 $('#mainSpinner').addClass('d-none');
        //                 $('#msg').text(data.msg);
        //                 $('#msg').show();
        //             }
        //             else if(data.status == 500){
        //                 $('#mainSpinner').addClass('d-none');
        //                 $('#msg').text(data.msg);
        //                 $('#msg').show();
        //             }
        //         },
        //     });

        // });


    });
</script>
@endsection