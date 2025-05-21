<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;

    protected $table = 'accomodations';

    protected $primaryKey = 'accomodation_id';

    protected $fillable = [
        'accomodation_id',
        'accomodation_image',
        'accomodation_name',
        'accomodation_type',
        'accomodation_capacity',
        'accomodation_price',
    ];

    
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'accomodation_id');
    }

}
