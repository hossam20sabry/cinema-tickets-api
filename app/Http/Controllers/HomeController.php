<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\Kind;
use App\Models\User;
use App\Notifications\CinemaTickets;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $explores = Movie::where('explore' , '1')->get();
        $theaters = Theater::paginate(3);
        $kinds = Kind::all();
        return view('home.index', compact('explores' , 'theaters' , 'kinds'));
    }

    public function send_email(){
        $user = User::find(10);

        $details = [
            'greeting' => 'Welcome to Cinema Tickets',
            'firstline' => 'test',
            'secondtline' => 'test ',
            'button' => 'test',
            'url' => route('index'),
            'lastline' => 'Thank you',
        ];

        Notification::send($user , new CinemaTickets($details));

        return response()->json(['status' => 200]);
        
    }
}
