<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MarketplaceAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarketplaceController extends Controller
{
    public function index() {
        return MarketplaceAccount::where('user_id', auth()->id())->get();
    }

    public function store(Request $request) {
        $data = $request->validate([
            'marketplace' => 'required|string|in:wb,ozon,yandex',
            'api_key' => 'required|string',
            'account_name' => 'required|string'
        ]);

        return MarketplaceAccount::updateOrCreate(
            ['user_id' => auth()->id(), 'marketplace' => $data['marketplace']],
            ['api_key' => $data['api_key'], 'account_name' => $data['account_name']]
        );
    }

    public function syncWbOrders() {
        $account = MarketplaceAccount::where('user_id', auth()->id())
            ->where('marketplace', 'wb')->firstOrFail();

        $response = Http::withToken($account->api_key)
            ->get('https://api.wildberries.ru/api/v1/orders');

        if (!$response->ok()) {
            return response()->json(['error' => 'Ошибка при подключении к WB'], 500);
        }

        return $response->json(); // на первом этапе просто вернём сырые заказы
    }
}
