<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableordersetting_model extends CI_Model {
  function __construct(){
    // Call the Model constructor
    parent::__construct();
  }
	 
	function get_profile(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('ID',$id);
    $query = $this->db->get('users');
    return $query->row();
  }  
	
	function update_tableorder($arrin){ 
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
    $query = $this->db->update('tables',$data);
    $output[0] = $this->process->get_username($this->process->get_tableorder($arrin[0])->LAST_UPDATED_BY);
    $output[1] = $this->process->get_tableorder($arrin[0])->LAST_UPDATED_DATE;
    $outputs = implode(",",$output);   
    return $outputs;
	}
	
	function delete_tableorder($cid){ 
		$did = strstr($cid, '_', true); 
		$idn = $this->process->get_tableorder($did)->NAME;
    $query = $this->db->query('DELETE t FROM tables t 
      LEFT JOIN menu m ON m.CATEGORY_ID = t.ID 
      WHERE m.CATEGORY_ID IS NULL
      AND t.ID='.$did.';');    
    if($this->db->affected_rows()!=0){
      $out = "OK";
    } else {
      //$out = $idn." can not be deleted, it has been used by some menus";
      $out = "This Entry has being currently used, please make sure there's NO Dependencies";
    }
    return $out;
  }   
	
	function get_tableorder($cid){    
    $query = $this->db->select('*')
                      ->from('tables')  
                      ->where('ID',$cid)
                      ->limit(1)
                      ->get('');
    return $query->row();
  }      
                     
	function get_restaurant_name($id){
    $query = $this->db->select('NAME AS REST_NAME')
                      ->from('restaurants')
                      ->where('ID',$id)
                      ->get('');
    return $query->row()->REST_NAME;
  }
  
  function get_username($id){
    $query = $this->db->select('USERNAME')
                      ->from('users')
                      ->where('ID',$id)
                      ->get('');
    return $query->row()->USERNAME;
  }
}