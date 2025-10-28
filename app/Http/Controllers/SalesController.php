<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Orderhistory;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $orders = Orderhistory::with(['details', 'discountcode'])
            ->orderBy('id', 'desc')
            ->get();

        return view('sales.index', compact('orders'));
    }    
}
