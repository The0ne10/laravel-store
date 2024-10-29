<?php

namespace Domain\Auth\Contracts;

interface RegisterNewUserActionContract
{
    public function __invoke(string $name, string $email, string $password);
}
