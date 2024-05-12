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
     * @dataProvider consumptionDataProvider
     */
    public function testCompareTariffs($consumption, $expectedResponse)
    {
        // Arrange
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

        // Act
        $response = $controller->compareTariffs($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    public static function consumptionDataProvider()
    {
        return [
            'positive consumption'=> [
                3500,
                [
                    ['name' => 'Product B', 'annual_cost' => 800, 'status' => 'available'],
                    ['name' => 'Product A', 'annual_cost' => 830, 'status' => 'available'],
                ]
            ],
            'negative consumption'=> [
                -100, // Negative consumption value
                [
                    'error' => [
                        'consumption' => ['The consumption field must be at least 0.']
                    ]
                ]
            ],
            // Add more test cases with different consumption values and expected responses
        ];
    }
}
