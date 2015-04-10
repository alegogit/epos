<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trends_model extends CI_Model {
  
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
  
  function dash_monthly_revenue($rest_id){
	     $query = $this->db->query("-- This month
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, DATE_FORMAT(NOW() ,'%Y-%m-%d') REC_MONTH 
                              		FROM ORDERS O 
                              		WHERE O.ENDED BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-%d') 
                              		  AND NOW()
                              		  AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- Last month
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 1 MONTH) REC_MONTH 
                              		FROM ORDERS O
                              		WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 1 MONTH) 
                              			AND SUBDATE(DATE_FORMAT(NOW() ,'%Y-%m-%d'), 1)
                              			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 2 months ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 2 MONTH) REC_MONTH 
                              		FROM ORDERS O
                              		WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 2 MONTH) 
                              		  AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 1 MONTH), 1)
                              			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                 
                                  -- 3 months ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 3 MONTH) REC_MONTH 
                              		FROM ORDERS O
                              		WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 3 MONTH) 
                              		  AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 2 MONTH), 1)
                              			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                      
                                  -- 4 months ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 4 MONTH) REC_MONTH 
                              		FROM ORDERS O
                              		WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 4 MONTH) 
                              		  AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 3 MONTH), 1)
                              			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                   
                                  -- 5 months ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 5 MONTH) REC_MONTH 
                              		FROM ORDERS O
                              		WHERE O.ENDED BETWEEN (DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 5 MONTH)
                              		  AND SUBDATE((DATE_FORMAT(NOW() ,'%Y-%m-%d') - INTERVAL 4 MONTH), 1)
                              			AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  ORDER BY REC_MONTH ASC;");
		    return $query->result();  
	}
  
  function dash_weekly_revenue($rest_id){
	     $query = $this->db->query("-- This Week
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, DATE_FORMAT(NOW() ,'%Y-%m-%d') REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d') AND NOW()
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- Last week
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) 
                              				AND DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d')
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 2 Weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 3 weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	   UNION ALL
                                      
                                  -- 4 weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                   
                                  -- 5 weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                              	
                                  -- 6 weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	UNION ALL
                                  
                                  -- 7 Weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 8 Weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 9 Weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 10 Weeks ago 
                                  SELECT IFNULL(SUM(PAID_AMOUNT),0) AMT, SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  ORDER BY REC_WEEK ASC;");
		    return $query->result();  
	}
			
  function dash_weekly_avslspcust($rest_id){   
	     $query = $this->db->query("SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,  
                              		DATE_FORMAT(NOW() ,'%Y-%m-%d') REC_WEEK
                              		FROM ORDERS O 
                              			WHERE O.ENDED BETWEEN DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d') 
                              				AND NOW()
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	UNION ALL
                                  
                                  -- Last week
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) 
                              				AND DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d')
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 2 Weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 3 weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	UNION ALL
                                      
                                  -- 4 weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                   
                                  -- 5 weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                              	
                                  -- 6 weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                              	UNION ALL
                                  
                                  -- 7 Weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 8 Weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 9 Weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  UNION ALL
                                  
                                  -- 10 Weeks ago 
                                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(SUM(O.NO_OF_GUEST),1) AS AVG_SALES_CUST,
                              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) REC_WEEK 
                              		FROM ORDERS O
                              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) 
                              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63)
                              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                                  ORDER BY REC_WEEK ASC;");
	     return $query->result();  
  }	
  
  function dash_weekly_avslspinv($rest_id){   
	     $query = $this->db->query("SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1) AS AVG_SALES_INV,  
                		DATE_FORMAT(NOW() ,'%Y-%m-%d') REC_WEEK
                		FROM ORDERS O 
                			WHERE O.ENDED BETWEEN DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d') 
                				AND NOW()
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                	UNION ALL
                    
                    -- Last week
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1) AS AVG_SALES_INV,
                		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) REC_WEEK 
                		FROM ORDERS O
                			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7) 
                				AND DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d')
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                    UNION ALL
                    
                    -- 2 Weeks ago 
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
                		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) REC_WEEK 
                		FROM ORDERS O
                			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14) 
                				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),7)
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                    UNION ALL
                    
                    -- 3 weeks ago 
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1) AS AVG_SALES_INV,
                		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) REC_WEEK 
                		FROM ORDERS O
                			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21) 
                				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),14)
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                	UNION ALL
                        
                    -- 4 weeks ago 
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
                		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) REC_WEEK 
                		FROM ORDERS O
                			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28) 
                				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),21)
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                    UNION ALL
                     
                    -- 5 weeks ago 
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
                		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) REC_WEEK 
                		FROM ORDERS O
                			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35) 
                				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),28)
                				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                    UNION ALL
                	
                    -- 6 weeks ago 
                    SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) REC_WEEK 
              		FROM ORDERS O
              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42) 
              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),35)
              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
              	UNION ALL
                  
                  -- 7 Weeks ago 
                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) REC_WEEK 
              		FROM ORDERS O
              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49) 
              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),42)
              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                  UNION ALL
                  
                  -- 8 Weeks ago 
                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) REC_WEEK 
              		FROM ORDERS O
              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56) 
              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),49)
              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                  UNION ALL
                  
                  -- 9 Weeks ago 
                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) REC_WEEK 
              		FROM ORDERS O
              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63) 
              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),56)
              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                  UNION ALL
                  
                  -- 10 Weeks ago 
                  SELECT IFNULL(SUM(O.PAID_AMOUNT),0)/ IFNULL(COUNT(O.ID),1)  AS AVG_SALES_INV,
              		SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) REC_WEEK 
              		FROM ORDERS O
              			WHERE O.ENDED BETWEEN SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),70) 
              				AND SUBDATE(DATE_FORMAT(SUBDATE(SYSDATE(), WEEKDAY(SYSDATE())), '%Y-%m-%d'),63)
              				AND O.REST_ID = ".$rest_id." AND O.ACTIVE = 0
                  ORDER BY REC_WEEK ASC;");
	     return $query->result();  
  }           
         
	function no_stock($rest_id)
	{
	     $query = $this->db->query('SELECT NAME FROM INVENTORY WHERE REST_ID = '.$rest_id.' AND QUANTITY=0;');
	     return $query->result();  
	}

}