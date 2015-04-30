<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_controller extends CI_Controller {

	function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('forgot_model','forgot',TRUE);
        $this->load->helper(array('form', 'url','html'));
        $this->load->library(array('form_validation','session'));  
        $this->load->library('hash');   
		    $this->data['user'] = '';  
		    $this->data['username'] = '';
    }
	
	function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_check_database');
        //$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database'); //|callback_check_database
 
        if($this->form_validation->run() == FALSE){                                              
	        $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');      
          $this->load->view('forgot/mail_form');  
        } else {      
	        $email = $this->input->post('email');
          date_default_timezone_set('Asia/Jakarta');
	        $reset_code = $this->hash->epos_encrypt(date('Ymd')."@".$this->data['username'],$this->config->item('encryption_key'));
          $reset_url = $this->config->item('base_url')."reset/".$reset_code;   
	        $message = "Hi ".$this->data['user'].",<br>&nbsp;<br>";
	        $message .= "Reset Password Request was made.<br>&nbsp;<br>"; 
	        $message .= "<b>If this wasn't you</b><br>";
	        $message .= "Please ignore this message.<br>&nbsp;<br>";
	        $message .= "<b>If this was you</b><br>";
          $message .= "To initiate the process for resetting the password for your ";
          $message .= $email." NadiPOS Account, visit the link below: <br>";
          $message .= $reset_url." <br>";
          $message .= "If clicking the link above does not work, copy and paste the URL in a new browser window instead.
                       <br>&nbsp;<br> 
                        Thank you for using NadiPOS.
                        <br>&nbsp;<br>
                        This is a post-only mailing. Replies to this message are not monitored or answered.";     
          $this->load->library('email');
          $this->email->from($this->config->item('smtp_user'),'NadiPOS');
          $this->email->to($email);
          
          $this->email->subject('NadiPOS Reset Password Request');
          $this->email->message($message);
          
          $this->email->send();

          //echo $this->email->print_debugger();
          $this->load->view('forgot/mail_sent');
        }  
			    
     }
	 
	 function check_database()
	 {
	   //Field validation succeeded.  Validate against database
	   $email = $this->input->post('email');
	 
	   //query the database
	   $result = $this->forgot->mail_avail($email);
	 
	   if($result){
		  $mailuser = array();
		  foreach($result as $row){
		   $mailuser = array(
			   'email' => $row->EMAIL_ADDRESS,
			   'username' => $row->USERNAME,
			   'name' => $row->NAME
		   );
		  }
		  $this->data['user'] = ($mailuser['name']!="")?$mailuser['name']:$mailuser['username'];
		  $this->data['username'] = $mailuser['username'];
		  return true;
	   } else {
	    //$eek1 = $this->forgot->epos_encrypt($this->config->item('encryption_key'));
	    //$eek2 = $this->forgot->epos_decrypt($eek1);
	    $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');
		  $this->form_validation->set_message('check_database', 'Email Address is not registered');
		  //$this->form_validation->set_message('check_database', 'Email Address is not registered '.$eek1.' '.$eek2);
		  return false;
	   }
	 }

}
