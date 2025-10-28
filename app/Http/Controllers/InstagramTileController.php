<?php

namespace App\Http\Controllers;

use App\Models\InstagramTile;
use Illuminate\Http\Request;

class InstagramTileController extends Controller
{

    // Actualiza por campo 'order'
    public function updateByOrder(Request $request, int $order)
    {
        $tile = InstagramTile::where('order', $order)->firstOrFail();

        $data = $request->validate([
            'post_url' => 'nullable|url|max:255',
            'image'    => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/instagram/';
            $ruta = $webLink . '/imagenes/instagram/' . $name;

            // $ruta_archivo = public_path('template/images/instagram/');
            // $ruta = '/template/images/instagram/' . $name;

            $file->move($ruta_archivo, $name);
            $data['image_path'] = $ruta;
        }

        $tile->update($data);
        $tile->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Tile actualizado correctamente.',
            'tile'    => $tile,
        ]);
    }
}
