<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Theater;
use App\Models\ShowTime;
use App\Models\Screen;

class ShowtimesController extends Controller
{

    public function index(Theater $theater, Movie $movie)
    {
        $showTimes = ShowTime::where('movie_id', $movie->id)->where('theater_id', $theater->id)->get();
        return view('admin.theaters.showtimes.index', compact('theater', 'movie', 'showTimes'));
    }

    public function create(Theater $theater, Movie $movie)
    {
        return view('admin.theaters.showtimes.create', compact('theater', 'movie'));
    }

    public function store(Request $request, Theater $theater, Movie $movie)
    {
        $request->validate([
            'theater_id' => 'required',
            'screens' => 'required',
            'movie_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ], [
            'theater_id.required' => 'The theater id is required.',
            'screens.required' => 'The screen id is required.',
            'movie_id.required' => 'The movie id is required.',
            'date.required' => 'The date is required.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
        ]);

        $startTime = $request->date . ' ' . $request->start_time;
        $endTime = $request->date . ' ' . $request->end_time;

        // Check for overlapping showtimes
        $overlapShowtime = ShowTime::where('show_times.theater_id', $request->theater_id)
        ->where('show_times.date', $request->date)
        ->whereHas('screens', function ($query) use ($request) {
            $query->whereIn('screens.id', $request->screens);
        })
        ->where(function ($query) use ($startTime, $endTime) {
            $query->where(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '<', $startTime)
                    ->where('show_times.end_time', '>', $startTime);
            })
            ->orWhere(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '<', $endTime)
                    ->where('show_times.end_time', '>', $endTime);
            })
            ->orWhere(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '>=', $startTime)
                    ->where('show_times.end_time', '<=', $endTime);
            });
        })
        ->first();


        if ($overlapShowtime) {
            return response()->json([
                'status' => false,
                'message' => 'There is an overlapping showtime for the same screen and date.',
            ]);
        }

        // Create and save the new showtime
        $showTime = new ShowTime();
        $showTime->movie_id = $request->movie_id;
        $showTime->theater_id = $request->theater_id;
        $showTime->date = $request->date;
        $showTime->start_time = $request->start_time;
        $showTime->end_time = $request->end_time;
        $showTime->save();
        $showTime->screens()->syncWithoutDetaching($request->screens);

        return response()->json([
            'status' => true,
            'message' => 'Showtime created successfully.',
        ]);

    }

    public function edit($id){
        $showTime = ShowTime::find($id);
        return view('admin.theaters.showtimes.edit', compact('showTime'));
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $showTime = ShowTime::find($id);
        
        $request->validate([
            // 'theater_id' => 'required',
            'screens' => 'required',
            // 'movie_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ], [
            // 'theater_id.required' => 'The theater id is required.',
            'screens.required' => 'The screen id is required.',
            // 'movie_id.required' => 'The movie id is required.',
            'date.required' => 'The date is required.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
        ]);

        $startTime = $request->date . ' ' . $request->start_time;
        $endTime = $request->date . ' ' . $request->end_time;

        // Check for overlapping showtimes
        $overlapShowtime = ShowTime::where('show_times.theater_id', $request->theater_id)
        ->where('show_times.date', $request->date)
        ->whereHas('screens', function ($query) use ($request) {
            $query->whereIn('screens.id', $request->screens);
        })
        ->where(function ($query) use ($startTime, $endTime) {
            $query->where(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '<', $startTime)
                    ->where('show_times.end_time', '>', $startTime);
            })
            ->orWhere(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '<', $endTime)
                    ->where('show_times.end_time', '>', $endTime);
            })
            ->orWhere(function ($q) use ($startTime, $endTime) {
                $q->where('show_times.start_time', '>=', $startTime)
                    ->where('show_times.end_time', '<=', $endTime);
            });
        })
        ->first();


        if ($overlapShowtime) {
            return redirect()->back()->withInput()->with('error', 'There is an overlapping showtime for the same screen and date.');
        }

        // Create and save the new showtime
        $showTime->date = $request->date;
        $showTime->start_time = $request->start_time;
        $showTime->end_time = $request->end_time;
        $showTime->save();
        $showTime->screens()->syncWithoutDetaching($request->screens);

        return redirect()->back()->with('success', 'Showtime updated successfully.');
    }
    public function destroy(Request $request)
    {
        $showTime = ShowTime::find($request->showTime_id);
        $showTime->delete();
        
        if(isset($showTime)){
            return response()->json([
                'status' => true,
                'message' => 'Showtime deleted successfully.',
                'showTime_id' => $showTime->id
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Showtime not found.',
        ]);
    }
}
