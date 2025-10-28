<?php

namespace App\Http\Controllers;

use App\Models\HomeBagel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeBagelController extends Controller
{
    public function index()
    {
        $bagels = HomeBagel::orderBy('order')->get();
        return view('admin.homebagels.index', compact('bagels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image'       => 'required|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
        ]);

        $file = $request->file('image');
        $name = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());

        // === Rutas ===
        $webRootPath = config('app.web_root_path');
        $webLink     = config('app.web_link');
        $ruta_archivo = $webRootPath.'/imagenes/home_bagels/';
        $ruta        = $webLink.'/imagenes/home_bagels/'.$name;

        // Crear carpeta si no existe
        if (!File::exists($ruta_archivo)) {
            File::makeDirectory($ruta_archivo, 0755, true);
        }

        // $ruta_archivo = public_path('template/images/home_bagels/');
        // $ruta = '/template/images/home_bagels/' . $name;

        // Mover archivo
        $file->move($ruta_archivo, $name);

        // Asignar ruta y orden
        $data['image_path'] = $ruta;
        $data['order'] = (HomeBagel::max('order') ?? 0) + 1;

        $bagel = HomeBagel::create($data);

        return response()->json(['success' => true, 'bagel' => $bagel]);
    }

    public function update(Request $request, $id)
    {
        $homeBagel = HomeBagel::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
        ]);

        $webRootPath = config('app.web_root_path');
        $webLink     = config('app.web_link');

        // Si sube nueva imagen, eliminar la anterior
        if ($request->hasFile('image')) {
            if ($homeBagel->image_path) {
                $oldFile = str_replace($webLink, $webRootPath, $homeBagel->image_path);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            $file = $request->file('image');
            $name = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $ruta_archivo = $webRootPath.'/imagenes/home_bagels/';
            $ruta        = $webLink.'/imagenes/home_bagels/'.$name;

            if (!File::exists($ruta_archivo)) {
                File::makeDirectory($ruta_archivo, 0755, true);
            }


            // $ruta_archivo = public_path('template/images/home_bagels/');
            // $ruta = '/template/images/home_bagels/' . $name;
            

            $file->move($ruta_archivo, $name);
            $data['image_path'] = $ruta;
        }

        $homeBagel->update($data);

        return response()->json([
            'success' => true,
            'bagel'   => $homeBagel
        ]);
    }

    public function destroy($id)
    {
        $homeBagel = HomeBagel::findOrFail($id);
        $webRootPath = config('app.web_root_path');
        $webLink = config('app.web_link');

        // Eliminar imagen asociada
        if ($homeBagel->image_path) {
            $oldFile = str_replace($webLink, $webRootPath, $homeBagel->image_path);
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        $homeBagel->delete();

        return response()->json(['success' => true]);
    }
}
