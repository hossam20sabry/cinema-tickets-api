<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Screen;
use App\Models\Section;
use App\Models\Row;
use App\Models\ShowTime;
use App\Models\Seat;
use App\Models\Date;
class Theater extends Model
{
    use HasFactory;
    // use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    public function movies(){
        return $this->belongsToMany(Movie::class, 'movie__theaters', 'theater_id', 'movie_id');
    }
    public function screens(){
        return $this->hasMany(Screen::class);
    }

    public function rows(){
        return $this->hasManyDeep(Row::class, [
            Screen::class,
            // Section::class,
        ]);
    }
    public function showTimes(){
        return $this->hasMany(ShowTime::class);
    }
    
}
