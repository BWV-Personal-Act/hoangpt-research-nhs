<?php

namespace App\Libs;

class ValueUtil
{
    /**
     * Get value list from yml config file
     *
     * @param string $keys
     * @param array $options
     * @return array|string|null
     */
    public static function get($keys, $options = []) {
        return ConfigUtil::getValueList($keys, $options);
    }

    /**
     * Get value list contain japanese and english
     *
     * @param string $keys
     * @param array $options
     * @return array|null
     */
    public static function getList($keys, $options = []) {
        $options['getList'] = true;

        return ConfigUtil::getValueList($keys, $options);
    }

    /**
     * Convert from value into text in view
     *
     * @param string|int $value property value Ex: 1
     * @param string $listKey list defined in yml Ex: web.type
     * @return string|null text if exists else blank
     */
    public static function valueToText($value, $listKey) {
        // check params
        if (! isset($value) || ! isset($listKey)) {
            return null;
        }
        // get list options
        $list = ValueUtil::get($listKey);
        if (empty($list)) {
            $list = ValueUtil::getList($listKey);
        }
        if (is_array($list) && isset($list[$value])) {
            return $list[$value];
        }
        // can't get value
        return null;
    }

    /**
     * Get value from const (in Yml config file)
     *
     * @param string $keys
     * @return int|string|null
     */
    public static function constToValue($keys) {
        return ConfigUtil::getValue($keys);
    }

    /**
     * Get text from const (in Yml config file)
     *
     * @param string $keys
     * @return int|string|null
     */
    public static function constToText($keys) {
        return ConfigUtil::getValue($keys, true);
    }

    /**
     * Get value from test i
     *
     * @param string $searchText
     * @param string $keys
     * @return int|string|null
     */
    public static function textToValue($searchText, $keys) {
        $valueList = ValueUtil::get($keys);
        foreach ($valueList as $key => $text) {
            if ($searchText == $text) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Remove decimal trailing zeros
     *
     * @param string $number
     * @return string
     */
    public static function removeDecimalTrailingZeros($number) {
        if (empty($number)) {
            return $number;
        }
        $integerPath = number_format($number);
        $decimalPath = explode('.', $number);
        $decimalPath = isset($decimalPath[1]) ? $decimalPath[1] : '';
        $decimalPath = rtrim($decimalPath, '0');
        $decimalPath = ! empty($decimalPath) ? '.' . $decimalPath : '';

        return $integerPath . $decimalPath;
    }

    /**
     * Get season name by season_code
     *
     * @param string $seasonCode
     * @param mixed $isIncludeSessionCode
     * @return string
     */
    public static function getSeasonNameFromSeasonCode($seasonCode, $isIncludeSessionCode = false) {
        $lstSeasonCode = getList('mst_item_detail.season_code');
        $arrSeasonCode = str_split($seasonCode);
        // renew array season_code with key start 1
        $renewArrSeasonCode = array_combine(range(1, count($arrSeasonCode)), array_values($arrSeasonCode)) ?? [];
        $keyLast = array_key_last($lstSeasonCode);
        $isAllSeason = isset($renewArrSeasonCode[$keyLast]) && ($renewArrSeasonCode[$keyLast] == 1);
        $seasonName = $isAllSeason
            ? $lstSeasonCode[$keyLast]
            : implode('/', array_filter($lstSeasonCode, function ($key) use ($renewArrSeasonCode) {
                return isset($renewArrSeasonCode[$key]) && ($renewArrSeasonCode[$key]) == 1;
            }, ARRAY_FILTER_USE_KEY));

        return $isIncludeSessionCode
                ? ($isAllSeason ? '00001' : substr($seasonCode, 0, 5)) . ' - ' . $seasonName
                : $seasonName;
    }

    /**
     * Convert string to array
     *
     * @param string $string
     * @return array
     */
    public static function stringToArray($string) {
        if (empty($string)) {
            return [];
        }
        $replaceSearch = ['[', ']', ' ', '"', "'"];
        $string = str_replace($replaceSearch, '', $string);

        return explode(',', $string);
    }
}
