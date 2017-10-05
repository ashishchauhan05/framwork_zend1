<?php

class My_Dump_Context_Xml implements My_Dump_Context_Interface
{
	protected $_dump = array();
	protected $_dom = null;
	protected $_rootElement = null;
    protected $_encoding = 'UTF-8';
	
	public function __construct()
	{
		$this->_dom = $this->_createDOM();
		$this->_dom->formatOutput = true;
		$this->_rootElement = $this->_dom->appendChild(new DOMElement('dump'));
	}
	
	/**
	 * 
	 * @return DOMDocument
	 */
	private function _createDOM()
	{
		return new DOMDocument('1.0', $this->_encoding);
	}
	
	public function turn(array $dump)
	{
		$this->_dump = $dump;
		
		$this->_serialize();
		
		return $this->_dom->saveXML();
	}
	
	protected function _serialize()
	{
		$this->_rootElement->appendChild($this->_dom->importNode($this->_serializeValue($this->_dump), true));
	}
	
	protected function _serializeValue($value)
	{
		if (is_object($value)) {
			return $this->_serializeObject($value);
		} else if (is_array($value)) {
			return $this->_serializeArray($value);
		} else {
			$dom = $this->_createDOM();
			$rootElement = $dom->appendChild(new DOMElement('scalar'));
			$rootElement->appendChild(new DOMText($value));
			return $dom->documentElement;
		}
	}
	
	protected function _serializeArray(array $array)
	{
		$dom = $this->_createDOM();
		$rootElement = $dom->appendChild(new DOMElement('hash'));
		foreach($array as $key => $value) {
			if (! is_string($key)) {
				continue;
			}
			$keyElement = $rootElement->appendChild(new DOMElement($key));
			$keyElement->appendChild($dom->importNode($this->_serializeValue($value), true));
		}
		return $dom->documentElement;
	}
	
	protected function _serializeObject($object)
	{
		$dom = $this->_createDOM();
		$rootElement = $dom->appendChild(new DOMElement('hash'));
		$objectReflection = new ReflectionObject($object);
		foreach ($objectReflection->getProperties() as $property) {
			/* @var $property ReflectionProperty */
			$name = $property->getName();
			$value = null;
			if ($property->isPublic()) {
				$value = $property->getValue($object);
			} else {
				$name = preg_replace('~^_~', '', $name);
				// lookup getter
				$getterName = sprintf('get%s', ucfirst($name));
				if (! $objectReflection->hasMethod($getterName)) {
					continue;
				}
				$getterReflection = $objectReflection->getMethod($getterName);
				/* @var $getterReflection ReflectionMethod */
				if ($getterReflection->getNumberOfRequiredParameters()
					|| ! $getterReflection->isPublic()) {
					continue;
				}
				$value = $getterReflection->invoke($object);
			}
			$nameElement = $rootElement->appendChild(new DOMElement($name));
			$nameElement->appendChild($dom->importNode($this->_serializeValue($value), true));
		}
		return $dom->documentElement;
	}
}