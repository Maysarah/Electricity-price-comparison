<?php

namespace Tests\Unit\Services\Tariffs\Strategies;

use App\Models\TariffProduct;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use Tests\TestCase;

class PackagedTariffCalculationStrategyTest extends TestCase
{
    /**
     * @dataProvider calculateAnnualCostDataProvider
     */
    public function testCalculateAnnualCost($consumption, $baseCost, $includedKwh, $additionalKwhCost, $expectedResult)
    {
        // Arrange
        $strategy = new PackagedTariffCalculationStrategy();
        $product = new TariffProduct([
            'base_cost' => $baseCost, // per year
            'included_kwh' => $includedKwh, // included kWh
            'additional_kwh_cost' => $additionalKwhCost, // in percentage
        ]);

        // Act
        $annualCost = $strategy->calculateAnnualCost($consumption, $product);

        // Assert
        $this->assertEquals($expectedResult, $annualCost);
    }

    public static function calculateAnnualCostDataProvider()
    {
        return [
            // Test case 1: consumption within the included kWh
           "consumption within the included kwh" => [800, 10, 1000, 25, 10], // Expected annual cost is the base cost

            // Test case 2: consumption exceeding the included kWh
           "consumption exceeding the included kwh" => [1500, 10, 1000, 25, 10 + (500 * 0.25)] // Expected annual cost is the base cost plus additional consumption cost
        ];
    }
}
