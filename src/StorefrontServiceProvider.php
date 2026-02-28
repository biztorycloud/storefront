<?php

namespace Biztory\Storefront;

use App\Http\Middleware\ApiDataResponse;
use Biztory\Storefront\Contracts\CartRepositoryInterface;
use Biztory\Storefront\Contracts\StoreRepositoryInterface;
use Biztory\Storefront\Repositories\CartRepository;
use Biztory\Storefront\Repositories\StoreRepository;
use Illuminate\Contracts\Http\Kernel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
        // Register any other service providers needed
        $this->app->register(\Spatie\LaravelData\LaravelDataServiceProvider::class);

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
