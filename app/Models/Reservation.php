<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($reservation) {
            // Check if payment_status is "paid" and reservation_status is "checked_out"
            if ($reservation->isDirty(['payment_status', 'reservation_status'])) {
                if ($reservation->payment_status === 'paid' && $reservation->reservation_status === 'checked_out') {
                    $reservation->delete(); // Soft delete (Archive)
                }
            }
        });
    }

    protected $table = 'reservation_details';

    protected $fillable = [
        'user_id',
        'package_id',
        'name',
        'email',
        'mobileNo',
        'address',
        'number_of_guests',
        'rent_as_whole',
        'room_preference',
        'activities',
        'reservation_date',
        'reservation_check_in_date',
        'reservation_check_out_date',
        'reservation_check_out',
        'reservation_check_in',
        'special_request',
        'status',
        'payment_method',
        'payment_status',
        'amount',
        'reference_num',
        'upload_payment',
        'number_of_adults',
        'number_of_children',
        'total_guest',
        'selected_packages',
    ];
    
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'reservation_id');
    }
}
