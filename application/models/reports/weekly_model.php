<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weekly_model extends CI_Model {
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
      		SUM(TOTAL_THIS_WEEK) 					TOTAL_THIS_WEEK,
      		SUM(TOTAL_LAST_WEEK)					TOTAL_LAST_WEEK,
      		SUM(DISCOUNT_THIS_WEEK) 				DISCOUNT_THIS_WEEK,
      		SUM(DISCOUNT_LAST_WEEK)	 				DISCOUNT_LAST_WEEK,
      		SUM(NET_SALES_THIS_WEEK) 				NET_SALES_THIS_WEEK,
      		SUM(NET_SALES_LAST_WEEK)				NET_SALES_LAST_WEEK,
      		SUM(SERVICE_CHARGE_THIS_WEEK)			SERVICE_CHARGE_THIS_WEEK,
      		SUM(SERVICE_CHARGE_LAST_WEEK)			SERVICE_CHARGE_LAST_WEEK,
      		SUM(TOTAL_TAX_THIS_WEEK)				TOTAL_TAX_THIS_WEEK,
      		SUM(TOTAL_TAX_LAST_WEEK)				TOTAL_TAX_LAST_WEEK,
      		SUM(TIP_THIS_WEEK)						TIP_THIS_WEEK,
      		SUM(TIP_LAST_WEEK)						TIP_LAST_WEEK,
      		SUM(ROUNDING_THIS_WEEK)					ROUNDING_THIS_WEEK,
      		SUM(ROUNDING_LAST_WEEK)					ROUNDING_LAST_WEEK,
      		SUM(TOTAL_SALES_THIS_WEEK)				TOTAL_SALES_THIS_WEEK,
      		SUM(TOTAL_SALES_LAST_WEEK)				TOTAL_SALES_LAST_WEEK
      	FROM
      (
      	-- This Week
      	SELECT  
      		SUM(TOTAL) 								TOTAL_THIS_WEEK,
      		0 										TOTAL_LAST_WEEK,
      		SUM(DISCOUNT) 							DISCOUNT_THIS_WEEK,
      		0	 									DISCOUNT_LAST_WEEK,
      		SUM(TOTAL) - SUM(DISCOUNT) 				NET_SALES_THIS_WEEK,
      		0										NET_SALES_LAST_WEEK,
      		SUM(SERVICE_CHARGE)						SERVICE_CHARGE_THIS_WEEK,
      		0										SERVICE_CHARGE_LAST_WEEK,
      		SUM(TOTAL_TAX)							TOTAL_TAX_THIS_WEEK,
      		0										TOTAL_TAX_LAST_WEEK,
      		SUM(TIP)								TIP_THIS_WEEK,
      		0										TIP_LAST_WEEK,
      		SUM(TOTAL_ROUNDING)						ROUNDING_THIS_WEEK,
      		0										ROUNDING_LAST_WEEK,
      		SUM(PAID_AMOUNT)						TOTAL_SALES_THIS_WEEK,
      		0										TOTAL_SALES_LAST_WEEK
      	 FROM ORDERS
      	 WHERE REST_ID = ".$rest_id." 
      		AND STARTED BETWEEN 
      			DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
      			DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY)
      	 UNION
      	 -- Last Week
           SELECT  
      		0		 								TOTAL_THIS_WEEK,
      		SUM(TOTAL) 								TOTAL_LAST_WEEK,
      		0			 							DISCOUNT_THIS_WEEK,
      		SUM(DISCOUNT)	 						DISCOUNT_LAST_WEEK,
      		0										NET_SALES_THIS_WEEK,
      		SUM(TOTAL) - SUM(DISCOUNT) 				NET_SALES_LAST_WEEK,
      		0										SERVICE_CHARGE_THIS_WEEK,
      		SUM(SERVICE_CHARGE)						SERVICE_CHARGE_LAST_WEEK,
      		0										TOTAL_TAX_THIS_WEEK,
      		SUM(TOTAL_TAX)							TOTAL_TAX_LAST_WEEK,
      		0										TIP_THIS_WEEK,
      		SUM(TIP)								TIP_LAST_WEEK,
      		0										ROUNDING_THIS_WEEK,
      		SUM(TOTAL_ROUNDING)						ROUNDING_LAST_WEEK,
      		0										TOTAL_SALES_THIS_WEEK,
      		SUM(PAID_AMOUNT)						TOTAL_SALES_LAST_WEEK
      	 FROM ORDERS
      	 WHERE REST_ID = ".$rest_id." 
           AND STARTED BETWEEN
      		DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
      		DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
      ) WEEKLY_SALES_DATA;");
		return $query->row();
	}
  
  function get_summary($rest_id,$enddate){
    $query = $this->db->query(" -- Coloumn 1 : Summary
    SELECT  
    	SUM(TOTAL_SALES_THIS_WEEK)					TOTAL_SALES_THIS_WEEK,
    	SUM(TOTAL_SALES_LAST_WEEK)					TOTAL_SALES_LAST_WEEK,	
    	SUM(TOTAL_CUSTOMERS_THIS_WEEK)				TOTAL_CUSTOMERS_THIS_WEEK,
    	SUM(TOTAL_CUSTOMERS_LAST_WEEK)				TOTAL_CUSTOMERS_LAST_WEEK,
    	SUM(TOTAL_INVOICE_THIS_WEEK)				TOTAL_INVOICE_THIS_WEEK,
    	SUM(TOTAL_INVOICE_LAST_WEEK)				TOTAL_INVOICE_LAST_WEEK,
    	SUM(AVG_SALES_PER_CUST_THIS_WEEK)			AVG_SALES_PER_CUST_THIS_WEEK,
    	SUM(AVG_SALES_PER_CUST_LAST_WEEK)			AVG_SALES_PER_CUST_LAST_WEEK,
    	SUM(AVG_SALES_PER_INVOICE_THIS_WEEK)		AVG_SALES_PER_INVOICE_THIS_WEEK,
    	SUM(AVG_SALES_PER_INVOICE_LAST_WEEK)		AVG_SALES_PER_INVOICE_LAST_WEEK
        FROM
    	(
    		SELECT  
    			SUM(PAID_AMOUNT)							TOTAL_SALES_THIS_WEEK,
    			0											TOTAL_SALES_LAST_WEEK,	
    			SUM(NO_OF_GUEST)							TOTAL_CUSTOMERS_THIS_WEEK,
    			0											TOTAL_CUSTOMERS_LAST_WEEK,
    			SUM(INVOICE_BY_ORDERS.INVOICES)				TOTAL_INVOICE_THIS_WEEK,
    			0											TOTAL_INVOICE_LAST_WEEK,
    			ROUND(SUM(PAID_AMOUNT) 
    				/ SUM(NO_OF_GUEST),0)					AVG_SALES_PER_CUST_THIS_WEEK,
    			0											AVG_SALES_PER_CUST_LAST_WEEK,
    			ROUND(SUM(PAID_AMOUNT)
    				/ SUM(INVOICE_BY_ORDERS.INVOICES), 0)	AVG_SALES_PER_INVOICE_THIS_WEEK,
    			0											AVG_SALES_PER_INVOICE_LAST_WEEK
    		 FROM ORDERS O
    			INNER JOIN (
    				SELECT ORDER_ID, COUNT(INVOICE_ID) INVOICES FROM ORDERS INNER JOIN INVOICES_ORDERS ON ID = ORDER_ID 
    						 WHERE STARTED BETWEEN 
    								DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
    								DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY)
    						GROUP BY ORDER_ID
    			) INVOICE_BY_ORDERS
    			ON O.ID = INVOICE_BY_ORDERS.ORDER_ID
    		 WHERE REST_ID = ".$rest_id." 
    		 AND STARTED BETWEEN
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
    				DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY)
    	UNION
    		 SELECT  
    			0											TOTAL_SALES_THIS_WEEK,
    			SUM(PAID_AMOUNT)							TOTAL_SALES_LAST_WEEK,	
    			0											TOTAL_CUSTOMERS_THIS_WEEK,
    			SUM(NO_OF_GUEST)							TOTAL_CUSTOMERS_LAST_WEEK,
    			0											TOTAL_INVOICE_THIS_WEEK,
    			SUM(INVOICE_BY_ORDERS.INVOICES)				TOTAL_INVOICE_LAST_WEEK,
    			0											AVG_SALES_PER_CUST_THIS_WEEK,
    			ROUND(SUM(PAID_AMOUNT)
    				/ SUM(NO_OF_GUEST),0)					AVG_SALES_PER_CUST_LAST_WEEK,
    			0											AVG_SALES_PER_INVOICE_THIS_WEEK,
    			ROUND(SUM(PAID_AMOUNT) 
    				/ SUM(INVOICE_BY_ORDERS.INVOICES), 0)	AVG_SALES_PER_INVOICE_LAST_WEEK
    		 FROM ORDERS O
    			INNER JOIN (
    				SELECT ORDER_ID, COUNT(INVOICE_ID) INVOICES FROM ORDERS INNER JOIN INVOICES_ORDERS ON ID = ORDER_ID 
    						 WHERE STARTED BETWEEN 
    							DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
    							DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
    						GROUP BY ORDER_ID
    			) INVOICE_BY_ORDERS
    			ON O.ID = INVOICE_BY_ORDERS.ORDER_ID
    		 WHERE REST_ID = ".$rest_id." 
    		 AND STARTED BETWEEN
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
    	) WEEKLY_SUMMARY;");
		return $query->row();
	}
  
  function get_payment($rest_id,$enddate){
	  $query = $this->db->query("-- Column 2: Top :Payment Type
    SELECT 
    	PAYMENT_METHOD							PAYMENT_METHOD,
    	SUM(AMOUNT_THIS_WEEK)					AMOUNT_THIS_WEEK,
        SUM(AMOUNT_LAST_WEEK)					AMOUNT_LAST_WEEK,
        SUM(TOTAL_THIS_WEEK)					TOTAL_THIS_WEEK,
        SUM(TOTAL_LAST_WEEK)					TOTAL_LAST_WEEK
    	FROM (
    		SELECT  R.VALUE 											PAYMENT_METHOD,
    		  IFNULL(SUM(O.PAID_AMOUNT), 0) 							AMOUNT_THIS_WEEK,
              0															AMOUNT_LAST_WEEK,
              IFNULL(COUNT(I.ID),0)  									TOTAL_THIS_WEEK,
              0															TOTAL_LAST_WEEK
    		FROM INVOICES I
    		INNER JOIN REF_VALUES R 
    				ON I.PAYMENT_METHOD = R.CODE
    				AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
    		INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
    		INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
    		WHERE STARTED BETWEEN
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
    				DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY) 
    			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
    		GROUP BY R.VALUE
    		UNION
    		SELECT  R.VALUE 											PAYMENT_METHOD,
    			0 														AMOUNT_THIS_WEEK,
    		  IFNULL(SUM(O.PAID_AMOUNT), 0) 							AMOUNT_LAST_WEEK, 
              0															TOTAL_THIS_WEEK,
              IFNULL(COUNT(I.ID),0)  									TOTAL_LAST_WEEK
    		FROM INVOICES I
    		INNER JOIN REF_VALUES R 
    				ON I.PAYMENT_METHOD = R.CODE
    				AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
    		INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
    		INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
    		WHERE STARTED BETWEEN
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
    				DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
    			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
    		GROUP BY R.VALUE
            ) PAYMENT_TYPE
    	GROUP BY PAYMENT_METHOD;");
		return $query->result();
	}
  
  function get_ordtype($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Middle: Sales Type - DINEIN, TakeOUT, Delivery  - display number, percent, dollar, sales
    SELECT
    	ORDER_TYPE								ORDER_TYPE,
        SUM(AMOUNT_THIS_WEEK)					AMOUNT_THIS_WEEK,
        SUM(AMOUNT_LAST_WEEK)					AMOUNT_LAST_WEEK,
        SUM(TOTAL_THIS_WEEK)					TOTAL_THIS_WEEK,
        SUM(TOTAL_LAST_WEEK)					TOTAL_LAST_WEEK
        FROM
     (
     -- This WEEK
     SELECT  R.VALUE 													ORDER_TYPE, 
    		ORDERS_GROUPED.AMOUNT										AMOUNT_THIS_WEEK, 
            0															AMOUNT_LAST_WEEK,
    		ORDERS_GROUPED.TOTAL										TOTAL_THIS_WEEK,
            0															TOTAL_LAST_WEEK
    	FROM REF_VALUES R 
    		LEFT OUTER JOIN 
            (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0)  TOTAL 
    				FROM ORDERS O
                    WHERE STARTED BETWEEN
    					DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
    					DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY)
    				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
    			GROUP BY O.ORDER_TYPE
            )ORDERS_GROUPED
            ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
        WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1
    UNION
     -- Last WEEK
     SELECT  R.VALUE 													ORDER_TYPE, 
    		0															AMOUNT_THIS_WEEK, 
            ORDERS_GROUPED.AMOUNT										AMOUNT_LAST_WEEK,
    		0															TOTAL_THIS_WEEK,
            ORDERS_GROUPED.TOTAL										TOTAL_LAST_WEEK
    	FROM REF_VALUES R 
    		LEFT OUTER JOIN 
            (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0)  TOTAL 
    				FROM ORDERS O
                    WHERE STARTED BETWEEN
    					DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
    					DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
    				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
    			GROUP BY O.ORDER_TYPE
            )ORDERS_GROUPED
            ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
        WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1
        )SALES_TYPE
    GROUP BY ORDER_TYPE;");
    		return $query->result();
    	}
    	
	function get_topcat($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Bottom: Top Category By Sales
      SELECT
	     CAT_NAME					CAT_NAME,
	     SUM(AMOUNT_THIS_WEEK)		AMOUNT_THIS_WEEK,
	     SUM(AMOUNT_LAST_WEEK)		AMOUNT_LAST_WEEK,
	     SUM(TOTAL_THIS_WEEK)		TOTAL_THIS_WEEK,
	     SUM(TOTAL_LAST_WEEK)		TOTAL_LAST_WEEK
      FROM
      (
		    SELECT 
          CAT_NAME		CAT_NAME,
          SUM(AMOUNT)		AMOUNT_THIS_WEEK,
          0				AMOUNT_LAST_WEEK,
          SUM(TOTAL)		TOTAL_THIS_WEEK,
          0				TOTAL_LAST_WEEK
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
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
						DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY)
					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
          GROUP BY OD.CATEGORY_NAME
			) THIS_WEEK
      GROUP BY CAT_NAME
      UNION ALL
		  SELECT 
        CAT_NAME		CAT_NAME,
        0				AMOUNT_THIS_WEEK,
        SUM(AMOUNT)		AMOUNT_LAST_WEEK,
        0				TOTAL_THIS_WEEK,
        SUM(TOTAL)		TOTAL_LAST_WEEK
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
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
        GROUP BY OD.CATEGORY_NAME
      ) LAST_WEEK
      GROUP BY CAT_NAME
    ) CAT_VALUES
    GROUP BY CAT_NAME;");
		return $query->result();
	}          
  
  function remove_zero_values($array,$opt=1){
    $i = 0;
    foreach ($array as $row){
    if($opt==1){    
      if($row->AMOUNT_THIS_WEEK==0){
        unset($array[$i]);
      }
    } else {   
      if($row->AMOUNT_LAST_WEEK==0){
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
      $merge = array('AMOUNT_THIS_WEEK' => 0, 'TOTAL_THIS_WEEK' => 0);
      foreach ($array as $row){    
        if($i>=5){         
          if((strtolower($row->CAT_NAME)!="adjustments")){
            $merge['AMOUNT_THIS_WEEK'] = $merge['AMOUNT_THIS_WEEK'] + $row->AMOUNT_THIS_WEEK;
            $merge['TOTAL_THIS_WEEK'] = $merge['TOTAL_THIS_WEEK'] + $row->TOTAL_THIS_WEEK;
            $row->CAT_NAME = "others";   
            $row->AMOUNT_THIS_WEEK = $merge['AMOUNT_THIS_WEEK'];
            $row->TOTAL_THIS_WEEK = $merge['TOTAL_THIS_WEEK'];
          } else {    
            unset($array[$i]);
          }
        } else {  
          unset($array[$i]);
        }
        $i++;
      }
    } else {         
      $merge = array('AMOUNT_LAST_WEEK' => 0, 'TOTAL_LAST_WEEK' => 0);
      foreach ($array as $row){    
        if($i>=5){         
          if((strtolower($row->CAT_NAME)!="adjustments")){
            $merge['AMOUNT_LAST_WEEK'] = $merge['AMOUNT_LAST_WEEK'] + $row->AMOUNT_LAST_WEEK;
            $merge['TOTAL_LAST_WEEK'] = $merge['TOTAL_LAST_WEEK'] + $row->TOTAL_LAST_WEEK;
            $row->CAT_NAME = "others";   
            $row->AMOUNT_LAST_WEEK = $merge['AMOUNT_LAST_WEEK'];
            $row->TOTAL_LAST_WEEK = $merge['TOTAL_LAST_WEEK'];
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
      	SUM(AMOUNT_THIS_WEEK)		AMOUNT_THIS_WEEK,
      	SUM(AMOUNT_LAST_WEEK)		AMOUNT_LAST_WEEK,
      	SUM(TOTAL_THIS_WEEK)		TOTAL_THIS_WEEK,
      	SUM(TOTAL_LAST_WEEK)		TOTAL_LAST_WEEK
      FROM
      (    
		SELECT 
			CAT_NAME		CAT_NAME,
            SUM(AMOUNT)		AMOUNT_THIS_WEEK,
            0				AMOUNT_LAST_WEEK,
            SUM(TOTAL)		TOTAL_THIS_WEEK,
            0				TOTAL_LAST_WEEK
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
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') DAY) AND 
						DATE('".$enddate."' + INTERVAL (6 - WEEKDAY('".$enddate."')) DAY) 
					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
			) THIS_WEEK
      GROUP BY CAT_NAME
      UNION ALL
		  SELECT 
        CAT_NAME		CAT_NAME,
        0				AMOUNT_THIS_WEEK,
        SUM(AMOUNT)		AMOUNT_LAST_WEEK,
        0				TOTAL_THIS_WEEK,
        SUM(TOTAL)		TOTAL_LAST_WEEK
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
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 7 DAY) AND
						DATE_SUB( '".$enddate."', INTERVAL WEEKDAY('".$enddate."') + 1 DAY) 
					AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
			) LAST_WEEK
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
	
	function get_recon($rest_id,$enddate){
    $query = $this->db->query("-- weekly Recon
      SELECT 	
		T.NAME 										TERMINAL_NAME,
        PH.CASH_OPENING								CASH_OPENING,
		PH.CASH_CLOSING								CASH_CLOSING,
		SUM(PH.CASH_CLOSING - PH.CASH_OPENING) 		CASH_FROM_REGISTER, 
		CASH_FROM_INVOICES.TOTAL 					CASH_FROM_INVOICES, 
        SUM(PH.CASH_CLOSING - PH.CASH_OPENING) - 	
			CASH_FROM_INVOICES.TOTAL 				DIFFERENCE,
        DATE(ALL_DATES.SELECTED_DATE) 				TERMINAL_DATE
	FROM TERMINAL T
	INNER JOIN RESTAURANTS R 
		ON T.REST_ID = R.ID
	INNER JOIN 
		(select selected_date from 
			(select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
			(select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
			(select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
			(select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
			(select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
			(select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
		) ALL_DATES
	ON	WEEK(ALL_DATES.SELECTED_DATE) = WEEK('".$enddate."')
		AND YEAR(ALL_DATES.SELECTED_DATE) = YEAR('".$enddate."')
	LEFT OUTER JOIN PAYMENT_HISTORY PH
		ON PH.TERMINAL_ID = T.ID
	LEFT OUTER JOIN (
		SELECT DATE(O.STARTED) ORDER_DATE, SUM(I.PAID_AMOUNT) TOTAL,  I.TERMINAL_ID 
			FROM INVOICES I
			INNER JOIN INVOICES_ORDERS OI
				ON OI.INVOICE_ID = I.ID
			INNER JOIN ORDERS O 
				ON O.ID = OI.ORDER_ID
		WHERE I.PAYMENT_METHOD = 'CASH'
		GROUP BY I.TERMINAL_ID, DATE(O.STARTED)
	) CASH_FROM_INVOICES
	ON CASH_FROM_INVOICES.ORDER_DATE = DATE(PH.DATE) 
	AND CASH_FROM_INVOICES.TERMINAL_ID = T.ID
WHERE T.REGISTERED = 1
	AND R.ID = ".$rest_id." 
  GROUP BY DATE(ALL_DATES.SELECTED_DATE);");
		return $query->result();
	}
	
}