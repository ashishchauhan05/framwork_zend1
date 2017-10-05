<?php

abstract class My_Db_Table_Row_Abstract extends Zend_Db_Table_Row_Abstract {
	
	protected function _postInsert() {
		parent::_postInsert();
	
	}
	
	protected function _postUpdate() {
		parent::_postUpdate();
	
	}
	
	protected function _postDelete() {
		parent::_postUpdate();
		
		
	}
}