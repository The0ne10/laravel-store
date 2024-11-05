<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke(Product $product, ?array $also = [])
    {
        $product->load(['OptionValues.option']);

        if (session()->has('also')) {
            $also = Product::query()
                ->where(function ($query) use ($product) {
                    $query->whereIn('id', session('also'))
                        ->where('id', '!=', $product->id);
                })->get();
        }


        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        // Функционал просмотренных товаров храниться в сессиях
        session()->put('also.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $options,
            'also' => $also,
        ]);
    }
}
