<?php

class My_Log_Writer_Firebug extends Zend_Log_Writer_Firebug
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setFormatter(new My_Log_Formatter_Firebug());
		
		$this->setPriorityStyle(My_Log::DB_ERROR, Zend_Wildfire_Plugin_FirePhp::LOG);
	}
}