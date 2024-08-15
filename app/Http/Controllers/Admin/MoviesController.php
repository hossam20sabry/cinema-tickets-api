<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kind;
use Illuminate\Http\Request;
use App\Models\Movie;

class MoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $kinds = \App\Models\Kind::all();
        $categories = \App\Models\Category::all();
        return view('admin.movies.create', compact('kinds', 'categories'));
    }

    public function store(Request $request)
    {
        // return response($request->all());
        $request->validate([
            'name' => 'required',
            'rating' => 'required|numeric|between:1,10',
            'kind' =>  'required',
            'release_date' => 'required|date',
            'category' => 'required',
            'duration' => 'required',
            'lang' => 'required',
            'director' => 'required|string',
            // 'poster_url' => 'required|image',
            // 'trailer_url' => 'required|video',
            // 'photo_url' => 'required|image',
        ],[
            'name.required' => 'Please Write Name.',
            'rating.required' => 'The movie rating is required.',
            'rating.numeric' => 'The movie rating must be a number.',
            'rating.between' => 'The movie rating must be between 1 and 10.',
            'kind.required' => 'The movie kind is required.',
            'category.required' => 'The movie category is required.',
            'duration.required' => 'The movie duration is required.',
            'lang.required' => 'The movie language is required.',
            'director.required' => 'The movie director is required.',
        ]);

        $movies = new Movie();
        $movies->name = $request->name;
        $movies->rating = $request->rating;
        $movies->release_date = $request->release_date;
        $movies->duration = $request->duration;
        $movies->lang = $request->lang;
        $movies->director = $request->director;
        $movies->category_id = $request->category;
        $movies->movie_renevues = 0;


        if($request->hasFile('poster_url')){
            $poster = $request->file('poster_url');
            $poster_name = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move('posters', $poster_name);
            $movies->poster_url = $poster_name;
        }else{
            $movies->poster_url = 'default';
        }
        
        if($request->hasFile('photo_url')){
            $photo = $request->file('photo_url');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move('photos', $photo_name);
            $movies->photo_url = $photo_name;
        }else{
            $movies->photo_url = 'default';
        }
        
        if($request->file('trailer_url')){
            $trailer = $request->file('trailer_url');
            $trailer_name = time() . '.' . $trailer->getClientOriginalExtension();
            $trailer->move('trailers', $trailer_name);
            $movies->trailer_url = $trailer_name;
        }
        else{
            $movies->trailer_url = 'default';
        }
        $movies->save();

        // start saving kinds
        $selectedKinds = $request->kind; 
        $movies->kinds()->syncWithoutDetaching($selectedKinds);
        // end saving kinds

        

        if(isset($movies)){
            return response()->json([
                'status' => true,
                'message' => 'movie is created successfuly',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'there is some error',
            ]);
        }
        
    }

    public function edit($id)
    {
        $movie = Movie::find($id);
        $kinds = \App\Models\Kind::all();
        $categories = \App\Models\Category::all();
        return view('admin.movies.edit', compact('movie', 'kinds', 'categories'));
    }

    public function update(Request $request, Movie $movie){
        $request->validate([
            'name' => 'required',
            'rating' => 'required|numeric|between:1,10',
            'kind' =>  'required',
            'release_date' => 'required|date',
            'category' => 'required',
            'duration' => 'required',
            'lang' => 'required',
            'director' => 'required|string',
        ],[
            'name.required' => 'Please Write Name.',
            'rating.required' => 'The movie rating is required.',
            'rating.numeric' => 'The movie rating must be a number.',
            'rating.between' => 'The movie rating must be between 1 and 10.',
            'kind.required' => 'The movie kind is required.',
            'category.required' => 'The movie category is required.',
            'duration.required' => 'The movie duration is required.',
            'lang.required' => 'The movie language is required.',
            'director.required' => 'The movie director is required.',
        ]);

        $movie->name = $request->name;
        $movie->rating = $request->rating;
        $movie->release_date = $request->release_date;
        $movie->duration = $request->duration;
        $movie->lang = $request->lang;
        $movie->director = $request->director;
        $movie->category_id = $request->category;
        $selectedKins = $request->kind;
        $movie->kinds()->sync($selectedKins);

        $poster = $request->file('poster_url');
        if($poster) {
            $poster_name = time() . '.' . $poster->getClientOriginalExtension();
            $poster->move('posters', $poster_name);
            $movie->poster_url = $poster_name;
        }

        $photo = $request->file('photo_url');
        if($photo){
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move('photos', $photo_name);
            $movie->photo_url = $photo_name;
        }

        $trailer = $request->file('trailer_url');
        if($trailer){
            $trailer_name = time() . '.' . $trailer->getClientOriginalExtension();
            $trailer->move('trailers', $trailer_name);
            $movie->trailer_url = $trailer_name;
        }

        $movie->save();
        
        if(isset($movie)){
            return response()->json([
                'status' => true,
                'message' => 'movie is updated successfuly',
                'movie' => $movie
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'there is some error',
            ]);
        }
    }

    public function destroy($id){
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('admin.movies.index');
    }

    public function search(Request $request){
        $movies = Movie::where('name', 'like', '%' . $request->search . '%')->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function explore(Movie $movie){
        $movie->explore = 1;
        $movie->save();
        return redirect()->back()->with('message', 'Movie added to explored  successfuly');
    }

    public function unexplore(Movie $movie){
        $movie->explore = 0;
        $movie->save();
        return redirect()->back()->with('message', 'Movie removed from explored  successfuly');
    }

    
}
