<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admintbl'; // your custom admin table
    protected $fillable = ['username', 'role', 'password']; // customize as needed
}
