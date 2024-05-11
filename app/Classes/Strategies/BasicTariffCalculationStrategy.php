<?php

namespace App\Classes\Strategies;

use App\Interfaces\Strategies\TariffCalculationStrategy;

class BasicTariffCalculationStrategy implements TariffCalculationStrategy
{
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
