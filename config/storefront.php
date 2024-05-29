<?php

use Biztory\Storefront\Enums\CurrencyCode;
use Biztory\Storefront\Enums\Document;
use Biztory\Storefront\Enums\DocumentType;

// config for Biztory/Storefront
return [
    'enabled_gateways' => [
        // 'paypal' => \Biztory\Storefront\PaymentGateways\PaypalPaymentGateway::class,
        // 'manual_payment' => \Biztory\Storefront\PaymentGateways\ManualPaymentGateway::class,
    ],

    'default_gateway' => 'manual',

    'default_currency' => CurrencyCode::MYR,

    'default_document' => Document::SaleOrder,

    'default_document_types' => [
        Document::SaleOrder->value => DocumentType::Normal->value,
        Document::Invoice->value => DocumentType::Normal->value,
        Document::Quote->value => DocumentType::Normal->value,
    ],

    'enable_guest_checkout' => false,

    'enable_postpaid' => true,

    'default_source_custom_field' => [
        'key' => 'source',
        'value' => 'online',
    ],

    'notifications' => [
        'order_created' => ['Admin'],
        'payment_received' => ['Admin'],
    ],

    'api_base_url' => [
        'default' => env('STOREFRONT_API_BASE_URL', 'https://bzapi.biztoryapp.com'),
        'invoice' => env('STOREFRONT_API_BASE_URL_INVOICE', env('STOREFRONT_API_BASE_URL', 'https://bzapi.biztoryapp.com').'/api/invoice-ms'),
    ],
];
