<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function showForm()
    {
        // Fetch the admin email from settings table
        $adminEmail = DB::table('settings')->where('key', 'admin_email')->value('value');

        return view('admin.settings', compact('adminEmail'));
    }

    public function updateEmail(Request $request)
    {
        // Validate the new email
        $request->validate([
            'admin_email' => 'required|email',
        ]);

        // Update the admin email in the settings table
        DB::table('settings')
            ->where('key', 'admin_email')
            ->update(['value' => $request->admin_email]);

        return redirect()->route('admin.settings')->with('success', 'Admin email updated successfully!');
    }
}
