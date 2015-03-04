<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurantsetting_model extends CI_Model {
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
	
	function update_restaurant($arrin){ 
	  date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
		$up = strstr($arrin[2], '__', true);
	  $data = array(
               $up => $arrin[1],
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
		$this->db->where('ID',$arrin[0]);
    $query = $this->db->update('RESTAURANTS',$data);
    $output[0] = $this->process->get_username($this->process->get_restaurant($arrin[0])->LAST_UPDATED_BY)->NAME;
    $output[1] = $this->process->get_restaurant($arrin[0])->LAST_UPDATED_DATE;
    $outputs = implode(",",$output);   
    return $outputs;
	}
  
  function delete_restaurant($rid){ 
		$did = strstr($rid, '_', true);
    $query = $this->db->query('DELETE R FROM RESTAURANTS R 
      LEFT JOIN USERS_RESTAURANTS UR ON UR.REST_ID = R.ID 
      LEFT JOIN TABLES TB ON TB.REST_ID = R.ID 
      LEFT JOIN DEVICES DV ON DV.REST_ID = R.ID 
      LEFT JOIN INVENTORY IV ON IV.REST_ID = R.ID 
      LEFT JOIN PRINTER PR ON PR.REST_ID = R.ID 
      LEFT JOIN ORDERS OD ON OD.REST_ID = R.ID 
      LEFT JOIN CUSTOMERS CU ON CU.REST_ID = R.ID 
      LEFT JOIN CATEGORY CA ON CA.REST_ID = R.ID 
      WHERE UR.REST_ID IS NULL
      AND TB.REST_ID IS NULL
      AND DV.REST_ID IS NULL
      AND IV.REST_ID IS NULL
      AND PR.REST_ID IS NULL
      AND OD.REST_ID IS NULL
      AND CU.REST_ID IS NULL
      AND CA.REST_ID IS NULL
      AND R.ID='.$did.';');    
    if($this->db->affected_rows()!=0){
      $out = "OK";
    } else {                        
		  //$idn = $this->process->get_tableorder($did)->TABLE_NUMBER;
      //$out = $idn." can not be deleted, it has been used by some userss";
      $out = "This Entry has being currently used, please make sure there's NO Dependencies";
    }
    return $out;
  } 
	
	function get_restaurant($rid){    
    $query = $this->db->select('*')
                      ->from('RESTAURANTS')  
                      ->where('ID',$rid)
                      ->limit(1)
                      ->get('');
    return $query->row();
  }
  
	function get_taken_email($email){    
    $query = $this->db->query('SELECT EMAIL_ADDRESS FROM RESTAURANTS WHERE EMAIL_ADDRESS = "'.$email.'";');
    if ($query->num_rows() > 0){
      $out = 'false';
    } else {
      $out = 'true';   
    }                  
    return $out;
  }  
  
	function get_taken_restname($restname){    
    $query = $this->db->query('SELECT NAME FROM RESTAURANTS WHERE NAME = "'.$restname.'";');
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