<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected function redirectTo()
    {
        if ((int) Auth::user()->role_id === 1) {
            return route('admin.dashboard');
        } elseif ((int) Auth::user()->role_id === 2) {
            return route('user.dashboard');
        } else {
            return route('user.dashboard');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login.login');
    }

    public function username()
    {
        return 'phone';
    }

    protected function credentials(Request $request): array
    {
        return [
            'phone' => $request->{$this->username()},
            'password' => $request->password,
            'status' => 1,
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($this->credentials($request), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectTo());
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('phone', $request->{$this->username()})->first();
        $message = trans('auth.failed');

        if ($user) {
            if ((int) $user->status === 0) {
                $message = 'Wait for approval.';
            } elseif ((int) $user->status === 2) {
                $message = 'Account is pending status.';
            }
        }

        throw ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}
