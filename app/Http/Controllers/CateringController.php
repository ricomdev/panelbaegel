<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CateringSetting;
use Illuminate\Support\Facades\File;

class CateringController extends Controller
{
    public function index()
    {
        $catering = CateringSetting::first();
        return view('pages.catering', compact('catering'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title'            => 'nullable|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'block_title'      => 'nullable|string|max:255',
            'block_paragraph'  => 'nullable|string',
            'block_highlight'  => 'nullable|string|max:255',
            'list_title'       => 'nullable|string|max:255',
            'disclaimer'       => 'nullable|string|max:255',
            'list_items'       => 'nullable|string',
            'feature_image_path' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $catering = CateringSetting::firstOrCreate([]);

        // ==========================
        // Manejo de imagen (con rutas absolutas)
        // ==========================
        if ($request->hasFile('feature_image_path')) {
            $file = $request->file('feature_image_path');
            $name = time() . '_' . $file->getClientOriginalName();

            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/catering/';
            $ruta = $webLink . '/imagenes/catering/' . $name;

            // $ruta_archivo = public_path('template/images/catering/');
            // $ruta = '/template/images/catering/' . $name;

            // Crear carpeta si no existe
            if (!File::exists($ruta_archivo)) {
                File::makeDirectory($ruta_archivo, 0777, true, true);
            }

            // Eliminar imagen anterior si existe
            if ($catering->feature_image_path) {
                $oldFile = str_replace($webLink, $webRootPath, $catering->feature_image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            // Mover nueva imagen
            $file->move($ruta_archivo, $name);
            $data['feature_image_path'] = $ruta;
        }

        // ==========================
        // Manejo de lista (JSON → array)
        // ==========================
        if (!empty($data['list_items'])) {
            $decoded = json_decode($data['list_items'], true);
            $data['list_items'] = is_array($decoded)
                ? $decoded
                : preg_split('/\r\n|\r|\n/', $data['list_items']);
        }

        // ==========================
        // Guardar cambios
        // ==========================
        $catering->update($data);

        return response()->json([
            'success'  => true,
            'message'  => 'Sección de Catering actualizada correctamente.',
            'catering' => $catering,
        ]);
    }
}
