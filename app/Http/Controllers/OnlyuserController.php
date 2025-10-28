<?php

namespace App\Http\Controllers;

use App\Models\Onlyuser;
use Illuminate\Http\Request;

class OnlyuserController extends Controller
{
    public function data(){
        $onlyuser= Onlyuser::all();
        return $onlyuser;
    }
}
