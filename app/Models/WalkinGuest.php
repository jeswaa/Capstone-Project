<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalkinGuest extends Model
{
    use HasFactory;

    protected $table = 'walkin_guests';
    
    protected $fillable = [
        'name',
        'address',
        'mobileNo',
        'reservation_check_in_date',
        'reservation_check_out_date',
        'check_in_time',
        'check_out_time',
        'number_of_adult',
        'number_of_children',
        'total_guests',
        'payment_status',
        'reservation_status',
        'accomodation_id',
        'payment_method',
        'amount'
    ];

    /**
     * Get the accommodation associated with the walk-in guest.
     */
    public function accommodation()
    {
        return $this->belongsTo(Accomodation::class, 'accomodation_id', 'accomodation_id');
    }

    /**
     * Set default values for the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!isset($model->payment_status)) {
                $model->payment_status = 'pending';
            }
            if (!isset($model->reservation_status)) {
                $model->reservation_status = 'pending';
            }
        });
    }
}