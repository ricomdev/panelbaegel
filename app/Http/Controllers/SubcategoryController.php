<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\SubcategoryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')
            ->orderBy('id')
            ->get();

        return view('subcategory.index', compact('subcategories'));
    }

    public function show($code)
    {
        $subcategoryImages = SubcategoryImage::whereHas('subcategory', function($q) use ($code){
            $q->where('code',$code);
        })
        ->orderBy('order')
        ->get();

        // 🔥 Traemos todas las categorías activas para mostrarlas en un select o etiqueta
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('subcategory.show', compact('code','subcategoryImages','categories'));
    }

    public function datasubcategory($code)
    {
        $subcategory = Subcategory::with(['images' => function($q){
            $q->orderBy('order');
        }])->where('code',$code)->first();

        return $subcategory;
    }

    public function updatesubcategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $subcategory = Subcategory::where('code', $request->codigo_antiguo)->firstOrFail();
            $subcategory->name = $request->name;
            $subcategory->code = $request->code;
            $subcategory->description = $request->description;
            $subcategory->is_active = $request->is_active;
            $subcategory->save();

            // 🔥 Reordenar imágenes existentes
            if ($request->has('order')) {
                foreach ($request->order as $id => $position) {
                    if (is_numeric($id)) {
                        SubcategoryImage::where('id', $id)
                            ->where('subcategory_id', $subcategory->id)
                            ->update(['order' => $position]);
                    }
                }
            }

            // 🆕 Guardar nuevas imágenes
            if ($request->hasFile('images')) {
                $maxOrder = SubcategoryImage::where('subcategory_id', $subcategory->id)->max('order') ?? -1;
                $files = $request->file('images');

                foreach ($files as $index => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $index . '.' . $extension;

                    // $ruta_archivo = public_path('template/images/subcategories/');
                    // $ruta = '/template/images/subcategories/' . $name;

                    // PRODUCCIÓN:
                    // $ruta_archivo = '/home3/baegelpe/public_html/imagenes/subcategories/';
                    // $ruta = 'https://www.baegel.pe/imagenes/subcategories/' . $name;
                    $webRootPath = config('app.web_root_path');
                    $web_link = config('app.web_link');
                    $ruta_archivo = $webRootPath.'/imagenes/subcategories/';
                    $ruta = $web_link.'/imagenes/subcategories/' . $name;

                    $file->move($ruta_archivo, $name);

                    SubcategoryImage::create([
                        'subcategory_id' => $subcategory->id,
                        'type' => 'secundaria', // por defecto
                        'path' => $ruta,
                        'order' => $maxOrder + $index + 1
                    ]);
                }
            }

            // 🔄 Recalcular tipos: la primera = principal, el resto secundarias
            $allImages = SubcategoryImage::where('subcategory_id', $subcategory->id)
                ->orderBy('order')
                ->get();

            foreach ($allImages as $idx => $img) {
                $img->type = $idx === 0 ? 'principal' : 'secundaria';
                $img->save();
            }

            DB::commit();
            return response()->json(1);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteImage($id)
    {
        $image = SubcategoryImage::findOrFail($id);

        // Opcional: eliminar archivo físico si existe
        $path = public_path(str_replace('/template/', 'template/', $image->path));
        if (file_exists($path)) {
            @unlink($path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}
