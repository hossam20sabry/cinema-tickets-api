<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // $request->user()->update([
        //     'password' => Hash::make($validated['password']),
        // ]);

        $admin = Auth::guard('admin')->user();
        $admin = Admin::find($admin->id);
        $admin->password = Hash::make($validated['password']);
        $admin->save();

        return back()->with('status', 'password-updated');
    }
}
