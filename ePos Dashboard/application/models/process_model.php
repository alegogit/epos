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
    return $dt;
	}
}