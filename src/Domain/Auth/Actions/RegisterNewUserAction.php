<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserActionContract;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserActionContract
{
    public function __invoke(string $name, string $email, string $password)
    {
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}
