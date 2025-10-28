<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::with(['faqs' => function ($q) {
            $q->orderBy('order_num');
        }])->orderBy('order_num')->get();

        return view('pages.faqs', compact('categories'));
    }

    // ==============================
    // CRUD: CATEGORÍAS
    // ==============================

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon_class' => 'nullable|string|max:100',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category = FaqCategory::create([
            'name' => $validated['name'],
            'icon_class' => $validated['icon_class'] ?? null,
            'order_num' => $validated['order_num'] ?? 0,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoría creada correctamente.',
            'category' => $category,
        ]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = FaqCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'icon_class' => 'nullable|string|max:100',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente.',
        ]);
    }

    public function destroyCategory($id)
    {
        $category = FaqCategory::findOrFail($id);

        // Eliminar también sus preguntas asociadas
        $category->faqs()->delete();
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Categoría y preguntas eliminadas correctamente.',
        ]);
    }

    // ==============================
    // CRUD: PREGUNTAS (FAQ)
    // ==============================

    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $faq = Faq::create([
            'faq_category_id' => $validated['faq_category_id'],
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'order_num' => $validated['order_num'] ?? 0,
            'is_active' => $validated['is_active'] ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pregunta creada correctamente.',
            'faq' => $faq,
        ]);
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $faq->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pregunta actualizada correctamente.',
        ]);
    }

    public function destroyFaq($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pregunta eliminada correctamente.',
        ]);
    }
}
