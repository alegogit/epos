<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventoryprocess_model extends CI_Model {
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
	
	function update_inventory($arrin){ 
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
    	$query = $this->db->update('INVENTORY',$data);
    	$output[0] = $this->process->get_username($this->process->get_inventory($arrin[0])->LAST_UPDATED_BY);
    	$output[1] = $this->process->get_inventory($arrin[0])->LAST_UPDATED_DATE;
    	$outputs = implode(",",$output);   
    	return $outputs;
	}
	
	function delete_inventory0($cid){ 
		$did = strstr($cid, '_', true);
    	$query = $this->db->where('ID', $did);
    	$query = $this->db->limit(1);
    	$query = $this->db->delete('INVENTORY');
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {                  
      		$out = "Unable to delete";
    	}
    	return $out;
  	}   
	  
  	function delete_inventory($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE I FROM INVENTORY I 
      		LEFT JOIN MENU_INVENTORY M ON M.INVENTORY_ID = I.ID 
      		WHERE M.INVENTORY_ID IS NULL
      		AND I.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {       
      		$out = "This Entry has being currently used, please make sure there's NO Dependencies";
    	}
    	return $out;
  } 
	
	function get_inventory($cid){    
    	$query = $this->db->select('*')
                      ->from('INVENTORY')  
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
                      ->get('');
    	return $query->row()->USERNAME;
  	}
}