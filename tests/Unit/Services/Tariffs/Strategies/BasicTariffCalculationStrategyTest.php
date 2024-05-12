<?php

namespace Tests\Unit\Services\Tariffs\Strategies;

use App\Models\TariffProduct;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use Tests\TestCase;

class BasicTariffCalculationStrategyTest extends TestCase
{
    public function testCalculateAnnualCost()
    {
        // Arrange
        $strategy = new BasicTariffCalculationStrategy();
        $consumption = 2000; // kWh
        $product = new TariffProduct([
            'base_cost' => 5, // per month
            'additional_kwh_cost' => 30, // in percentage
        ]);

        // Act
        $annualCost = $strategy->calculateAnnualCost($consumption, $product);

        // Assert
        // Base cost per year = base cost per month * 12
        // Additional consumption cost = consumption * (additional kWh cost / 100)
        // Total annual cost = base cost per year + additional consumption cost
        $expectedAnnualCost = (5 * 12) + ($consumption * (30 / 100));
        $this->assertEquals($expectedAnnualCost, $annualCost);
    }
}
