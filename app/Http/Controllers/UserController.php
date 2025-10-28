<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::whereNotIn('id', [1,2])
            ->orderBy('apellido','asc')
            ->get();
        //return $users;
        return view('user.index')->with(compact('users'));
    }
}
