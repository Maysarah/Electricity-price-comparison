<?php

namespace App\Services;
use App\Factories\TariffCalculationStrategyFactory;
use App\Models\TariffProduct;

class TariffCalculator
{
    private TariffCalculationStrategyFactory $strategyFactory;

    public function __construct(TariffCalculationStrategyFactory $strategyFactory)
    {
        $this->strategyFactory = $strategyFactory;
    }

    public function compareTariffs($consumption, TariffProduct $product): array
    {
        $strategy = $this->strategyFactory->createStrategy($product->type);

        // Check if the strategy is null
        if ($strategy === null) {
            // Handle the case where the strategy is null (unsupported product type)
            // Return an array indicating that the product is not available
            return ['name' => $product->name, 'annual_cost' => null, 'message' => 'Product not available yet or coming soon'];
        }

        // The strategy is not null, proceed with calculating the annual cost
        $annualCost = $strategy->calculateAnnualCost($consumption, $product);
        return ['name' => $product->name, 'annual_cost' => $annualCost];
    }
}
