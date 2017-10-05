<?php
//namespace Knp\Snappy;

class Admin_IndexController extends My_Controller_Action_Abstract {


    public function init() {
       /* Initialize action controller here */
        // $this->_helper->layout->setLayout('admin-layout');
      
    }

    public function indexAction() {
       
    }

    public function logoutAction() {

       $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($this->getBaseURL() . '/admin');
    }
    
}
