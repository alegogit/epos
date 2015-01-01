<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model {
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
  	
	function get_inventory()
	{
	     $query = $this->db->query('SELECT I.NAME,  
		      CONCAT(I.QUANTITY," ",I.METRIC) AS QUANTITY,
		        CASE WHEN I.QUANTITY = 0 THEN "NONE"
			         WHEN I.QUANTITY < MIN_QUANTITY THEN "LOW"
               WHEN I.LAST_UPDATED_DATE <SUBDATE(SYSDATE(),7) THEN "Not Moving"
            ELSE "OK"
            END AS STATUS
          FROM INVENTORY I;');
		    return $query->result();
	}
	
	function inv_status_color($status){
    if ($status=="NONE"){
      $color = "#d9534f";
    } elseif ($status=="LOW"){ 
      $color = "#f0ad4e";
    } elseif ($status=="Not Moving"){ 
      $color = "#777";
    } else {
      $color = "#333";
    }
    return $color;
  }
  
	function inv_status_class($status){
    if ($status=="NONE"){
      $class = "danger";
    } elseif ($status=="LOW"){ 
      $class = "warning";
    } elseif ($status=="Not Moving"){ 
      $class = "active";
    } else {
      $class = "";
    }
    return $class;
  }
		
}