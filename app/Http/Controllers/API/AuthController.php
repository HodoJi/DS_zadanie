<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function doLogin(Request $request): RedirectResponse
    {
        if (!$request->isMethod('post'))
        {
            return redirect(route('login'));
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        try
        {
            if (Auth::attempt($credentials))
            {
                $request->session()->regenerate();
                return redirect()->intended(route('home'));
            }
        }
        catch (QueryException)
        {
            return back()->with('login_fail', 'Login failed, try again.');
        }

        return back()->with('login_fail', 'Login failed, try again.');
    }

    public function doLogout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
