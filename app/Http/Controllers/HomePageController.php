<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomePageController extends Controller
{
    public function homepage()
    {
        return view('Frontend.homepage'); // Ensure 'homepage' matches your blade file name
    }
    public function profilepage()
    {
        $user = DB::table('users')->where('id', Auth::id())->first();
        return view('Frontend.profilepage', ['user' => $user]);
    }
}
