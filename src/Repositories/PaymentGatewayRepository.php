<?php

namespace Biztory\Storefront\Repositories;

class PaymentGatewayRepository
{
    protected $enabledGateways = [];

    public function __construct(array $enabledGateways)
    {
        foreach ($enabledGateways as $gatewayId => $gatewayClass) {
            if (class_exists($gatewayClass)) {
                $this->enabledGateways[$gatewayId] = app($gatewayClass);
            }
        }
    }

    public function getEnabledGateways(): array
    {
        $gateways = [];
        foreach ($this->enabledGateways as $gateway) {
            $gateways[] = $gateway->toArray();
        }

        return $gateways;
    }

    /**
     * Retrieves the payment gateway configuration by ID.
     *
     * @param  int  $id  The ID of the payment gateway.
     * @return array|null The payment gateway configuration if found, null otherwise.
     */
    public function getGateway($id): ?array
    {
        if (isset($this->enabledGateways[$id])) {
            return $this->enabledGateways[$id];
        }

        return null;
    }

    /**
     * Updates the payment gateway configuration by ID.
     *
     * @param  int  $id  The ID of the payment gateway.
     * @param  array  $data  The new configuration data.
     * @return array|null The updated payment gateway configuration if found, null otherwise.
     */
    public function updateGateway($id, array $data): ?array
    {
        if (isset($this->enabledGateways[$id])) {
            $this->enabledGateways[$id]->update($data);

            return $this->enabledGateways[$id];
        }

        return null;
    }
}
