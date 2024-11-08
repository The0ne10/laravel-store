<?php

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

final class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    )
    {
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Cart|Builder
    {
        $cart = Cart::query()
            ->updateOrCreate([
                'storage_id' => $this->identityStorage->get(),
            ], $this->storedData($this->identityStorage->get()));

        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => $this->stringedOptionValues($optionValues),
        ], [
            'price' => $product->price,
            'quantity' => DB::raw('quantity + ' . $quantity),
            'string_option_values' => $this->stringedOptionValues($optionValues),
        ]);

        $cartItem->optionValues()->sync($optionValues);

        $this->forgetCache();

        return $cart;
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity
        ]);
    }

    public function delete(CartItem $item): void
    {
        $item->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        $this->get()?->delete();

        $this->forgetCache();
    }

    /**
     *  Получение текущей корзины
     */
    public function get()
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function () {
            return Cart::query()
                ->with('cartItems')
                ->where('storage_id', $this->identityStorage->get())
                ->when(auth()->check(), fn(Builder $query) => $query->orWhere('user_id', auth()->id()))
                ->first() ?? false;
        });
    }

    public function items(): Collection
    {
        if(!$this->get()) {
            return collect([]);
        }

        return CartItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get());
    }

    public function count(): int
    {
        return $this->cartItems()->sum(function ($item) {
            return $item->quantity;
        });
    }

    public function amount()
    {
        return Price::make(
            $this->cartItems()->sum(function ($item) {
                return $item->amount->raw();
            })
        );
    }

    public function cartItems(): Collection
    {
        return $this->get()?->cartItems ?? collect([]);
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    private function storedData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function cacheKey(): string
    {
        return str('cart_' . $this->identityStorage->get())
            ->slug('_')
            ->value();
    }

    private function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }
}
