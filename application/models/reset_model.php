<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Reset_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function get_user_id($user) {
        $query = $this->db->select('ID')
                          ->from('USERS')
                          ->where('USERNAME', $user) 
                          ->limit(1)
                          ->get('');
        if($query->num_rows() == 1){ 
            return $query->row()->ID; //if data is true
        }	else {
            return false; //if data is wrong
        }
    }
    
    function change_password($id,$pass){
  	  date_default_timezone_set('Asia/Jakarta');
  		$dt = date('Y-m-d H:i:s');
  	  $data = array(
                 'PASSWORD' => $pass,
                 'LAST_UPDATED_BY' => $id,
                 'LAST_UPDATED_DATE' => $dt,
              ); 
  		$this->db->where('ID',$id);
      $query = $this->db->update('USERS',$data);
    }
}