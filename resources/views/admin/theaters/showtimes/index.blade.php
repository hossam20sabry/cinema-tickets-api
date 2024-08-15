@extends('admin.layout')

@section('content') 
<div class="py-3 background">
    <div class="container">
        <div class="d-flex">
            <a href="" class="decoration_none"><h3 class="text-uppercase">{{$movie->name}} in {{$theater->name}} screens</h3></a>
        </div>
    </div>
</div>
<div class="container my-4">
    <div class="col-md-12 box_shadow p-1 m-1 alert alert-success d-none" id="message" >
            
    </div>
</div>

<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<div class="container">
    @if($showTimes->count() > 0)
        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Screens</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($showTimes as $showTime)
                    <tr class="showTimeRow{{$showTime->id}}">
                        <td>{{$showTime->date}}</td>
                        <td>{{$showTime->start_time}}</td>
                        <td>{{$showTime->end_time}}</td>
                        <td>@foreach($showTime->screens as $key => $screen) @if($key > 0) , @endif{{$screen->screen_number}}  @endforeach</td>
                        <td><a href="{{ route('admin.showtimes.edit', $showTime->id)}}" class="btn btn-success">Update</a></td>
                        <td>
                            <form class="delete" showTime_id="{{$showTime->id}}">
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
    <h1 class="text-center text-capitalize">there is no showtimes</h1>
    @endif
</div>

<div class="mainSpinner d-none" id="mainSpinner">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only"></span>
    </div>
</div>

<script>
    $('.delete').submit(function(e){
        e.preventDefault();
        $('#message').hide();
        $('#mainSpinner').removeClass('d-none');
        let showTime_id = $(this).attr('showTime_id');
        $.ajax({
            method: "DELETE",
            url: "{{route('admin.showtimes.destroy')}}",
            data: {
            '_token': "{{csrf_token()}}",
            'showTime_id': showTime_id
            },
            success: function(data){
                if(data.status == true){
                    $('#message').show();
                    $('#message').text(data.message);
                    $('#mainSpinner').addClass('d-none');
                    $('.showTimeRow'+data.showTime_id).remove();
                }else{
                    $('#message').show();
                    $('#message').text(data.message);
                    $('#mainSpinner').addClass('d-none');
                }
            },
        });
    });
  </script>
@endsection