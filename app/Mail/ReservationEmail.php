<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationEmail extends Mailable
{
    use SerializesModels;

    public $subject;
    public $messageContent;
    public $reservationDetails;

    public function __construct($subject, $messageContent, $reservationDetails = null)
    {
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->reservationDetails = $reservationDetails;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.reservation')
                    ->with([
                        'messageContent' => $this->messageContent,
                        'reservationDetails' => $this->reservationDetails
                    ]);
    }
}
