<?php

namespace Tests\Unit\Services\Tariffs\Factories;

use App\Services\Tariffs\Factories\TariffCalculationStrategyFactory;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\TariffCalculationStrategy;
use PHPUnit\Framework\TestCase;

class TariffCalculationStrategyFactoryTest extends TestCase
{
    /**
     * @dataProvider strategyProvider
     */
    public function testCreateStrategy($productType, $expectedStrategy)
    {
        // Arrange
        $factory = new TariffCalculationStrategyFactory();

        // Act
        $strategy = $factory->createStrategy($productType);

        // Assert
        if ($expectedStrategy !== null) {
            $this->assertInstanceOf($expectedStrategy, $strategy);
        } else {
            $this->assertNull($strategy);
        }
    }

    public static function strategyProvider()
    {
        return [
            "Basic Tariff"     =>  [1, BasicTariffCalculationStrategy::class], // Basic Tariff
            "Packaged Tariff"  =>  [2, PackagedTariffCalculationStrategy::class], // Packaged Tariff
            "Unsupported type" =>  [3, null], // Unsupported type
        ];
    }
}
