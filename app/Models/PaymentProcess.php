<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProcess extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming conventions
    protected $table = 'payment_process';
    protected $fillable = [
        'reservation_id',
        'payment_method',
        'mobile_num',
        'amount',
        'upload_payment',
        'reference_num',
    ];

    // Define relationships
    public function reservation()
    {
        return $this->belongsTo(PackageSelectionReservation::class, 'reservation_id', 'id');
    }
}