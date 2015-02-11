<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menuinventorysetting_model extends CI_Model {
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
	
	function update_menuinventory($arrin){ 
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
    $query = $this->db->update('MENU_INVENTORY',$data);
    //$output[0] = $this->process->get_username($this->process->get_menuinventory($arrin[0])->LAST_UPDATED_BY);
    $output[0] = $this->process->get_name($this->process->get_menuinventory($arrin[0])->LAST_UPDATED_BY);
    $output[1] = $this->process->get_menuinventory($arrin[0])->LAST_UPDATED_DATE;
    $outputs = implode(",",$output);   
    return $outputs;
	}
  
  	function delete_menuinventory0($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE MI FROM MENU_INVENTORY MI 
      		LEFT JOIN INVENTORY I ON I.ID = MI.INVENTORY_ID 
      		WHERE I.ID IS NULL
      		AND MI.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {                        
			//$idn = $this->process->get_tableorder($did)->TABLE_NUMBER;
      		//$out = $idn." can not be deleted, it has been used by some menus";
      		$out = "This Entry has being currently used, please make sure there's NO Dependencies";
    	}
    	return $out;
  	} 
  	
  	function delete_menuinventory($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE MI FROM MENU_INVENTORY MI
      		WHERE MI.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {                        
      		$out = "Cannot be deleted";
    	}
    	return $out;
  	} 
	
	function get_menuinventory($cid){    
    $query = $this->db->select('*')
                      ->from('MENU_INVENTORY')  
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
    
  function get_name($id){
    $query = $this->db->select('NAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->get('');
    return $query->row()->NAME;
  }
}