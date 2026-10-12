<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class StoreController extends Controller
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
}
