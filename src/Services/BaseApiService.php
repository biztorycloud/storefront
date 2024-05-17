<?php

namespace Biztory\Storefront\Services;

use App\MultiTenancy\Tenant;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BaseApiService
{
    // private $payload;

    /**
     * create the payload for the order
     */
    // abstract public function createPayload(StoreOrderData $data): Data;

    /**
     * send the payload to the respective service
     */
    public function callApi(string $url, string $method, array $payload, array $headers = []): Response
    {
        // try to call api, else throw exception
        $response = Http::withHeaders([
                ...$headers,
                'x-subdomain' => Tenant::current()->domain,
                'X-Trace-ID' => config('_trace_id'),
                'Authorization' => request()->header('Authorization'),
            ])
            ->$method($url, $payload)
            ->throw();

        return $response;
    }

    /**
     * get api base url
     */
    abstract protected function getApiBaseUrl(): string;
}
