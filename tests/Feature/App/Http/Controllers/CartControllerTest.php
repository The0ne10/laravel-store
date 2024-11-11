<?php


use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;

beforeEach(function () {
    CartManager::fake();

    $this->product = ProductFactory::new()->createOne();
});


test('is empty cart', function () {
    $this->get(action([CartController::class, 'index']))
        ->assertOk()
        ->assertViewIs('cart.index')
        ->assertViewHas('items', collect());
});

test('is not empty cart', function ()  {
    cart()->add($this->product, 4);

    $this->get(action([CartController::class, 'index']))
        ->assertOk()
        ->assertViewIs('cart.index')
        ->assertViewHas('items', cart()->items());
});

test('added success', function () {
    $this->assertEquals(0, cart()->count());

    $this->post(action([CartController::class, 'add'], $this->product),
        ['quantity' => 4]
    );

    $this->assertEquals(4, cart()->count());
});

test('quantity changed', function () {
    cart()->add($this->product, 4);

    $this->assertEquals(4, cart()->count());

    $this->post(action([CartController::class, 'quantity'], cart()->items()->first()),
        ['quantity' => 8]
    );

    $this->assertEquals(8, cart()->count());
});

test('delete success', function () {
   cart()->add($this->product, 4);

   $this->assertEquals(4, cart()->count());

   $this->delete(action([CartController::class, 'delete'], cart()->items()->first()));

   $this->assertEquals(0, cart()->count());
});

test('truncate success', function () {
    cart()->add($this->product, 4);

    $this->assertEquals(4, cart()->count());

    $this->delete(
        action([CartController::class, 'truncate'])
    );

    $this->assertEquals(0, cart()->count());
});
