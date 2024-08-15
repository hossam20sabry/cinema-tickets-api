<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Screen;


class Row extends Model
{
    use HasFactory;
    public function screen(){
        return $this->belongsTo(Screen::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }
}
