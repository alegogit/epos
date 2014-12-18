<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process_model extends CI_Model {
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
  
  function get_order_details($order_id)
	{
	     $query = $this->db->query('SELECT M.NAME, 
		          OD.QUANTITY, OD.KITCHEN_NOTE, OD.PRICE, OD.VOID, OD.VOID_REASON 
	         FROM ORDER_DETAILS OD
	         LEFT OUTER JOIN MENU M	ON M.ID = OD.MENU_ID
           WHERE ORDER_ID = '.$order_id.';');
		    return $query->result();
	}
	 	
	function update_printer($arrin){ 
	  date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'NAME' => $arrin[1],
               'REST_ID' => $arrin[2],
               'PRINTER_CONNECTION' => $arrin[3],
               'PRINTER_IP_ADDRESS' => $arrin[4],
               'PRINTER_PORT' => $arrin[5],
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
		$this->db->where('ID',$arrin[0]);
    $query = $this->db->update('printer',$data);
    $output[0] = $this->process->get_printer($arrin[0])->ID;
    $output[1] = $this->process->get_printer($arrin[0])->NAME; 
    $output[2] = $this->process->get_restaurant_name($this->process->get_printer($arrin[0])->REST_ID); 
    $output[3] = $this->process->get_connectivity($this->process->get_printer($arrin[0])->PRINTER_CONNECTION);
    $output[4] = $this->process->get_printer($arrin[0])->PRINTER_IP_ADDRESS;
    $output[5] = $this->process->get_printer($arrin[0])->PRINTER_PORT;
    $output[6] = $this->process->get_username($this->process->get_printer($arrin[0])->LAST_UPDATED_BY);
    $output[7] = $this->process->get_printer($arrin[0])->LAST_UPDATED_DATE;
    $outputs = implode(",",$output);   
    return $outputs;
	}
	
	function get_printer($pid){    
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
    $query = $this->db->select('printer.*')
                      ->from('printer')
                      ->join('users_restaurants', 'printer.REST_ID = users_restaurants.REST_ID')  
                      ->where('printer.ID',$pid)
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
         
  function get_connectivity($code){
    $query = $this->db->select('VALUE')
                      ->from('ref_values')
                      ->where('CODE',$code)
                      ->get('');
    return $query->row()->VALUE;
  }
  
}