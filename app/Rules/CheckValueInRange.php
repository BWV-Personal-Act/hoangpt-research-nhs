<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Illuminate\Contracts\Validation\Rule;

class CheckValueInRange implements Rule
{
    private $min;

    private $max;

    /**
     * Create a new rule instance.
     *
     * @param int $min
     * @param int $max
     * @return void
     */
    public function __construct($min, $max) {
        $this->min = $min;
        $this->max = $max;
    }

    public function passes($attribute, $value) {
        return $value === null || $value >= $this->min && $value <= $this->max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('ECL053', [$this->min, $this->max]);
    }
}
