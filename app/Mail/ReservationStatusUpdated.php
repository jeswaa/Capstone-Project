<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $customMessage;

    public function __construct($reservation, $customMessage)
    {
        $this->reservation = $reservation;
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        return $this->subject('Your Reservation is Confirmed has been Updated')
                    ->view('StaffSide.reservation_status_updated');
    }
}
