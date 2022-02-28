<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApartmentUpdateSubscribersMail;

class SendEmailApartmentSubscribers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $subscribers = $event->apartment->subscribers()->where('price', '>', $event->apartment->price)->get();
        foreach($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new ApartmentUpdateSubscribersMail($event->apartment));
        }
    }
}
