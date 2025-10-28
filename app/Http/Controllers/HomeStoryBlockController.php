<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeStoryBlock;
use Illuminate\Support\Facades\File;

class HomeStoryBlockController extends Controller
{
    public function index()
    {
        $blocks = HomeStoryBlock::orderBy('order')->get();
        return view('pages.home_story_blocks', compact('blocks'));
    }

    public function update(Request $request, $id)
    {
        $block = HomeStoryBlock::findOrFail($id);

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'text_desktop' => 'nullable|string',
            'text_mobile' => 'nullable|string',
            'position' => 'required|in:left,right',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Imagen
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time().'_'.$file->getClientOriginalName();

            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/home_story/';
            $ruta = $webLink . '/imagenes/home_story/' . $name;
            
            // $ruta_archivo = public_path('template/images/catering/');
            // $ruta = '/template/images/catering/' . $name;

            if (!File::exists($ruta_archivo)) {
                File::makeDirectory($ruta_archivo, 0777, true, true);
            }

            // eliminar imagen previa
            if ($block->image_path) {
                $old = str_replace($webLink, $webRootPath, $block->image_path);
                if (File::exists($old)) File::delete($old);
            }

            $file->move($ruta_archivo, $name);
            $data['image_path'] = $ruta;
        }

        $block->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Bloque actualizado correctamente.',
            'block' => $block
        ]);
    }
}
