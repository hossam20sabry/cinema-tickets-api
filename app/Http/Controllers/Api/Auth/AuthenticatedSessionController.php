<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Kind;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
            return response([
                'msg' => 'provided email or password is incorrect',
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;
        $kinds = Kind::all();

        return response(compact('user', 'token', 'kinds'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response()->json(['success' => true]);
    }
}
