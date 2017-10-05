<?php

class My_Format_Date {
	
	protected static $_viewFormats = array(
		'datetime' => array(
			'format' => 'm/d/Y h:i a',
			'regexp' => '/^\d{2}\/\d{2}\/\d{4}\s\d{2}:\d{2}\s(am|pm)$/i'
		),
		'date' => array(
			'format' => 'm/d/Y',
			'regexp' => '/^\d{2}\/\d{2}\/\d{4}$/'
		),
		'time' => array(
			'format' => 'h:i a',
			'regexp' => '/^\d{2}:\d{2}\s(am|pm)$/i'
		),
	);

	protected static $_dbFormats = array(
		'datetime' => array(
			'format' => 'Y-m-d H:i:s',
			'regexp' => '/^\d{4}\-\d{2}\-\d{2}\s\d{2}:\d{2}:\d{2}$/'
		),
		'date' => array(
			'format' => 'Y-m-d',
			'regexp' => '/^\d{4}\-\d{2}\-\d{2}$/'
		),
		'time' => array(
			'format' => 'H:i:s',
			'regexp' => '/^\d{2}:\d{2}:\d{2}$/'
		)
	);

	public static function format($date = null, $formatType = null, $formatGroup = null) {
		if (is_null($date) && $formatType && $formatGroup) {
			if ($formatGroup == 'db') {
				$date = date(self::$_viewFormats[$formatType]['format']);
			} else {
				$date = date(self::$_dbFormats[$formatType]['format']);
			}
		}
		
		if (empty($date)) {
			return null;
		}

		$dateFormat  = null;

		foreach (self::$_viewFormats as $formatName => $format) {
			if (preg_match($format['regexp'], $date)) {
				exit;
				if ($formatType) {
					$formatName = $formatType;
				}
				
				$dateFormat = self::$_dbFormats[$formatName]['format'];
				
				break;
			}
		}
		
		foreach (self::$_dbFormats as $formatName => $format) {
			if (preg_match($format['regexp'], $date)) {
				if ($formatType) {
					$formatName = $formatType;
				}

				$dateFormat  = self::$_viewFormats[$formatName]['format'];
				
				break;
			}
		}
		
		if ($dateFormat) {
			return date($dateFormat, strtotime($date));
		} else {
			return null;
		}
	}
}