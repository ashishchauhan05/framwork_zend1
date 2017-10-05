<?php
class Default_View_Helper_FormatDateTime extends Zend_View_Helper_Abstract {  
	public function formatDateTime($date = null) {
		return My_Format_Date::format($date, 'datetime', 'view');
	}
}