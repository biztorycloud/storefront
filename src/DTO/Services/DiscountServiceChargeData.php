<?php

namespace Biztory\Storefront\DTO\Services;

use Faker\Factory;
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
    ) {}

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            label: $faker->randomElement(['%', 'MYR']),
            tax: $faker->randomFloat(2, 0, 100),
            value: $faker->randomFloat(2, 0, 100),
            tax_amt: $faker->randomFloat(2, 0, 100),
            total: $faker->randomFloat(2, 0, 100),
            shown: $faker->boolean,
        );
    }
}
