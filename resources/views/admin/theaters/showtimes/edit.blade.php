@extends('admin.layout')

@section('content')
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <h3 class="text-uppercase">{{$showTime->theater->name}} - {{$showTime->movie->name}} - Update showtime</h3>
        </div>
    </div>
</div>
<div class="container my-4 ">
    <div class="row center">
        @if(session()->has('success'))
        <div class="col-md-12 box_shadow p-3 m-2 alert alert-success" id="message">
            {{session()->get('success')}}
        </div>
        @endif
        @if(session()->has('error'))
        <div class="col-md-12 box_shadow p-3 m-2 alert alert-danger" id="message">
            {{session()->get('error')}}
        </div>
        @endif

        <form class="forms-sample" id="showTimeForm" action="{{route('admin.showtimes.update', $showTime->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row box_shadow p-3">
                
                <div class="col-6 mt-2">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input  type="date" class="form-control mystyle" name="date" id="date" placeholder="date" value="{{$showTime->date}}">
                    </div>
                    @error('date')
                    <div class="form-error">
                        <p class="text-danger mb-3" id="date_error">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="col-6 mt-2">
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input  type="time"  class="form-control mystyle" name="start_time" id="start_time" placeholder="start_time" value="{{$showTime->start_time}}">
                    </div>
                    @error('start_time')
                    <div class="form-error">
                        <p class="text-danger mb-3" id="start_time_error">{{$message}}</p>
                    </div>
                    @enderror
                </div>

                <div class="col-6 mt-2">
                    <div class="form-group">
                            <label for="end_time" >End Time - Movie Duration <span class="red_span">{{$showTime->movie->duration}}</span></label>
                            <input  type="time"  class="form-control mystyle" name="end_time" id="end_time" placeholder="end_time" value="{{$showTime->end_time}}">
                        </div>
                        @error('end_time')
                        <div class="form-error">
                            <p class="text-danger mb-3" id="end_time_error">{{$message}}</p>
                        </div>
                        @enderror
                </div>

                <div class="col-6 mt-2">
                    <label for="" class="border-bottom w-100">Select Screens</label>
                    @foreach($showTime->theater->screens as $screen)
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                value="{{$screen->id}}" 
                                id="screens_{{$screen->id}}" 
                                name="screens[]" 
                                @if(in_array($screen->id, $showTime->screens->pluck('id')->toArray())) checked @endif
                            >
                            <label class="form-check-label" for="screens_{{$screen->id}}">
                                {{$screen->theater->name}} Screen - {{$screen->screen_number}}
                            </label>
                        </div>
                    @endforeach
                    @error('screens')
                    <div class="form-error">
                        <p class="text-danger mb-3" id="screens_error">{{$message}}</p>
                    </div>
                    @enderror
                </div>
                
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <label class="p-1" for=""></label>
                    <button type="submit" id="submit" class="btn btn-primary w-50 mt-1">Submit</button>
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
    $('#submit').click(function(e){
        $('#mainSpinner').removeClass('d-none');
    })
</script>
@endsection
{{-- @section('script')
<script>
    $("#showTimeForm").submit(function(e){
        e.preventDefault();
        $("#message").hide();
        $('#message').removeClass('alert-success');
        $('#message').removeClass('alert-danger');
        $('#mainSpinner').removeClass('d-none');

        $('#start_time_error').text('');
        $('#end_time_error').text('');
        $('#date_error').text('');
        $('#screens_error').text('');

        // let theater_id = $("#theater_id").val();
        // let movie_id = $("#movie_id").val();
        let screens = []; 

        $('input[name="screens[]"]:checked').each(function() {
            screens.push($(this).val()); 
        });
        let date = $("#date").val();
        let start_time = $("#start_time").val();
        let end_time = $("#end_time").val();
        let _token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{route('admin.showtimes.update',  $showTime->id)}}",
            method: "POST",
            data: {
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
                    $('#date').val(data.showTime.date);
                    $('#start_time').val(data.showTime.start_time);
                    $('#end_time').val(data.showTime.end_time);

                    // Uncheck all checkboxes
                    $('input[name="screens[]"]').prop('checked', false);

                    // Check only the checkboxes that correspond to the selected screens
                    $.each(data.showTime.screens, function(index, screenId) {
                        $("#screens_" + screenId).prop("checked", true);
                    });
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
                })
                $('#mainSpinner').addClass('d-none');
            }
        })
    });

    // // Set values for form fields
    // $("#date").val("{{ $showTime->date }}");
    // $("#start_time").val("{{ $showTime->start_time }}");
    // $("#end_time").val("{{ $showTime->end_time }}");

    // // Set checked attribute for screens
    // @foreach($showTime->theater->screens as $screen)
    //     $("#screens_{{ $screen->id }}").prop("checked", {{ in_array($screen->id, $showTime->screens->pluck('id')->toArray()) ? 'true' : 'false' }});
    // @endforeach
</script>
@endsection --}}
