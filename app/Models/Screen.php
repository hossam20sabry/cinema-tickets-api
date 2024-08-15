<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theater;
use App\Models\Row;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\Booking;

class Screen extends Model
{
    use HasFactory;
    public function theater(){
        return $this->belongsTo(Theater::class);
    }

    public function rows(){
        return $this->hasMany(Row::class);
    }

    public function seats(){
        return $this->hasManyThrough(Seat::class, Row::class);
    }

    public function showtimes(){
        return $this->belongsToMany(ShowTime::class, 'showtime_screens', 'screen_id', 'showtime_id');
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

}
