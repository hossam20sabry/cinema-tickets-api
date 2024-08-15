<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Seat;
use App\Models\Screen;
use App\Models\User;
use App\Models\ShowTime;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'exp_time', // Add this if exp_time is also a date field
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Cairo');
    }

    public function getExpTimeAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Cairo');
    }

    public function seats(){
        return $this->belongsToMany(Seat::class, 'booking__seats', 'booking_id', 'seat_id');
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function ShowTime(){
        return $this->belongsTo(ShowTime::class);
    }

    public function Screen(){
        return $this->belongsTo(Screen::class);
    }
    
    public function movie(){
        return $this->belongsTo(Movie::class);
    }
}
