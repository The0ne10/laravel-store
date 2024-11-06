<?php

use App\Http\Controllers\HomeController;

it('successful response home page', function () {
    $this->get(action(HomeController::class))
        ->assertOk();
});
