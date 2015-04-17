<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginauth_controller extends CI_Controller {

	function __construct() {
        parent::__construct();
        //load session and connect to database
        $this->load->model('login_model','login',TRUE);
        $this->load->helper(array('form', 'url','html'));
        $this->load->library(array('form_validation','session'));
    }
	
	function index() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database'); //|callback_check_database
 
        $data['username'] = ($this->input->post('username'))?$this->input->post('username'):"";
        
        if($this->form_validation->run() == FALSE){
            $this->load->view('login',$data);   
        }	else {
			//$sess_array = array(
				//'username' => $this->input->post('username'),
				//'password' => $this->input->post('password')
			//);
			//$this->session->set_userdata('logged_in', $sess_array);
            //Go to private area
            redirect('dashboard', 'refresh');
        }   
			    
     }
     
  function check_database($password){
    //Field validation succeeded.  Validate against database
	  $username = $this->input->post('username');
	  
    //query the database
	  $result = $this->login->login($username, sha1(md5($password)));
	  
    $role = 0;
    if($result){
		  $sess_array = array();
		  foreach($result as $row){
		    $sess_array = array(
			   'id' => $row->USER_ID,
         'username' => $row->USERNAME,
         'role' => $row->ROLE_ID,
         'def_rest' => $row->REST_ID
		    );
		    $this->session->set_userdata('logged_in', $sess_array);
		    $this->login->update_logintime();
        $role = $row->ROLE_ID;
        $stat = $row->ACTIVE;
      }
		  //echo "<pre>" . var_dump($row) . "</pre>";
      $config = $this->config->config; 
      if (($role>$config['max_role'])||($stat!=1)){ 
        $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');
        $this->form_validation->set_message('check_database', 'You are not allowed to login to the system. Please contact Administrator.');
        return false;
      } else {    
		    return TRUE;
      }
    } else {
      $this->form_validation->set_error_delimiters('<div id="output" class="fade-in">', '</div>');
      $this->form_validation->set_message('check_database', 'Invalid username or password');
      return false;
    }
  }

}
