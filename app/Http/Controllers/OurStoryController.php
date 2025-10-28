<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OurStoryBlock;
use Illuminate\Http\Request;

class OurStoryController extends Controller
{
    public function index()
    {
        $story = OurStoryBlock::first();
        return response()->json($story);
        // Si necesitas vista, cambia a: return view('admin.ourstory.index', compact('story'));
    }

    public function update(Request $request, OurStoryBlock $ourStory)
    {
        $data = $request->validate([
            'h3_desktop' => 'nullable|string|max:255',
            'h3_mobile'  => 'nullable|string|max:255',
            'h1'         => 'nullable|string|max:255',
            'p'          => 'nullable|string',
            'btn_label'  => 'nullable|string|max:100',
            'btn_route'  => 'nullable|string|max:191',
            'is_active'  => 'nullable|boolean',
        ]);

        $ourStory->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sección "Quiénes Somos" actualizada correctamente.',
            'story'   => $ourStory
        ]);
    }
}
