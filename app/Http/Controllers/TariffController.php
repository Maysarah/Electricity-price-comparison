<?php

namespace App\Http\Controllers;

use App\Services\Tariffs\TariffCalculatorService;
use App\Services\Tariffs\TariffValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    private TariffCalculatorService $tariffCalculatorService;
    private TariffValidator $tariffValidator;

    public function __construct(
        TariffCalculatorService $tariffCalculatorService,
        TariffValidator $tariffValidator
    ) {
        $this->tariffCalculatorService = $tariffCalculatorService;
        $this->tariffValidator = $tariffValidator;
    }

    /**
     * Compare tariffs based on the provided consumption.
     *
     * @param Request $request The HTTP request containing the consumption data.
     * @return JsonResponse The JSON response containing the comparison results.
     */
    public function compareTariffs(Request $request): JsonResponse
    {
        $validationResult = $this->tariffValidator->validate($request->all());
        if ($validationResult) {
            return response()->json(['error' => $validationResult], 400);
        }

        $consumption = $request->input('consumption');
        $results = $this->tariffCalculatorService->compareTariffs($consumption);

        return response()->json($results);
    }
}

