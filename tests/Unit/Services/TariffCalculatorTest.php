<?php

namespace Services;

use App\Factories\TariffCalculationStrategyFactory;
use App\Interfaces\Strategies\TariffCalculationStrategy;
use App\Models\TariffProduct;
use App\Services\TariffCalculator;
use PHPUnit\Framework\TestCase;

class TariffCalculatorTest extends TestCase
{
    /**
     *
     * @dataProvider tariffProvider
     */
    public function testCompareTariffs($consumption, $productData, $expectedName, $expectedAnnualCost)
    {
        // Arrange
        $mockStrategy = $this->createMock(TariffCalculationStrategy::class);
        $mockStrategy->method('calculateAnnualCost')->willReturn($expectedAnnualCost);
        $strategyFactory = $this->createMock(TariffCalculationStrategyFactory::class);
        $strategyFactory->method('createStrategy')->willReturn($mockStrategy);

        $calculator = new TariffCalculator($strategyFactory);

        $product = new TariffProduct($productData);

        // Act
        $result = $calculator->compareTariffs($consumption, $product);

        // Assert
        $this->assertEquals($expectedName, $result['name']);
        $this->assertEquals($expectedAnnualCost, $result['annual_cost']);
        $this->assertArrayNotHasKey('message', $result); // Assert that 'message' key is not present
    }

    public static function tariffProvider(): array
    {
        return [
            // Basic tariff
            [1000, ['name' => 'Product A', 'type' => 1, 'base_cost' => 50], 'Product A', 800],
            // Packaged tariff
            [1500, ['name' => 'Product B', 'type' => 2, 'base_cost' => 80], 'Product B', 1200],
        ];
    }

}
