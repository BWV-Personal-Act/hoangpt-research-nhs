<?php

use App\Libs\{ConfigUtil, EncryptUtil, ValueUtil};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

if (! function_exists('getConstToValue')) {
    /**
     * Get value from constant
     *
     * @param string $key
     * @return int|string|null
     */
    function getConstToValue($key) {
        return ValueUtil::constToValue($key);
    }
}

if (! function_exists('getConstToText')) {
    /**
     * Get text from const (in Yml config file)
     *
     * @param $key
     * @return int|string|null
     */
    function getConstToText($key) {
        return ValueUtil::constToText($key);
    }
}

if (! function_exists('getList')) {
    /**
     * Get value for select/checkbox/radio option from key
     *
     * @param string $key
     * @return array|string|null
     */
    function getList($key) {
        return ValueUtil::getList($key);
    }
}

if (! function_exists('getMessage')) {
    /**
     * Get message from key
     *
     * @param string $messId
     * @param array $options
     * @param mixed $paramArray
     * @return mixed|string|null
     */
    function getMessage($messId, $paramArray = []) {
        return ConfigUtil::getMessage($messId, $paramArray);
    }
}

if (! function_exists('getValueToText')) {
    /**
     * Convert from value into text in view
     *
     * @param string|int $value property value Ex: 1
     * @param string $listKey list defined in yml Ex: web.type
     * @return string|null text if exists else blank
     */
    function getValueToText($value, $listKey) {
        return ValueUtil::valueToText($value, $listKey);
    }
}

if (! function_exists('encryptUrlBase64')) {
    /**
     * Encrypt string use urlencode and base64
     *
     * @param string $str
     * @return string
     */
    function encryptUrlBase64($str) {
        return EncryptUtil::encryptUrlBase64($str);
    }
}

if (! function_exists('decryptUrlBase64')) {
    /**
     * Decrypt string use urlencode and base64
     *
     * @param string $str
     * @return string
     */
    function decryptUrlBase64($str) {
        return EncryptUtil::decryptUrlBase64($str);
    }
}

if (! function_exists('decryptAes256')) {
    /**
     * Decrypt string use AES256
     *
     * @param string $str
     * @return string
     */
    function decryptAes256($str) {
        return EncryptUtil::decryptAes256($str);
    }
}

if (! function_exists('formatDate')) {
    /**
     * Format date
     *
     * @param string $format
     * @param string $time
     * @param string $timezone
     * @param mixed|null $tz
     * @return string|null
     */
    function formatDate($format, $time, $tz = null) {
        try {
            if (! empty($time)) {
                return Carbon::parse($time, $tz)->format($format);
            }
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}

if (! function_exists('arrToAttr')) {
    /**
     * Convert an associative array to HTML attributes string
     *
     * @param array $arr
     * @return string
     */
    function arrToAttr($arr) {
        return implode(' ', array_map(function ($name) use ($arr) {
            return "{$name}=\"{$arr[$name]}\"";
        }, array_keys($arr)));
    }
}

if (! function_exists('removeDecimalTrailingZeros')) {
    /**
     * Remove decimal trailing zeros
     *
     * @param float $number
     * @param int $decimal
     */
    function removeDecimalTrailingZeros($number) {
        return ValueUtil::removeDecimalTrailingZeros($number);
    }
}

if (! function_exists('joinCodeWithValue')) {
    /**
     * join the code with value
     *
     * @param string $nameConfig
     * @param string|int $code
     * @param string $charConnect
     */
    function joinCodeWithValue($code, $nameConfig, $charConnect = ':') {
        return getValueToText($code, $nameConfig) ? $code . $charConnect . getValueToText($code, $nameConfig) : '';
    }
}

if (! function_exists('stringToArray')) {
    /**
     * Convert string to array
     *
     * @param string $string
     * @return array
     */
    function stringToArray($string) {
        return ValueUtil::stringToArray($string);
    }
}

if (! function_exists('getListByCodesWithValue')) {
    /**
     * Get a list of values for select/checkbox/radio options based on a nameConfig,
     * applying the joinCodeWithValue transformation.
     *
     * @param string $nameConfig
     * @param string $charConnect
     */
    function getListByCodesWithValue($nameConfig, $charConnect = ':') {
        $optionsWithCodes = getList($nameConfig);
        foreach ($optionsWithCodes as $key => &$value) {
            $value = joinCodeWithValue($key, $nameConfig, $charConnect);
        }

        return $optionsWithCodes;
    }
}
