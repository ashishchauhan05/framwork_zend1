<?php

class ErrorController extends My_Controller_Action_Abstract
{

    public function errorAction() {
        $errors = $this->getRequest()->getParam('error_handler');
        $this->view->error  = $errors;
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                $this->getResponse()->setHttpResponseCode(404);
                $this->view->code = 404;
                break;
            default:
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->code = 500;
                
                $exception = $errors->exception;
                $logType = 'CRIT';
                if ($exception instanceof Zend_Db_Statement_Exception
                	|| $exception instanceof Zend_Db_Table_Row_Exception) {
                	$logType = 'DB_ERROR';
                }
                My_Log::logger($logType, $exception);
                $this->view->logType = $logType;
                break;
        }
    }
}

