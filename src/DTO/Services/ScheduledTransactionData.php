<?php

namespace Biztory\Storefront\DTO\Services;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
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
    ) {
    }
}
