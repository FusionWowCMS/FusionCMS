<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CodeIgniter\I18n;

use DateTime;
use IntlCalendar;

/**
 * Class TimeDifference
 *
 * @see \CodeIgniter\I18n\TimeDifferenceTest
 */
class TimeDifference
{
    /**
     * The timestamp of the "current" time.
     *
     * @var IntlCalendar
     */
    protected $currentTime;

    /**
     * The timestamp to compare the current time to.
     *
     * @var float
     */
    protected $testTime;

    /**
     * Eras.
     *
     * @var float
     */
    protected $eras = 0;

    /**
     * Years.
     *
     * @var float
     */
    protected $years = 0;

    /**
     * Months.
     *
     * @var float
     */
    protected $months = 0;

    /**
     * Weeks.
     *
     * @var int
     */
    protected $weeks = 0;

    /**
     * Days.
     *
     * @var int
     */
    protected $days = 0;

    /**
     * Hours.
     *
     * @var int
     */
    protected $hours = 0;

    /**
     * Minutes.
     *
     * @var int
     */
    protected $minutes = 0;

    /**
     * Seconds.
     *
     * @var int
     */
    protected $seconds = 0;

    /**
     * Difference in seconds.
     *
     * @var int
     */
    protected $difference;

    /**
     * Note: both parameters are required to be in the same timezone. No timezone
     * shifting is done internally.
     */
    public function __construct(DateTime $currentTime, DateTime $testTime)
    {
        $this->difference = $currentTime->getTimestamp() - $testTime->getTimestamp();

        $current = IntlCalendar::fromDateTime($currentTime);
        $time    = IntlCalendar::fromDateTime($testTime)->getTime();

        $this->currentTime = $current;
        $this->testTime    = $time;
    }

    /**
     * Returns the number of years of difference between the two.
     *
     * @return float|int
     */
    public function getYears(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / YEAR;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_YEAR);
    }

    /**
     * Returns the number of months difference between the two dates.
     *
     * @return float|int
     */
    public function getMonths(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / MONTH;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_MONTH);
    }

    /**
     * Returns the number of weeks difference between the two dates.
     *
     * @return float|int
     */
    public function getWeeks(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / WEEK;
        }

        $time = clone $this->currentTime;

        return (int) ($time->fieldDifference($this->testTime, IntlCalendar::FIELD_DAY_OF_YEAR) / 7);
    }

    /**
     * Returns the number of days difference between the two dates.
     *
     * @return float|int
     */
    public function getDays(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / DAY;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_DAY_OF_YEAR);
    }

    /**
     * Returns the number of hours difference between the two dates.
     *
     * @return float|int
     */
    public function getHours(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / HOUR;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_HOUR_OF_DAY);
    }

    /**
     * Returns the number of minutes difference between the two dates.
     *
     * @return float|int
     */
    public function getMinutes(bool $raw = false)
    {
        if ($raw) {
            return $this->difference / MINUTE;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_MINUTE);
    }

    /**
     * Returns the number of seconds difference between the two dates.
     *
     * @return int
     */
    public function getSeconds(bool $raw = false)
    {
        if ($raw) {
            return $this->difference;
        }

        $time = clone $this->currentTime;

        return $time->fieldDifference($this->testTime, IntlCalendar::FIELD_SECOND);
    }

    /**
     * Convert the time to human readable format
     */
    public function humanize(?string $locale = null): string
    {
        $current = clone $this->currentTime;
        $CI =& get_instance();
        $CI->lang->load('date');

        $years   = $current->fieldDifference($this->testTime, IntlCalendar::FIELD_YEAR);
        $months  = $current->fieldDifference($this->testTime, IntlCalendar::FIELD_MONTH);
        $days    = $current->fieldDifference($this->testTime, IntlCalendar::FIELD_DAY_OF_YEAR);
        $hours   = $current->fieldDifference($this->testTime, IntlCalendar::FIELD_HOUR_OF_DAY);
        $minutes = $current->fieldDifference($this->testTime, IntlCalendar::FIELD_MINUTE);

        if ($years !== 0) {
            $phrase = $years . ' ' . $CI->lang->line($years > 1 ? 'date_years' : 'date_year');
            $before = $years < 0;
        } elseif ($months !== 0) {
            $phrase = $months . ' ' . $CI->lang->line($months > 1 ? 'date_months' : 'date_month');
            $before = $months < 0;
        } elseif ($days !== 0 && (abs($days) >= 7)) {
            $weeks  = ceil($days / 7);
            $phrase = $weeks . ' ' . $CI->lang->line($weeks > 1 ? 'date_weeks' : 'date_week');
            $before = $days < 0;
        } elseif ($days !== 0) {
            $phrase = $days . ' ' . $CI->lang->line($days > 1 ? 'date_days' : 'date_day');
            $before = $days < 0;
        } elseif ($hours !== 0) {
            $phrase = $hours . ' ' . $CI->lang->line($hours > 1 ? 'date_hours' : 'date_hour');
            $before = $hours < 0;
        } elseif ($minutes !== 0) {
            $phrase = $minutes . ' ' . $CI->lang->line($minutes > 1 ? 'date_minutes' : 'date_minute');
            $before = $minutes < 0;
        } else {
            return 'ago';
        }

        return $before ? $phrase . ' ago' : 'in ' . $phrase;
    }

    /**
     * Allow property-like access to our calculated values.
     *
     * @param string $name
     *
     * @return float|int|null
     */
    public function __get($name)
    {
        $name   = ucfirst(strtolower($name));
        $method = "get{$name}";

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return null;
    }

    /**
     * Allow property-like checking for our calculated values.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        $name   = ucfirst(strtolower($name));
        $method = "get{$name}";

        return method_exists($this, $method);
    }
}
