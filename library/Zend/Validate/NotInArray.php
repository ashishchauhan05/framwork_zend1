<?php

class Zend_Validate_NotInArray extends Zend_Validate_InArray {
    const IN_ARRAY = 'inArray';

    protected $_messageTemplates = array(
        self::IN_ARRAY => "'%value%' was found in the haystack"
    );
    
	public function isValid($value)
    {
        $this->_setValue($value);
        if (in_array(strtolower($value), $this->_haystack, $this->_strict)) {
            $this->_error(self::IN_ARRAY);
            return false;
        }
        return true;
    }
}