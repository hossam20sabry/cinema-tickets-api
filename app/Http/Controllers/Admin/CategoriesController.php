<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required',
            ]);

            $category = new Category();
            $category->title = $request->title;
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Category created successfully'
            ]);

        } catch (QueryException $e) {

            if($e->errorInfo[1] == 1062) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category already exists'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);

        }

    }

    public function edit(Category $category)	
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|unique:categories,title,' . $category->id,
        ]);

        $category->title = $request->title;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'title' => $request->title
        ]);

    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index');

    }

    public function search(Request $request)
    {
        $categories = Category::where('title', 'like', '%' . $request->search . '%')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function movies(Category $category)
    {
        $movies = $category->movies;
        return view('admin.categories.movies', compact('category', 'movies'));
    }
}
