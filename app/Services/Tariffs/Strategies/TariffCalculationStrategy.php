<?php
namespace App\Services\Tariffs\Strategies;

interface TariffCalculationStrategy
{
    public function calculateAnnualCost($consumption, $product);
}
