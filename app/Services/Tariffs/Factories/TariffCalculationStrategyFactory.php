<?php

namespace App\Services\Tariffs\Factories;

use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\TariffCalculationStrategy;

class TariffCalculationStrategyFactory
{
    public function createStrategy(int $productType): ?TariffCalculationStrategy
    {
        return match ($productType) {
            1 => new BasicTariffCalculationStrategy(),
            2 => new PackagedTariffCalculationStrategy(),
            default => null, // Return null for unsupported product types
        };
    }

}
