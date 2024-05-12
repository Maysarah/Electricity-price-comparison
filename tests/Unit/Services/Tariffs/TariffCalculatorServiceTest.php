<?php

namespace Tests\Unit\Services\Tariffs;

use App\Models\TariffProduct;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;
use App\Services\Tariffs\TariffCalculatorService;
use App\Services\Tariffs\Factories\TariffCalculationStrategyFactory;
use App\Services\Tariffs\Repositories\TariffProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class TariffCalculatorServiceTest extends TestCase
{
    /**
     * @dataProvider consumptionDataProvider
     */
    public function testCompareTariffs($consumption)
    {
        // Mock TariffProductRepository
        $tariffProducts = new Collection([
            new TariffProduct(['name' => 'Product A', 'type' => 1]),
            new TariffProduct(['name' => 'Product B', 'type' => 2]),
        ]);
        $tariffProductRepository = $this->createMock(TariffProductRepository::class);
        $tariffProductRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($tariffProducts);

        // Mock TariffCalculationStrategyFactory
        $strategyFactory = $this->createMock(TariffCalculationStrategyFactory::class);
        $strategyFactory->expects($this->exactly(2))
            ->method('createStrategy')
            ->willReturnMap([
                [1, $this->createMock(BasicTariffCalculationStrategy::class)],
                [2, $this->createMock(PackagedTariffCalculationStrategy::class)],
            ]);

        // Create an instance of TariffCalculatorService
        $calculatorService = new TariffCalculatorService($strategyFactory, $tariffProductRepository);

        // Call the method
        $actualResults = $calculatorService->compareTariffs($consumption);

        // Assert that the actual results is an array
        $this->assertIsArray($actualResults);

        // Assert the structure of each result
        foreach ($actualResults as $result) {
            $this->assertArrayHasKey('name', $result);
            $this->assertArrayHasKey('annual_cost', $result);
            $this->assertArrayHasKey('status', $result);
        }
    }

    public static function consumptionDataProvider()
    {
        return [
            'positive consumption' => [2000],
            'negative consumption' => [-2000],
        ];
    }
}
