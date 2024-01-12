<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\I18n\Exceptions;

/**
 * I18nException
 */
class I18nException
{
    /**
     * Thrown when createFromFormat fails to receive a valid
     * DateTime back from DateTime::createFromFormat.
     *
     * @return string
     */
    public static function forInvalidFormat(string $format)
    {
        return $format . ' is not a valid datetime format';
    }

    /**
     * Thrown when the numeric representation of the month falls
     * outside the range of allowed months.
     *
     * @return string
     */
    public static function forInvalidMonth(string $month)
    {
        return 'Months must be between 1 and 12. Given: ' . $month;
    }

    /**
     * Thrown when the supplied day falls outside the range
     * of allowed days.
     *
     * @return string
     */
    public static function forInvalidDay(string $day)
    {
        return 'Days must be between 1 and 31. Given: ' . $day;
    }

    /**
     * Thrown when the day provided falls outside the allowed
     * last day for the given month.
     *
     * @return string
     */
    public static function forInvalidOverDay(string $lastDay, string $day)
    {
        return "Days must be between 1 and $lastDay. Given: $day";
    }

    /**
     * Thrown when the supplied hour falls outside the
     * range of allowed hours.
     *
     * @return string
     */
    public static function forInvalidHour(string $hour)
    {
        return 'Hours must be between 0 and 23. Given: ' . $hour;
    }

    /**
     * Thrown when the supplied minutes falls outside the
     * range of allowed minutes.
     *
     * @return string
     */
    public static function forInvalidMinutes(string $minutes)
    {
        return 'Minutes must be between 0 and 59. Given: ' . $minutes;
    }

    /**
     * Thrown when the supplied seconds falls outside the
     * range of allowed seconds.
     *
     * @return string
     */
    public static function forInvalidSeconds(string $seconds)
    {
        return 'Seconds must be between 0 and 59. Given: ' . $seconds;
    }
}
