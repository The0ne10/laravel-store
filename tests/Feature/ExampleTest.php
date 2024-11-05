<?php

use App\Http\Controllers\HomeController;

it('returns a successful response', function () {
    $this->get(action(HomeController::class))
        ->assertOk();
});
