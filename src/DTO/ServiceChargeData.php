<?php

namespace Biztory\Storefront\DTO;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class ServiceChargeData extends Data
{
    public function __construct(
        public string $label,
        #[MapName('tax')]
        public float $tax_rate,
        #[MapName('value')]
        public string $tax_code,
        #[MapName('tax_amt')]
        public float $tax_amount,
        public float $total,
    ) {}
}
