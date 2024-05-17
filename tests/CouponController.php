<?php

// generate test for CouponController
it('can get coupon', function () {
    $response = $this->get('/api/third-party-ms/storefront/coupons');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'code',
        'message',
        'data' => [
            'id',
            'code',
            'discount',
            'type',
            'expired_at',
        ],
    ]);
});
