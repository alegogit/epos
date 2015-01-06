<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model {
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
  
	function get_currencies(){
    $query = $this->db->select('CODE,VALUE,DESCRIPTION')
                      ->from('ref_values')
                      ->where('LOOKUP_NAME','CURRENCY')
                      ->get('');
    return $query->result();
  }
  
	function get_rest_currency($rest_id){
    $query = $this->db->select('CURRENCY')
                      ->from('restaurants')
                      ->where('ID',$rest_id)
                      ->limit(1)
                      ->get('');
    return $query->row()->CURRENCY;
  }
  
  
	function set_default_currency($curr_cd,$rest_id){
	  date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'CURRENCY' => $curr_cd,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
		$this->db->where('ID',$rest_id);
    $query = $this->db->update('restaurants',$data);
  }
}