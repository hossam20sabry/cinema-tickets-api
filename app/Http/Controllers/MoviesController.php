<?php

namespace App\Http\Controllers;

use App\Models\Kind;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function index(Request $request){
        
        $query = Movie::query();

        if($request->has('search')){
            $query->where('name' , 'like' , "%{$request->get('search')}%");
        }

        $movies = $query->get();

        $kinds = Kind::all();
        return view('home.movies.index' , compact('movies' , 'kinds'));
    }

    public function kinds($id){
        $kind = Kind::find($id);
        $movies = $kind->movies;
        $kinds = Kind::all();
        return view('home.kinds.show' , compact('movies' , 'kind', 'kinds'));
    }

    public function search(Request $request){
        $request->validate(['search' => 'required']);
        $search = $request->input('search');
        $movies = Movie::where('name' , 'like' , "%$search%")->get();
        $kinds = Kind::all();
        return view('home.movies.index' , compact('movies' , 'kinds'));
    }
}
