<?php

Zend_Loader::loadClass('Zend_Config_Xml');

class My_Config_Xml extends Zend_Config_Xml {

    protected function _toArray(SimpleXMLElement $xmlObject)
    {
        $config = array();

        foreach ($xmlObject->children() as $key => $value) {

            if( $value->attributes() ){
              foreach( $value->attributes() as $aKey => $aItem){
                $config[$key]['_attributes'][$aKey] = current($aItem);
              }
            }

            if ( sizeof($value->children()) ) {
                if( $value->attributes() ){
                    $config[$key] = $this->_arrayMergeRecursive($config[$key], $this->_toArray( $value ));
                } else {
                    if( gettype(current($xmlObject->children())) == 'array' ){
                        $config[$key][] = $this->_toArray($value);
                    } else {
                        $config[$key] = $this->_toArray($value );
                    }
                }
            } else {
                if( !empty( $config[$key] ) ){
                    settype($config[$key], 'array');
                    $config[$key][] = (string)current($value);
                } else {
                    $config[$key] = (string)current($value);
                }
            }
        }

        return $config;
    }

}