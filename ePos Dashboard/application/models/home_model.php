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
                              ->join('users_restaurants', 'restaurants.ID = users_restaurants.RESTAURANT_ID')
                              ->get('');
          return $query->result();
    }

	function num_transactions_today()
	{
	     $query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS res FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID = 1;');
		//return $query->result();  
          return $query->row();
	}
     
     function percentage_increase_from_yesterday()
	{
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID =1)
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE DATE(ENDED) = DATE(SUBDATE(SYSDATE(),1)) AND REST_ID =1)
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
		FROM DUAL;');
		//return $query->result();  
          return $query->row();
	}
	
	function total_sales_today()
	{
	     $query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS res FROM ORDERS WHERE DATE(ENDED) = DATE(SYSDATE()) AND REST_ID =1;');
		//return $query->result();  
          return $query->row();
	}
     
     function num_transactions_this_year()
	{
	     $query = $this->db->query('SELECT IFNULL(COUNT(ID),0) AS res FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID =1;');
		//return $query->result();  
          return $query->row();
	}
     
     function percentage_increase_from_last_week()
	{
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = 1)
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) 
														AND (DATE(ENDED) < DATE(SUBDATE(SYSDATE(),7))) 
														AND REST_ID = 1)
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
		FROM DUAL;');
		//return $query->result();  
          return $query->row();
	}
	
	function percentage_increase_this_year()
	{                                                                   
	     $query = $this->db->query('SELECT
			IFNULL((((
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID = 1)
				/ 
				(SELECT IFNULL(SUM(TOTAL),0) FROM ORDERS WHERE (YEAR(ENDED) = YEAR(SYSDATE())) AND (
						DATE(ENDED) < GREATEST(DATE_FORMAT(NOW() ,"%Y-01-01"), DATE_SUB(SYSDATE(), INTERVAL 6 MONTH))
                        ) AND
                        REST_ID = 1)
			) -1 ) *100 ) ,0)
			AS PERCENTAGE
		FROM DUAL;');
		//return $query->result();  
          return $query->row();
	}
	
	function total_sales_this_year()
	{
	     $query = $this->db->query('SELECT IFNULL(SUM(TOTAL),0) AS res FROM ORDERS WHERE YEAR(ENDED) = YEAR(SYSDATE()) AND REST_ID =1');
		//return $query->result();  
          return $query->row();
	}
     
     function num_customers_30day()
	{
	     $query = $this->db->query('SELECT COUNT(C.ID) AS res 
          FROM CUSTOMERS C
			INNER JOIN ORDERS O ON O.CUSTOMER_ID = C.ID
            WHERE O.REST_ID = 1
				AND O.ENDED > SUBDATE(SYSDATE(), 30);');
		//return $query->result();  
          return $query->row();
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