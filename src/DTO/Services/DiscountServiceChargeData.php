<?php

namespace Biztory\Storefront\DTO\Services;

use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class DiscountServiceChargeData extends Data
{
    public function __construct(
        #[In('%', 'MYR')]
        public string $label,
        #[Min(0)]
        public float $tax,
        #[Min(0)]
        public string $value,
        #[Min(0)]
        public float $tax_amt,
        #[Min(0)]
        public float $total,
        public bool $shown = false,
    ) {
    }
}
