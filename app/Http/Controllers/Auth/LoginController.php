<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Handle the user after they have been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Send unverified users to the notice page
        if (method_exists($user, 'hasVerifiedEmail') && method_exists($user, 'mustVerifyEmail')) {
            if ($user->mustVerifyEmail() && ! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
        }

        // Admins/Supers → admin dashboard
        if (in_array($user->role, ['Super', 'Admin'], true)) {
            return redirect()->route('admin.dashboard');
        }

        // Everyone else → home (or / fallback)
        return \Illuminate\Support\Facades\Route::has('home')
            ? redirect()->route('home')
            : redirect('/');
    }


    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
