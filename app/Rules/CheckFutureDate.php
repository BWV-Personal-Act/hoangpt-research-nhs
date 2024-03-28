<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckFutureDate implements Rule
{
    private $label;

    /**
     * Create a new rule instance.
     *
     * @param string $label
     * @param int $min
     * @return void
     */
    public function __construct($label) {
        $this->label = $label;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $inputDate = formatDate('Y-m-d', $value);
        $nowDate = Carbon::now()->format('Y-m-d');

        return empty($value) || ($inputDate >= $nowDate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('ECL027', [$this->label]);
    }
}
