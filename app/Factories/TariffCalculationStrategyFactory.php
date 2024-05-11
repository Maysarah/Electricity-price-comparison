<?php

namespace App\Factories;

use App\Classes\Strategies\BasicTariffCalculationStrategy;
use App\Classes\Strategies\PackagedTariffCalculationStrategy;
use App\Interfaces\Strategies\TariffCalculationStrategy;

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
