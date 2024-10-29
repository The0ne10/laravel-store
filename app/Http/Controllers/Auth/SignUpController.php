<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpFormRequest;
use Domain\Auth\Contracts\RegisterNewUserActionContract;

class SignUpController extends Controller
{
    public function page()
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpFormRequest $request, RegisterNewUserActionContract $action)
    {
        // TODO: Make DTOs
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
        );

        return redirect()->intended(route('home'));
    }
}
