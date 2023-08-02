<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\ControlMaterial;
use App\Models\pay_receipt;
use App\Models\WDTreasury;
use App\Observers\CRQuantityObserve;
use App\Observers\ObAsset;
use App\Observers\PayObserver;
use App\Observers\WDObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        pay_receipt::observe(PayObserver::class);
        WDTreasury::observe(WDObserver::class);
        Asset::observe(ObAsset::class);
        ControlMaterial::observe(CRQuantityObserve::class);
    }
}
