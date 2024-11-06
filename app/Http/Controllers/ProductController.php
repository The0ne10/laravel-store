<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ProductController extends Controller
{
    public function __invoke(Product $product, ?array $also = []): View|Factory|Application
    {
        $product->load(['OptionValues.option']);

        if (session()->has('also')) {
            $also = Product::query()
                ->where(function ($query) use ($product) {
                    $query->whereIn('id', session('also'))
                        ->where('id', '!=', $product->id);
                })->get();
        }

        // Функционал просмотренных товаров храниться в сессиях
        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'also' => $also,
        ]);
    }
}
