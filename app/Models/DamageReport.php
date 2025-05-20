<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'damage_description',
        'damage_cost',
        'status',
        'damage_photos',
        'notes',
        'reported_at'
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'damage_cost' => 'decimal:2'
    ];
}