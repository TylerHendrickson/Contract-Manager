<?php
require_once 'timezone.php';
/*
 * Here are some utility functions
 */

/*
 * This function gets a string of the time that can set our database.
 */
function getTimeForDB($time=null){
	$dtime = getTime($time);
	return $dtime->format(DateTime::ATOM);
}

/*
 * This function gets a time object with a selected timezone.
 */
function getTime($time=null){
	return new DateTime($time, new DateTimeZone(TIMEZONE));
}
