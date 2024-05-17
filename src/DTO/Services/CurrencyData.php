<?php

namespace Biztory\Storefront\DTO\Services;

use Biztory\Storefront\Enums\CurrencyCode;
use Spatie\LaravelData\Data;

class CurrencyData extends Data
{
    public function __construct(
        public CurrencyCode $iso,
        public float $exchange_rate = 1,
        public bool $is_based = false,
    ) {
    }

    public static function fromString(string $iso): self
    {
        return new self(
            iso: CurrencyCode::from($iso),
        );
    }
}
