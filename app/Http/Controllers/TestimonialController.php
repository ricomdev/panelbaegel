<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(){
        $testimonials = Testimonial::with('user')->orderBy('created_at','desc')->get();
        return view('testimonial.index')->with(compact('testimonials'));
    }

//    public function datatestimonial(){
//        $testimonials = Testimonial::with('user')->get();
//        return $testimonials;
//    }

    public function updatetestimonial(Request $request)
    {
        $testimonial = Testimonial::find($request->id);

        $testimonial->show = $request->show;

        if($testimonial->save()){
            return '1';
        }else{
            return '2';
        }

    }

}
