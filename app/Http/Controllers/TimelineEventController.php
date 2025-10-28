<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimelineEvent;
use Illuminate\Http\Request;

class TimelineEventController extends Controller
{
    public function update(Request $request, TimelineEvent $timelineEvent)
    {
        $data = $request->validate([
            'year' => 'required|string|max:10',
            'description' => 'required|string|max:500',
            'icon' => 'nullable|mimes:svg,png,jpg,jpeg,webp,gif|max:4096',
        ]);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $name = time() . '_' . $file->getClientOriginalName();

            $webRootPath = config('app.web_root_path');
            $webLink = config('app.web_link');

            $ruta_archivo = $webRootPath . '/imagenes/timeline/';
            $ruta = $webLink . '/imagenes/timeline/' . $name;

            // $ruta_archivo = public_path('template/images/timeline/');
            // $ruta = '/template/images/timeline/' . $name;

            $file->move($ruta_archivo, $name);
            $data['icon_path'] = $ruta;
        }

        $timelineEvent->update($data);
        $timelineEvent->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Evento actualizado correctamente.',
            'event' => $timelineEvent,
        ]);
    }

}
