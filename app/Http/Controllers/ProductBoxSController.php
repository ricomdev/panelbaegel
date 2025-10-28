<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductBoxItem;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBoxSController extends Controller
{
    /**
     * 📄 LISTA DE PRODUCTOS BOX-S
     */
    public function index()
    {
        $products = Product::with('subcategory')
            ->whereIn('type', ['box3s', 'box6s'])
            ->orderBy('id')
            ->get();

        return view('product.boxs.index', compact('products'));
    }

    /**
     * ✏️ MOSTRAR FORMULARIO DE EDICIÓN BOX-S
     */
    public function show($code)
    {
        $productImages = ProductImage::whereHas('product', fn($q) => $q->where('code', $code))
            ->orderBy('order')
            ->get();

        $subcategories = Subcategory::all();

        // Productos UNIT ya agregados a este box
        $boxItems = ProductBoxItem::with('itemProduct')
            ->whereHas('product', fn($q) => $q->where('code', $code))
            ->get();

        return view('product.boxs.show', compact('code', 'productImages', 'subcategories', 'boxItems'));
    }

    /**
     * 🔄 OBTENER DATOS DE PRODUCTO BOX-S (JSON)
     */
    public function dataproduct($code)
    {
        $product = Product::with([
            'images' => fn($q) => $q->orderBy('order'),
            'boxItems.itemProduct'
        ])
            ->where('code', $code)
            ->first();

        return $product;
    }

    /**
     * 💾 ACTUALIZAR PRODUCTO BOX-S
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::where('code', $request->codigo_antiguo)->firstOrFail();

            // ✅ Campos principales
            $product->subcategory_id = $request->subcategory_id;
            $product->type = $request->type; // puede ser box3s o box6s
            $product->code = $request->code;
            $product->short_name = $request->short_name;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->description_002 = $request->description_002;
            $product->price = $request->price;
            $product->is_active = $request->is_active ?? 0;
            $product->qty_bagel = $request->qty_bagel;  // visible aquí
            $product->qty_spreads = null;              // oculto
            $product->save();

            // 🔥 Reordenar imágenes
            if ($request->has('order')) {
                foreach ($request->order as $id => $pos) {
                    if (is_numeric($id)) {
                        ProductImage::where('id', $id)
                            ->where('product_id', $product->id)
                            ->update(['order' => $pos]);
                    }
                }
            }

            // 🆕 Guardar nuevas imágenes
            if ($request->hasFile('images')) {
                $maxOrder = ProductImage::where('product_id', $product->id)->max('order') ?? -1;
                foreach ($request->file('images') as $idx => $file) {
                    $ext = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $idx . '.' . $ext;

                    //$ruta_archivo = public_path('template/images/products/');
                    //$ruta = '/template/images/products/' . $name;
                    
                    // Producción:
                    //$ruta_archivo = '/home3/baegelpe/public_html/imagenes/products/';
                    $webRootPath = config('app.web_root_path');
                    $web_link = config('app.web_link');
                    $ruta_archivo = $webRootPath.'/imagenes/products/';
                    $ruta = $web_link.'/imagenes/products/' . $name;
                    

                    $file->move($ruta_archivo, $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $ruta,
                        'type' => 'secundaria',
                        'order' => $maxOrder + $idx + 1
                    ]);
                }
            }

            // 🔄 Recalcular principal/secundarias
            $imgs = ProductImage::where('product_id', $product->id)
                ->orderBy('order')
                ->get();

            foreach ($imgs as $i => $img) {
                $img->type = $i === 0 ? 'principal' : 'secundaria';
                $img->save();
            }

            //Guardar relación con productos UNIT
            ProductBoxItem::where('product_id', $product->id)->delete(); // limpiar anteriores
            if ($request->has('box_items')) {
                foreach ($request->box_items as $item) {
                    if (!empty($item['item_prod_id'])) {
                        ProductBoxItem::create([
                            'product_id' => $product->id,
                            'item_prod_id' => $item['item_prod_id'],
                            'qty_stock' => $item['qty_stock'] ?? 1,
                        ]);
                    }
                }
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
    public function deleteImage($id)
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

    /**
     * 📦 OBTENER PRODUCTOS UNIT DE UNA SUBCATEGORÍA (para armar box)
     */
    public function getUnitsBySubcategory($subcategory_id)
    {
        $units = Product::where('subcategory_id', $subcategory_id)
            ->where('type', 'unit')
            ->where('is_active', 1)
            ->select('id', 'name', 'short_name', 'price')
            ->get();

        return response()->json($units);
    }
}
