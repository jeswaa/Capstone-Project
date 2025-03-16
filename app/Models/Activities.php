<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;

    protected $table = 'activitiestbl';

    protected $fillable = [
        'activity_name',
        'activity_image',
        'activity_status',
    ];
}
