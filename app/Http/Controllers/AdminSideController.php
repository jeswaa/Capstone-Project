<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSideController extends Controller
{
    public function dashboard(){
        return view('AdminSide.dashboard');
    }
}
