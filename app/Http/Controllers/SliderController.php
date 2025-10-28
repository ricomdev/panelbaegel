<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type'         => 'required|in:image,youtube',
            'title'        => 'nullable|string|max:255',
            'caption'      => 'nullable|string|max:255',
            'button_text'  => 'nullable|string|max:100',
            'button_link'  => 'nullable|url|max:255',
            'youtube_id'   => 'nullable|string|max:100',
            'image'        => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:8192',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable|boolean'
        ]);

        // ======================================================
        // Guardar imagen si existe
        // ======================================================
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();

            // Rutas definidas en config/app.php
            $webRootPath = config('app.web_root_path');
            $web_link = config('app.web_link');

            // Ruta física y URL pública
            $ruta_archivo = $webRootPath . '/imagenes/sliders/';
            $ruta = $web_link . '/imagenes/sliders/' . $name;

            // $ruta_archivo = public_path('template/images/sliders/');
            // $ruta = '/template/images/sliders/' . $name;

            // Crear carpeta si no existe
            if (!File::exists($ruta_archivo)) {
                File::makeDirectory($ruta_archivo, 0777, true, true);
            }

            // Mover archivo
            $file->move($ruta_archivo, $name);

            $data['image_path'] = $ruta;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? (Slider::max('order') + 1);

        Slider::create($data);

        return response()->json(['success' => true, 'message' => 'Slider creado correctamente.']);
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'type'         => 'required|in:image,youtube',
            'title'        => 'nullable|string|max:255',
            'caption'      => 'nullable|string|max:255',
            'button_text'  => 'nullable|string|max:100',
            'button_link'  => 'nullable|url|max:255',
            'youtube_id'   => 'nullable|string|max:100',
            'image'        => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:8192',
            'order'        => 'nullable|integer|min:0',
            'is_active'    => 'nullable|boolean'
        ]);

        // ======================================================
        // Si se sube una nueva imagen, eliminar la anterior y guardar la nueva
        // ======================================================
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();

            $webRootPath = config('app.web_root_path');
            $web_link = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/sliders/';
            $ruta = $web_link . '/imagenes/sliders/' . $name;

            // $ruta_archivo = public_path('template/images/sliders/');
            // $ruta = '/template/images/sliders/' . $name;

            if (!File::exists($ruta_archivo)) {
                File::makeDirectory($ruta_archivo, 0777, true, true);
            }

            //Eliminar anterior
            if ($slider->image_path) {
                $oldFile = str_replace($web_link, $webRootPath, $slider->image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file->move($ruta_archivo, $name);
            $data['image_path'] = $ruta;
        }

        $data['is_active'] = $request->boolean('is_active');
        $slider->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slider actualizado correctamente.',
            'slider' => $slider
        ]);

    }

    public function destroy(Slider $slider)
    {
        $webRootPath = config('app.web_root_path');
        $web_link = config('app.web_link');

        // Eliminar imagen si existe
        if ($slider->image_path) {
            $oldFile = str_replace($web_link, $webRootPath, $slider->image_path);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $slider->delete();

        return response()->json(['success' => true, 'message' => 'Slider eliminado.']);
    }
}