<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menusetting_model extends CI_Model {
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
	
	function update_menu($arrin){ 
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
    $query = $this->db->update('MENU',$data);
    $output[0] = $this->process->get_username($this->process->get_menu($arrin[0])->LAST_UPDATED_BY)->NAME;
    $output[1] = $this->process->get_menu($arrin[0])->LAST_UPDATED_DATE;
    $outputs = implode(",",$output);   
    return $outputs;
	}
  
  	function delete_menu($mid){ 
		$did = strstr($mid, '_', true);
    	$query = $this->db->query('DELETE M FROM MENU M 
      		LEFT JOIN ORDER_DETAILS O ON O.MENU_ID = M.ID 
      		WHERE O.MENU_ID IS NULL
      		AND M.ID='.$did.';');    
    	if($this->db->affected_rows()!=0){
      		$out = "OK";
    	} else {                        
			//$idn = $this->process->get_tableorder($did)->TABLE_NUMBER;
      		//$out = $idn." can not be deleted, it has been used by some menus";
      		$out = "This Entry has being currently used, please make sure there's NO Dependencies";
    	}
    	return $out;
  	} 
	
	function get_menu($cid){    
    $query = $this->db->select('*')
                      ->from('MENU')  
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
    $query = $this->db->select('NAME,USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
                      ->get('');
    return $query->row();
  }
}