<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function index(Request $request){
        
        $movies = Movie::paginate(3);

        return response( compact('movies') );
    }

    public function top10(){
        $movies = Movie::orderBy('rating' , 'desc')->take(10)->get();
        return response(compact('movies'));
    }

    public function kinds($id){
        $kind = Kind::find($id);
        $movies = $kind->movies;
        $kinds = Kind::all();
        return view('home.kinds.show' , compact('movies' , 'kind', 'kinds'));
    }

    // public function search(Request $request) {
    //     // Retrieve the search parameter from the request
    //     $search = $request->input('search');
    
    //     // Check if the search parameter is received
    //     if (!$search) {
    //         return response()->json(['error' => 'Search term is required'], 400);
    //     }
    
    //     // Return the search parameter in the response
    //     return response()->json(['search' => $search]);
    // }


    public function Kind($id){
        $kind = Kind::find($id);
        // return response(compact('kind'));
        $movies = $kind->movies;
        return response(compact('movies'));
    }
}
