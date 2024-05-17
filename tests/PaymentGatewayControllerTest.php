<?php

// generate test for PaymentGatewayController
it('can get enabled gateways', function () {
    $response = $this->get('/api/third-party-ms/storefront/gateways');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            '*' => [
                'id',
                'name',
                'description',
                'enabled',
            ],
        ],
    ]);
});

it('can get a gateway', function () {
    $response = $this->get('/api/third-party-ms/storefront/gateways/1');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'id',
            'name',
            'description',
            'enabled',
        ],
    ]);
});

it('can update a gateway', function () {
    $response = $this->post('/api/third-party-ms/storefront/gateways/1', [
        'enabled' => false,
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'id',
            'name',
            'description',
            'enabled',
        ],
    ]);
});

it('can callback a gateway', function () {
    $response = $this->post('/api/third-party-ms/storefront/gateways/1/callback');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'id',
            'ref_num',
            'payment_date',
            'payment_method' => [
                'id',
                'name',
            ],
            'description',
            'amount',
        ],
    ]);
});
