<?php

namespace Biztory\Storefront\Listeners;

use Biztory\Storefront\Events\OrderPlaced;

class StorefrontSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            OrderPlaced::class,
            NotificationEmailForOrderPlaced::class,
        );

        $events->listen(
            OrderPlaced::class,
            ClearCartAfterPlacedOrder::class,
        );
    }
}
