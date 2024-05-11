<?php

namespace Http\Controllers;

use App\Http\Controllers\TariffController;
use App\Models\TariffProduct;
use App\Repositories\TariffProductRepository;
use App\Services\TariffCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class TariffControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCompareTariffsValidConsumption()
    {
        // Arrange
        $tariffProducts = new \Illuminate\Database\Eloquent\Collection([
            new TariffProduct(['name' => 'Product A', 'annual_cost' => 800]),
            new TariffProduct(['name' => 'Product B', 'annual_cost' => 900]),
        ]);

        $repository = $this->createMock(TariffProductRepository::class);
        $repository->expects($this->once())->method('getAll')->willReturn($tariffProducts);

        // Mocking the tariff calculator
        $calculator = $this->createMock(TariffCalculator::class);
        $calculator->expects($this->exactly(2))->method('compareTariffs')->willReturn(['mocked' => 'result']);

        // Create an instance of the controller
        $controller = new TariffController($calculator, $repository);

        // Act
        $request = new Request(['consumption' => 1000]);
        $response = $controller->compareTariffs($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        // Add more assertions as needed
    }
}
