<?php 
class My_Plugin_Logger extends Zend_Controller_Plugin_Abstract {
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {
    	return;
    	if ('eml' != $request->getModuleName()) {
			return;
        }
	
        $logger = new My_Log();
    	$writers = array();
    	$config = Zend_Registry::getInstance()->get('config');
    	$dbConfig = Zend_Registry::get('config_global')->get('resources')->get('db')->get('params')->toArray();
    	
    	$writersParamsAssociations = array(
    		'db' => $dbConfig
    	);
    	
    	$writers = $config->logger->writer->toArray();
		if (! @ $writers[0]) {
			$writers = array($writers);
    	}
    	
    	foreach ($writers as $writer) {
    		try {
    			$writerReflection = new ReflectionClass($writer['name']);
    			if (@ $writer['params'] && is_array($writer['params'])) {
    				$writersParamsAssociations = array_merge($writersParamsAssociations, $writer['params']);
    			}
				if (! $writerReflection->isInstantiable()) {
					throw new ReflectionException('Writer class is not instantiable');
				}
				/* @var $writerConstructor ReflectionMethod */
				$writerConstructor = $writerReflection->getConstructor();
				$writerConstructorParams = array();
				
				foreach ($writerConstructor->getParameters() as $parameter) {
					/* @var $parameter ReflectionParameter */
					$value = @ $writersParamsAssociations[$parameter->name];
					if (! $value) {
						continue;
					}
					$writerConstructorParams[$parameter->name] = $value;
				}
				$writerInstance = $writerReflection->newInstanceArgs($writerConstructorParams);
    			/* @var $writerInstance Zend_Log_Writer_Abstract */
    			
    			$logger->addWriter($writerInstance);
    			
    			$filters = $writer['filters'];
    			if (is_scalar($filters)) {
    				$filters = array($filters);
    			}
    			foreach ($filters as $filterClass) {
    				if (! $filterClass) {
    					continue;
    				}
    				$filterReflection = new ReflectionClass($filterClass);
    				$filterInstance = $filterReflection->newInstance();
					$writerInstance->addFilter($filterInstance);
    			}
    		} catch(ReflectionException $exception) {
    			// doing nothing for now
    		} catch(Zend_Log_Exception $exception) {
    			// doing nothing for now
    		}
    	}
    	
    	Zend_Registry::getInstance()->set('logger', $logger);

    }
}
