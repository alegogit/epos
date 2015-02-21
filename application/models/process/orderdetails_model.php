<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderdetails_model extends CI_Model {
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
  
  function get_order_details($order_id)
	{
	     $query = $this->db->query('SELECT M.NAME, 
		          OD.QUANTITY, OD.KITCHEN_NOTE, OD.PRICE, OD.VOID, OD.VOID_REASON 
	         FROM ORDER_DETAILS OD
	         LEFT OUTER JOIN MENU M	ON M.ID = OD.MENU_ID
           WHERE ORDER_ID = '.$order_id.';');
		    return $query->result();
	}
	 	
	function get_restaurant_name($id){
    $query = $this->db->select('NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->where('ID',$id)
                      ->get('');
    return $query->row()->REST_NAME;
  }
  
  function get_username($id){
    $query = $this->db->select('USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->get('');
    return $query->row()->USERNAME;
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
  
}