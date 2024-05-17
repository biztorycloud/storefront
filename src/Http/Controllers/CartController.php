<?php

namespace Biztory\Storefront\Http\Controllers;

use Biztory\Storefront\Contracts\CartRepositoryInterface;
use Biztory\Storefront\DTO\CartData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function __construct(protected CartRepositoryInterface $repository)
    {
    }

    public function get(Request $request): CartData
    {
        return $this->repository->get();
    }

    public function set(CartData $payload): CartData
    {
        $this->repository->set($payload);

        return $payload;
    }
}
