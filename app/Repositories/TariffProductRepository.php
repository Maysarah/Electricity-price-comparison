<?php

namespace App\Repositories;

use App\Models\TariffProduct;

class TariffProductRepository
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return TariffProduct::all();
    }

}
