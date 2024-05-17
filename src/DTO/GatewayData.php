<?php

namespace Biztory\Storefront\DTO;

use Biztory\Storefront\Repositories\PaymentGatewayRepository;
use Illuminate\Http\Client\Request;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class GatewayData extends Data
{
    public function __construct(
        #[In(['manual'])]
        public string $id,
        #[Exists('payment_methods')]
        public int $payment_method_id,
        public string $display_name,
        public ?string $description = null,
    ) {
    }

    // when creating from Request
    public static function fromRequest(Request $request, PaymentGatewayRepository $repository): self
    {
        $gateway = $repository->getGateway($request->input('id'));

        return new self(
            id: $gateway['id'],
            payment_method_id: $request->input('payment_method_id') ?? $gateway['payment_method_id'],
            display_name: $request->input('display_name') ?? $gateway['display_name'],
            description: $request->input('description') ?? $gateway['description'],
        );
    }
}
