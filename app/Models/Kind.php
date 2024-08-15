<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Kind extends Model
{
    use HasFactory;

    public function movies(){
        return $this->belongsToMany(Movie::class, 'movie__kinds', 'kind_id', 'movie_id');
    }

}
