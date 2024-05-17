<?php

namespace Biztory\Storefront\DTO;

use Biztory\Storefront\Enums\DiscountType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class CouponData extends Data
{
    public $discount;

    public function __construct(
        // #[Unique('coupons', 'code')]
        public string $id,
        public string $name,
        public string $description,
        #[Min(0)]
        public float|Lazy $discount_amount,
        public DiscountType|Lazy $discount_type,
    ) {
        $this->discount = [
            'amount' => $this->discount_amount,
            'type' => $this->discount_type,
        ];
        $this->discount_amount = Lazy::create(fn () => $this->discount['amount']);
        $this->discount_type = Lazy::create(fn () => $this->discount['type']);
    }
}
