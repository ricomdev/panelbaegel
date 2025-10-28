<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Actualiza por campo 'order'
    public function updateByOrder(Request $request, int $order)
    {
        $service = Service::where('order', $order)->firstOrFail();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
        ]);

        // Subida del ícono
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // Rutas definidas en config/app.php
            $webRootPath = config('app.web_root_path');
            $web_link    = config('app.web_link');

            // Ruta física y URL pública
            $ruta_archivo = $webRootPath . '/imagenes/services/';
            $ruta = $web_link . '/imagenes/services/' . $name;

            // $ruta_archivo = public_path('template/images/instagram/');
            // $ruta = '/template/images/instagram/' . $name;

            $file->move($ruta_archivo, $name);
            $data['icon_path'] = $ruta;
        }

        // Actualizar servicio y refrescar modelo
        $service->update($data);
        $service->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Servicio actualizado correctamente.',
            'service' => $service,
        ]);
    }
}
