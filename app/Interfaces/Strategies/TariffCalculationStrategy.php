<?php
namespace App\Interfaces\Strategies;

interface TariffCalculationStrategy
{
    public function calculateAnnualCost($consumption, $product);
}
