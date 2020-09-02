<?php
declare(strict_types=1);


namespace FrisbyModule\Frisby;

use DateTime;
use DateTimeZone;
use FrisbyModule\Frisby\TimeHandler;

/**
 * Frisby Framework
 * Time Class
 *
 * This class manages the basic time stuff
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class Time
{

	public const T_MIN = 60;
	public const T_HOUR = 3600;
	public const T_DAY = 86400;
	public const T_WEEK = 604800;
	public const T_MONTH = 2592000;
	public const T_YEAR = 31536000;

	public const T_DEFAULT_TIMEZONE = 'Europe/Istanbul';

	/**
	 * Produces a TimeHandler object
	 *
	 * @param string $string
	 * @param string|null $timezone
	 * @return TimeHandler
	*/
	public static function factory(string $string = 'now', ?string $timezone = null): TimeHandler
	{
		$timezone = $timezone === null ? new DateTimeZone(self::T_DEFAULT_TIMEZONE) : new DateTimeZone($timezone);
		return new TimeHandler(new DateTime($string), $timezone);
	}

	/**
	 * Checks the given string is a date or not.
	 *
	 * @param string|null $date
	 * @return bool
	 */
	public static function isDate(?string $date): bool
	{
		return strtotime($date) > 10000;
	}

	/**
	 * Converts any given date to unix timestamp
	 *
	 * @param null $time
	 * @return int
	 */
	public static function timestamp($time = null): int
	{
		$time = ($time === null) ? time() : (is_numeric($time) ? (int)$time : (int)strtotime($time));
		return $time instanceof DateTime ? (int)$time->format('U') : $time;
	}

	/**
	 * Converts any given string to DateTime object
	 *
	 * @param string $string
	 * @return DateTime
	 */
	public static function strToDateTime(string $string = 'now'): DateTime
	{
		return !self::isDate($string) ? new DateTime() : new DateTime('@' . strtotime($string));
	}
}