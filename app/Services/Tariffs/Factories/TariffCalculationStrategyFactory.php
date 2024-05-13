<?php

namespace App\Services\Tariffs\Factories;

use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\TariffCalculationStrategy;

class TariffCalculationStrategyFactory
{
    /**
     * Creates a tariff calculation strategy based on the given product type.
     *
     * @param int $productType The type of the product for which to create the strategy.
     * @return TariffCalculationStrategy|null The created strategy, or null if the product type is unsupported.
     */
    public function createStrategy(int $productType): ?TariffCalculationStrategy
    {
        return match ($productType) {
            1 => new BasicTariffCalculationStrategy(),
            2 => new PackagedTariffCalculationStrategy(),
            default => null, // Return null for unsupported product types
        };
    }

}
