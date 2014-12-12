<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model {
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
  
	function get_all_connectivity(){
    $query = $this->db->select('CODE,VALUE')
                      ->from('ref_values')
                      ->where('LOOKUP_NAME','PRINTER_CONNECTION')
                      ->get('');
    return $query->result();
  }
  
  function get_connectivity($code){
    $query = $this->db->select('VALUE')
                      ->from('ref_values')
                      ->where('CODE',$code)
                      ->get('');
    return $query->row();
  }
  
	function get_printer0(){
    $query = $this->db->select('printer.*,restaurants.NAME AS REST_NAME')
                      ->from('printer')
                      ->join('restaurants', 'printer.REST_ID = restaurants.ID')
                      ->get('');
    return $query->result();
  }
  
	function get_printer1(){
    $query = $this->db->get('printer');
    return $query->result();
  }
     
	function get_printer(){    
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
    $query = $this->db->select('printer.*')
                      ->from('printer')
                      ->join('users_restaurants', 'printer.REST_ID = users_restaurants.REST_ID')
                      ->get('');
    return $query->result();
  }               
   
}