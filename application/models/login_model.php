<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Login_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function login($username, $password) {
        //create query to connect user login database
        //$this->db->select('*');
        //$this->db->from('USERS');
        $this->db->where('USERS.USERNAME', $username);
        $this->db->where('USERS.PASSWORD', $password);  
        $this->db->limit(1);
        $this->db->join('USERS_RESTAURANTS', 'USERS.ID = USERS_RESTAURANTS.USER_ID');   
        $this->db->where('USERS_RESTAURANTS.DEFAULT_REST', 1);  
         
        //get query and processing
        $query = $this->db->get('USERS');
        if($query->num_rows() == 1) 
		{ 
            return $query->result(); //if data is true
        } 
		else 
		{
            return false; //if data is wrong
        }
		
    }
    
  function update_logintime(){       
	  date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');         
	  $data = array(            
               'LAST_LOGIN' => $dt
            );          
		$this->db->where('ID',$id);
    $query = $this->db->update('USERS',$data);
  }
    
}