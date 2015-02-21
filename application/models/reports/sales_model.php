<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends CI_Model {
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
    $query = $this->db->select('USERNAME')
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
	function get_sales_report($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT O.ID, O.ORDER_NUMBER ORDER_NUMBER, 
            T.TABLE_NUMBER TABLE_NUMBER,
            C.NAME CUSTOMER_NAME,
            O.STARTED, O.ENDED, O.NO_OF_GUEST, O.TOTAL, O.TIP, (O.DISCOUNT*O.TOTAL)/100 DISCOUNT, O.PAID_AMOUNT
          FROM ORDERS O
            LEFT OUTER JOIN TABLES T ON T.ID = O.TABLE_ID
            LEFT OUTER JOIN CUSTOMERS C ON C.ID = O.CUSTOMER_ID
            LEFT OUTER JOIN RESTAURANTS R ON R.ID = O.REST_ID
          WHERE O.ACTIVE = 0
            AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
            AND R.ID = '.$rest_id.';');
		    return $query->result();
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
	
	function get_void_items($start_date,$end_date,$rest_id)
	{                                                                                                                                  
	     $query = $this->db->query('SELECT M.NAME, 
		      OD.VOID_REASON, 
		      O.ORDER_NUMBER,	O.STARTED, O.ENDED
	      FROM ORDER_DETAILS OD
	        LEFT OUTER JOIN ORDERS O ON O.ID = OD.ORDER_ID
	        LEFT OUTER JOIN MENU M ON M.ID = OD.MENU_ID
        WHERE OD.VOID = 1
	        AND O.ACTIVE = 0
          AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
          AND O.REST_ID = '.$rest_id.';');
		    return $query->result();
	}
	
}