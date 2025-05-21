<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Activities;
use App\Models\Accomodation;
use Illuminate\Support\Facades\DB;

class ReservationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $customMessage;
    public $reservationDetails;
    public $balance; // Add balance property

    public function __construct($reservation, $customMessage)
    {
        $this->reservation = $reservation;
        $this->customMessage = $customMessage;
        $this->reservationDetails = $reservation;

        // Convert JSON string to array (IDs)
        $accommodationIds = $reservation->accomodation_id ? json_decode($reservation->accomodation_id, true) : [];
        $activityIds = $reservation->activity_id ? json_decode($reservation->activity_id, true) : [];
        // Fetch accommodation names from the database
        $this->accomodations = Accomodation::whereIn('accomodation_id', $accommodationIds)
            ->pluck('accomodation_name')
            ->implode(', ');

        // Fetch activity names from the database
        $this->activities = Activities::whereIn('id', $activityIds)
            ->pluck('activity_name')
            ->implode(', ');
        // Compute balance
        $amount = floatval(preg_replace('/[^\d.]/', '', $reservation->amount));
        $paymentStatus = strtolower($reservation->payment_status);
        $this->balance = ($paymentStatus === 'paid') ? 0 : ($amount - ($amount * 0.15));
    }

    public function build()
    {
        return $this->subject('Your Reservation Status Has Been Updated')
                    ->view('StaffSide.reservation_status_updated')
                    ->with([
                        'reservation' => $this->reservation,
                        'reservationDetails' => $this->reservationDetails,
                        'customMessage' => $this->customMessage,
                        'balance' => $this->balance,
                        'accomodations' => $this->accomodations,
                        'activities' => $this->activities,
                    ]);
    }


}

