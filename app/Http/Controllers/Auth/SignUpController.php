<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserActionContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class SignUpController extends Controller
{
    public function page(): View|Factory|Application
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserActionContract $action): RedirectResponse
    {
        $user = $action(NewUserDTO::fromRequest($request));

        auth()->login($user);
        return redirect()->intended(route('home'));
    }
}
