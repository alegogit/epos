<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daily_model extends CI_Model {
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
    $query = $this->db->query("-- Coloumn 1 Top : Revenue Numbers 
      SELECT  
      	SUM(TOTAL) 									SUBTOTAL,
      	SUM(DISCOUNT) 								DISCOUNT,
      	SUM(TOTAL) - SUM(DISCOUNT) 					NET_SALES,
          SUM(SERVICE_CHARGE)							SERVICE_CHARGE,
          SUM(TOTAL_TAX)								TOTAL_TAX,
      	SUM(TIP)									TIP,
          SUM(TOTAL_ROUNDING)							ROUNDING,
          SUM(TOTAL) - SUM(DISCOUNT) + 
      	SUM(SERVICE_CHARGE) +SUM(TOTAL_TAX) +
          SUM(TIP) +SUM(TOTAL_ROUNDING)				TOTAL_SALES,
          DATE(STARTED)								REPORT_DATE
      FROM ORDERS
      WHERE DATE(STARTED) = '".$enddate."' 
        AND REST_ID = ".$rest_id." AND VOID = 0;");
		return $query->row();
	}
  
  function get_summary($rest_id,$enddate){
    $query = $this->db->query(" -- Coloumn 1 Bottom: Summary
       SELECT  
      	SUM(TOTAL) - SUM(DISCOUNT) + 
      	SUM(SERVICE_CHARGE) +SUM(TOTAL_TAX) +
          SUM(TIP) +SUM(TOTAL_ROUNDING)				TOTAL_SALES,
          SUM(NO_OF_GUEST)							TOTAL_CUSTOMERS,
          SUM(INVOICE_BY_ORDERS.INVOICES)				TOTAL_INVOICE,
          ROUND(( SUM(TOTAL) - SUM(DISCOUNT) + 
      	SUM(SERVICE_CHARGE) +SUM(TOTAL_TAX) +
          SUM(TIP) +SUM(TOTAL_ROUNDING)) 
      		/ SUM(NO_OF_GUEST),0)					AVG_SALES_PER_CUST,
          ROUND(( SUM(TOTAL) - SUM(DISCOUNT) + 
      	SUM(SERVICE_CHARGE) +SUM(TOTAL_TAX) +
          SUM(TIP) +SUM(TOTAL_ROUNDING)) 
      		/ SUM(INVOICE_BY_ORDERS.INVOICES), 0)	AVG_SALES_PER_INVOICE,
          DATE(STARTED)								REPORT_DATE
       FROM ORDERS O
      	INNER JOIN (
      		SELECT ORDER_ID, COUNT(INVOICE_ID) INVOICES 
          FROM ORDERS 
          INNER JOIN INVOICES_ORDERS ON ORDERS.ID = INVOICES_ORDERS.ORDER_ID 
      				WHERE DATE(ORDERS.STARTED) = '".$enddate."'
                      GROUP BY INVOICES_ORDERS.ORDER_ID
          ) INVOICE_BY_ORDERS
          ON O.ID = INVOICE_BY_ORDERS.ORDER_ID
      WHERE DATE(STARTED) = '".$enddate."' 
        AND REST_ID = ".$rest_id." AND VOID = 0;");
		return $query->row();
	}
  
  function get_payment0($rest_id,$enddate){
	  $query = $this->db->query("-- Coloumn 2 Top : Payment Type
      SELECT  R.VALUE AS PAYMENT_METHOD, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(I.ID),0)  TOTAL 
      FROM INVOICES I
      INNER JOIN REF_VALUES R ON I.PAYMENT_METHOD = R.CODE
        AND R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
      INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      WHERE DATE(STARTED) = '".$enddate."'
        AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
      GROUP BY R.VALUE
      ORDER BY AMOUNT DESC;");
		return $query->result();
	}     
  
  function get_payment($rest_id,$enddate){
	  $query = $this->db->query("-- Coloumn 2 Top : Payment Type
      SELECT R.VALUE AS PAYMENT_METHOD, IFNULL(PAYMENTS_GROUPED.AMOUNT, 0) AMOUNT , IFNULL(PAYMENTS_GROUPED.TOTAL, 0) TOTAL
      FROM REF_VALUES R
      LEFT OUTER JOIN (
        SELECT I.PAYMENT_METHOD, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0) TOTAL
        FROM INVOICES I
        INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
        INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
        WHERE DATE(O.STARTED) = '".$enddate."'
        AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
        GROUP BY I.PAYMENT_METHOD
      )PAYMENTS_GROUPED
      ON PAYMENTS_GROUPED.PAYMENT_METHOD = R.CODE
      WHERE R.LOOKUP_NAME = 'PAYMENT_METHOD' AND R.IS_ACTIVE = 1
      ORDER BY AMOUNT DESC;");
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
    $query = $this->db->query(" -- Coloumn 2 Middle: Sales Type - DINEIN, TakeOUT, Delivery  - display number, percent, dollar, sales
       SELECT  R.VALUE AS ORDER_TYPE, ORDERS_GROUPED.AMOUNT, ORDERS_GROUPED.TOTAL
      	FROM REF_VALUES R 
      		LEFT OUTER JOIN 
              (	SELECT O.ORDER_TYPE, IFNULL(SUM(O.PAID_AMOUNT), 0) AMOUNT , IFNULL(COUNT(O.ID),0)  TOTAL 
      				FROM ORDERS O
                      WHERE DATE(STARTED) = '".$enddate."'
      				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0
      			GROUP BY O.ORDER_TYPE
              )ORDERS_GROUPED
              ON ORDERS_GROUPED.ORDER_TYPE = R.CODE
          WHERE R.LOOKUP_NAME = 'ORDER_TYPE' AND R.IS_ACTIVE = 1
      ORDER BY AMOUNT DESC;");
		return $query->result();
	}     
	
	function get_topcat($rest_id,$enddate,$top=5){  
    $array1 = $this->dash_top_cat2_tops($rest_id,$enddate,$top=5);
    $array2 = $this->dash_top_cat3_others($rest_id,$enddate,$top=5);
    $array3 = $this->dash_top_cat5_adjust($rest_id,$enddate);       
    $array5 = array_merge($array1,$array2,$array3);
		return $array5;  
	}
	
	function dash_top_cat1_total($rest_id,$enddate){  		
		$query = $this->db->query("SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
                              	FROM ORDER_DETAILS OD
                                  LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
                              	INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                                  INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		                        AND DATE(O.STARTED) = '".$enddate."'
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
                                GROUP BY OD.CATEGORY_NAME
                                ORDER BY AMOUNT DESC;");
		return $query->num_rows();  
	}
    
	function dash_top_cat2_tops($rest_id,$enddate,$top=5){  		
		$query = $this->db->query("SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
                              	FROM ORDER_DETAILS OD
                                  LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
                              	INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                                  INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		                        AND DATE(O.STARTED) = '".$enddate."'
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
                                GROUP BY OD.CATEGORY_NAME 
                                ORDER BY AMOUNT DESC
                                LIMIT ".$top.";");
		return $query->result();  
	}           
	
	function dash_top_cat3_others($rest_id,$enddate,$top=5){ 
    //$tot = $this->dash_top_cat1_total($enddate,$rest_id); 	
    $tot = 100; 		
		$query = $this->db->query("SELECT 'OTHERS' CAT_NAME, IFNULL(SUM(AMOUNT), 0) AMOUNT, IFNULL(SUM(TOTAL) ,0) TOTAL FROM(
                              	SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
                              		FROM ORDER_DETAILS OD
                              		LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
                              		INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                              		INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              		INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		                        AND DATE(O.STARTED) = '".$enddate."'
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
                              	GROUP BY OD.CATEGORY_NAME  
                                ORDER BY AMOUNT DESC
                              	LIMIT ".$top.", ".$tot."
                                ) OTHER_CAT;");
		return $query->result();  
	}   
  
	function dash_top_cat5_adjust($rest_id,$enddate){  		
		$query = $this->db->query("SELECT 'ADJUSTMENTS' CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
                              	FROM ORDER_DETAILS OD
                                  INNER JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID
                              	INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
                                  INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
                              	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		                        AND DATE(O.STARTED) = '".$enddate."'
                                  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0;");
		return $query->result();  
	}
	
	function get_topcat0($rest_id,$enddate){
    $query = $this->db->query("-- Coloumn 2 Bottom: Top Category By Sales
       SELECT OD.CATEGORY_NAME CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
      	FROM ORDER_DETAILS OD
          LEFT JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID AND PC.MENU_ID = NULL
      	INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
          INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		AND DATE(STARTED) = '".$enddate."'
      		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0
      GROUP BY OD.CATEGORY_NAME
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
      SELECT 'ADJUSTMENTS' CAT_NAME, IFNULL(SUM(OD.TOTAL),0)  AMOUNT, IFNULL(COUNT(OD.ID),0)  TOTAL 
      	FROM ORDER_DETAILS OD
          INNER JOIN PRICE_CHANGE PC ON PC.ORDER_DETAILS_ID = OD.ID
      	INNER JOIN INVOICES I ON OD.INVOICE_ID = I.ID
          INNER JOIN INVOICES_ORDERS OI ON OI.INVOICE_ID = I.ID
      	INNER JOIN ORDERS O ON OI.ORDER_ID = O.ID
      		AND DATE(STARTED) = '".$enddate."'
      		AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0 AND O.VOID = 0 AND OD.VOID = 0;");
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
    $query = $this->db->query("-- Daily Recon
      SELECT		T.NAME 										TERMINAL_NAME,
          PH.CASH_OPENING									CASH_OPENING,
  		PH.CASH_CLOSING									CASH_CLOSING,
  		SUM(PH.CASH_CLOSING - PH.CASH_OPENING) 		CASH_FROM_REGISTER, 
  		CASH_FROM_INVOICES.TOTAL 					CASH_FROM_INVOICES, 
          SUM(PH.CASH_CLOSING - PH.CASH_OPENING) - 	
  			CASH_FROM_INVOICES.TOTAL 				DIFFERENCE,
          DATE(PH.DATE) 								TERMINAL_DATE
  	 FROM TERMINAL T
  	INNER JOIN RESTAURANTS R 
  		ON T.REST_ID = R.ID
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
  	AND DATE(PH.DATE) = '".$enddate."'
  	AND R.ID = ".$rest_id.";");
		return $query->result();
	}
	
}