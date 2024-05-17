<?php

namespace Biztory\Storefront\Listeners;

use Biztory\Storefront\Events\OrderPlaced;
use Biztory\Storefront\Repositories\CartRepository;

class ClearCartAfterPlacedOrder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected CartRepository $cartRepository)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $this->cartRepository->clearCart();
    }
}
