<?php

// generate test for CartController

use Biztory\Storefront\DTO\CartData;
use Illuminate\Support\Facades\Route;
use Biztory\Storefront\Repositories\CartRepository;

// dump(Route::getRoutes());
describe('repository', function () {
    expect(new CartRepository())
        ->get()
        ->toBeInstanceOf(CartData::class);
});

it('can get cart')
    ->json('GET', 'api/Laravel/storefront/cart')
    ->dump()
    ->assertStatus(200)
    ->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'items' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'quantity',
                ],
            ],
            'total',
        ],
    ]);

it('can set cart', function () {
    $response = $this->post('api/Laravel/storefront/cart', [
        'items' => [
            [
                'id' => 1,
                'quantity' => 2,
            ],
            [
                'id' => 2,
                'quantity' => 1,
            ],
        ],
    ]);
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'items' => [
                '*' => [
                    'id',
                    'name',
                    'price',
                    'quantity',
                ],
            ],
            'total',
        ],
    ]);
});
