<?php

namespace Biztory\Storefront\Http\Controllers;

use Biztory\Storefront\Contracts\StoreRepositoryInterface;
use Biztory\Storefront\DTO\StoreSettingsData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    public function __construct(private StoreRepositoryInterface $repository)
    {
    }

    public function get(Request $request): StoreSettingsData
    {
        return $this->repository->getSettings();
    }

    public function set(Request $request): StoreSettingsData
    {
        $this->repository->setSettings(StoreSettingsData::validateAndCreate($request->all()));

        return $this->repository->getSettings();
    }
}
