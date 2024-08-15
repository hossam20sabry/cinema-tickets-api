<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index(Request $request){
        
        $theaters = Theater::paginate(3);

        return response(compact('theaters'));
    }

    public function show($id){
        // $theater = Theater::find($id)->load('movies');
        $theater = Theater::find($id);
        $movies = $theater->movies->where('comming', '0');
        $commingMovies = $theater->movies->where('comming', '1');
        return response(compact('theater', 'movies', 'commingMovies'));
    }

    public function search(Request $request){
        $search = $request->input('searchTheater');
        $theaters = Theater::where('name' , 'like' , "%$search%")->get();
        return response(compact('theaters'));
    }
}
