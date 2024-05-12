<?php

namespace App\Http\Controllers;

use App\Services\Tariffs\TariffCalculatorService;
use App\Services\Tariffs\TariffValidator;
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

    public function compareTariffs(Request $request): \Illuminate\Http\JsonResponse
    {
        $validationErrors = $this->tariffValidator->validate($request->all());
        if ($validationErrors) {
            return response()->json(['error' => $validationErrors], 400);
        }

        $consumption = $request->input('consumption');
        $results = $this->tariffCalculatorService->compareTariffs($consumption);

        return response()->json($results);
    }
}

