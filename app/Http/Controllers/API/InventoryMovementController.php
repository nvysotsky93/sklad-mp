<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class InventoryMovementController extends Controller
{
    public function index() {
        return InventoryMovement::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'description' => 'nullable|string'
        ]);
        return InventoryMovement::create($data);
    }

    public function show(InventoryMovement $inventoryMovement) {
        return $inventoryMovement;
    }

    public function update(Request $request, InventoryMovement $inventoryMovement) {
        $inventoryMovement->update($request->only(['type', 'quantity', 'description']));
        return $inventoryMovement;
    }

    public function destroy(InventoryMovement $inventoryMovement) {
        $inventoryMovement->delete();
        return response()->noContent();
    }
}
