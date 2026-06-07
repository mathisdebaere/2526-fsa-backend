<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerFoundMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $client,
        public Appointment $appointment,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vrijwilliger gevonden voor uw hulpaanvraag!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.volunteer-found',
        );
    }
}
