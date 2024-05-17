<?php

namespace Biztory\Storefront;

use Illuminate\Contracts\Http\Kernel;
use Spatie\LaravelPackageTools\Package;
use App\Http\Middleware\ApiDataResponse;
use Biztory\Storefront\Repositories\CartRepository;
use Biztory\Storefront\Repositories\StoreRepository;
use Biztory\Storefront\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Biztory\Storefront\Contracts\CartRepositoryInterface;
use Biztory\Storefront\Contracts\StoreRepositoryInterface;

class StorefrontServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('storefront')
            ->hasConfigFile()
            ->hasRoute('api');
        // ->hasViews()
        // ->hasMigration('create_storefront_table')
        // ->hasCommand(StorefrontCommand::class)
    }

    public function packageRegistered()
    {
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    public function packageBooted()
    {
        // push middlewares
        // $this->app->make(Kernel::class)->pushMiddleware(DBTransactionMiddleware::class);
        // $this->app->make(Kernel::class)->pushMiddleware(ApiDataResponse::class);
    }
}
