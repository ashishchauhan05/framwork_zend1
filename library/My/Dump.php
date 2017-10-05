<?php

class My_Dump
{
	protected $_storage = array();
	protected $_context = null;
	
	public function __construct($dump = null)
	{
		if ($dump && ! is_scalar($dump)) {
			foreach ($dump as $key => $value) {
				$this->_storage[$key] = $value;
			}
		}
		
		$this->setContext(new My_Dump_Context_Xml());
	}
	
	public function serialize()
	{
		if (!@ $this->_context) {
			throw new My_Dump_Exception('Context does not set up');
		}
		
		return $this->_context->turn($this->_storage);
	}
	
	public function setContext(My_Dump_Context_Interface $context)
	{
		$this->_context = $context;
	}
	
	public function __set($key, $value)
	{
		$this->_storage[$key] = $value;
	}
	
	public function __get($key)
	{
		return @ $this->_storage[$key];
	}
}