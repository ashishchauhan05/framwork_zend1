<?php
 abstract class My_Controller_Action_Abstract extends Zend_Controller_Action {

    public $siteContent = null;
    protected $siteNotification;
    protected $auth_user;
    protected $userCart;
    protected $userWishlist;
    protected $cartSession;
    protected $cartItems;

    protected $_flashMessenger;
	
	public function preDispatch() {
		parent::preDispatch();
		$this->setBaseUrl();

        $auth = Zend_Auth::getInstance();
		if (isset($_POST['PHPSESSID'])) Zend_Session::setId($_POST['PHPSESSID']);

        $request = $this->getRequest();
      
        $requestModule = $request->getParam('module');
        $requestController = $request->getParam('controller');
        $requestAction = $request->getParam('action');

        if($requestModule == 'admin') {

        // if(!$auth->getIdentity()){
            	
          //   	$this->_redirect($this->getBaseURL() . '/auth/login?return=admin/'.$requestController.'/'.$requestAction);
          //   }
          //   else {
          //   	$d = $auth->getIdentity();
        	 // 	if($d['type'] != 'admin')
          //   	  $this->_redirect($this->getBaseURL() . '/auth/login?return=admin/'.$requestController.'/'.$requestAction);                

          //   }

        }

		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->view->flashMessages = implode('. ', $this->_flashMessenger->getMessages());

		//Setting the request for view 
		$this->view->request = new My_Request();
		$this->view->baseUrl = $this->baseUrl = Zend_Controller_Front::getInstance()->getBaseURL();
		$auth = Zend_Auth::getInstance();
		
		//Setting the Paging File 
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.html');
		$this->view->addHelperPath(APPLICATION_PATH . '/default/views/helpers', 'Default_View_Helper');
	}
	
	public function makeUrl($url, $module = '') {
		if (!$module) {
			$module = Zend_Controller_Front::getInstance()->getRequest()->getParam('module');
		}
		if($module != 'default') {
			$url =  '/' . $module . $url;
		}
		$settingConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'setting.ini');
		if($settingConfig->base_folder) {
			$url = '/' . $settingConfig->base_folder . $url;
		}
		$host  = $_SERVER['HTTP_HOST'];
		$proto = (empty($_SERVER['HTTPS'])) ? 'http' : 'http';
		
		return $proto . '://' . $host.$url;
	}
	
	protected function flash($message, $redirect=false) {
		$messageText = $this->siteNotification->getMessage($message);
		if (!$messageText) {
			$messageText = $message;
		}
		
		$this->_flashMessenger->addMessage($messageText);
		
		if ($redirect) {
			if (is_array($redirect)) {
				$this->_helper->redirector($redirect[0], isset($redirect[1]) ? $redirect[1] : null);
			} else {
				$this->_redirect($redirect);
			}
		}
	}

	// Mail send function for Server

	// protected function sendEmail($to,$subject,$body) {

	// 	 //Initialize needed variables
 //               $tr = new Zend_Mail_Transport_Sendmail('support@laptopengineers.in');
 //               Zend_Mail::setDefaultTransport($tr);
 
		 
	// 	 $mail = new Zend_Mail();

 //                 $mail->setBodyHtml($body)
 //                    ->setFrom('support@laptopengineers.in', 'support@laptopengineers.in')
 //                    ->addTo($to, $to)
 //                    ->setSubject($subject);

 //                  //Send
	// 	 $sent = true;
	// 	 try {
	// 	  $mail->send($transport);
	// 	 }
	// 	 catch (Exception $e) {
	// 	  $sent = false;
	// 	 }

	// 	 //Return boolean indicating success or failure
	// 	 return $sent;
		 
	// }

 //        protected function sendEmail1($to,$subject,$body) {

	// 	 //Initialize needed variables
 //               $tr = new Zend_Mail_Transport_Sendmail('no-reply@laptopengineers.in');
 //               Zend_Mail::setDefaultTransport($tr);
 
		 
	// 	 $mail = new Zend_Mail();

 //                 $mail->setBodyHtml($body)
 //                    ->setFrom('no-reply@laptopengineers.in', 'no-reply@laptopengineers.in')
 //                    ->addTo($to, $to)
 //                    ->setSubject($subject);

 //                  //Send
	// 	 $sent = true;
	// 	 try {
	// 	  $mail->send($transport);
	// 	 }
	// 	 catch (Exception $e) {
	// 	  $sent = false;
	// 	 }

	// 	 //Return boolean indicating success or failure
	// 	 return $sent;
		 
	// }

	// Mail send function for Local 
	
	protected function sendEmail($to,$subject,$body) {

		 $your_name = '';
		 $your_email = ''; //Or your_email@gmail.com for Gmail
		 $your_password = '';
		 
         //SMTP server configuration
		 $smtpHost = 'smtpout.asia.secureserver.net';
		 $smtpConf = array(
		  'auth' => 'login',
		  'ssl' => 'ssl',
		  'port' => '465',
		  'username' => $your_email,
		  'password' => $your_password
		 );
		 $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);

		 //Create email
		 $mail = new Zend_Mail();
		 $mail->setFrom($your_email, $your_name);
		 $mail->addTo($to);
		 $mail->setSubject($subject);
		 $mail->setBodyHtml($body);

		 //Send
		 $sent = true;
		 try {
		  $mail->send($transport);
		 }
		 catch (Exception $e) {
		  $sent = false;
		 }

		 //Return boolean indicating success or failure
		 return $sent;
	}

	protected function getBaseURL() {
		$host  = $_SERVER['HTTP_HOST'];
                $settingConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'setting.ini');
                if ($settingConfig->base_folder) {
                    $host .= '/' . $settingConfig->base_folder;
                }
		$proto = (empty($_SERVER['HTTPS'])) ? 'http' : 'http';
		return $proto . '://' . $host;
	}
	
	protected function setBaseUrl($url = '', $addModuleName = null) {
		if ($addModuleName) $url = '/' . $addModuleName . $url;
		$settingConfig = new Zend_Config_Ini(APP_DIR . DS . 'configs' . DS . 'setting.ini');
		if($settingConfig->base_folder) $url = '/' . $settingConfig->base_folder . $url;
		Zend_Controller_Front::getInstance()->setBaseUrl($url);
	}

	protected function _getCredenital() {
		if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return md5($ip);//$_SERVER['HTTP_USER_AGENT'] .
	}
	
	protected function _getIpaddress() {
		if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;//$_SERVER['HTTP_USER_AGENT'] .
	}

	protected function _generateCaptcha($name, $config = array())
	{

	}
	public function postDispatch() {
    }
}
