<?php
class Default_View_Helper_MakeUrl extends Zend_Controller_Action_Helper_Abstract {  
	public function makeUrl($url, $module = '') {
		if (!$module) {
			$module = Zend_Controller_Front::getInstance()->getRequest()->getParam('module');
		}
		if($module != 'default') {
			$url =  '/' . $module . $url;
		}
		$settingConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'setting.ini');
		if($settingConfig->base_folder) {
			$url = '/' . $settingConfig->base_folder . $url;
		}
		$host  = $_SERVER['HTTP_HOST'];
		$proto = (empty($_SERVER['HTTPS'])) ? 'http' : 'https';
		
		return $proto . '://' . $host.$url;
	}
}
