<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;

    protected $table = 'accomodations';

    protected $fillable = [
        'accomodation_id',
        'accomodation_image',
        'accomodation_name',
        'accomodation_type',
        'accomodation_capacity',
        'accomodation_price',
    ];
}
