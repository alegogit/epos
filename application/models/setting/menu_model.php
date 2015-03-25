<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {
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
  
  function get_rest_logo(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id); 
		$this->db->where('USERS_RESTAURANTS.DEFAULT_REST',1);
    $query = $this->db->select('LOGO_URL')
                      ->from('RESTAURANTS')
                      ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                      ->limit(1)
                      ->get('');
    return $query->row()->LOGO_URL;
  }
  
  function get_currency($rest_id){
  	$query = $this->db->select('RESTAURANTS.CURRENCY, REF_VALUES.VALUE AS CUR')
                      ->from('RESTAURANTS')
                      ->join('REF_VALUES', 'REF_VALUES.CODE = RESTAURANTS.CURRENCY')
                      ->where('RESTAURANTS.ID',$rest_id)
                      ->where('REF_VALUES.LOOKUP_NAME','CURRENCY')
                      ->limit(1)
                      ->get('');
  	return $query->row()->CUR;
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
  
	function get_rest_menus($rest_id){                       
  	$query = $this->db->select('MENU.*, CATEGORY.NAME AS CAT_NAME, PRINTER.NAME AS PRINT_NAME')
                      ->from('MENU')
                      ->join('CATEGORY', 'MENU.CATEGORY_ID = CATEGORY.ID')
                      ->join('PRINTER', 'MENU.PRINTER = PRINTER.ID')
                      ->where('CATEGORY.REST_ID',$rest_id)
                      ->get('');
  	return $query->result();
  } 
  
  function get_rest_categories($rest_id){
  	$query = $this->db->select('ID,NAME')
                      ->from('CATEGORY')
                      ->where('REST_ID',$rest_id)
                      ->get('');
  	return $query->result();
  }    
  
  function get_rest_printer($rest_id){
  	$query = $this->db->select('ID,NAME')
                      ->from('PRINTER')
                      ->where('REST_ID',$rest_id)
                      ->get('');
  	return $query->result();
  }               
  
	function get_status(){  
    $this->db->where('LOOKUP_NAME','STATUS');
    $query = $this->db->get('REF_VALUES');
    return $query->result();
  }
  
  function set_status($stat){
    if($stat==1){
      $output = "Active";
    } else {
      $output = "<span style='color:#dd1144 !important;'>Inactive</span>";
    }
  } 
   
	function new_menu($NAME,$CATEGORY_ID,$PRICE,$PRINTER,$TAX){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
  	$query = $this->db->query('INSERT INTO MENU
      		(NAME,CATEGORY_ID,PRICE,PRINTER,TAX,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      		VALUES 
      		("'.$NAME.'",'.$CATEGORY_ID.','.$PRICE.','.$PRINTER.','.$TAX.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  }
  
}