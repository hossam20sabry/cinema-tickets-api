<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Theater;
use App\Models\ShowTime;
use App\Models\Kind;
use App\Models\Category;
use App\Models\date;

class Movie extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at','pivot'];

    public function theaters(){
        return $this->belongsToMany(Theater::class, 'movie__theaters', 'movie_id', 'theater_id');
    }

    public function showtimes(){
        return $this->hasMany(ShowTime::class);
    }

    public function kinds(){
        return $this->belongsToMany(Kind::class, 'movie__kinds', 'movie_id', 'kind_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
