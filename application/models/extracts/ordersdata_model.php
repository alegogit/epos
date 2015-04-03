<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordersdata_model extends CI_Model {
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
		if($session_data['role']!=1){   
      $this->db->where('USERS_RESTAURANTS.USER_ID',$id);
      $query = $this->db->select('*')
                        ->from('RESTAURANTS')
                        ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                        ->get('');
    } else {  
      $query = $this->db->select('*,ID AS REST_ID')
                        ->from('RESTAURANTS')
                        ->get('');
    }
    return $query->result();
  }           
  
  function get_rest_logo(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id); 
		$this->db->where('USERS_RESTAURANTS.DEFAULT_REST',1);
    $query = $this->db->select('LOGO_URL')
                      ->from('RESTAURANTS')
                      ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                      ->limit(1)
                      ->get('');
    return $query->row()->LOGO_URL;
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
    return $query->row()->REST_NAME;
  }
  
  function get_orders_data($start_date,$end_date,$rest_id)
	{
	     $query = $this->db->query("SELECT R.NAME	RESTAURANT_NAME, 
                                        CURRENCY.VALUE CURRENCY,
                                        O.ORDER_NUMBER ORDER_NUMBER,
                                        TABLENUMBER.TABLE_NUMBER TABLE_NUMBER,
                                        O.STARTED	STARTED, O.ENDED ENDED, 
                                        O.NO_OF_GUEST	NO_OF_GUEST, 
                                        O.TOTAL TOTAL_AMOUNT,	
                                        O.DISCOUNT DISCOUNT,
	O.TIP														TIP,
    O.TOTAL_ROUNDING											TOTAL_ROUNDING,
    O.TOTAL_TAX													TOTAL_TAX,
    O.SERVICE_CHARGE											SERVICE_CHARGE,
    O.DELIVERY_FEE												DELIVERY_FEE,
    O.PAID_AMOUNT												PAID_AMOUNT,
    ORDER_TYPE.VALUE											ORDER_TYPE,
    IF(O.VOID =0, 'NO', 'YES')									ORDER_VOID,
    O.VOID_REASON												ORDER_VOID_REASON,
	
	C.NAME														CUSTOMER_NAME,
	PAYMENT_METHOD.VALUE										PAYMENT_METHOD,
    I.TOTAL              										INVOICE_TOTAL,
	I.DISCOUNT													INVOICE_DISCOUNT,
	I.TIP														INVOICE_TIP,
    I.ROUNDING													INVOICE_ROUNDING,
    I.TOTAL_TAX													INVOICE_TOTAL_TAX,
    I.SERVICE_CHARGE											INVOICE_SERVICE_CHARGE,
    I.PAID_AMOUNT												INVOICE_PAID_AMOUNT,
    TERMINAL.NAME												TERMINAL_NAME,
    
    OD.RANK														ORDER_DETAIL_RANK,
    OD.MENU_NAME												MENU_NAME,
	OD.CATEGORY_NAME											CATEGORY_NAME,  
    OD.PRICE        	    									PRICE,
    OD.QUANTITY         										QUANTITY,
    OD.TOTAL													TOTAL,
	OD.KITCHEN_NOTE         									KITCHEN_NOTE,
	IF(OD.VOID =0, 'NO', 'YES')	       							ITEM_VOID,
	OD.VOID_REASON												ITEM_VOID_REASON,
    
	GREATEST(O.CREATED_DATE, OD.CREATED_DATE,
				I.CREATED_DATE)									ORDER_CREATED_DATE,
	GREATEST(O.LAST_UPDATED_DATE, OD.LAST_UPDATED_DATE,
				I.LAST_UPDATED_DATE)							ORDER_LAST_UPDATED_DATE,
    U.NAME														ORDER_LAST_UPDATED_BY
FROM (SELECT @rownum:=0) r, ORDERS O
INNER JOIN RESTAURANTS R
	ON R.ID = O.REST_ID
    AND O.REST_ID = ".$rest_id."
	AND O.ACTIVE = 0
    AND O.ENDED BETWEEN '".$start_date."' AND DATE_ADD('".$end_date."', INTERVAL 1 DAY)
LEFT OUTER JOIN REF_VALUES CURRENCY
	ON CURRENCY.CODE = O.CURRENCY
		AND CURRENCY.LOOKUP_NAME = 'CURRENCY' AND CURRENCY.IS_ACTIVE = 1
LEFT OUTER JOIN TABLES TABLENUMBER
	ON TABLENUMBER.ID = O.TABLE_ID
LEFT OUTER JOIN REF_VALUES ORDER_TYPE
	ON ORDER_TYPE.CODE = O.ORDER_TYPE
		AND ORDER_TYPE.LOOKUP_NAME = 'ORDER_TYPE' AND ORDER_TYPE.IS_ACTIVE = 1
INNER JOIN INVOICES_ORDERS OI 
	ON OI.ORDER_ID = O.ID
INNER JOIN INVOICES I 
	ON I.ID = OI.INVOICE_ID
LEFT OUTER JOIN CUSTOMERS C
	ON C.ID = I.CUSTOMER_ID

LEFT OUTER JOIN REF_VALUES PAYMENT_METHOD
	ON PAYMENT_METHOD.CODE = I.PAYMENT_METHOD
		AND PAYMENT_METHOD.LOOKUP_NAME = 'PAYMENT_METHOD' AND PAYMENT_METHOD.IS_ACTIVE = 1
INNER JOIN TERMINAL TERMINAL
	ON TERMINAL.ID = I.TERMINAL_ID

INNER JOIN ORDER_DETAILS OD
	ON OD.INVOICE_ID = I.ID
INNER JOIN USERS U
	ON U.ID = O.LAST_UPDATED_BY;");
       $header = "";     
       foreach ($query->list_fields() as $field){
          $header .= $field."|";
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
       $output[3] = count($output[0]);
       $output[5] = $this->key_orders_data($output[2]);
		   return $output;
		   //return "$output[0]\n$output[1]";    
		    //return $query->result();
	}             
  
  function key_orders_data($result){
    $out_arr = array();
    $i=0;
    foreach($result as $key){
      $out_arr[0][$i] = $key->ORDER_NUMBER;
      $out_arr[1][$i] = $key->MENU_NAME;
      $out_arr[2][$i] = $key->PRICE;
      $out_arr[3][$i] = $key->QUANTITY;
      $out_arr[4][$i] = $key->KITCHEN_NOTE;
      $out_arr[5][$i] = $key->ITEM_VOID;
      $out_arr[6][$i] = $key->ITEM_VOID_REASON;
      $out_arr[7][$i] = $key->CUSTOMER_NAME;
      $out_arr[8][$i] = $key->STARTED;
      $out_arr[9][$i] = $key->ENDED;
      $out_arr[10][$i] = $key->NO_OF_GUEST;
      $out_arr[11][$i] = $key->TOTAL_AMOUNT;
      $out_arr[12][$i] = $key->PAID_AMOUNT;
      $out_arr[13][$i] = $key->CURRENCY;
      $out_arr[14][$i] = $key->PAYMENT_METHOD;
      $out_arr[15][$i] = $key->TIP;  
      $out_arr[16][$i] = $key->DISCOUNT;
      $out_arr[17][$i] = $key->ORDER_VOID;
      $out_arr[18][$i] = $key->ORDER_VOID_REASON;
      $out_arr[19][$i] = $key->RESTAURANT_NAME;
      $out_arr[20][$i] = $key->ORDER_CREATED_DATE;
      $out_arr[21][$i] = $key->ORDER_LAST_UPDATED_DATE;
      $out_arr[22][$i] = $key->ORDER_LAST_UPDATED_BY;
      $i++;
    }
    return $out_arr;
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