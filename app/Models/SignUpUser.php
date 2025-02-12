<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SignUpUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'tblsignup'; // Ensure this matches your table name

    protected $fillable = [
        'fullname',
        'address',
        'mobileNo',
        'email',
        'image',
        'password',
        'google_id',
        'email_verified_at',
    ];
}
