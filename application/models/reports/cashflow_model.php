<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_model extends CI_Model {
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
  	
	function get_cashflow0($rest_id,$startdate,$enddate)
	{
	    $query = $this->db->query("SELECT	R.NAME REST_NAME, D.NAME DEVICE_NAME,	SUM(PH.CASH_CLOSING - CASH_OPENING) CASH_FROM_REGISTER, 
		                                    CASH_FROM_ORDERS.TOTAL CASH_FROM_ORDER, 
                                        DEBIT_FROM_ORDERS.TOTAL DEBIT_FROM_ORDERS, CREDIT_FROM_ORDERS.TOTAL CREDIT_FROM_ORDERS, 
                                        DATE(PH.DATE) TERMINAL_DATE
	                               FROM DEVICES D
	                               INNER JOIN RESTAURANTS R	ON D.REST_ID = R.ID
	                               INNER JOIN PAYMENT_HISTORY PH ON PH.TERMINAL_ID = D.ID
	                               LEFT OUTER JOIN (
                                    SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL, TERMINAL_ID FROM ORDERS 
                                    WHERE PAYMENT_METHOD = 'CASH'
                                    GROUP BY TERMINAL_ID, DATE(STARTED)
                                 ) CASH_FROM_ORDERS	ON CASH_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE)
	                               LEFT OUTER JOIN (
                                		SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL,  TERMINAL_ID FROM ORDERS 
                                		WHERE PAYMENT_METHOD = 'CREDIT'
                                		GROUP BY TERMINAL_ID, DATE(STARTED)
                                 ) CREDIT_FROM_ORDERS	ON CREDIT_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE)
                                 LEFT OUTER JOIN (
                                		SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL,  TERMINAL_ID FROM ORDERS 
                                		WHERE PAYMENT_METHOD = 'DEBIT'
                                		GROUP BY TERMINAL_ID, DATE(STARTED)
                                 ) DEBIT_FROM_ORDERS ON DEBIT_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE)
                                 WHERE D.REGISTERED = 1 AND PH.DATE BETWEEN '".$startdate."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY) AND R.ID = ".$rest_id."
	                               GROUP BY D.ID;");
		    return $query->result();
	}
	
	function get_cashflow($rest_id,$startdate,$enddate)
	{
	    $query = $this->db->query("SELECT R.NAME REST_NAME, D.NAME DEVICE_NAME, 
										SUM(PH.CASH_CLOSING - CASH_OPENING) CASH_FROM_REGISTER, 
										CASH_FROM_ORDERS.TOTAL CASH_FROM_ORDER, 
        								DEBIT_FROM_ORDERS.TOTAL DEBIT_FROM_ORDERS,
										CREDIT_FROM_ORDERS.TOTAL CREDIT_FROM_ORDERS, 
        								DATE(PH.DATE) TERMINAL_DATE
									FROM DEVICES D
									INNER JOIN RESTAURANTS R ON D.REST_ID = R.ID
									LEFT OUTER JOIN PAYMENT_HISTORY PH ON PH.TERMINAL_ID = D.ID
									LEFT OUTER JOIN (
										SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL,  TERMINAL_ID FROM ORDERS 
										WHERE PAYMENT_METHOD = 'CASH'
										GROUP BY TERMINAL_ID, DATE(STARTED)
									) CASH_FROM_ORDERS ON CASH_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE) AND PH.TERMINAL_ID = D.ID
									LEFT OUTER JOIN (
										SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL,  TERMINAL_ID FROM ORDERS 
										WHERE PAYMENT_METHOD = 'CREDIT'
										GROUP BY TERMINAL_ID, DATE(STARTED)
								    ) CREDIT_FROM_ORDERS ON CREDIT_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE) AND PH.TERMINAL_ID = D.ID
								    LEFT OUTER JOIN (
										SELECT DATE(STARTED) ORDER_DATE, SUM(TOTAL) TOTAL,  TERMINAL_ID FROM ORDERS 
										WHERE PAYMENT_METHOD = 'DEBIT'
										GROUP BY TERMINAL_ID, DATE(STARTED)
								    ) DEBIT_FROM_ORDERS ON DEBIT_FROM_ORDERS.ORDER_DATE = DATE(PH.DATE) AND PH.TERMINAL_ID = D.ID
									WHERE D.REGISTERED = 1 AND PH.DATE BETWEEN '".$startdate."' AND DATE_ADD('".$enddate."', INTERVAL 1 DAY) AND R.ID = ".$rest_id."
									GROUP BY D.ID, DATE(PH.DATE);");
		    return $query->result();
	}	
	
	function inv_status_color($status){
    if ($status=="NONE"){
      $color = "#d9534f";
    } elseif ($status=="LOW"){ 
      $color = "#f0ad4e";
    } elseif ($status=="Not Moving"){ 
      $color = "#777";
    } else {
      $color = "#333";
    }
    return $color;
  }
  
	function inv_status_class($status){
    if ($status=="NONE"){
      $class = "danger";
    } elseif ($status=="LOW"){ 
      $class = "warning";
    } elseif ($status=="Not Moving"){ 
      $class = "active";
    } else {
      $class = "";
    }
    return $class;
  }
		
}