<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeProductPriceRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $validated = $this->validate($request, ['page' => 'sometimes|integer|min:0']);

        $products = Product::with([
            'vendor' => function ($q) {
                $q->select('id', 'name');
            }
        ])
        ->orderBy('name', 'ASC')->paginate(25);

        return view('product/index', compact('products'));
    }

    public function changePrice(ChangeProductPriceRequest $request)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($validated['id']);
        return response()->json($product->fill($validated)->save());
    }
}
