<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return Product::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku',
            'barcode' => 'nullable|string',
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'quantity' => 'required|integer'
        ]);
        return Product::create($data);
    }

    public function show(Product $product) {
        return $product;
    }

    public function update(Request $request, Product $product) {
        $product->update($request->only(['name', 'barcode', 'price', 'cost_price', 'quantity']));
        return $product;
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->noContent();
    }
}
