<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Inventorywastage_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function login($username, $password) {
        $this->db->where('USERS.USERNAME', $username);
        $this->db->where('USERS.PASSWORD', $password);  
        $this->db->limit(1);
        $this->db->join('USERS_RESTAURANTS', 'USERS.ID = USERS_RESTAURANTS.USER_ID');   
        $this->db->where('USERS_RESTAURANTS.DEFAULT_REST', 1); 
        $query = $this->db->get('USERS');
        if($query->num_rows() == 1){
          return $query->result(); //if data is true
        } else {
          return false; //if data is wrong
        }               		
    }
    
    function get_daily_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC 
                                  WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1) 
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_DAY';"); 
      return $query->result();
    }
    
    function get_weekly_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC
                                	WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1)
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_WEEK';"); 
      return $query->result();
    }    
    
    function get_monthly_waste(){
      $query = $this->db->query("SELECT ID, QUANTITY, METRIC, WASTAGE_PERCENT, WASTAGE_FREQ, 
                                  CASE METRIC
                                	WHEN 'PIECES' THEN ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 0) 
                                  ELSE ROUND(QUANTITY * (100 - WASTAGE_PERCENT)/ 100, 1)
                                  END  AS NEW_QUANTITY
                                FROM INVENTORY
                                WHERE WASTAGE_FREQ = 'PER_MONTH';"); 
      return $query->result();
    }    
    
	function update_quantity($uid,$iid,$qty){ 
	  date_default_timezone_set('Asia/Jakarta');
		$id = $uid; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'QUANTITY' => $qty,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt
            ); 
		$this->db->where('ID',$iid);
    $query = $this->db->update('INVENTORY',$data);
	}
        
}