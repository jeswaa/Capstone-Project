<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'entrance_fee',
        'type',
        'age_range',
        'end_time',
        'start_time',
        'session',
        'created_at',
        'updated_at',
    ];
}
