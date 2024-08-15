<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Screen;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Booking;

class ShowTime extends Model
{
    use HasFactory;

    public function screens(){
        return $this->belongsToMany(Screen::class, 'showtime_screens', 'showtime_id', 'screen_id');
    }

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function theater(){
        return $this->belongsTo(Theater::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }
}
