<?php

namespace Biztory\Storefront\Services;

use Biztory\Storefront\DTO\Services\SaleOrderData;
use Biztory\Storefront\DTO\Services\SaleOrderItemData;
use Biztory\Storefront\DTO\StoreOrderData;
use Biztory\Storefront\DTO\StoreOrderItemData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Spatie\LaravelData\Lazy;

class SaleOrderApiService extends BaseApiService
{
    public function createPayload(StoreOrderData $data): SaleOrderData
    {
        // create payload for the order
        return SaleOrderData::validateAndCreate([
            // everything except payment_term
            ...$data->except('payment_term', 'discount', 'service_charge')->toArray(),
            // payment_term handling
            'payment_term' => $data->payment_term,
            'sal_type' => $data->doc_type->value,
            // extra handling
            ...(class_basename($data->currency_iso) !== 'Optional' ? [
                'currency' => [
                    'iso' => $data->currency_iso,
                    'exchange_rate' => $data->currency_exchange_rate,
                ]
            ] : []),
            ...($data->discount ? ['discount' => [
                ...$data->discount->toArray(),
                'shown' => true,
            ]] : []),
            ...($data->service_charge ? ['service_charge' => $data->service_charge?->toArray()] : []),
            'items' => $data->items->map(fn (StoreOrderItemData $itm) => SaleOrderItemData::from([
                ...$itm->toArray(),
                'item_id' => $itm->product_id,
                'qty' => $itm->quantity,
                'total_tax' => $itm->tax,
            ]))->toArray(),
        ]);
    }

    // public function callApi(StoreOrderData $data): void
    // {
    //     // try to call api, else throw exception
    //     $response = Http::post($this->getApiBaseUrl(), $payload->toArray());
    // }

    protected function getApiBaseUrl(): string
    {
        // get api base url
        return config('storefront.api_base_url.invoice').'/sale-order';
    }

    public function store(StoreOrderData $data): StoreOrderData
    {
        // send the payload to the respective service
        $payload = $this->createPayload($data);
        // call the api
        $response = $this->callApi($this->getApiBaseUrl(), 'post', $payload->toArray());
        // handle response
        if (!$response->successful()) {
            $response->throw();
        }

        return $this->formatResponse($response);
    }

    private function formatResponse(Response $response): StoreOrderData
    {
        $response_data = $response->json('data');
        // remove unnecessary optional keys
        Arr::forget($response_data, [
            'payment_term',
            'meta',
            'currency',
            'type',
            'shipping_addr',
            'billing_addr',
        ]);
        $items = StoreOrderItemData::collection(
            Arr::map(
                Arr::get($response_data, 'items', []),
                fn ($itm) => [
                    ...$itm,
                    'quantity' => Arr::get($itm, 'qty'),
                ]
            )
        );
        return StoreOrderData::from([
            ...$response_data,
            'items' => Lazy::create(fn () => $items),
            // 'currency_iso' => $currency,
            // 'status' => intval(Arr::get($response_data, 'status', 0)),
            // 'type' => match (Arr::get($response_data, 'type')) {
            //     'invoice' => DocumentType::Invoice,
            //     'quote' => DocumentType::Quote,
            //     'sale_order' => DocumentType::SaleOrder,
            //     default => null,
            // },
        ])->except(
            'payment_term',
            'custom_fields',
            'terms',
            'type',
            'currency_exchange_rate',
            'rounding'
        );
    }
}
