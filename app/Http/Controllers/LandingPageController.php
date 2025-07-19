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
        $feedbacks = DB::table('feedback')
            ->join('users', 'feedback.user_id', '=', 'users.id')
            ->select('feedback.*', 'users.name as name', 'users.image as image')
            ->orderBy('feedback.created_at', 'desc')
            ->limit(3)
            ->get();
        return view('FrontEnd.landingpage', compact('accommodations', 'activities', 'feedbacks')); // Ensure the filename is lowercase
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