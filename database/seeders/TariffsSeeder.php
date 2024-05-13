<?php

namespace Database\Seeders;

use App\Models\TariffProduct;
use Illuminate\Database\Seeder;

class TariffsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Product A',
                'type' => 1,
                'base_cost' => 5,
                'additional_kwh_cost' => 22,
                'included_kwh' => null,
            ],
            [
                'name' => 'Product B',
                'type' => 2,
                'base_cost' => 800,
                'additional_kwh_cost' => 30,
                'included_kwh' => 4000,
            ],
//            [
//                'name' => 'Product C',
//                'type' => 3,
//                'base_cost' => 800,
//                'additional_kwh_cost' => 30,
//                'included_kwh' => 4500,
//            ],
//            [
//                'name' => 'Product D',
//                'type' => 4,
//                'base_cost' => 800,
//                'additional_kwh_cost' => 30,
//                'included_kwh' => 5000,
//            ]
        ];

        foreach ($data as $tariffData) {
            // Check if the record already exists in the database
            $existingTariff = TariffProduct::where('type', $tariffData['type'])->first();

            // If the record does not exist, insert it into the database
            if (!$existingTariff) {
                TariffProduct::create($tariffData);
            }
        }
    }
}
