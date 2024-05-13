<?php
namespace Tests\Unit\Services\Tariffs;
use Tests\TestCase;
use App\Services\Tariffs\TariffCalculatorService;
use App\Services\Tariffs\Factories\TariffCalculationStrategyFactory;
use App\Services\Tariffs\Repositories\TariffProductRepository;
use App\Models\TariffProduct;
use App\Services\Tariffs\Strategies\BasicTariffCalculationStrategy;
use App\Services\Tariffs\Strategies\PackagedTariffCalculationStrategy;

class TariffCalculatorServiceTest extends TestCase
{
    /**
     * @dataProvider consumptionAndExpectedResultsProvider
     */
    public function testCompareTariffs($consumption, $expectedResults)
    {
        // Mock dependencies
        $strategyFactory = $this->createMock(TariffCalculationStrategyFactory::class);
        $productRepository = $this->createMock(TariffProductRepository::class);

        // Create mock products
        $products = [
            new TariffProduct(['name' => 'Product A', 'type' => 1, "base_cost" => 5, "additional_kwh_cost" => 22]),
            new TariffProduct(['name' => 'Product B', 'type' => 2, "included_kwh" => 4000, "base_cost"=> 800, "additional_kwh_cost"=> 30]),
            // Add more mock products as needed
        ];

        // Configure product repository mock
        $productRepository->expects($this->once())
            ->method('getAll')
            ->willReturn(new \Illuminate\Database\Eloquent\Collection($products));


        // Configure strategy factory mock
        $strategyFactory->method('createStrategy')
            ->willReturnCallback(function ($type) {
                // Return the appropriate strategy based on product type
                if ($type === 1) {
                    return new BasicTariffCalculationStrategy();
                } elseif ($type === 2) {
                    return new PackagedTariffCalculationStrategy();
                } else {
                    return null; // Mock unsupported type
                }
            });

        // Instantiate service
        $service = new TariffCalculatorService($strategyFactory, $productRepository);

        // Call the method under test
        $actualResults = $service->compareTariffs($consumption);

        // Assert the results
        $this->assertEquals($expectedResults, $actualResults);
    }

    public static function consumptionAndExpectedResultsProvider(): array
    {
        return [
            // Test case 1: Consumption: 3500, Expected Results: Products sorted by annual_cost
            [3500, [
                [
                    'name' => 'Product B',
                    'annual_cost' => 800,
                    'status' => 'available'
                ],
                [
                    'name' => 'Product A',
                    'annual_cost' => 830,
                    'status' => 'available'
                ]
            ]],
            // Test case 2: Consumption: 4000, Expected Results: Products sorted by annual_cost
            [4000, [
                [
                    'name' => 'Product B',
                    'annual_cost' => 800,
                    'status' => 'available'
                ],
                [
                    'name' => 'Product A',
                    'annual_cost' => 940,
                    'status' => 'available'
                ]
            ]],
            // Test case 3: Consumption: 5000, Expected Results: Products sorted by annual_cost
            [5000, [
                [
                    'name' => 'Product B',
                    'annual_cost' => 1100,
                    'status' => 'available'
                ],
                [
                    'name' => 'Product A',
                    'annual_cost' => 1160,
                    'status' => 'available'
                ]
            ]],
            // Add more test cases as needed
        ];
    }
}
