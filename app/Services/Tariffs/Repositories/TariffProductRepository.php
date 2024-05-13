<?php

namespace App\Services\Tariffs\Repositories;

use App\Models\TariffProduct;
use Illuminate\Database\Eloquent\Collection;

class TariffProductRepository
{
    /**
     * Retrieves all tariff products from the database.
     *
     * @return Collection A collection of all tariff products.
     */
    public function getAll(): Collection
    {
        return TariffProduct::all();
    }

}
