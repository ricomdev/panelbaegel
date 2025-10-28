<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('category.index', compact('categories'));
    }

    public function show($code)
    {
        $categoryImages = CategoryImage::whereHas('category', function($q) use ($code){
            $q->where('code',$code);
        })->orderBy('order')->get();

        return view('category.show', compact('code','categoryImages'));
    }

    public function datacategory($code)
    {
        $category = Category::with(['images' => function($q){
            $q->orderBy('order');
        }])->where('code',$code)->first();
        return $category;
    }

    public function updatecategory(Request $request)
    {
        DB::beginTransaction();
        try {
            $category = Category::where('code', $request->codigo_antiguo)->firstOrFail();
            $category->name = $request->name;
            $category->code = $request->code;
            $category->is_active = $request->is_active;
            $category->save();

            // 🔥 Reordenar imágenes existentes según el drag & drop
            if ($request->has('order')) {
                foreach ($request->order as $id => $position) {
                    // Solo aplicar a imágenes existentes (IDs numéricos)
                    if (is_numeric($id)) {
                        CategoryImage::where('id', $id)
                            ->where('category_id', $category->id)
                            ->update(['order' => $position]);
                    }
                }
            }

            // 🆕 Guardar nuevas imágenes (se agregan al final)
            if ($request->hasFile('images')) {
                $maxOrder = CategoryImage::where('category_id', $category->id)->max('order') ?? -1;
                $files = $request->file('images');
                foreach ($files as $index => $file) {
                    $extension = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $index . '.' . $extension;

                    // $ruta_archivo = public_path('template/images/categories/');
                    // $ruta = '/template/images/categories/' . $name;

                    // Producción:
                    // $ruta_archivo = '/home3/baegelpe/public_html/imagenes/categories/';
                    // $ruta = 'https://www.baegel.pe/imagenes/categories/' . $name;
                    $webRootPath = config('app.web_root_path');
                    $web_link = config('app.web_link');
                    $ruta_archivo = $webRootPath.'/imagenes/categories/';
                    $ruta = $web_link.'/imagenes/categories/' . $name;

                    $file->move($ruta_archivo, $name);

                    CategoryImage::create([
                        'category_id' => $category->id,
                        'type' => 'secundaria', // por defecto
                        'path' => $ruta,
                        'order' => $maxOrder + $index + 1
                    ]);
                }
            }

            // 🔄 Recalcular tipos (primera imagen = principal, resto secundarias)
            $allImages = CategoryImage::where('category_id', $category->id)
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
        $image = CategoryImage::findOrFail($id);

        // Opcional: eliminar archivo físico si existe
        $path = public_path(str_replace('/template/', 'template/', $image->path));
        if (file_exists($path)) {
            @unlink($path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}
