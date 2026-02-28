<?php

namespace Biztory\Storefront\DTO\Services;

use Faker\Factory;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class ScheduledTransactionData extends Data
{
    public function __construct(
        #[Date]
        public string $date,
        #[Max(9999999)]
        public float $amount,
        public Optional|int $id,
        #[Max(255)]
        public Optional|string $remark,
    ) {}

    public static function fake(): self
    {
        $faker = Factory::create();

        return new self(
            date: $faker->date(),
            amount: $faker->randomFloat(2, 0, 9999999),
            id: new Optional,
            remark: $faker->sentence(5),
        );
    }

    public static function fakeCollection(): DataCollection
    {
        return self::collection(
            array_fill(0, random_int(1, 2), self::fake())
        );
    }
}
