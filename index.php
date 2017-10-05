<?php

function dd($data) {
    echo '<pre>';
    print_r($data);
    exit;
}
ini_set('post_max_size', '132M');
ini_set('upload_max_filesize', '132M');
ini_set('memory_limit', '-1');
// ini_set('max_upload_time', '3600');
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));
    
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
    
define('HOME_DIR', realpath(dirname( __FILE__ )));
define('APP_DIR', HOME_DIR . '/application');
define('TMP_DIR', HOME_DIR . '/tmp');
define('WWW_DIR', 'www');
define('UPLOADS_DIR', 'www/uploads');
define('LIB_DIR', HOME_DIR . '/library');
define('DS', DIRECTORY_SEPARATOR);
 // error_reporting( E_ALL );
    
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';
//require_once 'knp-autoload.php';
require_once 'mpdf/mpdf.php';

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('My_');
//$loader->registerNamespace('Knp\\');
$loader->setFallbackAutoloader(true);

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
