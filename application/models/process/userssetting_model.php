<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userssetting_model extends CI_Model {
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
	
	function update_users($arrin){ 
	  	date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
		$up = strstr($arrin[2], '-', true);
		if ($up=="DEF_REST"){
	  		$data1 = array(
               'DEFAULT_REST' => 0,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
			$this->db->where('USER_ID',$arrin[0]);
			$this->db->where('REST_ID != '.$arrin[1]);
    		$query1 = $this->db->update('USERS_RESTAURANTS',$data1);
	  		$data2 = array(
               'DEFAULT_REST' => 1,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
			$this->db->where('USER_ID',$arrin[0]);
			$this->db->where('REST_ID',$arrin[1]);
    		$query2 = $this->db->update('USERS_RESTAURANTS',$data2);
		} else {
	  		$data = array(
               $up => $arrin[1],
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
			$this->db->where('ID',$arrin[0]);
    		$query = $this->db->update('USERS',$data);
    	}
		$output[0] = $this->process->get_username($this->process->get_users($arrin[0])->LAST_UPDATED_BY)->NAME;
    	$output[1] = $this->process->get_users($arrin[0])->LAST_UPDATED_DATE;
    	$outputs = implode(",",$output);   
    	return $outputs;
	}
  
  	function delete_users($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE U FROM USERS U 
      		LEFT JOIN ORDERS O ON O.USER_ID = U.ID 
      		WHERE O.USER_ID IS NULL
      		AND U.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {                        
			$out = "This Entry has being currently used, please make sure there's NO Dependencies";
    	}
    	return $out;
  	} 
	
	function get_users($cid){    
    	$query = $this->db->select('*')
                      ->from('USERS')  
                      ->where('ID',$cid)
                      ->limit(1)
                      ->get('');
    	return $query->row();
  	}
  
	function get_taken_email($email){    
    	$query = $this->db->query('SELECT EMAIL_ADDRESS FROM USERS WHERE EMAIL_ADDRESS = "'.$email.'";');
    	if ($query->num_rows() > 0){
      		$out = 'false';
    	} else {
      		$out = 'true';   
    	}                  
    	return $out;
  	}  
  
	function get_taken_username($username){    
    	$query = $this->db->query('SELECT USERNAME FROM USERS WHERE USERNAME = "'.$username.'";');
    	if ($query->num_rows() > 0){
      		$out = 'false';
    	} else {
      		$out = 'true';
    	}                  
    	return $out;
  	}      
                     
	function get_restaurant_name($id){
    	$query = $this->db->select('NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row()->REST_NAME;
  	}
  
  function get_username($id){
    $query = $this->db->select('NAME,USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
                      ->get('');
    return $query->row();
  }
}