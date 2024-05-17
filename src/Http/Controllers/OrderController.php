<?php

namespace Biztory\Storefront\Http\Controllers;

use Biztory\Storefront\Contracts\StoreRepositoryInterface;
use Biztory\Storefront\DTO\StoreOrderData;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct(protected StoreRepositoryInterface $repository)
    {
    }

    public function store(StoreOrderData $payload): StoreOrderData
    {
        return $this->repository->placeOrder($payload);
    }
}
