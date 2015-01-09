<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reset_controller extends CI_Controller {

	function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('reset_model','reset',TRUE);
        $this->load->helper(array('form', 'url','html')); 
    }
	
	function index() {                                  
        $resetcode = substr(strstr(uri_string(),'/'),1); 
        $data['code'] = $resetcode;    
	      $reset_parm = $this->reset->epos_decrypt($resetcode,$this->config->item('encryption_key'));
	      $reset_date = strstr($reset_parm,'@', true);
	      $reset_user = substr(strstr($reset_parm,'@'),1);        
	      $date_diff = floor(abs(strtotime(date('Ymd')) - strtotime($reset_date))/(60*60*24));
	      
	      if($date_diff > $this->config->item('reset_link_expiry')){  
          $data['notif'] = "Link error or the link might has been expired, please request for Forgot Password again";         
          $data['nxact'] = "Back Home";
          $this->load->view('reset/reset_notif',$data); 
        } else {    
          $user_id = $this->reset->get_user_id($reset_user);
          if($user_id){   
            if( $this->input->post('password2') && ($this->input->post('password1')==$this->input->post('password2')) ){
              $this->reset->change_password($user_id,sha1(md5($this->input->post('password2'))));     
              $data['notif'] = "You have successfully reset your password";          
              $data['nxact'] = "Login Now";   
              $this->load->view('reset/reset_notif',$data);
            } else {     
              $this->load->view('reset/reset_form',$data);
            }
          } else {                 
            $data['notif'] = "Link Error";          
            $data['nxact'] = "Back Home";
            $this->load->view('reset/reset_notif',$data);
          }
        } 
          
			    
     }
	 
}
