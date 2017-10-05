<?php

class My_Log_Writer_Db extends Zend_Log_Writer_Abstract 
{
	/**
	 * Database adapter instance
	 * @var Zend_Db_Adapter_Pdo_Mysql
	 */
	protected $_db;

	/**
	 * Name of the log table in the database
	 * @var string
	 */
	protected $_table;

	/**
	 * Relates database columns names to log data field keys
	 * @var null|array
	 */
	protected $_columnMap;
	
	/**
	 * An associative array with data describing 
	 * the event that is passed to the writers
	 * @var array
	 */
	protected $_event;

	/**
	 * Class constructor
	 *
	 * @param Zend_Db_Adapter $db   Database adapter instance
	 * @param string $table         Log table in database
	 * @param array $columnMap
	 */
	public function __construct($db, $table, $columnMap = null)
	{
		if ($db === null) {
			throw new Zend_Log_Exception('Database adapter is null');
		}
		
		$this->_db    = $db;
		$this->_table = $table;
		$this->_columnMap = $columnMap;
	}

	/**
	 * Formatting is not possible on this writer
	 */
	public function setFormatter(Zend_Log_Formatter_Interface $formatter)
	{
		throw new Zend_Log_Exception(sprintf('%s does not support formatting', get_class()));
	}

	/**
	 * Remove reference to database adapter
	 *
	 * @return void
	 */
	public function shutdown()
	{
		$this->_db = null;
	}

	/**
	 * Log a message to this writer.
	 *
	 * @param  array     $event  log data event
	 * @return void
	 */
	public function write($event)
	{
		$this->_event = $event;
		
		try {
			$this->_filtering();
			$this->_prepare();
	        $this->_write($event);
		} catch(Zend_Log_Exception $exception) {
			// doing nothing for now
		}
	}

	protected function _prepare()
	{
		switch ($this->_event['priority']) {
			case My_Log::DB_ERROR:
				if (! ($this->_event['message'] instanceof Exception)) {
					break;
				}
				$this->_event['databaseMessage'] = $this->_event['message']->getMessage();
				$this->_event['message'] = 'An error occurred while attempting to make database operation';				
				break;
			
			default:
				break;
		}
	}
	
	protected function _filtering()
	{
		foreach ($this->_filters as $filter) {
			/* @var $filter Zend_Log_Filter_Interface */
            if (! $filter->accept($this->_event)) {
                throw new Zend_Log_Exception(sprintf('Filter %s doesn\'t accept current event', get_class($filter)));
            }
        }
	}

	/**
	 * Write a message to the log.
	 * 
	 * @return void
	 */
	protected function _write($event)
	{
		if ($this->_columnMap === null) {
			$dataToInsert = $this->_event;
		} else {
			$dataToInsert = array();
			foreach ($this->_columnMap as $columnName => $fieldKey) {
				$dataToInsert[$columnName] = $this->_event[$fieldKey];
			}
		}

		$this->_db->insert($this->_table, $dataToInsert);
	}

	static public function factory($config) {
		
	}
}
