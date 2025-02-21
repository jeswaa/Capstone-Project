<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation_details';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobileNo',
        'address',
        'number_of_guests',
        'rent_as_whole',
        'room_preference',
        'activities',
        'reservation_date',
        'reservation_check_out',
        'reservation_check_in',
        'special_request',
        'status',
        'payment_method',
        'payment_status',
        'amount',
        'reference_num',
        'upload_payment',
    ];
}
