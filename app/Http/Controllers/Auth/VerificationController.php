<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     */
    protected function redirectTo()
    {
        $user = auth()->user();

        // Adjust these checks to match your role system
        if ($user && method_exists($user, 'hasAnyRole') && $user->hasAnyRole(['Admin', 'Super', 'admin', 'super'])) {
            return '/admin';
        }

        return '/';
    }

    /**
     * The user has been verified.
     * This runs after successful verification in the VerifiesEmails trait.
     */
    protected function verified(Request $request)
    {
        // Fire the Verified event (some versions already do this, but it’s safe)
        event(new Verified($request->user()));

        // Add a flash message for your home page/layout to show
        return redirect($this->redirectPath())
            ->with('status', 'email-verified');
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
