<?php
//namespace Knp\Snappy;

class Admin_UsersController extends My_Controller_Action_Abstract {
  
    public function init() {
       /* Initialize action controller here */
       
    }

    public function indexAction() {

    }

    public function viewAction() {
       $request = $this->getRequest();
       $id = $request->getParam('id','');
         
    }
}
