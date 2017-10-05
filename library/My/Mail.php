<?php

class My_Mail
{
	/**
	 * Email address for sending email
	 * 
	 * @var string
	 */
	var $to = '';
	
	/**
	 * Class constructor
	 *
	 * @param string $to email address
	 */
	public function __construct($to) {
		$this->to = $to;
	}
	
	/**
	 * Sending email
	 * 
	 * @param string $subject
	 * @param text $message
	 */
	public function send($subject, $message, $attachment) {
       	    $transport = new Zend_Mail_Transport_Smtp('localhost');
    		$mailConfig = Zend_Registry::get('config_global')->email;
    		$mail = new Zend_Mail($mailConfig->charset);
    		$mail->setFrom($mailConfig->from_email, $mailConfig->from_name);
    		$mail->addTo($this->to);
    		$mail->setSubject($subject);
    		$mail->setBodyText(strip_tags($message));
    		$mail->setBodyHtml($message);
    		if ($attachment) {
    			$mail->addAttachment($attachment);
    		}
            $mail->send($transport);
    	 
    }
  
}