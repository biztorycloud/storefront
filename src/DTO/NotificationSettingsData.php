<?php

namespace Biztory\Storefront\DTO;

use App\Role;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\Data;

class NotificationSettingsData extends Data
{
    /**
     * @param  array<int, App\Role>  $order_created
     * @param  array<int, App\Role>  $payment_received
     */
    public function __construct(
        public ?array $order_created,
        public ?array $payment_received,
    ) {
        $this->order_created = $order_created ?? config('storefront.notifications.order_created');
        $this->payment_received = $payment_received ?? config('storefront.notifications.payment_received');
    }

    public static function rules(): array
    {
        $roles = Cache::tags('roles')->remember('all_roles', 60 * 60, function () {
            return Role::all()->pluck('name')->toArray();
        });

        return [
            'order_created' => ['array'],
            'order_created.*' => ['string', 'in:'.implode(',', $roles)],
            'payment_received' => ['array'],
            'payment_received.*' => ['string', 'in:'.implode(',', $roles)],
        ];
    }
}
