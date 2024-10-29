<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::query()
            ->homePage()
            ->get();

        $brand = Brand::query()
            ->homePage()
            ->get();

        $product = Product::query()
            ->homePage()
            ->get();

        return view('welcome');


    }
}
