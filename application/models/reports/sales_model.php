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
  
	function get_sales_report($start_date,$end_date,$rest_id){
	     $query = $this->db->query("-- ORDER LIST
                  SELECT  O.ID,
                  		O.ORDER_NUMBER ORDER_NUMBER, 
                  		T.TABLE_NUMBER TABLE_NUMBER,
                          O.STARTED,
                          O.ENDED,
                          O.NO_OF_GUEST,
                          ORDER_TYPE.VALUE ORDER_TYPE,
                  		O.TOTAL TOTAL_BILL,
                          O.DISCOUNT DISCOUNT,
                          O.TIP,
                          O.TOTAL_ROUNDING,
                  		O.DELIVERY_FEE,
                          O.SERVICE_CHARGE,
                          O.TOTAL_TAX,
                          O.PAID_AMOUNT,
                          U.NAME SERVER_NAME
                  FROM ORDERS O
                  	LEFT OUTER JOIN TABLES T 
                  		ON T.ID = O.TABLE_ID
                  	LEFT OUTER JOIN USERS U 
                  		ON U.ID = O.USER_ID
                  	LEFT OUTER JOIN REF_VALUES ORDER_TYPE
                  		ON ORDER_TYPE.CODE = O.ORDER_TYPE
                          AND ORDER_TYPE.LOOKUP_NAME = 'ORDER_TYPE'
                  		AND ORDER_TYPE.IS_ACTIVE = 1
                  	WHERE O.ACTIVE = 0
                      AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                      AND O.VOID = 0
                      AND O.REST_ID = ".$rest_id.";");
		    return $query->result();
	}
  
	function get_sales_report0($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT O.ID, O.ORDER_NUMBER ORDER_NUMBER, 
                                    T.TABLE_NUMBER TABLE_NUMBER, C.NAME CUSTOMER_NAME,
                                    O.STARTED, O.ENDED, O.NO_OF_GUEST,
		                                O.TOTAL TOTAL_BILL, O.PAYMENT_METHOD	PAYMENT_METHOD, O.TIP,
		                                O.DISCOUNT DISCOUNT, O.SERVICE_CHARGE, O.TOTAL_TAX,
                                    O.PAID_AMOUNT
                                  FROM ORDERS O
                                  LEFT OUTER JOIN TABLES T ON T.ID = O.TABLE_ID
                                  LEFT OUTER JOIN CUSTOMERS C ON C.ID = O.CUSTOMER_ID
                                  LEFT OUTER JOIN RESTAURANTS R	ON R.ID = O.REST_ID	
                                  WHERE O.ACTIVE = 0
                                  AND O.ENDED BETWEEN "'.$start_date.'" AND DATE_ADD("'.$end_date.'", INTERVAL 1 DAY)
                                  AND R.ID = '.$rest_id.';');
		    return $query->result();
	}
  
  function get_order_details($inv_id)
	{
	     $query = $this->db->query("-- Order Detail List (Based on Invoice)
                  SELECT  OD.MENU_NAME,
                          OD.CATEGORY_NAME, 
                  		OD.KITCHEN_NOTE, 
                  		OD.QUANTITY,
                  		OD.PRICE, 
                          OD.TOTAL
                  	FROM ORDER_DETAILS OD
                  WHERE VOID = 0
                  AND INVOICE_ID = ".$inv_id.";");
		    return $query->result();
	}
  
  function get_order_details0($order_id){
	     $query = $this->db->query('SELECT OD.MENU_NAME, OD.CATEGORY_NAME, OD.KITCHEN_NOTE, 
                                		OD.QUANTITY, OD.PRICE, OD.TOTAL,
                                		OD.VOID, OD.VOID_REASON 
                                	FROM ORDER_DETAILS OD
                                  WHERE ORDER_ID = '.$order_id.';');
		    return $query->result();
	}
	
	function get_void_items($start_date,$end_date,$rest_id)
	{                                                                                                                                  
	     $query = $this->db->query("-- Void ORDERS 
                  SELECT	O.ID,
                  		O.ORDER_NUMBER ORDER_NUMBER, 
                  		T.TABLE_NUMBER TABLE_NUMBER,
                          O.STARTED,
                          O.ENDED,
                          O.NO_OF_GUEST,
                          ORDER_TYPE.VALUE ORDER_TYPE,
                  		O.TOTAL TOTAL_BILL,
                          O.DISCOUNT DISCOUNT,
                          O.TIP,
                          O.TOTAL_ROUNDING,
                  		O.DELIVERY_FEE,
                          O.SERVICE_CHARGE,
                          O.TOTAL_TAX,
                          O.PAID_AMOUNT
                  	FROM ORDERS O
                      LEFT OUTER JOIN TABLES T 
                  		ON T.ID = O.TABLE_ID
                  	LEFT OUTER JOIN RESTAURANTS R
                  		ON R.ID = O.REST_ID
                  	LEFT OUTER JOIN USERS U 
                  		ON U.ID = O.USER_ID
                  	LEFT OUTER JOIN REF_VALUES ORDER_TYPE
                  		ON ORDER_TYPE.CODE = O.ORDER_TYPE
                          AND ORDER_TYPE.LOOKUP_NAME = 'ORDER_TYPE'
                  		AND ORDER_TYPE.IS_ACTIVE = 1
                  WHERE O.VOID = 1
                  	AND O.ACTIVE = 0
                      AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                      AND O.REST_ID = ".$rest_id.";");
		    return $query->result();
	}
	
	function get_void_items0($start_date,$end_date,$rest_id)	{                                                                                                                                  
	     $query = $this->db->query('SELECT OD.MENU_NAME, OD.VOID_REASON, 
		                                O.ORDER_NUMBER, O.STARTED, O.ENDED
                                  FROM ORDER_DETAILS OD
                                  LEFT OUTER JOIN ORDERS O ON O.ID = OD.ORDER_ID
                                  WHERE OD.VOID = 1	AND O.ACTIVE = 0
                                  AND O.ENDED BETWEEN "'.$start_date.'" AND DATE_ADD("'.$end_date.'", INTERVAL 1 DAY)
                                  AND O.REST_ID = '.$rest_id.';');
		    return $query->result();
	}
	
}