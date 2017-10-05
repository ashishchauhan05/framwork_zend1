<?php

class Default_View_Helper_GetBaseUrl extends Zend_Controller_Action_Helper_Abstract {

    public function getBaseUrl() {

        $host = $_SERVER['HTTP_HOST'];
        $proto = (empty($_SERVER['HTTPS'])) ? 'http' : 'https';

        $settingConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'setting.ini');
        if ($settingConfig->base_folder) {
            $host .= '/' . $settingConfig->base_folder;
        }

        return $proto . '://' . $host;
    }

}
