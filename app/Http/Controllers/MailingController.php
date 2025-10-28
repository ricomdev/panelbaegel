<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailingSetting;
use Illuminate\Support\Facades\File;

class MailingController extends Controller
{
    /**
     * Muestra la vista para editar la imagen del header del correo.
     */
    public function mailingHeaderImage()
    {
        $header = MailingSetting::where('key', 'email_header_image')->first();
        return view('pages.mailing_settings', compact('header'));
    }

    /**
     * Actualiza o sube la imagen del header del correo.
     */
    public function updateMAilingHeaderImage(Request $request)
    {
        $setting = MailingSetting::firstOrNew(['key' => 'email_header_image']);

        $data = $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = "header_mailing.png";

            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            // Carpeta de destino
            $ruta_archivo = $webRootPath.'/imagenes/mailing/';
            $ruta = $webLink.'/imagenes/mailing/' . $name;


            // $ruta_archivo = public_path('template/images/mailing/');
            // $ruta = '/template/images/mailing/' . $name;


            // // Crear carpeta si no existe
            // if (!File::exists($ruta_archivo)) {
            //     File::makeDirectory($ruta_archivo, 0777, true, true);
            // }

            // Eliminar imagen anterior si existía
            if ($setting->value) {
                $old = str_replace($webLink, $webRootPath, $setting->value);
                if (File::exists($old)) File::delete($old);
            }

            // Subir nueva imagen
            $file->move($ruta_archivo, $name);
            $setting->value = $ruta;
        }

        $setting->save();

        return response()->json([
            'success' => true,
            'message' => 'Imagen de cabecera del correo actualizada correctamente.',
            'setting' => $setting
        ]);
    }
}
