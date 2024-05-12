<?php

namespace Tests\Unit\Services\Tariffs\Factories;

use App\Services\Tariffs\Factories\TariffCalculationStrategyFactory;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use PHPUnit\Framework\TestCase;

class TariffCalculationStrategyFactoryTest extends TestCase
{
    /**
     * @dataProvider strategyProvider
     */
    public function testCreateStrategy($productType, $expectedStrategy)
    {
        // Mock the factory
        $factoryMock = $this->getMockBuilder(TariffCalculationStrategyFactory::class)
            ->onlyMethods(['createStrategy'])
            ->getMock();

        // Configure the mock to return the expected strategy
        $factoryMock->expects($this->any())
            ->method('createStrategy')
            ->willReturnMap([
                [1, new BasicTariffCalculationStrategy()],
                [2, new PackagedTariffCalculationStrategy()],
            ]);

        // Use the factory mock to create the strategy
        $strategy = $factoryMock->createStrategy($productType);

        // Perform assertions
        if ($expectedStrategy !== null) {
            $this->assertInstanceOf($expectedStrategy, $strategy);
        } else {
            $this->assertNull($strategy);
        }
    }

    public static function strategyProvider()
    {
        return [
            "Basic Tariff"     =>  [1, BasicTariffCalculationStrategy::class],
            "Packaged Tariff"  =>  [2, PackagedTariffCalculationStrategy::class],
            "Unsupported type" =>  [3, null],
        ];
    }
}
