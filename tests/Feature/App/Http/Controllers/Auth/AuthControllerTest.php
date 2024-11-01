<?php

use Domain\Auth\Models\User;

it('can login', function () {
    $user = User::query()->create([
        'name' => 'test',
        'email' => 'test@test.com',
        'password' => bcrypt('password'),
    ]);

    $this->assertModelExists($user);
});
