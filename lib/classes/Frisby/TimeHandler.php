<?php
declare(strict_types=1);

namespace FrisbyModule\Frisby;

use FrisbyModule\Frisby\Time;
use DateTime;
use DateTimeZone;
use stdClass;

/**
 * Frisby Framework
 * TimeHandler Class
 *
 * This class handles date and time objects
 *
 * @author Utku Korkmaz
 * @package FrisbyModule\Frisby
 */
class TimeHandler
{

	public string $timezone;
	public int $timestamp;
	public string $date;
	protected string $format = "Y-m-d H:i:s";

	protected DateTime $dateTime;

	/**
	 * TimeHandler constructor.
	 * @param DateTime $dateTime
	 * @param DateTimeZone $timeZone
	 */
	public function __construct(DateTime $dateTime, DateTimeZone $timeZone)
	{
		$this->dateTime = $dateTime;
		$this->dateTime->setTimezone($timeZone);
		$this->timestamp = Time::timestamp($dateTime->format('U'));
		$this->date = date($this->format, $this->timestamp);
		$this->timezone = $timeZone->getName();
	}

	/**
	 * @return string
	 */
	public function getFormat(): string
	{
		return $this->format;
	}

	/**
	 * @param string $format
	 */
	public function setFormat(string $format): void
	{
		$this->format = $format;
	}

	/**
	 * @return string
	 */
	public function getDate(): string
	{
		return $this->dateTime->format($this->format);
	}


	public function getDateTimeObject(): DateTime
	{
		return $this->dateTime;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->getDate();
	}

}