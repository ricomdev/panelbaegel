<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterSetting;
use App\Models\SocialLink;

class FooterController extends Controller
{
    public function index()
    {
        $footer = FooterSetting::first();
        $socials = SocialLink::orderBy('order_num')->get();

        return view('pages.footer', compact('footer', 'socials'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'hours_desktop' => 'nullable|string|max:255',
            'hours_mobile'  => 'nullable|string',
            'address'       => 'nullable|string|max:255',
            'whatsapp'      => 'nullable|string|max:50',
            'follow_text'   => 'nullable|string|max:255',
            'newsletter_title' => 'nullable|string|max:100',
            'newsletter_text'  => 'nullable|string|max:255',
        ]);

        $footer = FooterSetting::first() ?? new FooterSetting();
        $footer->fill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración del footer actualizada correctamente.'
        ]);
    }

    public function storeSocial(Request $request)
    {
        $validated = $request->validate([
            'platform'   => 'required|string|max:100',
            'url'        => 'required|url|max:255',
            'icon_class' => 'required|string|max:100',
            'order_num'  => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $social = SocialLink::create([
            'platform'   => $validated['platform'],
            'url'        => $validated['url'],
            'icon_class' => $validated['icon_class'],
            'order_num'  => $validated['order_num'] ?? 0,
            'is_active'  => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Red social creada correctamente.',
            'social'  => $social
        ]);
    }

    public function updateSocial(Request $request, $id)
    {
        $validated = $request->validate([
            'platform'   => 'required|string|max:100',
            'url'        => 'required|url|max:255',
            'icon_class' => 'required|string|max:100',
            'order_num'  => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $social = SocialLink::findOrFail($id);
        $social->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Red social actualizada correctamente.',
            'social'  => $social
        ]);
    }

    public function destroySocial($id)
    {
        $social = SocialLink::findOrFail($id);
        $social->delete();

        return response()->json([
            'success' => true,
            'message' => 'Red social eliminada correctamente.'
        ]);
    }
}
