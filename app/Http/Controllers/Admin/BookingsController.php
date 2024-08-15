<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('booking_status', 'confirmed')->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        $user = User::where('email', 'like', '%' . $search . '%')->first();
        if ($user) {
            $bookings = Booking::where('booking_status', 'confirmed')->where('user_id', $user->id)->get();
            return view('admin.bookings.index', compact('bookings'));
        }
        else{
            return view('admin.bookings.index');
        }
        
    }

    public function show($id)
    {
        $booking = Booking::find($id);
        $user = $booking->user;
        return view('admin.bookings.show', compact('booking', 'user'));
    }
}
