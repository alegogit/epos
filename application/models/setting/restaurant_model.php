<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant_model extends CI_Model {
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
    
	function get_username($id){
    $query = $this->db->select('NAME,USERNAME')
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
  
	function get_restaurant_data(){ 
		$session_data = $this->session->userdata('logged_in');  
		$role = $session_data['role'];                             
		$id = $session_data['id'];
		if($role>1){
      $query = $this->db->where('USERS_RESTAURANTS.USER_ID',$id);
      $query = $this->db->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID');
    }
    $query = $this->db->select('RESTAURANTS.*, REF_VALUES.VALUE AS CURRENCY_NAME')
                      ->from('RESTAURANTS')
                      ->join('REF_VALUES', 'RESTAURANTS.CURRENCY = REF_VALUES.CODE')
                      ->where('REF_VALUES.LOOKUP_NAME','CURRENCY')
                      ->get('');
    return $query->result();                                           
  }
  
	function get_currencies(){
    $query = $this->db->select('CODE,VALUE,DESCRIPTION')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME','CURRENCY')
                      ->get('');
    return $query->result();
  }
    
  function get_default_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.DEFAULT_REST=1 AND USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    $output = ($this->db->affected_rows()>0)?$query->row():"NONE";
    return $output;
  } 
  
  function get_assigned_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.REST_ID, RESTAURANTS.NAME AS NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    return $query->result();
  } 
  
  function get_users_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    return $query->result();
  }
  
  function get_role_name($role_id){
    $query = $this->db->select('NAME')
                      ->from('ROLES')
                      ->where('ID',$role_id)
                      ->limit(1)
                      ->get('');
    return $query->row()->NAME;
  }
  
  function get_roles(){         
		$session_data = $this->session->userdata('logged_in');  
		$role = $session_data['role'];   
		if($role>1){
      $query = $this->db->where('ID > 2');
    }
    $query = $this->db->select('ID,NAME')
                      ->from('ROLES')
                      ->get('');
    return $query->result();
  }
   
	function new_restaurant($NAME,$TELEPHONE,$FAX,$ADDRESS_LINE_1,$ADDRESS_LINE_2,$CITY,$POSTAL_CODE,$COUNTRY,$GEOLOC,$EMAIL_ADDRESS,$CURRENCY,$SERVICE_CHARGE){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query1 = $this->db->query('INSERT INTO RESTAURANTS
      (NAME,TELEPHONE,FAX,ADDRESS_LINE_1,ADDRESS_LINE_2,CITY,POSTAL_CODE,COUNTRY,GEOLOC,EMAIL_ADDRESS,CURRENCY,SERVICE_CHARGE,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ("'.$NAME.'","'.$TELEPHONE.'","'.$FAX.'","'.$ADDRESS_LINE_1.'","'.$ADDRESS_LINE_2.'","'.$CITY.'","'.$POSTAL_CODE.'","'.$COUNTRY.'","'.$GEOLOC.'","'.$EMAIL_ADDRESS.'","'.$CURRENCY.'",'.$SERVICE_CHARGE.','.$id.',NOW(),'.$id.',NOW());');
  }
  
}