<?php

class Default_Model_Users extends My_Db_Table_Abstract {

    public function getUserData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('users',array('id', 'name',  'email', 'phone','password','wallet_amount','reason','zipcode','creation_date','updation_date'));
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }

        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function getCountriesData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('countries');
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function getStatesData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('states');
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function getCitiesData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('cities');
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function getRowByFilters($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('users',array('id', 'name',  'email', 'phone','zipcode'))
        ->joinLeft('address','address.user_id = users.id');
        // ->where('is_active = ? ', 1);
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
            // $select->where('address.is_active = ? ', 1);
        }
        
        // die($select); 
        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }


    public function setUser($dataSet = array()) {
        $db = Zend_Registry::get('db');
        
        $respose=$db->insert('users', $dataSet);
//        dd($respose);
        $id = $db->lastInsertId('users', 'id');
        return $id;
    }

    public function sendQuery($dataSet = array()) {
        $db = Zend_Registry::get('db');
        
        $respose=$db->insert('send_query', $dataSet);
//        dd($respose);
        $id = $db->lastInsertId('send_query', 'id');
        return $id;
    }

    public function getQueryData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('send_query');
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function sendClaim($dataSet = array()) {
        $db = Zend_Registry::get('db');
        // dd($dataSet);
        $respose=$db->insert('part-request', $dataSet);
       // dd($respose);
        $id = $db->lastInsertId('part-request', 'id');
        return $id;
    }

    public function getClaimData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('part-request',array('id','menu','sub-menu','category','input-part','name','email','phone','feedback','created_at','updated_at','deleted_at'));
        // ->joinLeft('category','category.cid = part-request.category',array('category'))
        // ->joinLeft('sub_menu','sub_menu.sid=part-request.sub-menu',array('sub_menu'));
        // ->joinLeft('menu','menu.mid = category.mid',array('menu'));
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function setClaimResponse($dataSet = array()) {
        $db = Zend_Registry::get('db');
        // dd($dataSet);
        $respose=$db->insert('claim-response', $dataSet);
       // dd($respose);
        $id = $db->lastInsertId('claim-response', 'id');
        return $id;
    }

    public function getClaimResponseData($filters = array(), $row = FALSE) {
      
        $db = Zend_Registry::get('db');
        $select = $db->select()->from('claim-response');
        
        if ($filters) {
            foreach ($filters as $key => $value) {
                $select->where($key . ' = ? ', $value);
            }
        }

        // die($select);

        if ($row) {
            return $db->fetchRow($select);
        } else {
            return $db->fetchAll($select);
        }
    }

    public function setdealerRegistration($dataSet = array()) {
       $db = Zend_Registry::get('db');
       
       $respose=$db->insert('dealer_registration', $dataSet);
//        dd($respose);
       $id = $db->lastInsertId('dealer_registration', 'id');
       return $id;
    }

    public function getdealerRegistrationData($filters = array(), $row = FALSE) {
     
       $db = Zend_Registry::get('db');
       $select = $db->select()->from('dealer_registration');
       if ($filters) {
           foreach ($filters as $key => $value) {
               $select->where($key . ' = ? ', $value);
           }
       }

       // die($select);

       if ($row) {
           return $db->fetchRow($select);
       } else {
           return $db->fetchAll($select);
       }
    }

    //function to remove user form the db
    public function deleteUser($userId = null) {

        $db = Zend_Registry::get('db');
        $response = $db->delete('users', 'users.id =' . $userId);
        return $response;
    }

    //update user 
    public function updateUserByUserId($dataSet = null, $userId = null) {
        $db = Zend_Registry::get('db');
        // dd($dataSet);
        $response = $db->update('users', $dataSet, 'id =' . $userId);
        // dd($response);
        return $response;
    }

}
