<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User; // Import the User class

class Admin extends User // Extend User instead of Model
{
    use HasFactory;
    
    protected $guarded = 'admin';
    
    protected $table = 'admintbl'; // your custom admin table
    protected $fillable = ['username', 'role', 'password']; // you can customize as needed
    
    // Add any additional methods or relationships if needed
}
