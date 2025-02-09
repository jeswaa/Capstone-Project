<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSideController extends Controller
{
    public function dashboard(){
        return view('AdminSide.dashboard');
    }

    public function reservations(){
        return view('AdminSide.reservation');
    }

    public function guests(){
        return view('AdminSide.guest');
    }

    public function transactions(){
        return view('AdminSide.transactions');
    }

    public function reports(){
        return view('AdminSide.reports');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
