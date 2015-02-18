<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model {
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
  
  	function get_restaurant(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id);
    	$query = $this->db->select('*')
                      ->from('RESTAURANTS')
                      ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                      ->get('');
    	return $query->result();
  	}
    
	function get_username($id){
    	$query = $this->db->select('USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row();
  	}
  
	function get_restaurant_name($id){
    	$query = $this->db->select('NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->where('ID',$id)
                      ->get('');
    	return $query->row();
  	}    
  
	function get_rest_inventory($rest_id){    
    	$this->db->where('REST_ID',$rest_id);
    	$query = $this->db->get('INVENTORY');
    	return $query->result();
  	}
	
	function get_metrics(){
    	$query = $this->db->select('CODE,VALUE')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME', 'METRIC')
                      ->get('');
    	return $query->result();
	} 
	
	function get_metric_name($metric_id){
    	$query = $this->db->select('VALUE')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME', 'METRIC')
                      ->where('CODE', $metric_id)
                      ->limit(1)
                      ->get('');
    	return $query->row();
	} 
	
	function get_waste_freq($waste_fr){
    	$query = $this->db->select('VALUE')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME', 'WASTAGE_FREQ')
                      ->where('CODE', $waste_fr)
                      ->limit(1)
                      ->get('');
    	return $query->row();
	} 
	
	function get_waste_freq_list(){
    	$query = $this->db->select('CODE,VALUE')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME', 'WASTAGE_FREQ')
                      ->get('');
    	return $query->result();
	} 
   
	function new_inventory($NAME,$QTY,$METRIC,$MINQ,$REST_ID){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    	$query = $this->db->query('INSERT INTO INVENTORY
      		(NAME,QUANTITY,METRIC,MIN_QUANTITY,REST_ID,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      		VALUES 
      		("'.$NAME.'",'.$QTY.',"'.$METRIC.'","'.$MINQ.'",'.$REST_ID.','.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  	}
	
	function set_class($qty,$std){
		if($qty>$std){
			$class = "";
		} else {
			if($qty!=0){
				$class = "warning";
			} else {
				$class = "danger";
			}
		}
		return $class;	
	}
  
}