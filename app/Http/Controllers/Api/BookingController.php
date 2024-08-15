<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //phase 1
    public function store(Request $request){
        $booking = new Booking();
        $booking->user_id = Auth::user()->id;
        $booking->movie_id = $request->movie_id;
        $booking->exp_time = Carbon::now()->addMinutes(10);
        $booking->save();
        return response()->json(['id' => $booking->id]);
        
    }

    public function show($id){
        $booking = Booking::with([
            'movie.theaters', 
            'movie.category', 
            'movie.kinds', 
            'ShowTime', 
            'ShowTime.theater', 
            'seats.row'
            ])->find($id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }

        if($booking->payment_status == 1) return response()->json(['status' => 404]);
        if($booking->user_id != Auth::user()->id) return response()->json(['status' => 403]);
        return response()->json($booking);
    }

    public function theater(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        // Call checkExp and handle its return value
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }
        $theater = Theater::findOrFail($request->theater_id);
        $show_times = $theater->showTimes->where('movie_id', $booking->movie->id);
        $show_times_array = $show_times->values()->all();

        return response()->json($show_times_array);
    }

    public function date(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }
        $show_time = ShowTime::find($request->showtime_id);
        $movie_id = $booking->movie->id;
        $theater_id = $show_time->theater_id;
        $date = $show_time->date;
        $theater = Theater::find($theater_id);
        $show_times = $theater->showTimes()
            ->where('movie_id', $movie_id)
            ->where('theater_id', $theater_id)
            ->where('date', $date)
            ->get();
        return response()->json($show_times);
    }

    public function time(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }
        
        $show_time = ShowTime::find($request->showtime_id);
        $screens = $show_time->screens;
        return response()->json([
            'screens' => $screens,
            'show_time' => $show_time
        ]);
    }

    //phase 2
    public function store2(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }
        
        $request->validate([
            'theater_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'screen_id' => 'required',
        ],[
            'theater_id.required' => 'please select cenima',
            'date.required' => 'please select date',
            'time.required' => 'please select time',
            'screen_id.required' => 'please select screen',
        ]);

        $booking->show_time_id = $request->showtime_id;
        $booking->screen_id = $request->screen_id;
        $booking->total_seats = 0;
        $booking->total_price = 0;
        $booking->seats()->detach();
        $booking->save();


        return response()->json([
            'status' => 200,
            'booking' => $booking
        ]);

    }

    public function seats($booking_id){
        $booking = Booking::find($booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }

        $screen = $booking->Screen->with(['rows.seats.bookings', 'theater'])->find($booking->screen_id);
        return response()->json(['screen' => $screen, 'booking' => $booking]);
    }

    public function select(Request $request){
        DB::beginTransaction();
    
        try {
            $booking = Booking::find($request->booking_id);
            if(!$booking) {
                DB::rollback();
                return response()->json(['status' => 404]);
            }

            if($booking->exp_time < Carbon::now()) {
                $booking->booking_status = 'expired';
                $booking->total_seats = 0;
                $booking->total_price = 0;
                $booking->seats()->detach();
                $booking->save();
                DB::rollback();
                return response()->json(['status' => 400]); 
            }
    
    
            $showTime = $booking->ShowTime;
    
            $seat = Seat::find($request->seat_id);
            $BookingsCount = $booking->seats()->count();
            if($BookingsCount > 5) {
                DB::rollback(); 
                return response()->json([
                    'status' => 400,
                    'msg' => 'The maximum number of seats is 6.',
                    'seat_id' => $seat->id,
                ]);
            }
    
            $letter = $seat->row->letter;
    
            $booked = $seat->bookings()->where('show_time_id', $showTime->id)->where('payment_status', '1')->first();
            $hisbooked = $seat->bookings()->find($booking->id);
    
            if($hisbooked) {
                DB::rollback(); 
                return response()->json([
                    'status' => 400, 
                    'msg' => "Seat [$letter$seat->number] Already selected.",
                    'seat_id' => $seat->id,
                ]);
            }
    
            if($booked) {
                DB::rollback(); 
                return response()->json([
                    'status' => 400, 
                    'msg' => "Seat [$letter$seat->number] is already booked.",
                    'seat_id' => $seat->id,
                ]);
            }
    
            $booking->seats()->syncWithoutDetaching($seat->id);
            $booking->total_price += $seat->price;
            $booking->total_price = round($booking->total_price, 2);
            $booking->total_seats += 1;
            $booking->save();
    
            DB::commit(); 
    
            return response()->json([
                'status' => 200,
                'seat_id' => $seat->id,
                'booking' => $booking,
                'BookingsCount' => $BookingsCount
            ]);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(), 
            ]);
        }
    }

    public function unSelect(Request $request){
        DB::beginTransaction(); 
        
        try {
            $booking = Booking::find($request->booking_id);
            if(!$booking) {
                DB::rollback();
                return response()->json(['status' => 404]);
            }

            if($booking->exp_time < Carbon::now()) {
                $booking->booking_status = 'expired';
                $booking->total_seats = 0;
                $booking->total_price = 0;
                $booking->seats()->detach();
                $booking->save();
                DB::rollback();
                return response()->json(['status' => 400]); 
            }
    
            $seat = Seat::find($request->seat_id);
            $showTime = $booking->showTime;
            $hisBookings = $seat->bookings()->find($booking->id);
            
            if($hisBookings){
                $booking->seats()->detach($seat->id);
                $booking->total_price -= $seat->price;
                $booking->total_seats -= 1;
                $booking->save();
    
                DB::commit(); 
    
                return response()->json([
                    'status' => 200,
                    'seat_id' => $seat->id,
                    'booking' => $booking
                ]);
            } else {
                DB::rollback(); 
                return response()->json([
                    'status' => 404,
                    'msg' => "No booking found for the seat.",
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json([
                'status' => 500,
                'error' => $e->getMessage(), 
            ]);
        }
    }

    public function storeSeats(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $expCheckResponse = $this->checkExp($booking);
        if ($expCheckResponse) {
            return $expCheckResponse;
        }

        if($booking->seats == null || $booking->seats->count() < 1) return response()->json(['status' => 400, 'msg' => 'No seats selected.']);
        $booking->booking_status = 'reserved';
        $booking->save();
        return response()->json([
            'status' => 200,
            'booking' => $booking,
            'ticket_price' => $booking->seats->first()->price
        ]);
    }

    public function thanks(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $user = $booking->user;
        if($user->id == Auth::user()->id && $booking->booking_status == 'paid') {
            return response()->json([
                'booking' => $booking
            ], 200);
        } else {
            return response()->json([
                'status' => 404
            ]);
        }
    }

    public function destroy(Request $request){
        $booking = Booking::find($request->booking_id);
        if(!$booking) return response()->json(['status' => 404]);
        $booking->delete();
        return response()->json([
            'status' => 200,
            'msg' => 'Booking has been deleted successfully.',
        ]);
    }

    public function myBookings(){
        $bookings = Booking::where('user_id', Auth::user()->id)
            ->where('booking_status', 'paid')
            ->with('movie', 'ShowTime.theater')
            ->get();

        return response()->json(['bookings' => $bookings]);
    }

    public function myBooking($id){
        $booking = Booking::with([
            'movie.theaters', 
            'movie.category', 
            'movie.kinds', 
            'ShowTime', 
            'ShowTime.theater', 
            'seats.row'
            ])->find($id);
        if(!$booking) return response()->json(['status' => 404]);
        if($booking->user_id != Auth::user()->id) return response()->json(['status' => 404]);
        return response()->json($booking);
    }



    private function checkExp($booking){
        if($booking->exp_time < Carbon::now()) {
            $booking->booking_status = 'expired';
            $booking->total_seats = 0;
            $booking->total_price = 0;
            $booking->seats()->detach();
            $booking->save();
            return response()->json(['status' => 404]); 
        }
        return null;
    }
}
