<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
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
  
	function get_users_data(){    
    $query = $this->db->get('users'); 
    return $query->result();
  } 
  
	function get_users_data1(){                         
    $query = $this->db->query('SELECT users.*, restaurants.ID AS REST_ID, restaurants.NAME AS REST_NAME
                              FROM users
                              LEFT JOIN users_restaurants ON users.ID = users_restaurants.USER_ID
                              LEFT JOIN restaurants ON users_restaurants.REST_ID = restaurants.ID
                              GROUP BY users.ID;
                              ');
    return $query->result();
  } 
  
	function get_users_data0(){                         
    $query = $this->db->query('SELECT users.*, restaurants.ID AS REST_ID, restaurants.NAME AS REST_NAME, roles.NAME AS ROLE_NAME
                              FROM users
                              JOIN users_restaurants ON users.ID = users_restaurants.USER_ID
                              JOIN restaurants ON users_restaurants.REST_ID = restaurants.ID
                              JOIN roles ON users.ROLE_ID = roles.ID
                              ');
    return $query->result();
  } 
  
  function get_rest_name($user_id){                         
    $query = $this->db->query('SELECT users_restaurants.*, restaurants.ID AS REST_ID, restaurants.NAME AS REST_NAME
                              FROM users_restaurants
                              JOIN restaurants ON users_restaurants.REST_ID = restaurants.ID
                              WHERE users_restaurants.DEFAULT_REST=1 AND users_restaurants.USER_ID = '.$user_id.'
                              ');
    return $query->row()->REST_NAME;
  } 
  
  function get_rest_name0($rest_id){
    $query = $this->db->select('NAME')
                      ->from('restaurants')
                      ->where('REST_ID',$rest_id)
                      ->limit(1)
                      ->get('');
    return $query->row()->NAME;
  }    
  
  function get_users_rest($user_id){                         
    $query = $this->db->query('SELECT users_restaurants.*, restaurants.ID AS REST_ID, restaurants.NAME AS REST_NAME
                              FROM users_restaurants
                              JOIN restaurants ON users_restaurants.REST_ID = restaurants.ID
                              WHERE users_restaurants.USER_ID = '.$user_id.'
                              ');
    return $query->result();
  }
  
  function get_role_name($role_id){
    $query = $this->db->select('NAME')
                      ->from('roles')
                      ->where('ID',$role_id)
                      ->limit(1)
                      ->get('');
    return $query->row()->NAME;
  }
   
	function new_users($NAME,$CATEGORY_ID,$PRICE,$PRINTER,$TAX){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query = $this->db->query('INSERT INTO users
      (NAME,CATEGORY_ID,PRICE,PRINTER,TAX,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ("'.$NAME.'",'.$CATEGORY_ID.','.$PRICE.','.$PRINTER.','.$TAX.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  }
  
}