<?php

class UserController extends My_Controller_Action_Abstract {

    protected $user;

    public function init() {
     $this->user = new Default_Model_Users();
    }

    public function indexAction() {

       $id = $this->auth_user['id'];
       // dd($id);
       $dataSet = $this->user->getUserData(array('users.id' => $id),true);
       // dd($dataSet);
       $this->view->dataSet = $dataSet;
    }

    public function changePasswordAction() {
       $request = $this->getRequest();
       $id = $this->auth_user['id'];
       // dd($id);
       $dataSet = $this->user->getUserData(array('users.id' => $id),true);
       // dd($dataSet);
       $this->view->dataSet = $dataSet;
    }

    public function editPasswordAction() {
       $request = $this->getRequest();
       $id = $this->auth_user['id'];
       // dd($id);
       if ($request->getPost('password', '')) {
            
            if ($request->getPost('password', '') == $request->getPost('repassword', '')) {
                
                $password = array(
                    'password' => $request->getPost('password', ''),
                    'updation_date' => time()
                );
                // dd($password);
                $data = $this->user->updateUserByUserId($password,$id);
                // dd($response);

                 $dataSet = array(
                        'status' => 200,
                        'message' => "Password has been changed",
                        'result' => $data
                    );

            }
            else {
             $dataSet = array(
                        'status' => 204,
                        'message' => "Password not matched",
                        'result' => null
                    );
            }
        }
        else {
             $dataSet = array(
                        'status' => 401,
                        'message' => "Invalid Request",
                        'result' => null
                    );
         }

         die(json_encode($dataSet));
    }
    
    public function updateUserFieldAction() {
        $request = $this->getRequest();
        $field = $request->getPost('field', '');
        $value = $request->getPost('value', '');
        $id = $this->auth_user['id'];

        $requestData = array(
            $field => $value
               );
         // echo $id;
         // dd($requestData);
         $data = $this->user->updateUserByUserId($requestData, $id);

          if($data) {
                $dataSet = array(
                    'status' => 200,
                    'message' => $field.' updated successfully',
                    'result' => null
                );
               
            } 
            else {

                 $dataSet = array(
                    'status' => 204,
                    'message' => "Error ..!! please check your details again",
                    'result' => null
                );
                
            }
        
        die(json_encode($dataSet));
    }

    public function editAction() {
        $id = $this->auth_user['id'];
        
       $dataSet = $this->user->getUserData(array('id' => $id),true);
       // dd($dataSet);
       $this->view->dataSet = $dataSet;
    }

    public function editAccountAction(){
        
        $request = $this->getRequest();
        $user_id = $this->auth_user['id'];
        $id = $request->getParam('id','');
        // dd($id);
        
        if($id) {
          // dd($id);
          // die("here");
          $requestData = array(
            'name' => $request->getPost('name', ''),
            'phone' => $request->getPost('phone', ''),
            'email' => $request->getPost('email', ''),
            'zender' => $request->getPost('zender', ''),
            'updation_date' => time()
          );
        // dd($requestData);
        $data = $this->user->updateUserByUserId($requestData, $id);
        // dd($data);
          
          die(json_encode($data = array('status' => 200,
          'data' => $data )));
        }

        
    }

    public function passwordcheckAction(){
        $request = $this->getRequest();
        $user_id = $this->auth_user['id'];
        $password=$request->getPost('keyword', '');
        // dd($user_id);
        $data = $this->user->getUserData(array('password' => $password,'id' => $user_id));
        // dd($data);
        if($data){
              $dataSet = array(
                'status' => 200,
                'message' => "Password Available !!",
                'result' => null
            );
        }
        else {
            $dataSet = array(
                'status' => 204,
                'message' => "Please Enter Correct Password !!",
                'result' => null
            );
        }
        die(json_encode($dataSet));
    }

}

?>
