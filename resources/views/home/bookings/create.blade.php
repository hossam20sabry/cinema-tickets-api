@extends('home.layout')
@section('css', '/home/css/book.css')

@section('content')
<section id="phase1">
    <div class="container-fluid px-sm-5 my-3">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-12" id="poster">
                <img src="/posters/{{$booking->movie->poster_url}}" class="img-thumbnail poster" alt="...">
            </div>
            <div class="col-lg-4 col-md-6 col-12 mb-3" id="select">
                
                <form class="mid" id="phase1Form">
                    
                    <input type="hidden" name="movie_id" id="movie_id" value="{{$booking->movie->id}}">
                    <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->id}}">
                    {{-- select theater --}}
                    @if(isset($theater))
                        <select class="form-select my-1 mt-3" aria-label="Default select example" name="theater_id" id="theater_id"> 
                            <option value="{{$theater->id}}" id="selected_theater_id" selected>{{$theater->name}}</option>
                            
                        </select>
                    @else
                        <select class="form-select my-1 mt-3" aria-label="Default select example" name="theater_id" id="theater_id"> 
                            <option value="" disabled selected>Select Cenima</option>
                            @foreach($theaters as $theater)
                            <option value="{{$theater->id}}">{{$theater->name}}</option>
                            @endforeach
                        </select>
                    @endif
                    <div class="form-error" >
                        <p class="text-danger validation-error" id="theater_id_error"></p>
                    </div>
                    <div class="spinner1 d-none" id="theater_id_spinner">
                        <img src="{{asset('/home/img/Spinner-0.5s-371px.gif')}}" alt="">
                    </div>



                    {{-- select date --}}
                    <select class="form-select my-1" aria-label="Default select example" name="date" id="date">
                        <option value="" disabled selected>Date</option>
                    </select>
                    <div class="form-error">
                        <p class="text-danger validation-error" id="date_error"></p>
                    </div>
                    <div class="spinner1 d-none" id="date_spinner">
                        <img src="{{asset('/home/img/Spinner-0.5s-371px.gif')}}" alt="">
                    </div>



                    {{-- select time --}}
                    <select class="form-select my-1 " aria-label="Default select example" name="time" id="time">
                        <option value="" disabled selected>Time</option>
                    </select>
                    <div class="form-error">
                        <p class="text-danger validation-error" id="time_error"></p>
                    </div>
                    <div class="spinner1 d-none" id="time_spinner">
                        <img src="{{asset('/home/img/Spinner-0.5s-371px.gif')}}" alt="">
                    </div>
                    


                    {{-- select screen --}}
                    <select class="form-select my-1 " aria-label="Default select example" name="screen_id" id="screen_id">
                        <option value="" disabled selected>Screen</option>
                    </select>
                    <div class="form-error">
                        <p class="text-danger validation-error pb-3" id="screen_id_error"></p>
                    </div>
                    <div class="spinner1 d-none" id="screen_spinner">
                        <img src="{{asset('/home/img/Spinner-0.5s-371px.gif')}}" alt="">
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" id="submit" class="btn btn-info w-100"> Next <span>></span></button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="table-responsive py-3 booking-table">
                    <table class="table table-success table-striped">
                        <tbody>
                            
                            <tr>
                                <td class="left-td">Name</td>
                                <td>{{$booking->movie->name}}</td>
                            </tr>
                            <tr>
                                <td class="left-td">Rate</td>
                                <td>{{$booking->movie->rating}}</td>
                            </tr>
                            <tr>
                                <td class="left-td">Language</td>
                                <td>{{$booking->movie->lang}}</td>
                            </tr>
                            <tr>
                                <td class="left-td">Kind</td>
                                <td>
                                    @foreach($booking->movie->kinds as $key => $kind)                                    
                                    @if($key !== 0) , @endif
                                    {{$kind->title}}
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="left-td">Category</td>
                                <td>{{$booking->movie->category->title}}</td>
                            </tr>
                            <tr>
                                <td class="left-td">Duration</td>
                                <td>{{$booking->movie->duration}} </td>
                            </tr>
                            <tr>
                                <td class="left-td">Release Date</td>
                                <td>{{$booking->movie->release_date}}</td>
                            </tr>
                            <tr>
                                <td class="left-td">Revenue</td>
                                <td>${{$movie->bookings->sum('total_price')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        


    <div class="container-fluid px-sm-5 my-2">
        <div class="row">
            <h1 class="text-center text-uppercase">Movie Trailer</h1>
            <div class="ratio ratio-16x9 my-2">
                <iframe src="{{asset('/trailers/1706489443.mp4')}}" title="MOVIE TRAILER" allowfullscreen ></iframe>
            </div>
        </div>
    </div>
</section>
</div>

</section>


<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function(){


        // handling phase 1
        let selected_theater_id = $('#selected_theater_id').val();
        let booking_id = $('#booking_id').val();

        if(selected_theater_id){
            console.log(selected_theater_id);
            $('#theater_id_spinner').removeClass('d-none');
            $('#date').addClass('d-none');
            var $date = $('#date');
            let movie_id = $('#movie_id').val();
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('bookings.theater')}}",
                type:"POST",
                data:{
                    booking_id: booking_id,
                    theater_id: selected_theater_id,
                    movie_id:movie_id,
                    _token:_token
                },
                success:function(data){
                    if(data.status == 404){
                        window.location.href = "{{route('bookings.redirect')}}";
                    }
                    $date.html('<option value="" disabled selected>Date</option>');
                    var previousValue = null;
                    $.each(data, function(index, showtime){
                        if (showtime.date !== previousValue) {
                            $date.append('<option value="'+ showtime.id +'">'+ showtime.date +'</option>');
                            previousValue = showtime.date;
                        }
                    });
                    // $('#theater_id_error').text('');
                    if($('#theater_id_spinner').addClass('d-none')){
                        $('#date').removeClass('d-none');
                    }
                }
            });
            $('#date, #time, #screen_id').val("");
            
        }else{
            $('#theater_id').change(function(){
                $('#theater_id_spinner').removeClass('d-none');
                $('#theater_id_error').text('');
                $('#date').addClass('d-none');
                var $date = $('#date');
                let movie_id = $('#movie_id').val();
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{route('bookings.theater')}}",
                    type:'post',
                    data:{
                        booking_id: booking_id,
                        theater_id: $(this).val(),
                        movie_id:movie_id,
                        _token:_token
                    },
                    success:function(data){
                        if(data.status == 404){
                            window.location.href = "{{route('bookings.redirect')}}";
                        }
                        $date.html('<option value="" disabled selected>Date</option>');
                        var previousValue = null;
                        $.each(data, function(index, showtime){
                            if (showtime.date !== previousValue) {
                                $date.append('<option value="'+ showtime.id +'">'+ showtime.date +'</option>');
                                previousValue = showtime.date;
                            }
                        });
                        $('#theater_id_error').text('');
                        if($('#theater_id_spinner').addClass('d-none')){
                            $('#date').removeClass('d-none');
                        }
                    }
                });
                $('#date, #time, #screen_id').val("");
            });
        }


        $('#date').change(function(){
            $('#date_spinner').removeClass('d-none');
            $('#date_error').text('');
            $('#time').addClass('d-none');
            var $time = $('#time');
            let movie_id = $('#movie_id').val();
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{route('bookings.date')}}",
                type:'post',
                data:{
                    booking_id: booking_id,
                    showtime_id: $(this).val(),
                    movie_id:movie_id,
                    _token:_token
                },
                success:function(data){
                    if(data.status == 404){
                        window.location.href = "{{route('bookings.redirect')}}";
                    }
                    $time.html('<option value="" disabled selected>time</option>');
                    var previousValue = null;
                    $.each(data, function(index, showtime){
                        if(showtime.start_time !== previousValue){
                            $time.append('<option value="'+ showtime.id +'">'+ showtime.start_time +'</option>');
                            previousValue = showtime.start_time;
                        }
                    });
                    $('#date_error').text('');
                    if($('#date_spinner').addClass('d-none')){
                        $('#time').removeClass('d-none');
                    }
                    
                }
            });
            $('#time, #screen_id').val("");
            
        });

        $('#time').change(function(){
            $('#time_spinner').removeClass('d-none');
            $('#time_error').text('');
            $('#screen_id').addClass('d-none');
            var $screen_id = $('#screen_id');
            let movie_id = $('#movie_id').val();
            let _token = $('input[name="_token"]').val();

            $.ajax({
                url:"{{route('bookings.time')}}",
                type:'post',
                data:{
                    booking_id: booking_id,
                    showTime_id:$(this).val(),
                    movie_id:movie_id,
                    _token:_token
                },
                success:function(data){
                    if(data.status == 404){
                        window.location.href = "{{route('bookings.redirect')}}";
                    }
                    var screens = data.screens;
                    var show_time = data.show_time;

                    $('#showTime_id_div').html('<input type="hidden" name="showTime_id" id="showTime_id" value="'+ show_time.id +'>');
                    $screen_id.html('<option value="" disabled selected>Screen</option>');
                    $.each(screens, function(index, screen){
                        $screen_id.append('<option value="'+ screen.id +'">'+ screen.screen_number +'</option>');
                    });
                    $('#time_error').text('');
                    if($('#time_spinner').addClass('d-none')){
                        $('#screen_id').removeClass('d-none');
                    }
                    
                },
                
            });
            $('#screen_id').val("");
        });


        $('#screen_id').change(function(){
            $('#screen_id_error').text('');
        });


        // handling phase 2
        

        $('#phase1Form').submit(function(e){
            e.preventDefault();
            $('#mainSpinner').removeClass('d-none');
            $('#theater_id_error').text('');
            $('#date_error').text('');
            $('#time_error').text('');
            $('#screen_id_error').text('');
            
            
            let _token = $('input[name="_token"]').val();
            let theater_id = $('#theater_id').val();
            let booking_id = $('#booking_id').val();
            let date = $('#date').val();
            let time = $('#time').val();
            let screen_id = $('#screen_id').val();

            $.ajax({
                url:"{{route('bookings.store2')}}",
                type:'post',
                data:{
                    booking_id:booking_id,
                    _token:_token,
                    theater_id:theater_id,
                    date:date,
                    time:time,
                    screen_id:screen_id,
                    booking_id:booking_id
                },
                success:function(data){
                    if(data.status == 404){
                        window.location.href = "{{route('bookings.redirect')}}";
                    }
                    
                    if(data.status === 200){
                        window.location.href = "{{route('bookings.seats', $booking->id)}}";
                    }
                },
                error: function(reject){
                    $('#mainSpinner').addClass('d-none');
                    let response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, value){
                        $("#"+key+"_error").text(value);
                    })
                    scrollTo(0, 0);
                }
            })
        });

    });
</script>
@endsection