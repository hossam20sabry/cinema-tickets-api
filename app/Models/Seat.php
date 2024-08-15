<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Row;
use App\Models\Booking;


class Seat extends Model
{
    use HasFactory;

    public function row(){
        return $this->belongsTo(Row::class);
    }

    public function bookings(){
        return $this->belongsToMany(Booking::class, 'booking__seats', 'seat_id', 'booking_id');
    }
}
