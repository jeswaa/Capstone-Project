<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDetails_Reservation extends Model
{
    use HasFactory;
    protected $table = 'personal_details_reservation';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'mobileNo',
        'address',
        'number_of_guests',
    ];

    // Relationship: A personal detail belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function packageSelectionReservation()
    {
        return $this->hasOne(PackageSelectionReservation::class, 'personal_details_id');
    }
}
