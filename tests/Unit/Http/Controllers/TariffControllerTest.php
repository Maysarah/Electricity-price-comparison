<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\TariffController;
use App\Services\Tariffs\TariffCalculatorService;
use App\Services\Tariffs\TariffValidator;
use Illuminate\Http\Request;
use Tests\TestCase;

class TariffControllerTest extends TestCase
{
    /**
     * @dataProvider validConsumptionDataProvider
     */
    public function testCompareTariffsValidConsumption($consumption, $expectedResponse)
    {
        $request = new Request(['consumption' => $consumption]);

        $calculatorMock = $this->createMock(TariffCalculatorService::class);
        $calculatorMock->expects($this->once())
            ->method('compareTariffs')
            ->with($consumption)
            ->willReturn($expectedResponse);

        $validatorMock = $this->createMock(TariffValidator::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->with(['consumption' => $consumption])
            ->willReturn(null);

        $controller = new TariffController($calculatorMock, $validatorMock);

        $response = $controller->compareTariffs($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    /**
     * @dataProvider invalidConsumptionDataProvider
     */
    public function testCompareTariffsInvalidConsumption($consumption, $expectedResponse)
    {
        $request = new Request(['consumption' => $consumption]);

        $calculatorMock = $this->createMock(TariffCalculatorService::class);

        // We don't expect compareTariffs to be called for invalid consumption
        $calculatorMock->expects($this->never())
            ->method('compareTariffs');

        $validatorMock = $this->createMock(TariffValidator::class);
        $validatorMock->expects($this->once())
            ->method('validate')
            ->with(['consumption' => $consumption])
            ->willReturn($expectedResponse); // Validation result for invalid consumption

        $controller = new TariffController($calculatorMock, $validatorMock);

        $response = $controller->compareTariffs($request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(['error' => $expectedResponse], $response->getData(true));
    }

    public static function validConsumptionDataProvider(): array
    {
        return [
            'positive consumption' => [
                3500,
                [
                    ['name' => 'Product B', 'annual_cost' => 800, 'status' => 'available'],
                    ['name' => 'Product A', 'annual_cost' => 830, 'status' => 'available'],
                ],
            ],
            // Add more valid consumption test cases as needed
        ];
    }

    public static function invalidConsumptionDataProvider(): array
    {
        return [
            'negative consumption' => [
                -100,
                ['consumption' => ['The consumption field must be at least 0.']]
            ],
            'string consumption' => [
                "1000", // Cast to integer
                ['consumption' => ['The consumption field must be an integer.']]
            ],
            // Add more invalid consumption test cases as needed
        ];
    }
}
