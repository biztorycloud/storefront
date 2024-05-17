<?php

namespace Biztory\Storefront\Listeners;

use App\Sale;
use Illuminate\Queue\InteractsWithQueue;
use Biztory\Storefront\DTO\StoreOrderData;
use Biztory\Storefront\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Biztory\PaymentGateway\Services\EmailService;

class NotificationEmailForOrderPlaced implements ShouldQueue
{
    use InteractsWithQueue;
    
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected EmailService $service)
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
        /** @var array<StoreOrderData> $saleData */
        $saleData = $event->data;
        $sale = Sale::findOrfail($saleData['id']);
        $this->service->emailInvoice($sale, 'emails.saleorder.order', 'Your Order');
    }
}
