<?php

namespace App\Providers;

use App\Classes\Strategies\BasicTariffCalculationStrategy;
use App\Classes\Strategies\PackagedTariffCalculationStrategy;
use App\Interfaces\Strategies\TariffCalculationStrategy;
use App\Models\TariffProduct;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
