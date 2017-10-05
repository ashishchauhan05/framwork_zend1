<?php

class AjaxController extends My_Controller_Action_Abstract {
    
  
    public function init() {
        /* Initialize action controller here */
        
    }

    public function indexAction() {

     $request = $this->getRequest();
     dd($request->getPost());
    }
    public function searchAction(){
     

    }
}
