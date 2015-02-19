<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customersprocess_model extends CI_Model {
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
	
	function update_customers($arrin){ 
	  	date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
		$up = strstr($arrin[2], '-', true);
	  	$data = array(
               $up => $arrin[1],
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
		$this->db->where('ID',$arrin[0]);
    	$query = $this->db->update('CUSTOMERS',$data);
    	$output[0] = $this->process->get_name($this->process->get_customers($arrin[0])->LAST_UPDATED_BY);
    	$output[1] = $this->process->get_customers($arrin[0])->LAST_UPDATED_DATE;
    	$outputs = implode(",",$output);   
    	return $outputs;
	}
		  
  	function delete_customers($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE C FROM CUSTOMERS C 
      		LEFT JOIN ORDERS O ON O.CUSTOMER_ID = C.ID 
      		WHERE O.CUSTOMER_ID IS NULL
      		AND C.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {       
      		$out = "This Entry has being currently used, please make sure there's NO Dependencies";
    	}
    	return $out;
  } 
	
	function get_customers($cid){    
    	$query = $this->db->select('*')
                      ->from('CUSTOMERS')  
                      ->where('ID',$cid)
                      ->limit(1)
                      ->get('');
    	return $query->row();
  	}      
                     
	function get_restaurant_name($id){
    	$query = $this->db->select('NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row()->REST_NAME;
  	}
  
  	function get_username($id){
    	$query = $this->db->select('USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
                      ->get('');
    	return $query->row()->USERNAME;
  	}
  	
  	function get_name($id){
    	$query = $this->db->select('NAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
                      ->get('');
    	return $query->row()->NAME;
  	}
}