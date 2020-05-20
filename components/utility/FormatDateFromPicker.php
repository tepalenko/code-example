<?php

namespace app\components\utility;

use Yii;

class FormatDateFromPicker
{
    /**
     * Format date from kartik\date\DatePicker to database format
     *
     * @param string $date
     * @return string
     */
    public static function dbFormat($date)
    {
        $time = strtotime($date);
        return date('Y-m-d H:i:s', $time);
    }

    /**
     * Format date from database format to kartik\date\DatePicker
     *
     * @param string $date
     * @return string
     */
    public static function datePickerFormat($date)
    {
        $time = strtotime($date);
        return date('d-M-Y', $time);
    }
}
