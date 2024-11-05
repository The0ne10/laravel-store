<?php

use App\Http\Controllers\ProductController;
use Database\Factories\ProductFactory;

test('it success response', function () {
    $product = ProductFactory::new()->createOne();

    $this->get(action(ProductController::class, $product))
        ->assertOk();
});
