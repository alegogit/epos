<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    var $username   = '';
    var $password = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	 
	function get_profile()
    {
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('ID',$id);
          $query = $this->db->get('users');
          return $query->row();
    }
	
	function get_restaurant()
    {
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
          //$query = $this->db->get('restaurants');
          $query = $this->db->select('*')
                              ->from('restaurants')
                              ->join('users_restaurants', 'restaurants.ID = users_restaurants.REST_ID')
                              ->get('');
          return $query->result();
    }

	function num_transactions_today($rest_id)
	{
	     $query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS res FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = '.$rest_id.';');
		//return $query->result();  
          return $query->row();
	}
     
     function percentage_increase_from_yesterday($rest_id)
	{
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID ='.$rest_id.')
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SUBDATE(SYSDATE(),1)) AND REST_ID ='.$rest_id.')
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
		FROM DUAL;');
		//return $query->result();  
          return $query->row();
	}
	
	function total_sales_today($rest_id)
	{
	     $query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS res FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID ='.$rest_id.';');
		//return $query->result();  
          return $query->row();
	}
     
     function num_transactions_this_year($rest_id)
	{
	     $query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS res FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID ='.$rest_id.';');
		//return $query->result();  
          return $query->row();
	}
     
     function percentage_increase_from_last_week($rest_id)
	{
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
		//return $query->result();  
          return $query->row();
	}
	
	function percentage_increase_this_year($rest_id)
	{                                                                   
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
	
	function total_sales_this_year($rest_id)
	{
	     $query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS res FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID ='.$rest_id.'');
		//return $query->result();  
          return $query->row();
	}
     
  function num_customers_30day($rest_id)
	{
	     $query = $this->db->query('SELECT COUNT(C.ID) AS res 
          FROM CUSTOMERS C
			INNER JOIN ORDERS O ON O.CUSTOMER_ID = C.ID
            WHERE O.REST_ID = '.$rest_id.'
				AND O.ENDED > SUBDATE(SYSDATE(), 30);');
		//return $query->result();  
          return $query->row();
	}
  /*
  function dash_payment_method($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT SUM(PAID_AMOUNT) AMOUNT, PAYMENT_METHOD 
          FROM ORDERS
          WHERE ENDED BETWEEN "'.$start_date.'" and "'.$end_date.'"
          AND REST_ID = '.$rest_id.'
          GROUP BY PAYMENT_METHOD;');
		    return $query->result();  
        //return $query->row();
	}
	*/
	
	function dash_payment_method($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT R.CODE, R.VALUE AS PAYMENT_METHOD, IFNULL(PAYMENT.AMOUNT, 0) AS AMOUNT FROM REF_VALUES R 
	        LEFT OUTER JOIN  (
		        SELECT PAYMENT_METHOD, IFNULL(SUM(PAID_AMOUNT),0) AMOUNT FROM ORDERS
		        WHERE ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
		        AND REST_ID = '.$rest_id.' AND ACTIVE = 0
		        GROUP BY PAYMENT_METHOD
          ) PAYMENT ON PAYMENT.PAYMENT_METHOD = R.CODE
          WHERE R.LOOKUP_NAME = "PAYMENT_METHOD" AND R.IS_ACTIVE = 1;');
		    return $query->result();  
        //return $query->row();
	}
	
	function dash_top_categories($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT C.NAME CAT_NAME, IFNULL(SUM(OD.PRICE*OD.QUANTITY),0) AMOUNT FROM ORDER_DETAILS OD
          INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
          AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
          AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
          INNER JOIN MENU M ON M.ID = OD.MENU_ID
          INNER JOIN CATEGORY C ON C.ID = M.CATEGORY_ID
          GROUP BY C.NAME
          ORDER BY AMOUNT DESC
          LIMIT 5;');
		    return $query->result();  
        //return $query->row();
	}
	
	function dash_best_sellers($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT M.NAME AS ITEMS, IFNULL(SUM(OD.PRICE*QUANTITY),0) AMOUNT, COUNT(M.NAME) AS QTY FROM ORDER_DETAILS OD 
	        INNER JOIN ORDERS O ON OD.ORDER_ID = O.ID
		      AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
		      AND O.REST_ID = '.$rest_id.' AND O.ACTIVE = 0
	        INNER JOIN MENU M ON M.ID = OD.MENU_ID
          GROUP BY M.NAME
          ORDER BY SUM(OD.PRICE*QUANTITY) DESC
          LIMIT 5;');
		    return $query->result();  
        //return $query->row();
	}
	
	function get_latest_promotions()
	{
		$this->db->where('TYPE','PROMO');
		$this->db->order_by('DATE', 'DESC');
		$query = $this->db->get('promos_local_services',2);
		return $query->result();
	}
	
	function get_latest_services()
	{
		$this->db->where('TYPE','LOCAL_SERVICES');
		$this->db->order_by('DATE', 'DESC');
		$query = $this->db->get('promos_local_services',2);
		return $query->result();
	}
	
    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}