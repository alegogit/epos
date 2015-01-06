<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_controller extends CI_Controller {

	function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('forgot_model','forgot',TRUE);
        $this->load->helper(array('form', 'url','html'));
        $this->load->library(array('form_validation','session'));
    }
	
	function index() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_check_database');
        //$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database'); //|callback_check_database
 
        if($this->form_validation->run() == FALSE){                                              
	        $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');      
          $this->load->view('forgot/mail_form');  
        } else {          
	        $email = $this->input->post('email'); 
          $this->load->library('email');
          $this->email->from('postmaster@localhost', 'Your Name');
          $this->email->to($email);
          //$this->email->to('alex@disiniaje.com');
          
          $this->email->subject('Email Test');
          $this->email->message('Testing the email class.');
          
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
			   'email' => $row->EMAIL_ADDRESS
			   ,'username' => $row->USERNAME
		   );
		   //$this->session->set_userdata('logged_in', $sess_array);
		  }
		  return true;
	   } else {
	    $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');
		  $this->form_validation->set_message('check_database', 'Email Address is not registered');
		  return false;
	   }
	 }

}
