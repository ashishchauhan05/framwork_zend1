<?php
class Default_View_Helper_FormatDate extends Zend_View_Helper_Abstract {  
	public function formatDate($date = null) {
		return My_Format_Date::format($date, 'date', 'view');
	}
}