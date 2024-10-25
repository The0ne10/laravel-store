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

class AuthController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            return view('auth.index');
        }
        return redirect()->route('home');
    }

    public function signUp()
    {
        return view('auth.sign-up');
    }

    public function forgot()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordFormRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));
            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(ResetPasswordFormRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET) {
            flash()->info(__($status));
            return back();
        }

        return redirect()->route('login')->with('message', __($status));
    }

    public function register(SignUpFormRequest $request)
    {
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('home');
    }

    public function signIn(SignInFormRequest $request)
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
