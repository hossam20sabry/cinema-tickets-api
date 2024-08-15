{{-- @extends('admin.parts.css') --}}
{{-- @section('head_name', 'Theater screen') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    {{-- @include('admin.parts.css') --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/home/css/theater.css')}}">
    <link rel="icon" href="{{asset('/home/img/logo 102.png')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>{{$booking->screen->theater->name}} - screen {{$booking->screen->screen_number}}</title>
</head>
<body>

    <div class="mainSpinner d-none" id="mainSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only"></span>
        </div>
    </div>

    <section id="phase1">
        <div class="row content_center" style="--bs-gutter-x: 0rem;">
            <div class="container  my">
                <div class="row" id="movies-page">
                    @if(session()->has('error'))
                        <div class="col-12">
                            <div class="alert alert-danger">
                                {{session()->get('error')}}
                            </div>
                        </div>
                    @endif
                    
                    <div class="movie-container">
                        
                        
                        <div class="container">
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="alert alert-danger d-none" id="msg">
                                        
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3 d-flex justify-content-center">
                                    <label class="text-uppercase">{{$booking->movie->name}} in {{$booking->showTime->theater->name}}</label>
                                </div>
                                <div class="col-sm-12 mb-3 d-flex justify-content-center">
                                    <p class="text-danger">if you go to another Page and come back please refresh the Page to Keep you Updated</p>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-center" >
                                    <ul class="showcase">
                                        <li>
                                            <label class="pt-1">screen - {{$booking->screen->screen_number}}</label>
                                        </li>
                                        <li>
                                            <div class="top_seat"></div>
                                            <small>N/A</small>
                                        </li>
                                        <li>
                                            <div class="top_seat selected"></div>
                                            <small>Selected</small>
                                        </li>
                                        <li>
                                            <div class="top_seat occupied"></div>
                                            <small>Occupied</small>
                                        </li>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        
        
                        
                        
                        
                        <div class="container" id="container">
                            <div class="screen"></div>
                        </div>
        
                        <form action="{{route('bookings.storeSeats')}}" id="seatsForm" method="post">
                            @csrf
                            <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->id}}">
                            <input type="hidden" name="selected_seats" id="selected_seats" value="">
        
                            <div class="mmy">
                                <div class="row">
                                    @php $count = 1; $ch = 0; $letter ='A'; $check_apearance = 0; @endphp
                                    <div class="col" id="col">
                                        @foreach ($booking->screen->rows as $row)
                                            <div class="my_row">    
        
                                                <div class="row_letter">{{$row->letter}}</div>
        
                                                    @foreach ($row->seats as $key => $seat)
                                                        @if($seat->apearance == 1)
                                                            <div class="fake_seat"> </div>
                                                            @php $check_apearance = 1; @endphp
                                                        @else
                                                            <div class="seat 
                                                                @if($seat->bookings->count())
                                                                    @foreach($seat->bookings as $booking)
                                                                        @foreach($booking->seats as $seat2)
                                                                            @if($seat2->id == $seat->id)
                                                                            selected active
                                                                            @endif
                                                                        @endforeach
                                                                        @if($booking->show_time_id == $booking->ShowTime->id && $booking->booking_status == 'confirmed' )
                                                                            occupied
                                                                        @endif
                                                                    @endforeach
                                                                @endif"
                                                            
                                                            data-seat-id="{{$seat->id}}">
                                                                {{$seat->number}}
                                                            </div>
                                                            
                                                            <div class="spinner spinnerNum{{$seat->id}} d-none">
                                                                <img src="{{asset('/home/img/Spinner-0.5s-371px.gif')}}" alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
        
                                                <div class="row_letter">{{$row->letter}}</div>
        
                                            </div>
                                        @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                            
                        
        
                        <div class="container my d-flex" id="container">
                            <p class="text">
                                You have selected <span id="count">0</span> seats for the total price of Rs. <span id="total">0</span>
                            </p>
        
                            <div class="row row_width">
                                <div class="col d-flex justify-content-end rel ">
                                    <button type="submit" class="btn next_btn ">Next</button>
                                </div>
                            </form>
                                <div class="col d-flex  rel">
                                    <form action="{{route('bookings.destroy')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->id}}">
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>
        
                        </div>
                    </div>
                        
                        
                </div>
                
            </div>
        
            </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>

<script>
    const seat_price = {!! json_encode($booking->screen->seats->first()->price) !!};
    const ticket_counter = document.querySelector('#count');
    const ticket_price_total = document.querySelector('#total');
    const selected_seats_input = document.querySelector('#selected_seats');
    const selectedSeats = new Set(); 
    const mainSpinner = document.querySelector('#mainSpinner');
    const msg = document.querySelector('#msg');

    

    $(document).ready(function(){

        let booking_id = $('#booking_id').val();

        $('.seat').click(function(){

            const seatId = this.getAttribute('data-seat-id');
            
            msg.classList.add('d-none');
            // mainSpinner.classList.remove('d-none');

            $('.spinnerNum'+seatId).removeClass('d-none');
            this.classList.add('d-none');

            if (!this.classList.contains('occupied')){


                if (this.classList.contains('active')) {
                    var self = this;
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{route('bookings.unSelectSeat')}}",
                        method: "POST",
                        data: {
                            seatId: seatId,
                            booking_id: booking_id,
                            _token: _token
                        },
                        success:function(data){
                            if(data.status == 404){
                                window.location.href = "{{route('bookings.redirect')}}";
                            }
                            
                            if(data.status == 200){
                                self.classList.remove('active');
                                self.style.backgroundColor = '#444451';
                                selectedSeats.delete(seatId);
                                // Update the selected_seats input field value with the Set contents
                                selected_seats_input.value = Array.from(selectedSeats).join(',');
                                var count = selectedSeats.size;
                                var total = count * seat_price;
                                ticket_price_total.innerHTML = `${total}`;
                                ticket_counter.innerHTML = `${count}`;
                                self.classList.remove('d-none');
                                $('.spinnerNum'+data.seat_id).addClass('d-none');
                                // mainSpinner.classList.add('d-none');                           
                            }
                        }
                    })
                    
                } else {
                    var self = this;
                    var selected_seats_size = selectedSeats.size;
                    let _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{route('bookings.selectSeat')}}",
                        method: "POST",
                        data: {
                            seatId: seatId,
                            booking_id: booking_id,
                            selected_seats_size: selected_seats_size,
                            _token: _token
                        },
                        success:function(data){
                            if(data.status == 404){
                                window.location.href = "{{route('bookings.redirect')}}";
                            }
                            
                            if(data.status == 200){
                                self.classList.add('active');
                                self.style.backgroundColor = '#0081cb';
                                selectedSeats.add(seatId);
                                selected_seats_input.value = Array.from(selectedSeats).join(',');
                                var count = selectedSeats.size;
                                var total = count * seat_price;
                                ticket_price_total.innerHTML = `${total}`;
                                ticket_counter.innerHTML = `${count}`;
                                
                                self.classList.remove('d-none');
                                $('.spinnerNum'+data.seat_id).addClass('d-none');
                                // mainSpinner.classList.add('d-none');

                            }
                            else if(data.status == 400){
                                msg.innerHTML = data.msg;
                                msg.classList.remove('d-none');
                                // mainSpinner.classList.add('d-none');
                                self.classList.remove('d-none');
                                $('.spinnerNum'+data.seat_id).addClass('d-none');
                                scrollTo(0, 0);
                            }
                            else if(data.status == 401){
                                msg.innerHTML = data.msg;
                                msg.classList.remove('d-none');
                                // mainSpinner.classList.add('d-none');
                                self.classList.remove('d-none');
                                $('.spinnerNum'+data.seat_id).addClass('d-none');
                                scrollTo(0, 0);
                            }
                            else{
                                msg.classList.remove('d-none');
                                msg.innerHTML = 'Something went wrong';
                                // mainSpinner.classList.add('d-none');
                                self.classList.remove('d-none');
                                $('.spinnerNum'+data.seat_id).addClass('d-none');
                                scrollTo(0, 0);
                            }
                        },
                        
                    });
                    
                }
                

                // Update the selected_seats input field value with the Set contents
                selected_seats_input.value = Array.from(selectedSeats).join(',');
                }
                else{
                    console.log('occupied');
                }
        });

        

    });
</script>


{{-- <script src="{{asset('home/js/seats.js')}}"></script> --}}

</body>
</html>