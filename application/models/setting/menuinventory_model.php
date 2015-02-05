<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menuinventory_model extends CI_Model {
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
  
	function get_rest_menuinventory($rest_id){                      
    	$query = $this->db->select('MENU_INVENTORY.*, MENU.NAME AS MENU_NAME, INVENTORY.NAME AS INVENTORY_NAME, INVENTORY.METRIC AS INVENTORY_METRIC')
                      ->from('MENU_INVENTORY')
                      ->join('MENU', 'MENU_INVENTORY.MENU_ID = MENU.ID')
                      ->join('INVENTORY', 'MENU_INVENTORY.INVENTORY_ID = INVENTORY.ID')
                      ->where('INVENTORY.REST_ID',$rest_id)
                      ->get('');
    	return $query->result();
  	} 
	
  	function get_metric($metric_id){
    	$query = $this->db->select('VALUE AS METRIC_NAME')
                      ->from('REF_VALUES')
                      ->where('CODE',$metric_id)
                      ->where('LOOKUP_NAME','METRIC')
                      ->limit(1)
                      ->get('');
    	return $query->row()->METRIC_NAME;
  	}    
  
  	function get_rest_menus($rest_id){                    
    	$query = $this->db->select('MENU.ID,MENU.NAME')
                      ->from('MENU')
                      ->join('CATEGORY', 'CATEGORY.ID = MENU.CATEGORY_ID')
                      ->where('CATEGORY.REST_ID',$rest_id)
                      ->get('');
    	return $query->result();
  	}    
	
	
	function get_rest_inventories($rest_id){    
    	$this->db->where('REST_ID',$rest_id);
    	$query = $this->db->get('INVENTORY');
    	return $query->result();
  	}
	
  	function get_rest_categories($rest_id){
    	$query = $this->db->select('ID,NAME')
                      ->from('CATEGORY')
                      ->where('REST_ID',$rest_id)
                      ->get('');
    	return $query->result();
  	}    
	
	function new_menuinventory($MENU_ID,$INVENTORY_ID,$QUANTITY){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    	$query = $this->db->query('INSERT INTO MENU_INVENTORY
      		(MENU_ID,INVENTORY_ID,QUANTITY,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      		VALUES 
      		('.$MENU_ID.','.$INVENTORY_ID.','.$QUANTITY.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  	}
  
}