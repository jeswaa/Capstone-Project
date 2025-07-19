<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

class Staff extends User
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'status'
    ];

    protected $table = 'stafftbl';
    protected $guarded = 'staff';
}
