<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devices_model extends CI_Model {
  function __construct(){
    // Call the Model constructor
    parent::__construct();
  }
	 
	function get_profile(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('ID',$id);
    $query = $this->db->get('users');
    return $query->row();
  }  
  
  function get_restaurant(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
    $query = $this->db->select('*')
                      ->from('restaurants')
                      ->join('users_restaurants', 'restaurants.ID = users_restaurants.REST_ID')
                      ->get('');
    return $query->result();
  }
    
	function get_username($id){
    $query = $this->db->select('USERNAME')
                      ->from('users')
                      ->where('ID',$id)
                      ->get('');
    return $query->row();
  }
  
	function get_restaurant_name($id){
    $query = $this->db->select('NAME AS REST_NAME')
                      ->from('restaurants')
                      ->where('ID',$id)
                      ->get('');
    return $query->row();
  }    
  
	function get_rest_devices($rest_id){    
    $this->db->where('REST_ID',$rest_id);
    $query = $this->db->get('devices');
    return $query->result();
  } 
   
	function new_devices($MAC,$TYPE,$MAKE,$MODEL,$REST_ID){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query = $this->db->query('INSERT INTO devices
      (MAC_ADDRESS,TYPE,MAKE,MODEL,REST_ID,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ("'.$MAC.'","'.$TYPE.'","'.$MAKE.'","'.$MODEL.'",'.$REST_ID.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  }
  
}