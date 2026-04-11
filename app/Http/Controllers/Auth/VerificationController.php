<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        if ($request->user() && method_exists($request->user(), 'hasVerifiedEmail') && $request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        return view('auth.verify');
    }

    protected function redirectPath()
    {
        return $this->redirectTo;
    }

    public function verify(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'markEmailAsVerified') && method_exists($user, 'hasVerifiedEmail')) {
            if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return redirect($this->redirectPath() . '?verified=1');
    }

    public function resend(Request $request)
    {
        if ($request->user() && method_exists($request->user(), 'hasVerifiedEmail') && $request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user()) {
            $request->user()->sendEmailVerificationNotification();
        }

        return back()->with('resent', true);
    }
}
