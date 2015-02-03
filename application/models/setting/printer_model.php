<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printer_model extends CI_Model {
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
  
	function get_all_connectivity(){
    $query = $this->db->select('CODE,VALUE')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME','PRINTER_CONNECTION')
                      ->get('');
    return $query->result();
  }
  
  function get_connectivity($code){
    $query = $this->db->select('VALUE')
                      ->from('REF_VALUES')
                      ->where('CODE',$code)
                      ->get('');
    return $query->row();
  }
  
	function get_printer0(){
    $query = $this->db->select('PRINTER.*,RESTAURANTS.NAME AS REST_NAME')
                      ->from('PRINTER')
                      ->join('RESTAURANTS', 'PRINTER.REST_ID = RESTAURANTS.ID')
                      ->get('');
    return $query->result();
  }
  
	function get_printer1(){
    $query = $this->db->get('PRINTER');
    return $query->result();
  }
     
	function get_printer2(){    
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id);
    $query = $this->db->select('PRINTER.*')
                      ->from('PRINTER')
                      ->join('USERS_RESTAURANTS', 'PRINTER.REST_ID = USERS_RESTAURANTS.REST_ID')
                      ->get('');
    return $query->result();
  } 
  
  function get_printer($rest_id){    
    $this->db->where('REST_ID',$rest_id);
    $query = $this->db->get('PRINTER');
    return $query->result();
  }       
    
	function new_printer($NAME,$PRINTER_MAC_ADDRESS,$REST_ID,$PRINTER_CONNECTION,$PRINTER_IP_ADDRESS,$PRINTER_PORT){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    	$query = $this->db->query('INSERT INTO PRINTER 
      		(NAME,PRINTER_MAC_ADDRESS,REST_ID,PRINTER_CONNECTION,PRINTER_IP_ADDRESS,PRINTER_PORT,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      		VALUES 
      		("'.$NAME.'","'.$PRINTER_MAC_ADDRESS.'",'.$REST_ID.',"'.$PRINTER_CONNECTION.'","'.$PRINTER_IP_ADDRESS.'","'.$PRINTER_PORT.'",'.$id.',NOW(),'.$id.',NOW());');
		//return $query->row();
  	}               
   
}