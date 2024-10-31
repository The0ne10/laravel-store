<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserActionContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserActionContract
{
    public function __invoke(NewUserDTO $dto): User
    {
        $user = User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => bcrypt($dto->password),
        ]);

        event(new Registered($user));

        return $user;
    }
}
