<?php

namespace Biztory\Storefront\DTO;

use Biztory\Storefront\Enums\PaymentTermUnitGroup;
use Biztory\Storefront\Enums\PaymentTermUnitText;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

class PaymentTermData extends Data
{
    public function __construct(
        #[Min(0), Max(100)]
        public int $percent,
        #[MapInputName('due_unit.text')]
        public PaymentTermUnitText $due_unit_label,
        #[MapInputName('due_unit.group')]
        public PaymentTermUnitGroup $due_unit_group,
        #[Min(0)]
        public ?int $due_num,
    ) {
    }
}
