<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback; // Import the model (if you have one)

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'feedback' => 'required|string|max:500',
        ]);

        // Save feedback to the database (if using a model)
        Feedback::create([
            'message' => $request->input('feedback'),
        ]);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }
}

