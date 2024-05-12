<?php

namespace App\Services\Tariffs\Strategies;

class PackagedTariffCalculationStrategy implements TariffCalculationStrategy
{
    public function calculateAnnualCost($consumption, $product): float|int
    {
        if ($consumption <= $product->included_kwh) {
            // If consumption is within the included kWh, return the base cost
            return $product->base_cost;
        } else {
            // If consumption exceeds the included kWh, calculate additional consumption cost
            $additionalConsumption = $consumption - $product->included_kwh;
            $additionalCost = $additionalConsumption * ($product->additional_kwh_cost / 100); // Convert cent to euro
            // Return the total annual cost, which is the base cost plus the additional consumption cost
            return $product->base_cost + $additionalCost;
        }
    }
}
