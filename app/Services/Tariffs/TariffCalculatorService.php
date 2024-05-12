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

    public function compareTariffs($consumption): array
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


    private function sortResults(array $results): array
    {
        $nullCostEntries = [];
        $nonNullCostEntries = [];

        // Separate entries with null annual_cost and non-null annual_cost
        foreach ($results as $entry) {
            if (array_key_exists('annual_cost', $entry)) {
                if ($entry['annual_cost'] === null) {
                    $nullCostEntries[] = $entry;
                } else {
                    $nonNullCostEntries[] = $entry;
                }
            } else {
                // If 'annual_cost' key doesn't exist, move it to the end
                $nullCostEntries[] = $entry;
            }
        }

        // Sort entries with non-null annual_cost based on 'annual_cost'
        usort($nonNullCostEntries, function ($a, $b) {
            return $a['annual_cost'] <=> $b['annual_cost'];
        });

        // Merge arrays (null entries followed by sorted non-null entries)
        return array_merge($nonNullCostEntries, $nullCostEntries);
    }


}
