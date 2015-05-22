<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {
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
  
  function get_user_rest($id,$role=0){
		if($role!=1){   
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
    return $query->row();
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
  
  function get_restid_logo($id){
		$this->db->where('ID',$id); 
    $query = $this->db->select('LOGO_URL')
                      ->from('RESTAURANTS')
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
  	
	function get_payment($rest_id,$startdate,$enddate)
	{
	    $query = $this->db->query("SELECT 	
          -- R.ID										REST_ID,
      		-- R.NAME										REST_NAME,
          -- T.ID										TERMINAL_ID,
      		T.NAME 										TERMINAL_NAME,
      		CASH_FROM_INVOICES.TOTAL 					CASH_FROM_INVOICES, 
          DEBIT_FROM_INVOICES.TOTAL 					DEBIT_FROM_INVOICES,
      		CREDIT_FROM_INVOICES.TOTAL 					CREDIT_FROM_INVOICES, 
          IFNULL(CASH_FROM_INVOICES.TOTAL,0) +  IFNULL(DEBIT_FROM_INVOICES.TOTAL,0) + IFNULL(CREDIT_FROM_INVOICES.TOTAL,0) TOTAL,
          ALL_DATES.SELECTED_DATE					    TRAN_DATE
      	FROM TERMINAL T
      	INNER JOIN RESTAURANTS R 
      		ON T.REST_ID = R.ID
      	RIGHT JOIN 
      		(select selected_date from 
      			(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
      			 (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
      			 (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
      			 (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
      			 (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
      			 (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
      			where selected_date between '".$startdate."' AND DATE_ADD('".$enddate."', INTERVAL 1 DAY)
              AND selected_date < DATE_ADD('".$enddate."', INTERVAL 1 DAY)
              ) ALL_DATES
      	ON 1=1
      	LEFT OUTER JOIN (
      		SELECT DATE(O.STARTED) ORDER_DATE, SUM(I.PAID_AMOUNT) TOTAL,  I.TERMINAL_ID 
      			FROM INVOICES I
      			INNER JOIN INVOICES_ORDERS OI
      				ON OI.INVOICE_ID = I.ID
      			INNER JOIN ORDERS O 
      				ON O.ID = OI.ORDER_ID
      		WHERE I.PAYMENT_METHOD = 'CASH' AND O.ACTIVE = 0 AND O.VOID = 0
      		GROUP BY I.TERMINAL_ID, DATE(O.STARTED)
      	) CASH_FROM_INVOICES
      	ON CASH_FROM_INVOICES.TERMINAL_ID = T.ID AND ALL_DATES.SELECTED_DATE = CASH_FROM_INVOICES.ORDER_DATE
      	LEFT OUTER JOIN (
      		SELECT DATE(O.STARTED) ORDER_DATE, SUM(I.PAID_AMOUNT) TOTAL,  I.TERMINAL_ID 
      			FROM INVOICES I
      			INNER JOIN INVOICES_ORDERS OI
      				ON OI.INVOICE_ID = I.ID
      			INNER JOIN ORDERS O 
      				ON O.ID = OI.ORDER_ID
      		WHERE I.PAYMENT_METHOD = 'CREDIT' AND O.ACTIVE = 0 AND O.VOID = 0
      		GROUP BY I.TERMINAL_ID, DATE(O.STARTED)
      	) CREDIT_FROM_INVOICES
      	ON CREDIT_FROM_INVOICES.TERMINAL_ID = T.ID AND ALL_DATES.SELECTED_DATE = CREDIT_FROM_INVOICES.ORDER_DATE
          LEFT OUTER JOIN (
      		SELECT DATE(O.STARTED) ORDER_DATE, SUM(I.PAID_AMOUNT) TOTAL,  I.TERMINAL_ID 
      			FROM INVOICES I
      			INNER JOIN INVOICES_ORDERS OI
      				ON OI.INVOICE_ID = I.ID
      			INNER JOIN ORDERS O 
      				ON O.ID = OI.ORDER_ID
      		WHERE I.PAYMENT_METHOD = 'DEBIT' AND O.ACTIVE = 0 AND O.VOID = 0
      		GROUP BY I.TERMINAL_ID, DATE(O.STARTED)
      	) DEBIT_FROM_INVOICES
      	ON DEBIT_FROM_INVOICES.TERMINAL_ID = T.ID AND ALL_DATES.SELECTED_DATE = DEBIT_FROM_INVOICES.ORDER_DATE
      WHERE T.REGISTERED = 1
      	AND R.ID = ".$rest_id."
      GROUP BY T.ID, ALL_DATES.SELECTED_DATE;");
		    return $query->result();
	}
		
}