<?php

namespace Tests\Unit\Services\Tariffs\Repositories;

use App\Models\TariffProduct;
use App\Services\Tariffs\Repositories\TariffProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class TariffProductRepositoryTest extends TestCase
{
    public function testGetAllReturnsCollectionOfTariffProducts()
    {
        // Create some mocked products
        $mockedProducts = new Collection([
            new TariffProduct(['name' => 'Product A', 'annual_cost' => 800]),
            new TariffProduct(['name' => 'Product B', 'annual_cost' => 900]),
        ]);

        // Mock the repository and specify the behavior
        $repositoryMock = Mockery::mock(TariffProductRepository::class);
        $repositoryMock->shouldReceive('getAll')->andReturn($mockedProducts);

        // Call the method under test
        $products = $repositoryMock->getAll();

        // Perform assertions
        $this->assertInstanceOf(Collection::class, $products);
        $this->assertCount(2, $products);
        foreach ($products as $product) {
            $this->assertInstanceOf(TariffProduct::class, $product);
        }
    }
}
