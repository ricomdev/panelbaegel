<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    public function index(){
        $discounts = Discount::orderBy('id')->get();
        return view('discount.index')->with(compact('discounts'));
    }

    public function show($codigo){
        return view('discount.show')->with(compact('codigo'));
    }

    public function datadiscount($codigo){
        $discount = Discount::where('codigo',$codigo)->get();
        return $discount;
    }

    public function create(){
        return view('discount.create');
    }

    public function creatediscount(Request $request)
    {
        $discount = new Discount;

        $discount->codigo = $request->codigo;
        $discount->discount = $request->discount;
        $discount->onlyuser_id = $request->onlyuser;

        if($discount->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function updatediscount(Request $request)
    {
        $discount_id = Discount::where('codigo',$request->codigo_antiguo)->first()->id;

        $discount = Discount::find($discount_id);
        $discount->codigo = $request->codigo;
        $discount->discount = $request->discount;
        $discount->onlyuser_id = $request->onlyuser;

        if($discount->save()){
            return '1';
        }else{
            return '2';
        }

    }

    public function deletediscount($codigo)
    {
        $discount_id = Discount::where('codigo',$codigo)->first()->id;

        $discount = Discount::find($discount_id);
        if($discount->delete()) {
            return '1';
        }else{
            return '2';
        }

    }

    public function checkcodediscount($codigo){

        try {
            $discount = Discount::where('codigo', $codigo)->firstOrFail()->id;
            return '1';
        }
        catch(ModelNotFoundException $e) {
            return '2';
        }

    }
}
