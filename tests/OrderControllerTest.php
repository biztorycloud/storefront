<?php

use Biztory\Storefront\DTO\StoreOrderData;

it('can accept payload and turn into dto', function () {
    $payload = json_decode(file_get_contents(__DIR__ . '/sample/order1.json'), true);
    $response = StoreOrderData::validateAndCreate($payload);
    expect($response)->toBeInstanceOf(StoreOrderData::class);
});