<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Contracts\ProductCatalogInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductCatalogInterface $catalog,
    ) {}

    public function index(Request $request): View
    {
        $products = $this->catalog->listProducts($request->only(['search', 'category']));
        $categories = $this->catalog->listCategories();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
