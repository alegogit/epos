<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monthly_model extends CI_Model {
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
  
	function get_revenue($rest_id,$enddate){ 
    $query = $this->db->query("-- Coloumn 1 Top: Revenue Numbers
      SELECT  
      		SUM(TOTAL_THIS_MONTH) 					TOTAL_THIS_MONTH,
      		SUM(TOTAL_LAST_MONTH)					TOTAL_LAST_MONTH,
      		SUM(DISCOUNT_THIS_MONTH) 				DISCOUNT_THIS_MONTH,
      		SUM(DISCOUNT_LAST_MONTH)	 			DISCOUNT_LAST_MONTH,
      		SUM(NET_SALES_THIS_MONTH) 				NET_SALES_THIS_MONTH,
      		SUM(NET_SALES_LAST_MONTH)				NET_SALES_LAST_MONTH,
      		SUM(SERVICE_CHARGE_THIS_MONTH)			SERVICE_CHARGE_THIS_MONTH,
      		SUM(SERVICE_CHARGE_LAST_MONTH)			SERVICE_CHARGE_LAST_MONTH,
      		SUM(TOTAL_TAX_THIS_MONTH)				TOTAL_TAX_THIS_MONTH,
      		SUM(TOTAL_TAX_LAST_MONTH)				TOTAL_TAX_LAST_MONTH,
      		SUM(TIP_THIS_MONTH)						TIP_THIS_MONTH,
      		SUM(TIP_LAST_MONTH)						TIP_LAST_MONTH,
      		SUM(ROUNDING_THIS_MONTH)				ROUNDING_THIS_MONTH,
      		SUM(ROUNDING_LAST_MONTH)				ROUNDING_LAST_MONTH,
      		SUM(TOTAL_SALES_THIS_MONTH)				TOTAL_SALES_THIS_MONTH,
      		SUM(TOTAL_SALES_LAST_MONTH)				TOTAL_SALES_LAST_MONTH
      	FROM
      (
      	-- This Month
      	SELECT  
      		SUM(TOTAL) 								TOTAL_THIS_MONTH,
      		0 										TOTAL_LAST_MONTH,
      		SUM(DISCOUNT) 							DISCOUNT_THIS_MONTH,
      		0	 									DISCOUNT_LAST_MONTH,
      		SUM(TOTAL) - SUM(DISCOUNT) 				NET_SALES_THIS_MONTH,
      		0										NET_SALES_LAST_MONTH,
      		SUM(SERVICE_CHARGE)						SERVICE_CHARGE_THIS_MONTH,
      		0										SERVICE_CHARGE_LAST_MONTH,
      		SUM(TOTAL_TAX)							TOTAL_TAX_THIS_MONTH,
      		0										TOTAL_TAX_LAST_MONTH,
      		SUM(TIP)								TIP_THIS_MONTH,
      		0										TIP_LAST_MONTH,
      		SUM(TOTAL_ROUNDING)						ROUNDING_THIS_MONTH,
      		0										ROUNDING_LAST_MONTH,
      		SUM(PAID_AMOUNT)						TOTAL_SALES_THIS_MONTH,
      		0										TOTAL_SALES_LAST_MONTH
      	 FROM ORDERS
      	 WHERE REST_ID = ".$rest_id." AND VOID = 0
      		AND STARTED BETWEEN DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      					DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY)
      	 UNION
      	 -- Last Month
           SELECT  
      		0		 								TOTAL_THIS_MONTH,
      		SUM(TOTAL) 								TOTAL_LAST_MONTH,
      		0			 							DISCOUNT_THIS_MONTH,
      		SUM(DISCOUNT)	 						DISCOUNT_LAST_MONTH,
      		0										NET_SALES_THIS_MONTH,
      		SUM(TOTAL) - SUM(DISCOUNT) 				NET_SALES_LAST_MONTH,
      		0										SERVICE_CHARGE_THIS_MONTH,
      		SUM(SERVICE_CHARGE)						SERVICE_CHARGE_LAST_MONTH,
      		0										TOTAL_TAX_THIS_MONTH,
      		SUM(TOTAL_TAX)							TOTAL_TAX_LAST_MONTH,
      		0										TIP_THIS_MONTH,
      		SUM(TIP)								TIP_LAST_MONTH,
      		0										ROUNDING_THIS_MONTH,
      		SUM(TOTAL_ROUNDING)						ROUNDING_LAST_MONTH,
      		0										TOTAL_SALES_THIS_MONTH,
      		SUM(PAID_AMOUNT)						TOTAL_SALES_LAST_MONTH
      	 FROM ORDERS
      	 WHERE REST_ID = ".$rest_id." AND VOID = 0
           AND STARTED BETWEEN
      		DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      		DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      ) MONTH_SALES_DATA;");
		return $query->row();
	}
  
  function get_summary($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 1 : Summary
      SELECT  
      	SUM(TOTAL_SALES_THIS_MONTH)					TOTAL_SALES_THIS_MONTH,
      	SUM(TOTAL_SALES_LAST_MONTH)					TOTAL_SALES_LAST_MONTH,	
      	SUM(TOTAL_CUSTOMERS_THIS_MONTH)				TOTAL_CUSTOMERS_THIS_MONTH,
      	SUM(TOTAL_CUSTOMERS_LAST_MONTH)				TOTAL_CUSTOMERS_LAST_MONTH,
      	SUM(TOTAL_INVOICE_THIS_MONTH)				TOTAL_INVOICE_THIS_MONTH,
      	SUM(TOTAL_INVOICE_LAST_MONTH)				TOTAL_INVOICE_LAST_MONTH,
      	SUM(AVG_SALES_PER_CUST_THIS_MONTH)			AVG_SALES_PER_CUST_THIS_MONTH,
      	SUM(AVG_SALES_PER_CUST_LAST_MONTH)			AVG_SALES_PER_CUST_LAST_MONTH,
      	SUM(AVG_SALES_PER_INVOICE_THIS_MONTH)		AVG_SALES_PER_INVOICE_THIS_MONTH,
      	SUM(AVG_SALES_PER_INVOICE_LAST_MONTH)		AVG_SALES_PER_INVOICE_LAST_MONTH
          FROM
      	(
      		SELECT  
      			SUM(PAID_AMOUNT)							TOTAL_SALES_THIS_MONTH,
      			0											TOTAL_SALES_LAST_MONTH,	
      			SUM(NO_OF_GUEST)							TOTAL_CUSTOMERS_THIS_MONTH,
      			0											TOTAL_CUSTOMERS_LAST_MONTH,
      			SUM(INVOICE_BY_ORDERS.INVOICES)				TOTAL_INVOICE_THIS_MONTH,
      			0											TOTAL_INVOICE_LAST_MONTH,
      			ROUND(SUM(PAID_AMOUNT) 
      				/ SUM(NO_OF_GUEST),0)					AVG_SALES_PER_CUST_THIS_MONTH,
      			0											AVG_SALES_PER_CUST_LAST_MONTH,
      			ROUND(SUM(PAID_AMOUNT)
      				/ SUM(INVOICE_BY_ORDERS.INVOICES), 0)	AVG_SALES_PER_INVOICE_THIS_MONTH,
      			0											AVG_SALES_PER_INVOICE_LAST_MONTH
      		 FROM ORDERS O
      			INNER JOIN (
      				SELECT ORDER_ID, COUNT(INVOICE_ID) INVOICES FROM ORDERS INNER JOIN INVOICES_ORDERS ON ORDERS.ID = INVOICES_ORDERS.ORDER_ID 
      						 WHERE ORDERS.STARTED BETWEEN 
      							DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      							DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY)
      						GROUP BY INVOICES_ORDERS.ORDER_ID
      			) INVOICE_BY_ORDERS
      			ON O.ID = INVOICE_BY_ORDERS.ORDER_ID
      		 WHERE REST_ID = ".$rest_id." AND VOID = 0 
      		 AND STARTED BETWEEN
      				DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      				DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
      	UNION
      		 SELECT  
      			0											TOTAL_SALES_THIS_MONTH,
      			SUM(PAID_AMOUNT)							TOTAL_SALES_LAST_MONTH,	
      			0											TOTAL_CUSTOMERS_THIS_MONTH,
      			SUM(NO_OF_GUEST)							TOTAL_CUSTOMERS_LAST_MONTH,
      			0											TOTAL_INVOICE_THIS_MONTH,
      			SUM(INVOICE_BY_ORDERS.INVOICES)				TOTAL_INVOICE_LAST_MONTH,
      			0											AVG_SALES_PER_CUST_THIS_MONTH,
      			ROUND(SUM(PAID_AMOUNT)
      				/ SUM(NO_OF_GUEST),0)					AVG_SALES_PER_CUST_LAST_MONTH,
      			0											AVG_SALES_PER_INVOICE_THIS_MONTH,
      			ROUND(SUM(PAID_AMOUNT) 
      				/ SUM(INVOICE_BY_ORDERS.INVOICES), 0)	AVG_SALES_PER_INVOICE_LAST_MONTH
      		 FROM ORDERS O
      			INNER JOIN (
      				SELECT ORDER_ID, COUNT(INVOICE_ID) INVOICES FROM ORDERS INNER JOIN INVOICES_ORDERS ON ORDERS.ID = INVOICES_ORDERS.ORDER_ID 
      						 WHERE ORDERS.STARTED BETWEEN 
      							DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      							DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      						GROUP BY INVOICES_ORDERS.ORDER_ID
      			) INVOICE_BY_ORDERS
      			ON O.ID = INVOICE_BY_ORDERS.ORDER_ID
      		 WHERE REST_ID = ".$rest_id." AND VOID = 0 
      		 AND STARTED BETWEEN
      				DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      				DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      	) MONTHLY_SUMMARY;");
		return $query->row();
	}
  
  function get_payment0($rest_id,$enddate){
	  $query = $this->db->query("-- Column 2: Top :Payment Type
      SELECT 
      	PAYMENT_METHOD							PAYMENT_METHOD,
      	SUM(AMOUNT_THIS_MONTH)					AMOUNT_THIS_MONTH,
          SUM(AMOUNT_LAST_MONTH)					AMOUNT_LAST_MONTH,
          SUM(TOTAL_THIS_MONTH)					TOTAL_THIS_MONTH,
          SUM(TOTAL_LAST_MONTH)					TOTAL_LAST_MONTH
      	FROM (
      		SELECT  R.VALUE 											PAYMENT_METHOD,
      		  IFNULL(SUM(O.PAID_AMOUNT), 0) 							AMOUNT_THIS_MONTH,
                0															AMOUNT_LAST_MONTH,
                IFNULL(COUNT(I.ID),0)  									TOTAL_THIS_MONTH,
                0															TOTAL_LAST_MONTH
      		FROM INVOICES I
      		INNER JOIN REF_VALUES R 
      				ON I.PAYMENT_METHOD = R.CODE
      				AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
      		INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      		INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		WHERE STARTED BETWEEN
      				DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      				DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
      			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
      		GROUP BY R.VALUE
      		UNION
      		SELECT  R.VALUE 											PAYMENT_METHOD,
      			0 														AMOUNT_THIS_MONTH,
      		  IFNULL(SUM(O.PAID_AMOUNT), 0) 							AMOUNT_LAST_MONTH, 
                0															TOTAL_THIS_MONTH,
                IFNULL(COUNT(I.ID),0)  									TOTAL_LAST_MONTH
      		FROM INVOICES I
      		INNER JOIN REF_VALUES R 
      				ON I.PAYMENT_METHOD = R.CODE
      				AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
      		INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      		INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		WHERE STARTED BETWEEN
      				DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      				DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
      		GROUP BY R.VALUE
              ) PAYMENT_TYPE
      	GROUP BY PAYMENT_METHOD
    ORDER BY AMOUNT_THIS_MONTH DESC;");
		return $query->result();
	}   
          
  function get_payment($rest_id,$enddate){
	  $query = $this->db->query("-- Column 2: Top :Payment Type
        SELECT 
        	PAYMENT_METHOD							PAYMENT_METHOD,
        	IFNULL(SUM(AMOUNT_THIS_MONTH),0)		AMOUNT_THIS_MONTH,
            IFNULL(SUM(AMOUNT_LAST_MONTH),0)		AMOUNT_LAST_MONTH,
            IFNULL(SUM(TOTAL_THIS_MONTH),0)			TOTAL_THIS_MONTH,
            IFNULL(SUM(TOTAL_LAST_MONTH),0)			TOTAL_LAST_MONTH
        	FROM (
        		SELECT  R.VALUE 											PAYMENT_METHOD,
        		  IFNULL(PAYMENTS_GROUPED.AMOUNT, 0) 						AMOUNT_THIS_MONTH,
                  0															AMOUNT_LAST_MONTH,
                  IFNULL(PAYMENTS_GROUPED.TOTAL,0)  						TOTAL_THIS_MONTH,
                  0															TOTAL_LAST_MONTH
        		FROM REF_VALUES R
        		LEFT OUTER JOIN (
        			SELECT I.PAYMENT_METHOD, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(I.ID),0)  TOTAL 
        				FROM INVOICES I
        					INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
        					INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                        WHERE O.ENDED BETWEEN 
        					DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
        					DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
        				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
        			GROUP BY I.PAYMENT_METHOD
        			)PAYMENTS_GROUPED
        			ON PAYMENTS_GROUPED.PAYMENT_METHOD = R.CODE  
        		WHERE R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
        		UNION
        		SELECT  R.VALUE 											PAYMENT_METHOD,
        		  0 														AMOUNT_THIS_MONTH,
        		  IFNULL(PAYMENTS_GROUPED.AMOUNT, 0)  						AMOUNT_LAST_MONTH, 
                  0															TOTAL_THIS_MONTH,
                  IFNULL(PAYMENTS_GROUPED.TOTAL,0)  	 					TOTAL_LAST_MONTH
                FROM REF_VALUES R
        			LEFT OUTER JOIN (
        			SELECT I.PAYMENT_METHOD, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(I.ID),0)  TOTAL 
        				FROM INVOICES I
        					INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
        					INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
                        WHERE O.ENDED BETWEEN 
        					DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
        					DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
        				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
        			GROUP BY I.PAYMENT_METHOD
        			)PAYMENTS_GROUPED
        			ON PAYMENTS_GROUPED.PAYMENT_METHOD = R.CODE  
        		WHERE R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
                ) PAYMENT_TYPE
        	GROUP BY PAYMENT_METHOD
          ORDER BY AMOUNT_THIS_MONTH DESC;");
		return $query->result();
	}           
  
  function get_paymethods(){ 
    $query = $this->db->select('VALUE AS PAYMENT_METHOD')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME','PAYMENT_METHOD')
                      ->where('IS_ACTIVE',1)
                      ->get('');
    return $query->result();
  }
  
  function get_ordtype($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Middle: Sales Type - DINEIN, TakeOUT, Delivery  - display number, percent, dollar, sales
       SELECT
      	ORDER_TYPE								ORDER_TYPE,
          SUM(AMOUNT_THIS_MONTH)					AMOUNT_THIS_MONTH,
          SUM(AMOUNT_LAST_MONTH)					AMOUNT_LAST_MONTH,
          SUM(TOTAL_THIS_MONTH)					TOTAL_THIS_MONTH,
          SUM(TOTAL_LAST_MONTH)					TOTAL_LAST_MONTH
          FROM
       (
       -- This month
       SELECT  R.VALUE 													ORDER_TYPE, 
      		ORDERS_GROUPED.AMOUNT										AMOUNT_THIS_MONTH, 
              0															AMOUNT_LAST_MONTH,
      		ORDERS_GROUPED.TOTAL										TOTAL_THIS_MONTH,
              0															TOTAL_LAST_MONTH
      	FROM REF_VALUES R 
      		LEFT OUTER JOIN 
              (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0)  TOTAL 
      				FROM ORDERS O
                      WHERE STARTED BETWEEN
      					DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      					DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
      				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
      			GROUP BY O.ORDER_TYPE
              )ORDERS_GROUPED
              ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
          WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1
      UNION
       -- Last month
       SELECT  R.VALUE 													ORDER_TYPE, 
      		0															AMOUNT_THIS_MONTH, 
              ORDERS_GROUPED.AMOUNT										AMOUNT_LAST_MONTH,
      		0															TOTAL_THIS_MONTH,
              ORDERS_GROUPED.TOTAL										TOTAL_LAST_MONTH
      	FROM REF_VALUES R 
      		LEFT OUTER JOIN 
              (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0)  TOTAL 
      				FROM ORDERS O
                      WHERE STARTED BETWEEN
      					DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      					DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
      			GROUP BY O.ORDER_TYPE
              )ORDERS_GROUPED
              ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
          WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1
          )SALES_TYPE
      GROUP BY ORDER_TYPE
    ORDER BY AMOUNT_THIS_MONTH DESC;");
    		return $query->result();
    	}
    	
	function get_topcat($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Bottom: Top Category By Sales
       SELECT
      	CAT_NAME					CAT_NAME,
      	SUM(AMOUNT_THIS_MONTH)		AMOUNT_THIS_MONTH,
      	SUM(AMOUNT_LAST_MONTH)		AMOUNT_LAST_MONTH,
      	SUM(TOTAL_THIS_MONTH)		TOTAL_THIS_MONTH,
      	SUM(TOTAL_LAST_MONTH)		TOTAL_LAST_MONTH
       FROM
      	(
      		SELECT 
      			CAT_NAME		CAT_NAME,
                  SUM(AMOUNT)		AMOUNT_THIS_MONTH,
                  0				AMOUNT_LAST_MONTH,
                  SUM(TOTAL)		TOTAL_THIS_MONTH,
                  0				TOTAL_LAST_MONTH
      		FROM(
      			 SELECT OD.CATEGORY_NAME CAT_NAME, 
      					IFNULL(SUM(OD.TOTAL),0)  AMOUNT, 
      					IFNULL(COUNT(OD.ID),0)  TOTAL 
      				FROM ORDER_DETAILS OD
      				LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
      				INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
      				INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      				INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      					AND STARTED BETWEEN
      						DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      						DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
      					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
      			GROUP BY OD.CATEGORY_NAME
      			) THIS_MONTH
                  GROUP BY CAT_NAME
              UNION ALL
      		SELECT 
      			CAT_NAME		CAT_NAME,
      			0				AMOUNT_THIS_MONTH,
      			SUM(AMOUNT)		AMOUNT_LAST_MONTH,
                  0				TOTAL_THIS_MONTH,
                  SUM(TOTAL)		TOTAL_LAST_MONTH
      		FROM(
      			 SELECT OD.CATEGORY_NAME CAT_NAME, 
      					IFNULL(SUM(OD.TOTAL),0)  AMOUNT, 
      					IFNULL(COUNT(OD.ID),0)  TOTAL 
      				FROM ORDER_DETAILS OD
      				LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
      				INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
      				INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      				INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      					AND STARTED BETWEEN
      						DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      						DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
      			GROUP BY OD.CATEGORY_NAME
      			) LAST_MONTH
                   GROUP BY CAT_NAME
      	) CAT_VALUES
          GROUP BY CAT_NAME
    ORDER BY AMOUNT_THIS_MONTH DESC;");
		return $query->result();
	}          
  
  function remove_zero_values($array,$opt=1){
    $i = 0;
    foreach ($array as $row){
    if($opt==1){    
      if($row->AMOUNT_THIS_MONTH==0){
        unset($array[$i]);
      }
    } else {   
      if($row->AMOUNT_LAST_MONTH==0){
        unset($array[$i]);
      }
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
    
  function set_as_others($array,$opt=1){
    $i = 0;     
    if($opt==1){    
      $merge = array('AMOUNT_THIS_MONTH' => 0, 'TOTAL_THIS_MONTH' => 0);
      foreach ($array as $row){    
        if($i>=5){         
          if((strtolower($row->CAT_NAME)!="adjustments")){
            $merge['AMOUNT_THIS_MONTH'] = $merge['AMOUNT_THIS_MONTH'] + $row->AMOUNT_THIS_MONTH;
            $merge['TOTAL_THIS_MONTH'] = $merge['TOTAL_THIS_MONTH'] + $row->TOTAL_THIS_MONTH;
            $row->CAT_NAME = "others";   
            $row->AMOUNT_THIS_MONTH = $merge['AMOUNT_THIS_MONTH'];
            $row->TOTAL_THIS_MONTH = $merge['TOTAL_THIS_MONTH'];
          } else {    
            unset($array[$i]);
          }
        } else {  
          unset($array[$i]);
        }
        $i++;
      }
    } else {         
      $merge = array('AMOUNT_LAST_MONTH' => 0, 'TOTAL_LAST_MONTH' => 0);
      foreach ($array as $row){    
        if($i>=5){         
          if((strtolower($row->CAT_NAME)!="adjustments")){
            $merge['AMOUNT_LAST_MONTH'] = $merge['AMOUNT_LAST_MONTH'] + $row->AMOUNT_LAST_MONTH;
            $merge['TOTAL_LAST_MONTH'] = $merge['TOTAL_LAST_MONTH'] + $row->TOTAL_LAST_MONTH;
            $row->CAT_NAME = "others";   
            $row->AMOUNT_LAST_MONTH = $merge['AMOUNT_LAST_MONTH'];
            $row->TOTAL_LAST_MONTH = $merge['TOTAL_LAST_MONTH'];
          } else {    
            unset($array[$i]);
          }
        } else {  
          unset($array[$i]);
        }
        $i++;
      }
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
    $i = @$key[0];
    $n = count($array)+$i;
    foreach ($array as $row){    
      if($i<$n-1){  
        unset($array[$i]);
      }
      $i++;
    }
    return $array;
  }  
	
	function get_adjust($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Bottom: Top Category By Sales
       SELECT
      	CAT_NAME					CAT_NAME,
      	SUM(AMOUNT_THIS_MONTH)		AMOUNT_THIS_MONTH,
      	SUM(AMOUNT_LAST_MONTH)		AMOUNT_LAST_MONTH,
      	SUM(TOTAL_THIS_MONTH)		TOTAL_THIS_MONTH,
      	SUM(TOTAL_LAST_MONTH)		TOTAL_LAST_MONTH
       FROM
      	(
      		SELECT 
      			CAT_NAME		CAT_NAME,
                  SUM(AMOUNT)		AMOUNT_THIS_MONTH,
                  0				AMOUNT_LAST_MONTH,
                  SUM(TOTAL)		TOTAL_THIS_MONTH,
                  0				TOTAL_LAST_MONTH
      		FROM(
      				SELECT 'ADJUSTMENTS' CAT_NAME, 
      					IFNULL(SUM(OD.TOTAL),0)  AMOUNT, 
      					IFNULL(COUNT(OD.ID),0)  TOTAL 
      				FROM ORDER_DETAILS OD
      				INNER JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID
      				INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
      				INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      				INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      					AND STARTED BETWEEN
      						DATE_FORMAT('".$enddate."' ,'%Y-%m-01') AND 
      						DATE_SUB(DATE_ADD(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH), INTERVAL 1 DAY) 
      					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
      			) THIS_MONTH
                  GROUP BY CAT_NAME
              UNION ALL
      		SELECT 
      			CAT_NAME		CAT_NAME,
      			0				AMOUNT_THIS_MONTH,
      			SUM(AMOUNT)		AMOUNT_LAST_MONTH,
                  0				TOTAL_THIS_MONTH,
                  SUM(TOTAL)		TOTAL_LAST_MONTH
      		FROM(
          		SELECT 'ADJUSTMENTS' CAT_NAME, 
      					IFNULL(SUM(OD.TOTAL),0)  AMOUNT, 
      					IFNULL(COUNT(OD.ID),0)  TOTAL 
      				FROM ORDER_DETAILS OD
      				INNER JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID
      				INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
      				INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      				INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      					AND STARTED BETWEEN
      						DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 MONTH) AND
      						DATE_SUB(DATE_FORMAT('".$enddate."' ,'%Y-%m-01'), INTERVAL 1 DAY) 
      					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
      			) LAST_MONTH
                   GROUP BY CAT_NAME
      	) CAT_VALUES
          GROUP BY CAT_NAME;");
    return $query->row();
  }
      	
  function get_voiditem($rest_id,$enddate){
    $query = $this->db->query("
             SELECT OD.MENU_NAME,
            		OD.PRICE,
                    OD.QUANTITY
             FROM ORDERS O 
            	INNER JOIN INVOICES_ORDERS OI ON OI.ORDER_ID = O.ID
            	INNER JOIN INVOICES I ON I.ID = OI.INVOICE_ID
                INNER JOIN ORDER_DETAILS OD ON OD.INVOICE_ID = I.ID
             WHERE OD.VOID = 1
             AND DATE(STARTED) = '".$enddate."'
             AND O.REST_ID = ".$rest_id." 
             ORDER BY OD.QUANTITY DESC;");
    return $query->result();
  }
      	
  function get_attnd($rest_id,$enddate){
    $first = date("Y-m-01",strtotime($enddate));  
    $year = date("Y",strtotime($enddate));
    $query = $this->db->query("
      -- Replace '2015-04-01' with the first date of the month 
      -- Replace '2015' with the year.
      
      SELECT 
      	U.NAME														USER_NAME,
      	1															WEEK_NUMBER,
      	U.TOTAL_HRS_WEEK 											TOTAL_HRS_EXPECTED,
      	IFNULL(A_CALC.TIME_DIFF,0)						 			TOTAL_HRS_WORKED,
      	IFNULL(A_CALC.TIME_DIFF,0) - U.TOTAL_HRS_WEEK 				DIFFERENCE,
      	T_DAYS.TOTAL_DAYS											TOTAL_DAYS,
      	IFNULL(A_CALC.DAYS_WORKED,0)								DAYS_WORKED,
      	T_DAYS.TOTAL_DAYS - IFNULL(A_CALC.DAYS_WORKED,0)			MISSED_DAYS
      FROM USERS U 
      	INNER JOIN ROLES R 
      		ON R.ID = U.ROLE_ID
      	INNER JOIN USERS_RESTAURANTS UR 
      		ON UR.USER_ID = U.ID
      	LEFT OUTER JOIN 
      		( SELECT SUM(TIMESTAMPDIFF(HOUR, A.CHECKIN,  A.CHECKOUT)) TIME_DIFF, A.USER_ID, COUNT(A.ID) AS DAYS_WORKED
      		    FROM ATTENDANCE A WHERE
      			CAST(A.CHECKIN AS DATE)  BETWEEN '".$first."'
      			AND STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+1,' Sunday'), '%X%V %W')
                  GROUP BY A.USER_ID 
      		) A_CALC
      		ON U.ID = A_CALC.USER_ID
      	LEFT OUTER JOIN 
          (
      		SELECT DATEDIFF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+1,' Sunday'), '%X%V %W'), '".$first."') +1 AS TOTAL_DAYS
          ) T_DAYS ON 1 = 1
      WHERE REST_ID = ".$rest_id." AND R.ID NOT IN (1,2)
      	AND U.ACTIVE = 1
      UNION 
      SELECT 
      	U.NAME														USER_NAME,
      	2															WEEK_NUMBER,
      	U.TOTAL_HRS_WEEK 											TOTAL_HRS_EXPECTED,
      	IFNULL(A_CALC.TIME_DIFF,0)						 			TOTAL_HRS_WORKED,
      	IFNULL(A_CALC.TIME_DIFF,0) - U.TOTAL_HRS_WEEK 				DIFFERENCE,
      	T_DAYS.TOTAL_DAYS											TOTAL_DAYS,
      	IFNULL(A_CALC.DAYS_WORKED,0)								DAYS_WORKED,
      	T_DAYS.TOTAL_DAYS - IFNULL(A_CALC.DAYS_WORKED,0)			MISSED_DAYS
      FROM USERS U 
      	INNER JOIN ROLES R 
      		ON R.ID = U.ROLE_ID
      	INNER JOIN USERS_RESTAURANTS UR 
      		ON UR.USER_ID = U.ID
      	LEFT OUTER JOIN 
      		( SELECT SUM(TIMESTAMPDIFF(HOUR, A.CHECKIN,  A.CHECKOUT)) TIME_DIFF, A.USER_ID, COUNT(A.ID) AS DAYS_WORKED
      			FROM ATTENDANCE A WHERE
      			CAST(A.CHECKIN AS DATE)  BETWEEN STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+1,' Monday'), '%X%V %W')
      			AND STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+2,' Sunday'), '%X%V %W')
                  GROUP BY A.USER_ID 
      		) A_CALC 
      		ON U.ID = A_CALC.USER_ID
      	LEFT OUTER JOIN 
          (
          SELECT 	DATEDIFF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+2,' Sunday'), '%X%V %W'), 
      				STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+1,' Monday'), '%X%V %W')) +1 AS TOTAL_DAYS
          ) T_DAYS ON 1 = 1
      WHERE REST_ID = ".$rest_id." AND R.ID NOT IN (1,2)
      	AND U.ACTIVE = 1
      UNION 
      SELECT 
      	U.NAME														USER_NAME,
      	3															WEEK_NUMBER,
      	U.TOTAL_HRS_WEEK 											TOTAL_HRS_EXPECTED,
      	IFNULL(A_CALC.TIME_DIFF,0)						 			TOTAL_HRS_WORKED,
      	IFNULL(A_CALC.TIME_DIFF,0) - U.TOTAL_HRS_WEEK 				DIFFERENCE,
      	T_DAYS.TOTAL_DAYS											TOTAL_DAYS,
      	IFNULL(A_CALC.DAYS_WORKED,0)								DAYS_WORKED,
      	T_DAYS.TOTAL_DAYS - IFNULL(A_CALC.DAYS_WORKED,0)			MISSED_DAYS
      FROM USERS U 
      	INNER JOIN ROLES R 
      		ON R.ID = U.ROLE_ID
      	INNER JOIN USERS_RESTAURANTS UR 
      		ON UR.USER_ID = U.ID
      	LEFT OUTER JOIN 
      		( SELECT SUM(TIMESTAMPDIFF(HOUR, A.CHECKIN,  A.CHECKOUT)) TIME_DIFF, A.USER_ID, COUNT(A.ID) AS DAYS_WORKED
      		    FROM ATTENDANCE A WHERE
      			CAST(A.CHECKIN AS DATE) BETWEEN STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+2,' Monday'), '%X%V %W')
      			AND STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Sunday'), '%X%V %W')
                  GROUP BY A.USER_ID 
      		) A_CALC
      		ON U.ID = A_CALC.USER_ID
      	LEFT OUTER JOIN 
      		(
              SELECT 	DATEDIFF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Sunday'), '%X%V %W'), 
      				STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+2,' Monday'), '%X%V %W')) +1 AS TOTAL_DAYS
              ) T_DAYS ON 1 = 1
      WHERE REST_ID = ".$rest_id." AND R.ID NOT IN (1,2)
      	AND U.ACTIVE = 1
      UNION 
      SELECT 
      	U.NAME														USER_NAME,
      	4															WEEK_NUMBER,
      	U.TOTAL_HRS_WEEK 											TOTAL_HRS_EXPECTED,
      	IFNULL(A_CALC.TIME_DIFF,0)						 			TOTAL_HRS_WORKED,
      	IFNULL(A_CALC.TIME_DIFF,0) - U.TOTAL_HRS_WEEK 				DIFFERENCE,
      	T_DAYS.TOTAL_DAYS											TOTAL_DAYS,
      	IFNULL(A_CALC.DAYS_WORKED,0)								DAYS_WORKED,
      	T_DAYS.TOTAL_DAYS - IFNULL(A_CALC.DAYS_WORKED,0)			MISSED_DAYS
      FROM USERS U 
      	INNER JOIN ROLES R 
      		ON R.ID = U.ROLE_ID
      	INNER JOIN USERS_RESTAURANTS UR 
      		ON UR.USER_ID = U.ID
      	LEFT OUTER JOIN 
      		( SELECT SUM(TIMESTAMPDIFF(HOUR, A.CHECKIN,  A.CHECKOUT)) TIME_DIFF, A.USER_ID, COUNT(A.ID) AS DAYS_WORKED
      			FROM ATTENDANCE A WHERE
      			CAST(A.CHECKIN AS DATE)  BETWEEN 
      				IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Monday'), '%X%V %W')> LAST_DAY('".$first."'), NULL, 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Monday'), '%X%V %W'))
      			AND IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Sunday'), '%X%V %W')> LAST_DAY('".$first."'), LAST_DAY('".$first."'), 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Sunday'), '%X%V %W'))
                  GROUP BY A.USER_ID 
      		) A_CALC 
      		ON U.ID = A_CALC.USER_ID
      	LEFT OUTER JOIN (
          SELECT DATEDIFF(IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Sunday'), '%X%V %W')> LAST_DAY('".$first."'), LAST_DAY('".$first."'), 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Sunday'), '%X%V %W')), 
      				IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Monday'), '%X%V %W')> LAST_DAY('".$first."'), NULL, 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+3,' Monday'), '%X%V %W'))) +1 AS TOTAL_DAYS
          ) T_DAYS ON 1 = 1
      WHERE REST_ID = ".$rest_id." AND R.ID NOT IN (1,2)
      	AND U.ACTIVE = 1
      UNION 
      SELECT 
      	U.NAME														USER_NAME,
      	5															WEEK_NUMBER,
      	U.TOTAL_HRS_WEEK 											TOTAL_HRS_EXPECTED,
      	IFNULL(A_CALC.TIME_DIFF,0)						 			TOTAL_HRS_WORKED,
      	IFNULL(A_CALC.TIME_DIFF,0) - U.TOTAL_HRS_WEEK 				DIFFERENCE,
      	T_DAYS.TOTAL_DAYS											TOTAL_DAYS,
      	IFNULL(A_CALC.DAYS_WORKED,0)								DAYS_WORKED,
      	T_DAYS.TOTAL_DAYS - IFNULL(A_CALC.DAYS_WORKED,0)			MISSED_DAYS
      FROM USERS U 
      	INNER JOIN ROLES R 
      		ON R.ID = U.ROLE_ID
      	INNER JOIN USERS_RESTAURANTS UR 
      		ON UR.USER_ID = U.ID
      	LEFT OUTER JOIN 
      		( SELECT SUM(TIMESTAMPDIFF(HOUR, A.CHECKIN,  A.CHECKOUT)) TIME_DIFF, A.USER_ID, COUNT(A.ID) AS DAYS_WORKED 
      			FROM ATTENDANCE A WHERE
      			CAST(A.CHECKIN AS DATE) BETWEEN 
      				IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Monday'), '%X%V %W')> LAST_DAY('".$first."'), NULL, 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Monday'), '%X%V %W'))
      			AND LAST_DAY('".$first."')
                  GROUP BY A.USER_ID 
      		) A_CALC
      		ON U.ID = A_CALC.USER_ID
      	LEFT OUTER JOIN (
      		SELECT DATEDIFF(LAST_DAY('".$first."'), 
      				IF(STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Monday'), '%X%V %W')> LAST_DAY('".$first."'), NULL, 
      					STR_TO_DATE(CONCAT('".$year."',WEEK('".$first."')+4,' Monday'), '%X%V %W'))) +1 AS TOTAL_DAYS
          ) T_DAYS ON 1 = 1
      WHERE REST_ID = ".$rest_id." AND R.ID NOT IN (1,2)
      	AND U.ACTIVE = 1;");
		return $query->result();
	}
	
}