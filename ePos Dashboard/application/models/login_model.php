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
        $this->db->join('users_restaurants', 'USERS.ID = users_restaurants.USER_ID');   
        $this->db->where('users_restaurants.DEFAULT_REST', 1);  
         
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
}