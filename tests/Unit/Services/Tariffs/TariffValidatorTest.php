<?php

namespace Tests\Unit\Services\Tariffs;

use App\Services\Tariffs\TariffValidator;
use Tests\TestCase;

class TariffValidatorTest extends TestCase
{
    /**
     * Test validation with positive and negative consumption values.
     *
     * @dataProvider consumptionDataProvider
     */
    public function testValidateConsumption($consumption, $expectedErrors)
    {
        // Create a new instance of TariffValidator
        $validator = new TariffValidator();

        // Validate consumption
        $errors = $validator->validate(['consumption' => $consumption]);

        // Assert that the validation errors match the expected errors
        $this->assertEquals($expectedErrors, $errors);
    }

    /**
     * Data provider for testValidateConsumption method.
     *
     * @return array
     */
    public static function consumptionDataProvider(): array
    {
        // to add consumption for non-integer
        return [
            'positive consumption' => [2000, null],
            'negative consumption' => [-2000, ['consumption' => ['The consumption field must be at least 0.']]],
            'string consumption' => ["Two Thousand", ['consumption' => ['The consumption field must be an integer.']]],
        ];
    }
}
