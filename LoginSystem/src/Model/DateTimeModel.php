<?php

namespace Model;    

class DateAndTimeModel {

    private static $TIME_ZONE = "Europe/Stockholm";

    private $date;
    private $day;
    private $month;
	private $time;
	
	public function show() {

		date_default_timezone_set(self::$TIME_ZONE);
		

		$timeString =  $this->getDay()  . ", the " . $this->getDate()  .  " of " . $this->getMonth() . $this->getYear() .
		", The time is " . $this->getTime() ;

		return '<p>' . $timeString . '</p>';
	}

    public function getDay() {
		$this->day = date('l');

		return $this->day;
	}
	public function getDate() {
		$this->date = date("jS");

		return $this->date;
	}

	public function getMonth () {
		$this->month = date("F ");

		return $this->month;
	}

	public function getYear() {
		$this->year = date("Y");

		return $this->year;
	}

	public function getTime () {
		$this->time = date("H:i:s");

		return $this->time;
	}
}