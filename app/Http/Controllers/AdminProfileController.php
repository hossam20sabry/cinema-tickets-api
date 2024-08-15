<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::guard('admin')->user()->id],
        ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $admin = Auth::guard('admin')->user();

        if(! Auth::guard('admin')->check() || ! Hash::check($request->password, $admin->password)) {
            return Redirect::back()->withErrors(['password' => 'The provided password is incorrect.']);
        }

        Auth::guard('admin')->logout(); 
        $admin = Admin::find($admin->id);
        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
        
    }
}
