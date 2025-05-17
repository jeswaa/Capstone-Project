<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LandingPageController extends Controller
{
    public function index()
    {
        return view('FrontEnd.landingpage'); // Ensure the filename is lowercase
    }
    public function homepage()
    {
        $accommodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        return view('FrontEnd.homepage', compact('accommodations', 'activities'));
    }
}