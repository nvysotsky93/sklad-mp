<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index() {
        return Warehouse::where('user_id', auth()->id())->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string'
        ]);
        $data['user_id'] = auth()->id();
        return Warehouse::create($data);
    }

    public function show(Warehouse $warehouse) {
        $this->authorizeOwner($warehouse);
        return $warehouse;
    }

    public function update(Request $request, Warehouse $warehouse) {
        $this->authorizeOwner($warehouse);
        $warehouse->update($request->only(['name', 'location']));
        return $warehouse;
    }

    public function destroy(Warehouse $warehouse) {
        $this->authorizeOwner($warehouse);
        $warehouse->delete();
        return response()->noContent();
    }

    private function authorizeOwner(Warehouse $warehouse) {
        if ($warehouse->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }
}
