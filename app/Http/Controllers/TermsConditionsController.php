<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsCondition;
use App\Models\TermsGeneralText;

class TermsConditionsController extends Controller
{
    public function index()
    {
        // Obtiene el texto general, si no existe lo crea vacío
        $generalText = TermsGeneralText::first();

        if (!$generalText) {
            $generalText = TermsGeneralText::create([
                'content' => '',
                'is_active' => 1,
            ]);
        }

        $terms = TermsCondition::orderBy('order_num')->get();

        return view('pages.terms_conditions', compact('generalText', 'terms'));
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

        $text = TermsGeneralText::create([
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
        $text = TermsGeneralText::findOrFail($id);

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
    // CRUD: SECCIONES DE TÉRMINOS
    // ==============================

    public function storeTerm(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $term = TermsCondition::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'order_num' => $validated['order_num'] ?? 0,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sección creada correctamente.',
            'term' => $term,
        ]);
    }

    public function updateTerm(Request $request, $id)
    {
        $term = TermsCondition::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $term->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sección actualizada correctamente.',
        ]);
    }

    public function destroyTerm($id)
    {
        $term = TermsCondition::findOrFail($id);
        $term->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sección eliminada correctamente.',
        ]);
    }
}
