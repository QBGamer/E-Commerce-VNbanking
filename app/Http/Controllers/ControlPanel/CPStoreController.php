<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\User;

class CPStoreController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('controlpanel.settings',[
            'users' => $users,
        ]);
    }

    public function roleChange(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'role' => 'required|in:admin,manager,staff', // Adjust roles as needed
        ]);

        $user = User::where('email', $request->email)->first();
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'User role updated successfully.'
            ]);
    }

    // function call in AppserviceProvider boot() to share data with all views
    public static function data(): array
    {
        return [
            'storeInfo' => self::storeInfo(),
        ];
    }

    public static function storeInfo()
    {
        $storeInfo = Setting::whereIn('key', [
            'store_name',
            'store_tagline',
            'store_email',
            'store_phone',
            'store_address',
            'store_icon',
        ])->pluck('value', 'key')->toArray();

        return [
            'name' => $storeInfo['store_name'] ?? 'E-Com',
            'tagline' => $storeInfo['store_tagline'] ?? 'Everything you need, delivered.',
            'email' => $storeInfo['store_email'] ?? 'info@ecom.com',
            'phone' => $storeInfo['store_phone'] ?? '123-456-7890',
            'address' => $storeInfo['store_address'] ?? '123 Main St, Anytown, USA',
            'icon' => $storeInfo['store_icon'] ?? null,
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
            'image' => 'nullable|array|max:6',
            'image.*' => 'file|image|mimes:png|max:1024',
        ]);

        Setting::updateOrCreate(['key' => 'store_name'], ['value' => $request->store_name]);
        Setting::updateOrCreate(['key' => 'store_tagline'], ['value' => $request->tagline]);
        Setting::updateOrCreate(['key' => 'store_email'], ['value' => $request->email]);
        Setting::updateOrCreate(['key' => 'store_phone'], ['value' => $request->phone]);
        Setting::updateOrCreate(['key' => 'store_address'], ['value' => $request->address]);

        $iconUpdated = false;
        $iconPath = null;

        if ($request->hasFile('image')) {
            $pngs = array_map(fn ($file) => file_get_contents($file->getRealPath()), $request->file('image'));
            $pngs = array_values(array_filter($pngs, fn ($bytes) => is_string($bytes) && strlen($bytes) >= 24));

            if ($pngs !== []) {
                Storage::disk('public')->put('icon.ico', self::pngToIco($pngs));
                Setting::updateOrCreate(['key' => 'store_icon'], ['value' => '/storage/icon.ico']);
                $iconUpdated = true;
                $iconPath = '/storage/icon.ico';
            }
        }

        return response()->json([
            'message' => $iconUpdated
                ? 'Store information and icon updated successfully.'
                : 'Store information updated successfully.',
            'icon_updated' => $iconUpdated,
            'url' => $iconPath ? $iconPath . '?v=' . time() : null,
        ]);
    }

    // Change header png by change header \x89PNG\r\n\x1a\n to \x00\x00\x01\x00 and add ico header
    private static function pngToIco(array $pngs): string
    {
        $valid = [];
        foreach ($pngs as $png) {
            if (strlen($png) < 24 || substr($png, 0, 8) !== "\x89PNG\r\n\x1a\n") {
                continue;
            }
            $dimensions = unpack('Nwidth/Nheight', substr($png, 16, 8));
            $valid[] = [$png, $dimensions['width'], $dimensions['height']];
        }

        $count = count($valid);
        if ($count === 0) {
            return '';
        }

        $header = "\x00\x00\x01\x00" . pack('v', $count);
        $offset = 6 + ($count * 16);
        $entries = '';
        $data = '';

        foreach ($valid as [$png, $width, $height]) {
            $entries .= chr($width >= 256 ? 0 : $width)
                . chr($height >= 256 ? 0 : $height)
                . "\x00\x00"            // palette, reserved
                . pack('v', 1)          // color planes
                . pack('v', 32)         // bits per pixel
                . pack('V', strlen($png))
                . pack('V', $offset);
            $data .= $png;
            $offset += strlen($png);
        }

        return $header . $entries . $data;
    }
}
