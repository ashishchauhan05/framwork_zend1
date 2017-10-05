<?php

class My_Log_Filter_Errors implements Zend_Log_Filter_Interface
{
	public function accept($event)
	{
		$priority = $event['priority'];
		return $priority == My_Log::DB_ERROR 
			|| $priority == My_Log::ERR
			|| $priority == My_Log::CRIT
			|| $priority == My_Log::WARN;
	}
}