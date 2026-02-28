<?php

namespace Biztory\Storefront\Listeners;

use App\Quote;
use App\Sale;
use App\SaleOrder;
use Biztory\PaymentGateway\Services\EmailService;
use Biztory\Storefront\DTO\StoreOrderData;
use Biztory\Storefront\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $order = $event->data;
        $model = match ($order['type']) {
            'Invoice' => Sale::class,
            'SaleOrder' => SaleOrder::class,
            'Quote' => Quote::class,
            default => $order['type'],
        };
        $invoice = $model::findOrfail($order['id']);
        $this->service->emailInvoice($invoice, 'emails.saleorder.order', 'Your Order');
    }
}
