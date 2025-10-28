<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Devuelve todas las configuraciones como JSON o array asociativo
        $settings = SiteSetting::all()->pluck('value', 'key');
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'timeline_title'         => 'nullable|string|max:255',
            'timeline_button'        => 'nullable|string|max:255',
            'find_us_title'          => 'nullable|string|max:255',
            'bagels_title'           => 'nullable|string|max:255',
            'want_baegels_title'     => 'nullable|string|max:255',
            'attention_text'         => 'nullable|string|max:255',
            'lovers_title'           => 'nullable|string|max:255',
            'instagram_follow_text'  => 'nullable|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Configuraciones actualizadas correctamente.',
            'settings' => SiteSetting::all()->pluck('value', 'key'),
        ]);
    }
}
