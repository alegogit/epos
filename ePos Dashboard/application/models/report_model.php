<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {
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
  
	function get_sales_report($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT O.ID, O.ORDER_NUMBER ORDER_NUMBER, 
          T.TABLE_NUMBER TABLE_NUMBER,
          C.NAME CUSTOMER_NAME,
          O.STARTED, O.ENDED, O.NO_OF_GUEST, O.TOTAL, O.TIP, (O.DISCOUNT*O.TOTAL)/100 DISCOUNT, O.PAID_AMOUNT
          FROM ORDERS O
          LEFT OUTER JOIN TABLES T ON T.ID = O.TABLE_NUMBER
          LEFT OUTER JOIN CUSTOMERS C ON C.ID = O.CUSTOMER_ID
          LEFT OUTER JOIN RESTAURANTS R ON R.ID = O.REST_ID
          WHERE O.ACTIVE = 0
          AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
          AND R.ID = '.$rest_id.';');
		    return $query->result();
        //return $query->row();
	}
	
	function dash_best_sellers($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT M.NAME AS ITEMS, IFNULL(SUM(OD.PRICE*QUANTITY),0) AMOUNT, COUNT(M.NAME) AS QTY FROM ORDER_DETAILS OD 
	        INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
		      AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
		      AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
	        INNER JOIN MENU M ON M.ID = OD.MENU_ID
          GROUP BY M.NAME
          ORDER BY SUM(OD.PRICE*QUANTITY) DESC
          LIMIT 5;');
		    return $query->result();  
        //return $query->row();
	}
	
}