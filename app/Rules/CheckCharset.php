<?php

namespace App\Rules;

use App\Libs\{ConfigUtil, ValueUtil};
use Illuminate\Contracts\Validation\Rule;

/**
 * Check if a string contains only valid characters in the charset of the database.
 */
class CheckCharset implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) {
        return empty($value) || preg_match('/^[\x{0000}-\x{FFFF}]*$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return ConfigUtil::getMessage('ECL049');
    }
}
