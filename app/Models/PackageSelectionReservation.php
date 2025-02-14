<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSelectionReservation extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default naming convention
    protected $table = 'package_selection_reservation';
    
    protected $fillable = [
        'personal_details_id',
        'rent_as_whole',
        'room_preference',
        'activities',
        'date',
        'time',
        'special_request',
    ];

    // Define relationships
    public function personalDetails()
    {
        return $this->belongsTo(PersonalDetailsReservation::class, 'personal_details_id');
    }

    public function paymentProcesses()
    {
        return $this->hasMany(PaymentProcess::class, 'reservation_id', 'id');
    }
}