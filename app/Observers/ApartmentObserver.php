<?php

namespace App\Observers;

use App\Models\Apartment;
use App\Events\ApartmentUpdated;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApartmentUpdateSubscribersMail;


class ApartmentObserver
{
    /**
     * Handle the Apartment "creating" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function creating(Apartment $apartment)
    {
        $apartment->slug = str()->snake($apartment->name);
    }

    /**
     * Handle the Apartment "created" event.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return void
     */
    public function created(Apartment $apartment)
    {
        //
    }

    /**
     * Handle the Apartment "updated" event.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return void
     */
    public function updated(Apartment $apartment)
    {
        event(new ApartmentUpdated($apartment));
    }

    /**
     * Handle the Apartment "deleted" event.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return void
     */
    public function deleted(Apartment $apartment)
    {
        //
    }

    /**
     * Handle the Apartment "restored" event.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return void
     */
    public function restored(Apartment $apartment)
    {
        //
    }

    /**
     * Handle the Apartment "force deleted" event.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return void
     */
    public function forceDeleted(Apartment $apartment)
    {
        //
    }
}
