<?php

namespace App\Http\Controllers;

use App\Repositories\TariffProductRepository;
use App\Services\TariffCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TariffController extends Controller
{
    private TariffCalculator $calculator;
    private TariffProductRepository $productRepository;

    public function __construct(
        TariffCalculator $calculator,
        TariffProductRepository $productRepository
    ) {
        $this->calculator = $calculator;
        $this->productRepository = $productRepository;
    }

    public function compareTariffs(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'consumption' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $consumption = $request->input('consumption');
        $tariffProducts = $this->productRepository->getAll();
        $results = [];

        foreach ($tariffProducts as $product) {
            $result = $this->calculator->compareTariffs($consumption, $product);
            $results[] = $result;
        }

        $results = $this->sortResults($results);

        return response()->json($results);
    }

    private function sortResults(array $results): array
    {
        usort($results, function ($a, $b) {
            // Check if 'annual_cost' key exists in both $a and $b
            $aHasCost = array_key_exists('annual_cost', $a);
            $bHasCost = array_key_exists('annual_cost', $b);

            // Handle the case where 'annual_cost' key is not present in $a
            if (!$aHasCost && $bHasCost) {
                return 1; // Move $a to the end
            } elseif ($aHasCost && !$bHasCost) {
                return -1; // Move $b to the end
            } elseif ($aHasCost && $bHasCost) {
                // Both have 'annual_cost' key, sort based on 'annual_cost'
                return $a['annual_cost'] <=> $b['annual_cost'];
            } else {
                // Both do not have 'annual_cost' key, maintain the order
                return 0;
            }
        });

        return $results;
    }
}
