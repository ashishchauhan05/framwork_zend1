<?php

class Default_Model_SiteNotificationRow extends My_Db_Table_Row_Abstract 
{

}

class Default_Model_SiteNotification extends My_Db_Table_Abstract
{
		
	protected $_name     = 'site_notifications';
	protected $_primary  = array('id');
	protected $_rowClass = 'Default_Model_SiteNotificationRow';
	
	protected $_dependentTables = array();
	protected $_referenceMap    = array();
	
	protected $_filters    = array();
	protected $_validators = array(
	);
}