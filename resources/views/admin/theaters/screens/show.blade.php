@extends('admin.layout')
@section('css', '/home/css/theater.css')
@section('content')
    <div class="container">
        <div class="row box_shadow p-3 d-flex align-items-center justify-content-center">
            
                <div class="col-12">
                    <h3 class="text-capitalize text-center">{{$screen->theater->name}} - screen {{$screen->screen_number}}</h3>
                </div>
                
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <ul class="showcase mt-3">
                        <li>
                            <div class="seat"></div>
                            <small>N/A</small>
                        </li>
                        <li>
                            <div class="seat selected"></div>
                            <small>Selected</small>
                        </li>
                        <li>
                            <div class="seat occupied"></div>
                            <small>Occupied</small>
                        </li>    
                    </ul>
                </div>
                
                <div class="col-12">
                    <div class="container" id="container">
                        <div class="screen"></div>
                    </div>
                </div>

                <form action="{{ route('admin.screens.fakeSeat', [$screen->theater->id, $screen->id]) }}" method="POST" id="seats-form">
                    @csrf
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="seats-container">
                            @php $count = 1; $ch = 1; $letter ='A'; $check_apearance = 0; @endphp
                            @foreach ($screen->rows as $row)
                                <div class="my_row">    
                                    <div class="row_letter">{{$row->letter}}</div>
                                    @foreach ($row->seats as $seat)
                                        @if($seat->apearance == 1)
                                        <div class="fake_seat"> </div>
                                        @php $check_apearance = 1; @endphp
                                        @else
                                        <div class="seat" data-seat-id="{{$seat->id}}">{{$seat->number}}</div>
                                        @endif
                                    @endforeach
                                    <div class="row_letter">{{$row->letter}}</div>
                                </div>
                            @endforeach
                        </div>
                            
                    </div>
                    
                    <div class="col-12 d-flex align-items-center justify-content-center">
                            <button type="submit" class="btn btn-primary mb-5 mt-3" id="btn">Make Fake</button>
                            <a href="{{ route('admin.screens.index', $screen->theater->id)}}" class="btn btn-info mb-5 mt-3 ms-3">{{$theater->name}} Screens</a>
                    </div>
                
                </form>
                

                @if($check_apearance == 1)
                <div class="col-12">
                    <h3 class="text-capitalize text-center">Deleted Seats</h3>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="seats-container">
                        @php $count = 1; $ch = 1; $letter ='A'; @endphp
                        @foreach ($screen->rows as $row)
                            <div class="my_row">    
                                @foreach ($row->seats as $seat)
                                    @if($seat->apearance == 1)
                                    <a href="{{ route('admin.screens.realSeat', [$screen->theater->id, $seat->id])}}" class="seat">{{$seat->number}}</a>
                                    @else
                                    <div class="fake_seat"> </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                
        </div>
        
    </div>


    <script>
        const screenData = {!! json_encode($screen) !!};
    </script>
    
    
    <script src="/home/js/theater.js"></script>
@endsection