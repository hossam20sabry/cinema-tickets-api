@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <h3 class="text-uppercase">{{$theater->name}} - {{$movie->name}} - create showtime</h3>
        </div>
    </div>
</div>
<div class="container my-4 ">
    <div class="row center">

        <div class="col-md-12 box_shadow p-3 m-2 alert" id="message" style="display: none">
            
        </div>
        

        <form class="forms-sample" id="showTimeForm">
            @csrf
            <input type="hidden" id="theater_id" name="theater_id" value="{{$theater->id}}">
            <input type="hidden" id="movie_id" name="movie_id" value="{{$movie->id}}">

            <div class="row box_shadow p-3">
                
                <div class="col-6 mt-2">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input  type="date" class="form-control mystyle" name="date" id="date" placeholder="date" value="{{old('date')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="date_error"></p>
                    </div>
                </div>

                <div class="col-6 mt-2">
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input  type="time"  class="form-control mystyle" name="start_time" id="start_time" placeholder="start_time" value="{{old('start_time')}}">
                    </div>
                    <div class="form-error">
                        <p class="text-danger mb-3" id="start_time_error"></p>
                    </div>
                </div>

                <div class="col-6 mt-2">
                    <div class="form-group">
                            <label for="end_time" >End Time - Movie Duration <span class="red_span">{{$movie->duration}}</span></label>
                            <input  type="time"  class="form-control mystyle" name="end_time" id="end_time" placeholder="end_time" value="{{old('end_time')}}">
                        </div>
                        <div class="form-error">
                            <p class="text-danger mb-3" id="end_time_error"></p>
                        </div>
                </div>

                <div class="col-6 mt-2">
                    <label for="" class="border-bottom w-100">Select Screens</label>
                    @foreach($theater->screens as $screen)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$screen->id}}" id="screens" name="screens[]">
                        <label class="form-check-label" for="screens">
                            {{$screen->theater->name}} Screen - {{$screen->screen_number}}
                        </label>
                    </div>
                    @endforeach
                    <div class="form-error">
                        <p class="text-danger mb-3" id="screens_error"></p>
                    </div>
                </div>
                
                <div class="col-6 d-flex justify-content-center align-items-center">
                    <label class="p-1" for=""></label>
                    <button type="submit" id="submit" class="btn btn-primary w-100 mt-1">Submit</button>
                </div>

                <div class="col-6 d-flex justify-content-center align-items-center">
                    <label class="p-1" for=""></label>
                    <a href="{{ route('admin.theaters.movies', $theater->id)}}" class="btn btn-dark w-100 mt-1">{{$theater->name}} Movies</a>
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
@endsection

@section('script')
<script>
    $("#showTimeForm").submit(function(e){
        e.preventDefault();
        // let message = document.querySelector('#message');
        // message..classList.remove('d-none');
        $("#message").hide();
        $('#message').removeClass('alert-success');
        $('#message').removeClass('alert-danger');
        $('#mainSpinner').removeClass('d-none');

        $('#start_time_error').text('');
        $('#end_time_error').text('');
        $('#date_error').text('');
        $('#screens_error').text('');

        let theater_id = $("#theater_id").val();
        let movie_id = $("#movie_id").val();
        let screens = []; 

        $('input[name="screens[]"]:checked').each(function() {
            screens.push($(this).val()); 
        });
        let date = $("#date").val();
        let start_time = $("#start_time").val();
        let end_time = $("#end_time").val();
        let _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{route('admin.showtimes.store', [$theater->id, $movie->id])}}",
            method: "POST",
            data: {
                theater_id: theater_id,
                movie_id: movie_id,
                screens: screens,
                date: date,
                start_time: start_time,
                end_time: end_time,
                _token: _token
            },
            success: function(data){
                if(data.status === true){
                    $('#message').addClass('alert-success');
                    $("#message").text(data.message);
                    $("#message").show();
                    $("#showTimeForm")[0].reset();
                    $('#mainSpinner').addClass('d-none');
                }
                else{
                    $('#message').addClass('alert-danger');
                    $('#message').text(data.message);
                    $('#message').show();
                    $('#mainSpinner').addClass('d-none');
                }
            },
            error: function(reject){
                
                let response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, value){
                    $("#"+key+"_error").text(value);
                    // console.log(key);
                })
                $('#mainSpinner').addClass('d-none');
            }
        })
    })
</script>
@endsection