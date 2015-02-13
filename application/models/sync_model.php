<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync_model extends CI_Model {
	function __construct(){
    	// Call the Model constructor
    	parent::__construct();
  	}
	 
	function get_profile(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('ID',$id);
    	$query = $this->db->get('USERS');
    	return $query->row();
  	}  
  
  	function get_restaurant(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id);
    	$query = $this->db->select('*')
                      ->from('RESTAURANTS')
                      ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                      ->get('');
    	return $query->result();
  	}
	
  	function get_default_rest(){   
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];                      
    	$query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.DEFAULT_REST=1 AND USERS_RESTAURANTS.USER_ID = '.$id.'
							  LIMIT 1;');
    	//$output = ($this->db->affected_rows()>0)?$query->row():"NONE";
    	//return $output;
    	return $query->row();
  	}
    
	function get_sync_history($rest_id){
    	$query = $this->db->select('*')
                      ->from('DEVICES')
                      ->where('REST_ID',$rest_id)
                      ->get('');
    	return $query->result();
  	}
	
	function get_username($id){
    	$query = $this->db->select('NAME,USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row();
  	}
  
	function get_restaurant_name($id){
    	$query = $this->db->select('NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row();
  	}    
    
}