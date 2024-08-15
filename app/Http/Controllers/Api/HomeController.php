<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\User;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class HomeController extends Controller
{
    public function main(){
        $kinds = Kind::all();
        $user = auth()->user();
        return response(compact('kinds' , 'user'));
    }

    
    public function index()
    {
        $explores = Movie::where('explore' , '1')
                        ->with('category')
                        ->get()
                        ->take(5);

        $top10 = Movie::orderBy('rating' , 'desc')->select('name', 'id', 'poster_url')->get()->take(5);
        $upcomingMovies = Movie::where('comming' , '1')->select('name', 'id', 'poster_url')->get()->take(5);
        $theaters = Theater::select('name', 'id', 'img')->get()->take(6);
        $kinds = Kind::select('title', 'id')->get();
        return response(compact('explores' , 'theaters' , 'kinds', 'top10', 'upcomingMovies'));
    }

    public function search($search){
        $movies = Movie::where('name' , 'like' , "%$search%")->get();
        $theaters = Theater::where('name' , 'like' , "%$search%")->get();
        return response(compact('movies', 'theaters'));
    }

    

    // public function send_email(){
    //     $user = User::find(10);

    //     $details = [
    //         'greeting' => 'Welcome to Cinema Tickets',
    //         'firstline' => 'test',
    //         'secondtline' => 'test ',
    //         'button' => 'test',
    //         'url' => route('index'),
    //         'lastline' => 'Thank you',
    //     ];

    //     Notification::send($user , new CinemaTickets($details));

    //     return response()->json(['status' => 200]);
        
    // }
}
