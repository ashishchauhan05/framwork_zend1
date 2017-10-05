<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	function _initConfig() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::set('config_global', $config);
        Zend_Registry::set('env', APPLICATION_ENV);
    }
    
    protected function _initFrontController ( )
    {
        $front = Zend_Controller_Front::getInstance();
        $front->setControllerDirectory( array (
        'default' => APPLICATION_PATH . '/default/controllers',
        'admin' => APPLICATION_PATH . '/admin/controllers'
        ));
        
        return $front;

    }
	protected function _initDB() {
		$dbConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'db.ini');
		$dbAdapter = Zend_Db::factory($dbConfig->adapter, array(
			'host'     => $dbConfig->host,
			'username' => $dbConfig->username,
			'password' => $dbConfig->password,
			'dbname'   => $dbConfig->dbname
		));
		My_Db_Table_Abstract::setDefaultAdapter($dbAdapter);
		
		Zend_Registry::set('db', $dbAdapter);
		
		
		$frontendOptions = array(
			'automatic_serialization' => true,
			'lifetime'                => 3600
		);
		$backendOptions  = array(
        	'cacheDir' => TMP_DIR . DS . 'cache' . DS . 'meta'
		);
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
		if (APPLICATION_ENV == 'development') {
        	$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
			$profiler->setEnabled(true);
			$dbAdapter->setProfiler($profiler);
		}
	}
	
	protected function _initPlugins()
    {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) {
            $bootstrap = $this;
        }
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        $viewPlugin = new My_Plugin_View();
        $loggerPlugin = new My_Plugin_Logger();

		$front->registerPlugin($viewPlugin);
        $front->registerPlugin($loggerPlugin);
        
    }	
	
	protected function _initLogger() {
    	$logger = new My_Log();

    	$writers = array();
    	$writersParamsAssociations = array(
    		'db' => Zend_Registry::getInstance()->get('db')
    	);

		$config = new My_Config_Xml(APPLICATION_PATH . '/configs/logger.xml', null);
    	$writers = $config->writer->toArray();

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

    	Zend_Registry::set('logger', $logger);
    }	
}

