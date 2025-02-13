<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function homepage()
    {
        return view('Frontend.homepage'); // Ensure 'homepage' matches your blade file name
    }
}
