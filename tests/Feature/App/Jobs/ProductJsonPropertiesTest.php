<?php

use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Support\Facades\Queue;

test('it created json properties', function () {
    $queue = Queue::getFacadeRoot();

    Queue::fake([ProductJsonProperties::class]);

    $properties = PropertyFactory::new()
        ->count(10)
        ->create();

    $product = ProductFactory::new()
        ->hasAttached($properties, function () {
            return ['value' => ucfirst(fake()->word())];
        })
        ->create();

    $this->assertEmpty($product->value('json_properties'));

    Queue::swap($queue);

    ProductJsonProperties::dispatchSync($product);

    $product->refresh();

    $this->assertNotEmpty($product->value('json_properties'));
});
