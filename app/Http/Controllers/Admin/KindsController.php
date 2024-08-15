<?php

namespace App\Http\Controllers\Admin;
use App\Models\Kind;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class KindsController extends Controller
{
    public function index()
    {
        $kinds = Kind::all();
        return view('admin.kinds.index', compact('kinds'));
    }

    public function create()
    {
        return view('admin.kinds.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required',
            ]);

            $kind = new Kind();
            $kind->title = $request->title;
            $kind->save();

            return response()->json([
                'status' => true,
                'message' => 'Kind created successfully'
            ]);

        } catch (QueryException $e) {

            if($e->errorInfo[1] == 1062) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kind already exists'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
        
    }

    public function edit($id)
    {
        $kind = Kind::find($id);
        return view('admin.kinds.edit', compact('kind'));
    }

    public function update(Request $request, Kind $kind)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $kind->title = $request->title;
        $kind->save();
        return response()->json([
            'status' => true,
            'title' => $request->title
        ]);
    }

    public function destroy(Kind $kind)
    {
        $kind->delete();
        return redirect()->route('admin.kinds.index');
    }

    public function search(Request $request)
    {
        $kinds = Kind::where('title', 'like', '%' . $request->search . '%')->get();
        return view('admin.kinds.index', compact('kinds'));
    }

    public function movies(Kind $kind){
        $movies = $kind->movies;
        return view('admin.kinds.movies', compact('movies', 'kind'));
    }
}
