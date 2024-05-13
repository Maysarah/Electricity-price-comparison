<?php

namespace Tests\Unit\Services\Tariffs\Strategies;

use App\Models\TariffProduct;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use Tests\TestCase;

class BasicTariffCalculationStrategyTest extends TestCase
{
    /**
     * @dataProvider calculationDataProvider
     */
    public function testCalculateAnnualCost($consumption, $baseCost, $additionalKwhCost, $expectedAnnualCost)
    {
        $strategy = new BasicTariffCalculationStrategy();
        $product = new TariffProduct([
            'base_cost' => $baseCost, // per month
            'additional_kwh_cost' => $additionalKwhCost, // in percentage
        ]);

        $annualCost = $strategy->calculateAnnualCost($consumption, $product);

        $this->assertEquals($expectedAnnualCost, $annualCost);
    }

    public static function calculationDataProvider(): array
    {
        return [
            [2000, 5, 30, (5 * 12) + (2000 * (30 / 100))], // Test case 1
            [3000, 8, 25, (8 * 12) + (3000 * (25 / 100))], // Test case 2
            // Add more test cases as needed
        ];
    }
}
