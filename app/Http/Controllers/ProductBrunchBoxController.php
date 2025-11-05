<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBrunchBoxController extends Controller
{
    public function index()
    {
        $products = Product::with('subcategory')
            ->whereIn('type', ['bb3b1s', 'bb6b2s'])
            ->orderBy('id')
            ->get();

        return view('product.brunch.index', compact('products'));
    }

    public function show($code)
    {
        $productImages = ProductImage::whereHas('product', fn($q) => $q->where('code', $code))
            ->orderBy('order')
            ->get();

        $subcategories = Subcategory::all();

        return view('product.brunch.show', compact('code', 'productImages', 'subcategories'));
    }

    public function dataproduct($code)
    {
        return Product::with(['images' => fn($q) => $q->orderBy('order')])
            ->where('code', $code)
            ->first();
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::where('code', $request->codigo_antiguo)->firstOrFail();

            $product->subcategory_id = $request->subcategory_id;
            $product->type = $request->type; // bb3b1s o bb6b2s
            $product->code = $request->code;
            $product->short_name = $request->short_name;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->description_002 = $request->description_002;
            $product->price = $request->price;
            $product->is_active = $request->is_active ?? 0;
            $product->qty_bagel = $request->qty_bagel;
            $product->qty_spreads = $request->qty_spreads; //AHORA SE GUARDA
            $product->save();

            // Reordenar imágenes
            if ($request->has('order')) {
                foreach ($request->order as $id => $pos) {
                    if (is_numeric($id)) {
                        ProductImage::where('id', $id)
                            ->where('product_id', $product->id)
                            ->update(['order' => $pos]);
                    }
                }
            }

            // Nuevas imágenes
            if ($request->hasFile('images')) {
                $maxOrder = ProductImage::where('product_id', $product->id)->max('order') ?? -1;
                foreach ($request->file('images') as $idx => $file) {
                    $ext = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $idx . '.' . $ext;

                    $ruta_archivo = public_path('template/images/products/');
                    $ruta = '/template/images/products/' . $name;

                    // //Producción:
                    // //$ruta_archivo = '/home3/baegelpe/public_html/imagenes/products/';
                    // $webRootPath = config('app.web_root_path');
                    // $web_link = config('app.web_link');
                    // $ruta_archivo = $webRootPath.'/imagenes/products/';
                    // $ruta = $web_link.'/imagenes/products/' . $name;

                    $file->move($ruta_archivo, $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $ruta,
                        'type' => 'secundaria',
                        'order' => $maxOrder + $idx + 1
                    ]);
                }
            }

            // Recalcular principal/secundarias
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

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        $webRootPath = config('app.web_root_path');
        $url = $image->path;
        $url_path = parse_url($url, PHP_URL_PATH);
        $physical_path = rtrim($webRootPath, '/') . '/' . ltrim($url_path, '/');

        if (file_exists($physical_path)) {
            @unlink($physical_path);
        }

        $image->delete();

        $remaining = ProductImage::where('product_id', $productId)
            ->orderBy('order')
            ->get();

        if ($remaining->count() > 0) {
            $first = $remaining->first();
            $first->update(['type' => 'principal']);
            foreach ($remaining->skip(1) as $img) {
                if ($img->type !== 'secundaria') {
                    $img->update(['type' => 'secundaria']);
                }
            }
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        $subcategories = Subcategory::all();
        return view('product.brunch.create', compact('subcategories'));
    }

    /**
     * Guardar PRODUCTO NUEVO BRUNCH BOX
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Crear producto
            $product = Product::create([
                'subcategory_id' => $request->subcategory_id,
                'type' => $request->type,                // bb3b1s o bb6b2s
                'code' => $request->code,
                'short_name' => $request->short_name,
                'name' => $request->name,
                'description' => $request->description,
                'description_002' => $request->description_002,
                'price' => $request->price,
                'is_active' => $request->is_active ?? 0,
                'qty_bagel' => $request->qty_bagel,
                'qty_spreads' => $request->qty_spreads, // se guarda
            ]);

            // Guardar imágenes
            if ($request->hasFile('images')) {
                $order = 0;
                foreach ($request->file('images') as $idx => $file) {
                    $ext = $file->getClientOriginalExtension();
                    $name = $request->code . '_' . date('Y_m_d_H_i_s') . '_' . $idx . '.' . $ext;

                    $ruta_archivo = public_path('template/images/products/');
                    $ruta = '/template/images/products/' . $name;

                    // //Producción:
                    // //$ruta_archivo = '/home3/baegelpe/public_html/imagenes/products/';
                    // $webRootPath = config('app.web_root_path');
                    // $web_link = config('app.web_link');
                    // $ruta_archivo = $webRootPath.'/imagenes/products/';
                    // $ruta = $web_link.'/imagenes/products/' . $name;

                    $file->move($ruta_archivo, $name);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $ruta,
                        'type' => $order === 0 ? 'principal' : 'secundaria',
                        'order' => $order
                    ]);

                    $order++;
                }
            }

            DB::commit();
            return response()->json(['success' => true]); // front redirige a edit
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkCode($code)
    {
        $exists = Product::where('code', $code)->exists();
        return response()->json(['exists' => $exists]);
    }
}
