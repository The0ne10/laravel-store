<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInFormRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Support\SessionRegenerator;

class SignInController extends Controller
{
    public function page(): Application|Factory|View|RedirectResponse
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        return redirect()->route('home');
    }

    public function handle(SignInFormRequest $request)
    {
        if (!auth()->once($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        SessionRegenerator::run(fn () => auth()->login(
            auth()->user()
        ));

        return redirect()->intended(route('home'));
    }

    public function logOut(): RedirectResponse
    {
        SessionRegenerator::run(fn () => auth()->logout());

        return redirect()->route('home');
    }
}
