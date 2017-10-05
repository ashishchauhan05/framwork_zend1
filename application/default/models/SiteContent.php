<?php

class Default_Model_SiteContentRow extends My_Db_Table_Row_Abstract
{

}

class Default_Model_SiteContent extends My_Db_Table_Abstract
{
	protected $_name     = 'site_contents';
	protected $_primary  = 'id';
	protected $_rowClass = 'Default_Model_SiteContentRow';
	
	protected $_dependentTables = array();
	protected $_referenceMap    = array();
	
	protected $_filters    = array();
	protected $_validators = array();
}