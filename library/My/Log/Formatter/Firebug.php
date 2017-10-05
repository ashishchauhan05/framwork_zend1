<?php

class My_Log_Formatter_Firebug implements Zend_Log_Formatter_Interface
{
	public function format($event)
	{
		return $event['message'];
	}
}
