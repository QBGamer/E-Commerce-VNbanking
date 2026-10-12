<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class CPStoreController extends Controller
{
    public static function data(): array
    {
        return [
            'storeInfo' => self::storeInfo(),
        ];
    }

    public static function storeInfo()
    {
        $storeInfo = Setting::whereIn('key', ['store_name', 'store_tagline', 'store_email', 'store_phone', 'store_address'])
            ->pluck('value', 'key')
            ->toArray();

        return [
            'name' => $storeInfo['store_name'] ?? 'E-Com',
            'tagline' => $storeInfo['store_tagline'] ?? 'Everything you need, delivered.',
            'email' => $storeInfo['store_email'] ?? 'info@ecom.com',
            'phone' => $storeInfo['store_phone'] ?? '123-456-7890',
            'address' => $storeInfo['store_address'] ?? '123 Main St, Anytown, USA',
        ];
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Setting::updateOrCreate(['key' => 'store_name'], ['value' => $request->store_name]);
        Setting::updateOrCreate(['key' => 'store_tagline'], ['value' => $request->tagline]);
        Setting::updateOrCreate(['key' => 'store_email'], ['value' => $request->email]);
        Setting::updateOrCreate(['key' => 'store_phone'], ['value' => $request->phone]);
        Setting::updateOrCreate(['key' => 'store_address'], ['value' => $request->address]);

        return response()->json([
            'message' => 'Store information updated successfully.',
        ]);
    }
}
