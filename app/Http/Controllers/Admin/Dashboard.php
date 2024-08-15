<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Theater;
use Illuminate\Http\Request;
use Carbon\Carbon;
class Dashboard extends Controller
{
    public function index(){
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        $totalPrice = Booking::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $totalBookings = Booking::whereBetween('created_at', [$startDate, $endDate])->where('booking_status', 'confirmed')->count();
        
        $startDateWeek = Carbon::now()->startOfWeek();
        $endDateWeek = Carbon::now()->endOfWeek();
        $totalPriceWeek = Booking::whereBetween('created_at', [$startDateWeek, $endDateWeek])->sum('total_price');
        $totalBookingsWeek = Booking::whereBetween('created_at', [$startDateWeek, $endDateWeek])->where('booking_status', 'confirmed')->count();

        $startDateMonth = Carbon::now()->startOfMonth();
        $endDateMonth = Carbon::now()->endOfMonth();
        $totalPriceMonth = Booking::whereBetween('created_at', [$startDateMonth, $endDateMonth])->sum('total_price');
        $totalBookingsMonth = Booking::whereBetween('created_at', [$startDateMonth, $endDateMonth])->where('booking_status', 'confirmed')->count();

        $movies = Movie::all();
        $movies_count =  count($movies);

        $theaters = Theater::all();
        $theaters_count =  count($theaters);

        $allBookings = Booking::where('booking_status', 'confirmed')->count();
        $bookings = Booking::where('booking_status', 'confirmed')->paginate(20);

        return view('admin.dashboard', compact(
            'totalPrice',
            'totalPriceWeek', 
            'movies_count', 
            'theaters_count', 
            'totalPriceMonth', 
            'totalBookings', 
            'totalBookingsWeek', 
            'totalBookingsMonth',
            'allBookings',
            'bookings'
        ));
    }
}
