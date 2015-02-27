<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers_model extends CI_Model {
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
		if($session_data['role']!=1){   
      $this->db->where('USERS_RESTAURANTS.USER_ID',$id);
      $query = $this->db->select('*')
                        ->from('RESTAURANTS')
                        ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                        ->get('');
    } else {  
      $query = $this->db->select('*,ID AS REST_ID')
                        ->from('RESTAURANTS')
                        ->get('');
    }
    return $query->result();
  }
    
	function get_username($id){
    $query = $this->db->select('USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
                      ->get('');
    return $query->row();
  }
  
	function get_name($id){
    $query = $this->db->select('NAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
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
  
	function get_rest_customers($rest_id){    
    $this->db->where('REST_ID',$rest_id);
    $query = $this->db->get('CUSTOMERS');
    return $query->result();
  } 
   
	function new_customers($NAME,$TELEPHONE,$ADDRESS_LINE_1,$ADDRESS_LINE_2,$CITY,$EMAIL_ADDRESS,$POSTAL_CODE,$COUNTRY,$REST_ID){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    	$query = $this->db->query('INSERT INTO CUSTOMERS
      		(NAME,TELEPHONE,ADDRESS_LINE_1,ADDRESS_LINE_2,CITY,EMAIL_ADDRESS,POSTAL_CODE,COUNTRY,REST_ID,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      		VALUES 
      		("'.$NAME.'","'.$TELEPHONE.'","'.$ADDRESS_LINE_1.'","'.$ADDRESS_LINE_2.'","'.$CITY.'","'.$EMAIL_ADDRESS.'","'.$POSTAL_CODE.'","'.$COUNTRY.'",'.$REST_ID.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  }
  
}