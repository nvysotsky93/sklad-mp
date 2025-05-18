<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index() {
        return InventoryMovement::whereHas('product.warehouse', function ($q) {
            $q->where('user_id', auth()->id());
        })->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'description' => 'nullable|string'
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->warehouse->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $movement = InventoryMovement::create($data);

        if ($data['type'] === 'in') {
            $product->increment('quantity', $data['quantity']);
        } elseif ($data['type'] === 'out') {
            $product->decrement('quantity', $data['quantity']);
        } elseif ($data['type'] === 'adjustment') {
            $product->update(['quantity' => $data['quantity']]);
        }

        return $movement;
    }

    public function show(InventoryMovement $inventoryMovement) {
        $this->authorizeOwner($inventoryMovement);
        return $inventoryMovement;
    }

    public function update(Request $request, InventoryMovement $inventoryMovement) {
        $this->authorizeOwner($inventoryMovement);
        // Обычно движения не редактируют, только создают и просматривают
        return response()->json(['message' => 'Editing not supported'], 405);
    }

    public function destroy(InventoryMovement $inventoryMovement) {
        $this->authorizeOwner($inventoryMovement);
        $inventoryMovement->delete();
        return response()->noContent();
    }

    private function authorizeOwner(InventoryMovement $movement) {
        if ($movement->product->warehouse->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
