<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extracts_model extends CI_Model {
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
  
  function get_restaurant(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
    $query = $this->db->select('*')
                      ->from('restaurants')
                      ->join('users_restaurants', 'restaurants.ID = users_restaurants.REST_ID')
                      ->get('');
    return $query->result();
  }
    
	function get_username($id){
    $query = $this->db->select('USERNAME')
                      ->from('users')
                      ->where('ID',$id)
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
  
  function get_orders_data($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query('SELECT O.ORDER_NUMBER ORDER_NUMBER,
	          M.NAME	MENU_NAME,
            OD.PRICE PRICE, OD.QUANTITY QUANTITY, OD.KITCHEN_NOTE KITCHEN_NOTE,	OD.VOID	ITEM_VOID, OD.VOID_REASON	ITEM_VOID_REASON,
	          C.NAME CUSTOMER_NAME,
          	O.STARTED	STARTED, O.ENDED ENDED, O.NO_OF_GUEST NO_OF_GUEST, 
            O.TOTAL TOTAL_AMOUNT, O.PAID_AMOUNT PAID_AMOUNT, O.CURRENCY CURRENCY, O.PAYMENT_METHOD	PAYMENT_METHOD, O.TIP	TIP, O.DISCOUNT	DISCOUNT,
            O.VOID ORDER_VOID, O.VOID_REASON ORDER_VOID_REASON,
	          R.NAME RESTAURANT_NAME,
            O.CREATED_DATE ORDER_CREATED_DATE, O.LAST_UPDATED_DATE ORDER_LAST_UPDATED_DATE,
            U.NAME ORDER_LAST_UPDATED_BY
          FROM ORDERS O
          INNER JOIN ORDER_DETAILS OD	ON O.ID = OD.ORDER_ID
          INNER JOIN RESTAURANTS R ON R.ID = O.REST_ID
          INNER JOIN CUSTOMERS C ON C.ID = O.CUSTOMER_ID
          INNER JOIN MENU M ON M.ID = OD.MENU_ID
          INNER JOIN USERS U ON U.ID = O.LAST_UPDATED_BY
          WHERE O.ACTIVE = 0
          AND O.ENDED BETWEEN "'.$start_date.'" AND "'.$end_date.'"
          AND R.ID = '.$rest_id.';');
       $header = "";     
       foreach ($query->list_fields() as $field){
          $header .= $field."\t";
          //$header .= $field."|";
       }    
       $data = '';  
       $line = ''; 
       foreach($query->result() as $rows){          
          foreach($rows as $value){                                           
            if((!isset($value)) || ($value == "")){
              $value = "\t";
            } else {
              $value = str_replace( '"' , '""' , $value );
              $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;   
          }
          $data .= trim( $line ) . "\n";
       }
       //$data = str_replace("\r" , "" , $data);
       if ($data == ""){
          $data = "\n No Record Found!\n";                       
       }
       $output[0] = $header;
       $output[1] = $data;
       $output[2] = $query->result();
		   return $output;
		   //return "$output[0]\n$output[1]";    
		    //return $query->result();
	}
	
	function export_excel_csv()
  {
    $num_fields = mysql_num_fields($rec);
   
    for($i = 0; $i < $num_fields; $i++ )
    {
        $header .= mysql_field_name($rec,$i)."\\t";
    }
   
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        foreach($row as $value)
        {                                           
            if((!isset($value)) || ($value == ""))
            {
                $value = "\\t";
            }
            else
            {
                $value = str_replace( '"' , '""' , $value );
                $value = '"' . $value . '"' . "\\t";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\\n";
    }
   
    $data = str_replace("\\r" , "" , $data);
   
    if ($data == "")
    {
        $data = "\\n No Record Found!\n";                       
    }
   
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=reports.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\\n$data";
  }
		
}