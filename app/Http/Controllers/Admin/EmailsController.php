<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\CinemaTickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EmailsController extends Controller
{
    public function email(Request $request){
        
        $request->validate([
            'body' => 'required',
            'id' => 'required',	
        ]);

        $user = User::find($request->id);

        $details = [
            'greeting' =>  "$user->name Welcome to Cinema Tickets",
            'firstline' => 'Good Day',
            'secondtline' => $request->body,
            'button' => 'Cinema Tickets',
            'url' => route('index'),
            'lastline' => 'Thank you',
        ];

        
        try {
            Notification::send($user , new CinemaTickets($details));
        } 
        catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong with email sending, please try again');
        }

        
        return redirect()->back()->with('success', "Email sent to $user->name  Successfuly");
        
    }
}
