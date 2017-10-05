<?php

class AuthController extends My_Controller_Action_Abstract {
 
   protected $users;

    public function init() {
        /* Initialize action controller here */
        $this->_helper->layout->disableLayout();
        $this->users = new Default_Model_Users();
		
    }

    public function indexAction() {
       die('dsfsd');       
 
    }

    public function loginAction() {
        $request = $this->getRequest();
        $auth = Zend_Auth::getInstance();
        $login_type = $request->getPost('login_type', '');
        // dd($request->getPost());
        if ($login_type && $login_type == 'admin') {

            $data = array(
                'email' => $request->getPost('username', ''),
                'password' => $request->getPost('password', '')
            );

            // $data = $this->users->getRowByFilters($requestData, true);

            if ($data['email'] == 'super@admin.com' && $data['password'] == '12345') {
                $data['id'] = 1;
                $data['type'] = 'admin';
                $data['name'] = 'super admin';
                $auth->getStorage()->write($data);
               
                $this->_redirect($this->getBaseURL() . '/admin');
               
            } else {
               $this->view->errors = 'Invalid Username or Password';
            }
        }
 
    }
   public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect($this->getBaseURL() . '/auth/login');
    }
     
    
    
}
