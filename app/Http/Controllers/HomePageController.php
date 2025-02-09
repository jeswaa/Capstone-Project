<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        return view('Frontend.homepage'); // Ensure 'homepage' matches your blade file name
    }
}
