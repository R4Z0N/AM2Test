<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApartmentUpdateSubscribersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $apartment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($apartment)
    {
        $this->apartment = $apartment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscribers.apartment-changed-price')->with([
                        'apartment' => $this->apartment
                    ]);;
    }
}
