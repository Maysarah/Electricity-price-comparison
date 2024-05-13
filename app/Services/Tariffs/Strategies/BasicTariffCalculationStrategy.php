<?php

namespace App\Services\Tariffs\Strategies;

use JetBrains\PhpStorm\NoReturn;

class BasicTariffCalculationStrategy implements TariffCalculationStrategy
{
    /**
     * Calculates the annual cost for a given consumption and product.
     *
     * @param int $consumption The consumption value in kWh.
     * @param mixed $product The product for which to calculate the annual cost.
     * @return float|int The calculated annual cost.
     */
   public function calculateAnnualCost($consumption, $product): float|int
    {
        // Convert the base cost from per month to per year
        $baseCostPerYear = $product->base_cost * 12;

        // Calculate the consumption cost based on the consumption in kWh
        $consumptionCost = $consumption * ($product->additional_kwh_cost / 100); // Convert cent to euro

        // Calculate the total annual cost
        return $baseCostPerYear + $consumptionCost;
    }
}
