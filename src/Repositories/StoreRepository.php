<?php

namespace Biztory\Storefront\Repositories;

use App\Branch;
use App\PaymentTerm;
use App\User;
use App\Util\Facade\Settings;
use Biztory\Storefront\Contracts\StoreRepositoryInterface;
use Biztory\Storefront\DTO\NotificationSettingsData;
use Biztory\Storefront\DTO\StoreOrderData;
use Biztory\Storefront\DTO\StoreSettingsData;
use Biztory\Storefront\Enums\Document;
use Biztory\Storefront\Events\OrderPlaced;
use Biztory\Storefront\Services\SaleOrderApiService;
use Illuminate\Support\Facades\Cache;

class StoreRepository implements StoreRepositoryInterface
{
    private string $settings_key = 'storefront.settings';

    private int $cache_ttl = 60 * 60 * 24 * 7;

    public function getSettings(): StoreSettingsData
    {
        return Cache::remember(
            $this->settings_key,
            $this->cache_ttl,
            fn () => StoreSettingsData::from(Settings::get($this->settings_key, $this->getDefaults()))
        );
    }

    public function setSettings(StoreSettingsData $settings): void
    {
        // overwrite the values
        $latest = $this->mergeExisting($settings);
        // update into settings table
        Settings::set($this->settings_key, $latest->toArray());
        // update cache
        Cache::put($this->settings_key, $latest, $this->cache_ttl);
    }

    public function placeOrder(StoreOrderData $payload): StoreOrderData
    {
        // call respective services to place order based on selected document type
        $api = match ($payload->type) {
            // TODO:
            // 'invoice' => new InvoiceService(),
            // 'quote' => new QuoteService(),
            Document::SaleOrder => new SaleOrderApiService,
            default => throw new \Exception('Invalid document type'),
        };
        $response = $api->store($payload);

        event(new OrderPlaced($response->toArray()));

        return $response;
    }

    /**
     * Get the default settings
     */
    private function getDefaults(): array
    {
        return StoreSettingsData::empty(
            [
                'name' => Settings::get('company_name'),
                'email' => Settings::get('company_email'),
                'logo' => Settings::get('company_logo'),
                'default_branch_id' => Branch::hq()->id,
                'default_payment_term_id' => PaymentTerm::default()->id,
                'default_author_id' => User::owner()->id,
                'default_source_custom_field' => config('storefront.default_source_custom_field'),
                'default_currency' => config('storefront.default_currency'),
                'default_document' => config('storefront.default_document'),
                'default_document_types' => config('storefront.default_document_types'),
                'enable_guest_checkout' => config('storefront.enable_guest_checkout'),
                'enable_postpaid' => config('storefront.enable_postpaid'),
                'notifications' => NotificationSettingsData::from([]),
            ]
        );
    }

    private function mergeExisting(StoreSettingsData $settings): StoreSettingsData
    {
        $existing = $this->getSettings();

        return StoreSettingsData::from(array_merge($existing->toArray(), $settings->toArray()));
    }
}
