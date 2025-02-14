<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SignUpUser;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('Frontend.signuppage');
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'mobileNo' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8',
        ]);

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('images'), $imageName);

        $user = User::create([
            'name' => $request->name,
            'address' => $request->address,
            'mobileNo' => $request->mobileNo,
            'email' => $request->email,
            'image' => $imageName,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            // Check if user is being passed to the authenticated
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                return redirect()->route('login')->with('AccountCreatedsuccess', 'Successfully Created a Acount and Logged In');
            } else {
                return back()->with('error', 'Failed to sign up.');
            }
        }
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

    
}
