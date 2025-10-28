<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * 📄 LISTA DE PRODUCTOS UNITARIOS
     */
    public function indexUnit()
    {
        $products = Product::with('subcategory')
            ->where('type', 'unit')
            ->orderBy('id')
            ->get();

        return view('product.unit.index', compact('products'));
    }

    /**
     * ✏️ MOSTRAR FORMULARIO DE EDICIÓN PRODUCTO UNITARIO
     */
    public function showUnit($code)
    {
        $productImages = ProductImage::whereHas('product', fn($q) => $q->where('code', $code))
            ->orderBy('order')
            ->get();

        $subcategories = Subcategory::all(); // Para elegir subcategoría padre

        return view('product.unit.show', compact('code', 'productImages', 'subcategories'));
    }

    /**
     * 🔄 OBTENER DATOS DE PRODUCTO UNITARIO (JSON)
     */
    public function dataproductUnit($code)
    {
        return Product::with(['images' => fn($q) => $q->orderBy('order')])
            ->where('code', $code)
            ->first();
    }

    /**
     * 💾 ACTUALIZAR PRODUCTO UNITARIO
     */
    public function updateUnit(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::where('code', $request->codigo_antiguo)->firstOrFail();

            // ✅ Actualizamos campos de la tabla products
            $product->subcategory_id = $request->subcategory_id;
            $product->type = 'unit'; // 🔥 fijo para este bloque
            $product->code = $request->code;
            $product->short_name = $request->short_name;
            $product->name = $request->name;
            $product->content = $request->content;
            $product->description = $request->description;
            $product->description_002 = $request->description_002;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->is_active = $request->is_active ?? 0;
            $product->qty_bagel = $request->qty_bagel;
            $product->qty_spreads = $request->qty_spreads;
            $product->save();

            // 🔥 Reordenar imágenes existentes según drag & drop
            if ($request->has('order')) {
                foreach ($request->order as $id => $position) {
                    if (is_numeric($id)) {
                        ProductImage::where('id', $id)
                            ->where('product_id', $product->id)
                            ->update(['order' => $position]);
                    }
                }
            }

            // 🆕 Guardar imágenes nuevas
            if ($request->hasFile('images')) {
                $maxOrder = ProductImage::where('product_id', $product->id)->max('order') ?? -1;
                foreach ($request->file('images') as $index => $file) {
                    $ext = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $index . '.' . $ext;

                    // $ruta_archivo = public_path('template/images/products/');
                    // $ruta = '/template/images/products/' . $name;

                    // Producción:
                    $ruta_archivo = '/home3/baegelpe/public_html/imagenes/products/';
                    $webRootPath = config('app.web_root_path');
                    $web_link = config('app.web_link');
                    $ruta_archivo = $webRootPath.'/imagenes/products/';
                    $ruta = $web_link.'/imagenes/products/' . $name;

                    $file->move($ruta_archivo, $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $ruta,
                        'type' => 'secundaria', // por defecto
                        'order' => $maxOrder + $index + 1
                    ]);
                }
            }

            // 🔄 Recalcular PRINCIPAL/SECUNDARIA (primera = principal)
            $imgs = ProductImage::where('product_id', $product->id)
                ->orderBy('order')
                ->get();

            foreach ($imgs as $i => $img) {
                $img->type = $i === 0 ? 'principal' : 'secundaria';
                $img->save();
            }

            DB::commit();
            return response()->json(1);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * 🗑️ ELIMINAR IMAGEN
     */
    public function deleteUnitImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;
    
        // 🔥 Eliminar archivo físico si existe
        $webRootPath = config('app.web_root_path');
        $url = $image->path;
        $url_path = parse_url($url, PHP_URL_PATH);
        $physical_path = rtrim($webRootPath, '/') . '/' . ltrim($url_path, '/');
    
        if (file_exists($physical_path)) {
            @unlink($physical_path);
        }
    
        $image->delete();
    
        // ✅ Reasignar principal si quedó vacante
        $remaining = ProductImage::where('product_id', $productId)
            ->orderBy('order')
            ->get();
    
        if ($remaining->count() > 0) {
            // El primero pasa a principal
            $first = $remaining->first();
            $first->update(['type' => 'principal']);
    
            // El resto secundarias
            foreach ($remaining->skip(1) as $img) {
                if ($img->type !== 'secundaria') {
                    $img->update(['type' => 'secundaria']);
                }
            }
        }
    
        return response()->json(['success' => true]);
    }

}
