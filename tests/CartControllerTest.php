<?php

// generate test for CartController

use Biztory\Storefront\DTO\CartData;
use Biztory\Storefront\Http\Controllers\CartController;
use Biztory\Storefront\Repositories\CartRepository;

describe('CartController', function () {
    $ctrl = new CartController(new CartRepository);

    it('can get cart', function () use ($ctrl) {
        $response = $ctrl->get(request());
        expect($response)
            ->toBeInstanceOf(CartData::class)
            ->toHaveCount(0);
    });
});

// it('can get cart')
//     ->json('GET', 'api/Laravel/storefront/cart')
//     ->dump()
//     ->assertStatus(200)
//     ->assertJsonStructure([
//         'code',
//         'message',
//         'data' => [
//             'items' => [
//                 '*' => [
//                     'id',
//                     'name',
//                     'price',
//                     'quantity',
//                 ],
//             ],
//             'total',
//         ],
//     ]);

// it('can set cart', function () {
//     $response = $this->post('api/Laravel/storefront/cart', [
//         'items' => [
//             [
//                 'id' => 1,
//                 'quantity' => 2,
//             ],
//             [
//                 'id' => 2,
//                 'quantity' => 1,
//             ],
//         ],
//     ]);
//     $response->assertStatus(200);
//     $response->assertJsonStructure([
//         'code',
//         'message',
//         'data' => [
//             'items' => [
//                 '*' => [
//                     'id',
//                     'name',
//                     'price',
//                     'quantity',
//                 ],
//             ],
//             'total',
//         ],
//     ]);
// });
