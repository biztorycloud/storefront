<?php

namespace Biztory\Storefront\DTO\Services;

use Biztory\Storefront\Enums\CurrencyCode;
use Faker\Factory;
use Spatie\LaravelData\Data;

class CurrencyData extends Data
{
    public function __construct(
        public CurrencyCode $iso,
        public float $exchange_rate = 1,
        public bool $is_based = false,
    ) {}

    public static function fromString(string $iso): self
    {
        return new self(
            iso: CurrencyCode::from($iso),
        );
    }

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            iso: CurrencyCode::from($faker->currencyCode),
            exchange_rate: $faker->randomFloat(4, 0.5, 2),
            is_based: $faker->boolean,
        );
    }
}
