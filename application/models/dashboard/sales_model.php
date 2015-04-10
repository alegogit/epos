<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends CI_Model {

  var $username   = '';
  var $password = '';
  var $date    = '';
  
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
  
  function get_logo_rest($restid=1){
		$this->db->where('ID',$restid); 
    $query = $this->db->select('LOGO_URL')
                      ->from('RESTAURANTS')
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
	
	function dash_top_categories($start_date,$end_date,$rest_id){  		
		$query = $this->db->query("SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
	                             FROM ORDER_DETAILS OD
                               LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
                               INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                               INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                               INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                                  AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                               GROUP BY OD.CATEGORY_NAME
                               UNION  
                               SELECT 'ADJUSTMENTS' CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
                          	   FROM ORDER_DETAILS OD
                               INNER JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID
                               INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                               INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                               INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                                  AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                ORDER BY AMOUNT DESC;");
		return $query->result();  
	}
  
  function remove_zero_values($array){
    $i = 0;
    foreach ($array as $row){    
      if($row->AMOUNT==0){
        unset($array[$i]);
      }
      $i++;
    } 
    return $array;
  }
  
  function get_top_five($array){
    $i = 0;
    foreach ($array as $row){    
      if($i>=5){
        unset($array[$i]);   
      }
      $i++;
    } 
    return $array;
  }  
    
  function set_as_others($array){
    $i = 0;
    $merge = array('AMOUNT' => 0, 'TOTAL' => 0);
    foreach ($array as $row){    
      if($i>=5){         
        if((strtolower($row->CAT_NAME)!="adjustments")){
          $merge['AMOUNT'] = $merge['AMOUNT'] + $row->AMOUNT;
          $merge['TOTAL'] = $merge['TOTAL'] + $row->TOTAL;
          $row->CAT_NAME = "others";   
          $row->AMOUNT = $merge['AMOUNT'];
          $row->TOTAL = $merge['TOTAL'];
        } else {    
          unset($array[$i]);
        }
      } else {  
        unset($array[$i]);
      }
      $i++;
    }              
    return $array;
  }
  
  function remove_others($array){  
    $i = 0; 
    foreach ($array as $row){
      if($i>=5){
        if(strtolower($row->CAT_NAME)!="adjustments"){ 
          unset($array[$i]);
        }
      } else {  
        unset($array[$i]);
      }
      $i++; 
    }  
    return $array;
  }
  
  function remove_other_others($array){
    $key = array_keys($array); 
    $i = $key[0];
    $n = count($array)+$i;
    foreach ($array as $row){    
      if($i<$n-1){  
        unset($array[$i]);
      }
      $i++;
    }
    return $array;
  }                 
	
	function dash_best_sellers($start_date,$end_date,$rest_id){    		
		$query = $this->db->query("SELECT OD.MENU_NAME AS ITEMS, IFNULL(SUM(OD.TOTAL),0) AMOUNT, COUNT(OD.MENU_NAME) AS QTY 
                              	FROM ORDER_DETAILS OD 
                                  INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                                  INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                              		AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                              		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                GROUP BY OD.MENU_NAME
                                ORDER BY SUM(OD.TOTAL) DESC
                                LIMIT 5;");
		return $query->result();  
	}        

	function dash_payment_method($start_date,$end_date,$rest_id){  		
		$query = $this->db->query("SELECT  R.VALUE AS PAYMENT_METHOD, IFNULL(SUM(O.TOTAL), 0) AMOUNT , IFNULL(COUNT(I.ID),0)  TOTAL 
                              	FROM INVOICES I
                              	INNER JOIN REF_VALUES R ON I.PAYMENT_METHOD = R.CODE
                              		AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
                                INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                              	WHERE O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                              		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	GROUP BY R.VALUE;");
		return $query->result();  
	}
  
	function dash_order_type($start_date,$end_date,$rest_id){  		
		$query = $this->db->query("SELECT R.VALUE AS ORDER_TYPE, IFNULL(ORDERS_GROUPED.AMOUNT, 0) AMOUNT, IFNULL(ORDERS_GROUPED.TOTAL, 0) TOTAL
                                FROM REF_VALUES R 
                                LEFT OUTER JOIN 
                                  (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.TOTAL), 0) AMOUNT, IFNULL(COUNT(O.ID),0)  TOTAL 
                                      FROM ORDERS O
                                      WHERE O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
                                      AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                      GROUP BY O.ORDER_TYPE
                                  ) ORDERS_GROUPED
                                ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
                                WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1;");
		return $query->result();  
	}
  
  function dash_monthly_revenue($rest_id)
	{
	     $query = $this->db->query("SELECT IFNULL(AMT,0) AS REVENUE, REC_MONTH FROM (
									    -- This month
									    SELECT SUM(TOTAL) AMT, DATE_FORMAT(NOW() ,'%Y-%m-01') REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()
												AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) A UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_MONTH FROM (
									    -- Last month
									    SELECT SUM(TOTAL) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 1 MONTH) REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 1 MONTH) AND SUBDATE(DATE_FORMAT(NOW() ,'%Y-%m-01'), 1)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) B UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_MONTH FROM (
									    -- 2 months ago 
									    SELECT SUM(TOTAL) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 2 MONTH) REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 2 MONTH) AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 1 MONTH), 1)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) C UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_MONTH FROM (
									    -- 3 months ago 
									    SELECT SUM(TOTAL) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 3 MONTH) REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 3 MONTH) AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 2 MONTH), 1)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
										) D UNION ALL
									        
									    SELECT IFNULL(AMT,0), REC_MONTH FROM (
									    -- 4 months ago 
									    SELECT SUM(TOTAL) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 4 MONTH) REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 4 MONTH) AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 3 MONTH), 1)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) E UNION ALL
									     
									    SELECT IFNULL(AMT,0), REC_MONTH FROM (
									    -- 5 months ago 
									    SELECT SUM(TOTAL) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 5 MONTH) REC_MONTH FROM ORDERS O
											WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 5 MONTH) AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-01') - INTERVAL 4 MONTH), 1)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) F 
          							ORDER BY REC_MONTH;");
		    return $query->result();  
	}
  
  function dash_weekly_revenue($rest_id)
	{
	     $query = $this->db->query("SELECT IFNULL(AMT,0) AS REVENUE, REC_WEEK FROM (
									    -- This Week
									    SELECT SUM(TOTAL) AMT, DATE_FORMAT(NOW() ,'%Y-%m-01') REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d') AND NOW()
												AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) A UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- Last week
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) AND 
																	DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d')
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) B UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 2 Weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) C UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 3 weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
										) D UNION ALL
									        
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 4 weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) E UNION ALL
									     
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 5 weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) F UNION ALL
										
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 6 weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) G UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 7 Weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) H UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 8 Weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) I UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 9 Weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) J UNION ALL
									    
									    SELECT IFNULL(AMT,0), REC_WEEK FROM (
									    -- 10 Weeks ago 
									    SELECT SUM(TOTAL) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) REC_WEEK FROM ORDERS O
											WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) AND 
																SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63)
									    		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
									    ) K
          							ORDER BY REC_WEEK;");
		    return $query->result();  
	}
			
   
	function no_stock($rest_id)
	{
	     $query = $this->db->query('SELECT NAME FROM INVENTORY WHERE REST_ID = '.$rest_id.' AND QUANTITY=0;');
	     return $query->result();  
	}

}