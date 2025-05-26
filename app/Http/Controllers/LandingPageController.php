<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LandingPageController extends Controller
{
    public function index()
    {
        $accommodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        return view('FrontEnd.landingpage', compact('accommodations', 'activities')); // Ensure the filename is lowercase
    }
    public function homepage()
    {
        $accommodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        $transactions = DB::table('transaction')
            ->get();
        
        return view('FrontEnd.homepage', compact('accommodations', 'activities', 'transactions'));
    }
}