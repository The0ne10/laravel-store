<?php

namespace Domain\Auth\Contracts;

use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;

interface RegisterNewUserActionContract
{
    public function __invoke(NewUserDTO $dto): User;
}
