<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function doLogin(Request $request): RedirectResponse|View
    {
        if (!$request->isMethod('post'))
        {
            return redirect(route('login'));
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $loginView = 'login';
        $failMsgVar = "login_fail_msg";
        $failMsg = "Login failed, try again.";

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
            return view($loginView, [$failMsgVar => $failMsg]);
        }

        return view($loginView, [$failMsgVar => $failMsg]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
