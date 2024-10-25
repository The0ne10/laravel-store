<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordFormRequest;
use App\Http\Requests\Auth\ResetPasswordFormRequest;
use App\Http\Requests\Auth\SignInFormRequest;
use App\Http\Requests\Auth\SignUpFormRequest;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class SignInController extends Controller
{
    public function page()
    {
        if (!Auth::check()) {
            return view('auth.index');
        }
        return redirect()->route('home');
    }

    public function handle(SignInFormRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
