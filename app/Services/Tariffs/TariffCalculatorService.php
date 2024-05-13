<?php

namespace App\Services\Tariffs;

use App\Services\Tariffs\Factories\TariffCalculationStrategyFactory;
use App\Services\Tariffs\Repositories\TariffProductRepository;

class TariffCalculatorService
{
    private TariffCalculationStrategyFactory $strategyFactory;
    private TariffProductRepository $productRepository;

    public function __construct(
        TariffCalculationStrategyFactory $strategyFactory,
        TariffProductRepository $productRepository
    ) {
        $this->strategyFactory = $strategyFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Compares tariffs based on the provided consumption and returns the results.
     *
     * @param int $consumption The consumption value for which to compare tariffs.
     * @return array The array of tariff comparison results.
     */
    public function compareTariffs(int $consumption): array
    {
        $tariffProducts = $this->productRepository->getAll();
        $results = [];

        foreach ($tariffProducts as $product) {
            $strategy = $this->strategyFactory->createStrategy($product->type);

            // Check if the strategy is null
            if ($strategy === null) {
                // Handle the case where the strategy is null (unsupported product type)
                // Return an array indicating that the product is not available
                $results[] = ['name' => $product->name, 'annual_cost' => null, 'status' => 'Product not available yet or coming soon'];
            } else {
                // The strategy is not null, proceed with calculating the annual cost
                $annualCost = $strategy->calculateAnnualCost($consumption, $product);
                $results[] = ['name' => $product->name, 'annual_cost' => $annualCost, 'status' => 'available'];
            }
        }
        return $this->sortResults($results);
    }

    /**
     * Sorts the results array with non-null 'annual_cost' entries in ascending order,
     * with null entries placed at the end.
     *
     * @param array $results The array of results to be sorted.
     * @return array The sorted array of results.
     */
    private function sortResults(array $results): array
    {
        // Separate entries with null and non-null annual_cost
        $nullCostEntries = [];
        $nonNullCostEntries = [];

        foreach ($results as $entry) {
            if (isset($entry['annual_cost'])) {
                $nonNullCostEntries[] = $entry;
            } else {
                $nullCostEntries[] = $entry;
            }
        }

        // Sort non-null entries based on 'annual_cost' in ascending order
        usort($nonNullCostEntries, function ($a, $b) {
            return $a['annual_cost'] <=> $b['annual_cost'];
        });

        // Merge sorted non-null entries with null entries
        return array_merge($nonNullCostEntries, $nullCostEntries);
    }



}
