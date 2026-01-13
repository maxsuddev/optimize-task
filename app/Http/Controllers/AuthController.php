<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        try {
            if (!auth('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
                
                return redirect()->back()->withErrors(['error' => __('messages.unauthorized')]);
            }

            return redirect()->route('leads.index')->with(['success' => __('messages.successLogin')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['email' => __('messages.unauthorized')]);
        }
    }
      public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
