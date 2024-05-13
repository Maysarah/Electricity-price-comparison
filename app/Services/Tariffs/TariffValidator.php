<?php

namespace App\Services\Tariffs;
use Illuminate\Support\Facades\Validator;

class TariffValidator
{
    /**
     * Validates the given data array.
     *
     * @param array $data The data to be validated.
     * @return array|null An array of validation errors if validation fails, otherwise null.
     */
    public function validate(array $data): ?array
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
