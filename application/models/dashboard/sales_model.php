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
	
	function total_sales_today($rest_id){
		//$query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS RES FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID ='.$rest_id.';');
		$query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS RES FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE =0;');
		return $query->row();
	}

	function percentage_increase_from_yesterday($rest_id){
	     /*
		 $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID ='.$rest_id.')
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SUBDATE(SYSDATE(),1)) AND REST_ID ='.$rest_id.')
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
			FROM DUAL;');
		*/
		$query = $this->db->query('SELECT
										IFNULL((((
											(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE =0)
											/ 
											(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) 
																					AND (DATE(ENDED) < DATE(SUBDATE(SYSDATE(),1))) 
																					AND REST_ID = '.$rest_id.' AND ACTIVE =0)
										) -1 ) *100 ) ,0)
										AS PERCENTAGE
									FROM DUAL;');
		 
          return $query->row();
	}

	function num_transactions_today($rest_id){
	     //$query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS RES FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = '.$rest_id.';')
	     $query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS RES FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE =0;');
		 return $query->row();
	}
     
	function percentage_increase_from_last_week($rest_id){
		/*
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = '.$rest_id.')
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) 
														AND (DATE(ENDED) < DATE(SUBDATE(SYSDATE(),7))) 
														AND REST_ID = '.$rest_id.')
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
			FROM DUAL;');  
		*/
		$query = $this->db->query('SELECT
										IFNULL((((
											(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE =0)
											/ 
											(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) 
																					AND (DATE(ENDED) < DATE(SUBDATE(SYSDATE(),7))) 
																					AND REST_ID = '.$rest_id.' AND ACTIVE =0)
										) -1 ) *100 ) ,0)
										AS PERCENTAGE
									FROM DUAL ');  
		return $query->row();
	}
	
	function total_sales_this_year($rest_id){
		//$query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS RES FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID ='.$rest_id.'');
		$query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS RES FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE = 0;');
		return $query->row();
	}
	
	function percentage_increase_this_year($rest_id){                                                                   
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = '.$rest_id.')
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) AND (
						DATE(ENDED) < GREATEST(DATE_FORMAT(NOW() ,"%Y-01-01"), DATE_SUB(SYSDATE(), INTERVAL 6 MONTH))
                        ) AND
                        REST_ID = '.$rest_id.')
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
		FROM DUAL;');
		//return $query->result();  
          return $query->row();
	}
	
	function num_transactions_this_year($rest_id){
		//$query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS RES FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID ='.$rest_id.';');
		$query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS RES  FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = '.$rest_id.' AND ACTIVE = 0;');
		return $query->row();
	}
	     
	function num_customers_30day($rest_id){
		$query = $this->db->query('SELECT COUNT(C.ID) AS RES 
        							FROM CUSTOMERS C
									INNER JOIN ORDERS O ON O.CUSTOMER_ID = C.ID
            						WHERE O.REST_ID = '.$rest_id.'
									AND O.ENDED > SUBDATE(SYSDATE(), 30);');
		return $query->row();
	}
	
	function dash_top_categories($start_date,$end_date,$rest_id){
		/*
		$query = $this->db->query('SELECT C.NAME CAT_NAME, IFNULL(SUM(OD.PRICE*OD.QUANTITY),0) AMOUNT FROM ORDER_DETAILS OD 
									INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
						          	AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
						          	AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
						          	INNER JOIN MENU M ON M.ID = OD.MENU_ID
						          	INNER JOIN CATEGORY C ON C.ID = M.CATEGORY_ID
						          	GROUP BY C.NAME
						          	ORDER BY AMOUNT DESC
						          	LIMIT 5;');
		*/
		$query = $this->db->query('SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT
									FROM ORDER_DETAILS OD
									INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
									AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
									AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
									GROUP BY OD.CATEGORY_NAME
									ORDER BY AMOUNT DESC
									LIMIT 5;');
		return $query->result();  
        //return $query->row();
	}
	
	function dash_best_sellers($start_date,$end_date,$rest_id){
		/*
		$query = $this->db->query('SELECT M.NAME AS ITEMS, IFNULL(SUM(OD.PRICE*QUANTITY),0) AMOUNT, COUNT(M.NAME) AS QTY FROM ORDER_DETAILS OD 
	        INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
		      AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
		      AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
	        INNER JOIN MENU M ON M.ID = OD.MENU_ID
          GROUP BY M.NAME
          ORDER BY SUM(OD.PRICE*QUANTITY) DESC
          LIMIT 5;');
		  */
		$query = $this->db->query('SELECT OD.MENU_NAME AS ITEMS, IFNULL(SUM(OD.TOTAL),0) AMOUNT, COUNT(OD.MENU_NAME) AS QTY 
									FROM ORDER_DETAILS OD 
									INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
									AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
									AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
									GROUP BY OD.MENU_NAME
									ORDER BY SUM(OD.TOTAL) DESC
									LIMIT 5;');
		return $query->result();  
        //return $query->row();
	}

	
	function dash_payment_method($start_date,$end_date,$rest_id){
		/*
		$query = $this->db->query('SELECT R.CODE, R.VALUE AS PAYMENT_METHOD, IFNULL(PAYMENT.AMOUNT, 0) AS AMOUNT FROM REF_VALUES R 
	        LEFT OUTER JOIN  (
		        SELECT PAYMENT_METHOD, IFNULL(SUM(PAID_AMOUNT),0) AMOUNT FROM ORDERS
		        WHERE ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
		        AND REST_ID = '.$rest_id.' AND ACTIVE = 0
		        GROUP BY PAYMENT_METHOD
          ) PAYMENT ON PAYMENT.PAYMENT_METHOD = R.CODE
          WHERE R.LOOKUP_NAME = "PAYMENT_METHOD" AND R.IS_ACTIVE = 1;');
		*/
		$query = $this->db->query('SELECT  R.VALUE AS PAYMENT_METHOD, IFNULL(SUM(O.TOTAL), 0) AMOUNT 
									FROM ORDERS O
									LEFT OUTER JOIN REF_VALUES R ON O.PAYMENT_METHOD = R.CODE
									WHERE R.LOOKUP_NAME = "PAYMENT_METHOD" AND R.IS_ACTIVE = 1
									AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
									AND REST_ID = '.$rest_id.' AND ACTIVE = 0
									GROUP BY R.VALUE;');
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