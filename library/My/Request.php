<?php

class My_Request extends Zend_Controller_Request_Http 
{  
	public function getPost($key = null, $default = null)
    {
        if (null === $key) {
            return $_POST;
        }
		
		if(isset($_POST[$key]) && is_object($_POST[$key]) ) {
			return $_POST[$key];
		} elseif(isset($_POST[$key]) && is_array($_POST[$key])) {
			$returnArray = $_POST[$key];
            $this->findInArray($returnArray);    
			return $returnArray;
                        
		} elseif(isset($_POST[$key]) && trim($_POST[$key])!="") {
			return call_user_func('htmlentities', trim($_POST[$key]));
		} 
		
		return $default;
        
    }
    
	 public function findInArray(&$array) {    
        $keys = array_keys($array);
        foreach($keys as $key)
        {            
            if (is_array($array[$key])) {
                $this->findInArray($array[$key]);
            } else {                                            
                if(is_object($array[$key]) && $array[$key]) {
        			$array[$key] = $array[$key];
        		} elseif($array[$key] && trim($array[$key])!="") {
        			$array[$key] = htmlspecialchars(trim($array[$key]));
        		}                             
			}
        }
       return false;
    }
}