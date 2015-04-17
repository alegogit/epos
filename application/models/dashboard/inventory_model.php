<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model {

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
    $query = $this->db->select('RESTAURANTS.CURRENCY, REF_VALUES.VALUE as CUR')
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
	
	function non_moving_items($rest_id)
	{
	     $query = $this->db->query('SELECT NAME FROM INVENTORY WHERE REST_ID = '.$rest_id.' AND LAST_UPDATED_DATE <SUBDATE(SYSDATE(),7);');
	     return $query->result();  
	}
	
	function low_in_stock($rest_id)
	{
	     $query = $this->db->query('SELECT NAME FROM INVENTORY WHERE REST_ID = '.$rest_id.' AND QUANTITY<MIN_QUANTITY;');
	     return $query->result();  
	}
	
	function no_stock($rest_id)
	{
	     $query = $this->db->query('SELECT NAME FROM INVENTORY WHERE REST_ID = '.$rest_id.' AND QUANTITY=0;');
	     return $query->result();  
	}

}