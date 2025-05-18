<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index() {
        return Warehouse::all();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'location' => 'nullable|string'
        ]);
        return Warehouse::create($data);
    }

    public function show(Warehouse $warehouse) {
        return $warehouse;
    }

    public function update(Request $request, Warehouse $warehouse) {
        $warehouse->update($request->only(['name', 'location']));
        return $warehouse;
    }

    public function destroy(Warehouse $warehouse) {
        $warehouse->delete();
        return response()->noContent();
    }
}
