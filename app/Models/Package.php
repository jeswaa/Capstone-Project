<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packagestbl';

    protected $fillable = [
        'package_name',
        'package_room_type',
        'package_description',
        'package_price',
        'package_duration',
        'package_max_guests',
        'package_activities',
        'image_package',   
    ];
}
