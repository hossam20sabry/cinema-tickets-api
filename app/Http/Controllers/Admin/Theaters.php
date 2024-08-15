<?php

namespace App\Http\Controllers\Admin;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\movie_Theater;
use App\Models\Kind;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Theaters extends Controller
{
    public function index()
    {
        $theaters = Theater::all();
        return view('admin.theaters.index', compact('theaters'));
    }

    public function create()
    {
        return view('admin.theaters.create');
    }

    public function store(Request $request)
    {
        $theater = new Theater;

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required | email',
            'img' => 'required',
            'wide_img' => 'required',

        ],[
            'name.required' => 'Please Write Name.',
            'location.required' => 'The location is required.',
            'city.required' => 'The city is required.',
            'phone.required' => 'The phone is required.',
            'email.email' => 'must be email.',
            'img.required' => 'The img is required.',
            'wide_img.required' => 'The wide_img is required.',
        ]);

        $theater->name = $request->name;
        $theater->location = $request->location;
        $theater->city = $request->city;
        $theater->phone = $request->phone;
        $theater->email = $request->email;

        // $moviesIds = [3, 13];
        // $new_moviesIds = implode(',', $moviesIds);
        // $theater->movie_id = $new_moviesIds;

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $img_name = time().'.'. $img->getClientOriginalExtension();
            $img->move('cinema_photos', $img_name);
            $theater->img = $img_name;
        }else {
            // Set a default placeholder URL if no file is uploaded
            $theater->img = 'default_placeholder.jpg'; // Replace with your actual default URL
        }

        if ($request->hasFile('wide_img')) {
            $wide_img = $request->file('wide_img');
            $img_name = time().'.'. $wide_img->getClientOriginalExtension();
            $wide_img->move('wide_img_cinema_photos', $img_name);
            $theater->wide_img = $img_name;
        }else {
            // Set a default placeholder URL if no file is uploaded
            $theater->wide_img = 'default_placeholder.jpg'; // Replace with your actual default URL
        }

        $theater->save();

        return redirect()->back()->with('success', 'Theater Created Successfuly');
    }

    public function edit(Theater $theater)
    {
        return view('admin.theaters.edit', compact('theater'));
    }

    public function update(Request $request, Theater $theater)
    {
        // dd($theater->name);
        
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required | email',
            // 'img' => 'required',
            // 'wide_img' => 'required',

        ],[
            'name.required' => 'Please Write Name.',
            'location.required' => 'The location is required.',
            'city.required' => 'The city is required.',
            'phone.required' => 'The phone is required.',
            'email.email' => 'must be email.',
            // 'img.required' => 'The img is required.',
            // 'wide_img.required' => 'The wide_img is required.',
        ]);

        

        // theater table only
        $theater->name = $request->name;
        $theater->location = $request->location;
        $theater->city = $request->city;
        $theater->phone = $request->phone;
        $theater->email = $request->email;

        $img = $request->file('img');
        if($img){
            $img_name = time().'.'.$img->getClientOriginalExtension();
            $img->move('cinema_photos', $img_name);
            $theater->img = $img_name;
        }

        $wide_img = $request->file('wide_img');
        if($wide_img){
            $img_name = time().'.'. $wide_img->getClientOriginalExtension();
            $wide_img->move('wide_img_cinema_photos', $img_name);
            $theater->wide_img = $img_name;
        }

        $theater->save();

        return redirect()->back()->with('success', 'Theater updated successfuly');
    }

    public function destroy(Theater $theater)
    {
        $theater->delete();
        return redirect()->back()->with('success', 'Theater Deleted Successfuly');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $theaters = Theater::where("name","like","%".$keyword."%")->get();
        return view('admin.theaters.index', compact('theaters'));
    }

    public function movies(Theater $theater){
        $movies = Movie::all()->sortBy(function($movie) use ($theater) {
            return $theater->movies->contains($movie) ? 0 : 1;
        });
        return view('admin.theaters.movies', compact('theater', 'movies'));
    }

    public function addMovies(Request $request, Theater $theater){
        $theater->movies()->syncWithoutDetaching($request->movies);
        return redirect()->back()->with('success', 'Movies Added Successfuly');
    }

    public function deleteMovies(Theater $theater, Movie $movie){
        $theater->movies()->detach($movie->id);
        return redirect()->back()->with('success', 'Movies Removed Successfuly');
    }
}
