<?php

namespace App\Libs;

use Carbon\Carbon;

class DateUtil
{
    /**
     * Format date
     * @param string|object $date
     * @param string $format
     * @return string;
     */
    public static function formatDate($date, $format = 'Y/m/d') {
        $result = null;
        if (is_string($date)) {
            $carbon = new Carbon($date);
            $result = $carbon->format($format);
        }

        return $result;
    }

    /**
     * Get full date time
     * @return string
     */
    public static function parseStringFullDateTime() {
        return Carbon::now()->format('YmdHis');
    }

    /**
     * Get timestamp
     *
     * @return string
     */
    public static function getTimestamp() {
        $microtime = floatval(substr((string) microtime(), 1, 8));
        $rounded = round($microtime, 3);
        $milisecond = substr((string) $rounded, 2, strlen($rounded));

        return Carbon::now()->format('YmdHis') . $milisecond;
    }
}
