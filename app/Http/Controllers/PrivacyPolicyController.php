<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\PrivacyGeneralText;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        // Obtiene el texto general, si no existe lo crea vacío
        $generalText = PrivacyGeneralText::first();

        if (!$generalText) {
            $generalText = PrivacyGeneralText::create([
                'content' => '',
                'is_active' => 1,
            ]);
        }

        $policies = PrivacyPolicy::orderBy('order_num')->get();

        return view('pages.privacy_policies', compact('generalText', 'policies'));
    }

    // ==============================
    // CRUD: TEXTO GENERAL
    // ==============================

    public function storeGeneral(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $text = PrivacyGeneralText::create([
            'content' => $validated['content'],
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Texto general creado correctamente.',
            'text' => $text,
        ]);
    }

    public function updateGeneral(Request $request, $id)
    {
        $text = PrivacyGeneralText::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $text->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Texto general actualizado correctamente.',
        ]);
    }

    // ==============================
    // CRUD: SECCIONES DE POLÍTICAS
    // ==============================

    public function storePolicy(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $policy = PrivacyPolicy::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'order_num' => $validated['order_num'] ?? 0,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sección creada correctamente.',
            'policy' => $policy,
        ]);
    }

    public function updatePolicy(Request $request, $id)
    {
        $policy = PrivacyPolicy::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $policy->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sección actualizada correctamente.',
        ]);
    }

    public function destroyPolicy($id)
    {
        $policy = PrivacyPolicy::findOrFail($id);
        $policy->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sección eliminada correctamente.',
        ]);
    }
}
