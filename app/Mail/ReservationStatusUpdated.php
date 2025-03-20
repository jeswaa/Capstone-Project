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
    public $reservationDetails;
    public $balance; // Add balance property

    public function __construct($reservation, $customMessage)
    {
        $this->reservation = $reservation;
        $this->customMessage = $customMessage;
        $this->reservationDetails = $reservation; // Make sure this contains reservation details

         // Convert amount to float
        $amount = floatval(preg_replace('/[^\d.]/', '', $reservation->amount)); // Remove ₱ and commas
        $paymentStatus = strtolower($reservation->payment_status); // Convert to lowercase for safety

        // Compute balance: 15% downpayment deducted from total
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
                        'balance' => $this->balance, // Pass balance to the view
                    ]);
    }
}
