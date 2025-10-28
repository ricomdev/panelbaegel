<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('order')->get();
        return response()->json($brands);
        // Si necesitas vista Blade: return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'logo'      => 'required|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
            'url'       => 'nullable|url|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // ✅ Nombre único
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // ✅ Rutas
            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/brands/';
            $ruta = $webLink . '/imagenes/brands/' . $name;

            // $ruta_archivo = public_path('template/images/brands/');
            // $ruta = '/template/images/brands/' . $name;

            // ✅ Guardar imagen
            $file->move($ruta_archivo, $name);

            $data['logo_path'] = $ruta;
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? (Brand::max('order') + 1);

        $brand = Brand::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Marca creada correctamente.',
            'brand'   => $brand
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'logo'      => 'nullable|image|max:2048',
            'url'       => 'nullable|url|max:255',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // ✅ Nombre único para evitar caché
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // ✅ Usamos las rutas definidas en config
            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/brands/';
            $ruta = $webLink . '/imagenes/brands/' . $name;

            // $ruta_archivo = public_path('template/images/brands/');
            // $ruta = '/template/images/brands/' . $name;

            $file->move($ruta_archivo, $name);

            $data['logo_path'] = $ruta;
        }

        $brand->update($data);

        // ✅ Refrescar modelo para asegurar obtener los datos más recientes
        $brand->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Marca actualizada correctamente.',
            'brand'   => $brand,
        ]);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Marca eliminada correctamente.'
        ]);
    }
}
