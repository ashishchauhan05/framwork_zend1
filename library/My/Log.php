<?php

/**
 * Class implements general error logging method
 * 
 */
class My_Log extends Zend_Log 
{
	const DB_ERROR = 8;
	
	/**
	 * General error logging method
	 * 
	 * @param string $code
	 * @param string|Exception $message
	 */
	public static function logger($code, $message, $databaseMessage = null)
	{
		$registry = Zend_Registry::getInstance();
		if (! $registry->isRegistered('logger')) {
			throw new Zend_Log_Exception('Logger doesn\'t registered');
		}
		/* @var $logger My_Log */
		$logger = $registry->get('logger');
		$priority = $logger->getPriority($code);
		
		$clientId = 0;
		$userId = 0;
		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
		if (@ $authNamespace->storage) {
			$clientId = $authNamespace->storage['client_id'];
			$userId = $authNamespace->storage['id'];
		}
		
		$extras = array(
			'clientId' => $clientId,
			'userId' => $userId,
			'databaseMessage' => '',
			'dump' => $logger->_dump(($message instanceof Exception) ? $message : null)
		);
		foreach ($extras as $name => $value) {
			$logger->setEventItem($name, $value);
		}
		
		$logger->log($message, $priority);
	}
	
	/**
	 * Dump necessary data
	 * 
	 * @param Exception|null $exception
	 * @return string
	 */
	protected function _dump($exception = null)
	{
		$frontController = Zend_Controller_Front::getInstance();
		$dump = new My_Dump();
		$dump->zend = array(
			'request' => $frontController->getRequest(),
			'response' => $frontController->getResponse()
		);
		if ($exception) {
			$dump->exception = $exception;
		}
		$dump->config = Zend_Registry::getInstance()->get('config_global')->toArray();
		$dump->session = $_SESSION;
		$dump->server = $_SERVER;
		
		return gzcompress($dump->serialize(), 9);
	}
	
	/**
	 * Overriden method log for one purpose -
	 * setup default value for $priority variable
	 * 
	 * @see Library/Zend/Zend_Log#log($message, $priority)
	 */
	public function log($message, $priority = self::DB_ERROR, $msg = NULL)
	{
		if ($priority === null) {
			$priority = self::DB_ERROR;
		}
		//parent::log($message, $priority);
	}
	
	/**
	 * getPriority takes name (string) of priority
	 * and returns her system value in Zend_Log
	 * 
	 * @param string $name
	 * @return integer
	 */
	public function getPriority($name)
	{
		if (! in_array($name, $this->_priorities)) {
			return null;
		}
		$priority = array_search($name, $this->_priorities);
		// array_search may return Boolean FALSE, but may
		// also return a non-Boolean value which evaluates
		// to FALSE, such as 0 or "".
		return $priority ? $priority : null;
	}
}