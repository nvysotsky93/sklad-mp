<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return Product::whereHas('warehouse', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
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

        // Проверка, принадлежит ли склад текущему пользователю
        if (!auth()->user()->warehouses()->where('id', $data['warehouse_id'])->exists()) {
            abort(403, 'Unauthorized');
        }

        return Product::create($data);
    }

    public function show(Product $product) {
        $this->authorizeOwner($product);
        return $product;
    }

    public function update(Request $request, Product $product) {
        $this->authorizeOwner($product);
        $product->update($request->only(['name', 'barcode', 'price', 'cost_price', 'quantity']));
        return $product;
    }

    public function destroy(Product $product) {
        $this->authorizeOwner($product);
        $product->delete();
        return response()->noContent();
    }

    private function authorizeOwner(Product $product) {
        if ($product->warehouse->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
