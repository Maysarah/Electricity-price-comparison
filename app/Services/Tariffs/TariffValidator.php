<?php

namespace App\Services\Tariffs;
use Illuminate\Support\Facades\Validator;

class TariffValidator
{
    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'consumption' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->toArray();
        }

        return null; // Return null if validation passes without errors
    }


}
