<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id','desc')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Retornar detalle en HTML para el modal
     */
    public function show($id)
    {
        $order = Order::with([
            'items.details', // sabores/contenidos
            'items.extras'   // extras
        ])->findOrFail($id);

        $html = view('orders.partials.detail', compact('order'))->render();
        return response()->json(['html' => $html]);
    }

}
