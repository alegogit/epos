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
  
	function get_rest_menus($rest_id){    
    $query = $this->db->get('menu');                      
    $query = $this->db->select('menu.*, category.NAME AS CAT_NAME, printer.NAME AS PRINT_NAME')
                      ->from('menu')
                      ->join('category', 'menu.CATEGORY_ID = category.ID')
                      ->join('printer', 'menu.PRINTER = printer.ID')
                      ->where('category.REST_ID',$rest_id)
                      ->get('');
    return $query->result();
  } 
  
  function get_rest_categories($rest_id){
    $query = $this->db->select('ID,NAME')
                      ->from('category')
                      ->where('REST_ID',$rest_id)
                      ->get('');
    return $query->result();
  }    
  
  function get_rest_printer($rest_id){
    $query = $this->db->select('ID,NAME')
                      ->from('printer')
                      ->where('REST_ID',$rest_id)
                      ->get('');
    return $query->result();
  }
   
	function new_menu($NAME,$CATEGORY_ID,$PRICE,$PRINTER,$TAX){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query = $this->db->query('INSERT INTO menu
      (NAME,CATEGORY_ID,PRICE,PRINTER,TAX,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ("'.$NAME.'",'.$CATEGORY_ID.','.$PRICE.','.$PRINTER.','.$TAX.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  }
  
}