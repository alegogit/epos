<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Restaurant_model extends CI_Model {
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
  
  function get_rest_logo0(){
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('USERS_RESTAURANTS.USER_ID',$id); 
		$this->db->where('USERS_RESTAURANTS.DEFAULT_REST',1);
    $query = $this->db->select('LOGO_URL, RESTAURANTS.NAME AS REST_NAME')
                      ->from('RESTAURANTS')
                      ->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID')
                      ->limit(1)
                      ->get('');
    return $query->row();
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
    $query = $this->db->select('NAME,USERNAME')
                      ->from('USERS')
                      ->where('ID',$id)
                      ->limit(1)
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
  
	function new_id(){
    $query = $this->db->select('MAX(ID)+1 AS NEW_ID')
                      ->from('RESTAURANTS')
                      ->get('');
    return $query->row()->NEW_ID;
  }    
  
	function get_restaurant_data(){ 
		$session_data = $this->session->userdata('logged_in');  
		$role = $session_data['role'];                             
		$id = $session_data['id'];
		if($role>1){
      $query = $this->db->where('USERS_RESTAURANTS.USER_ID',$id);
      $query = $this->db->join('USERS_RESTAURANTS', 'RESTAURANTS.ID = USERS_RESTAURANTS.REST_ID');
    }
    $query = $this->db->select('RESTAURANTS.*, REF_VALUES.VALUE AS CURRENCY_NAME')
                      ->from('RESTAURANTS')
                      ->join('REF_VALUES', 'RESTAURANTS.CURRENCY = REF_VALUES.CODE')
                      ->where('REF_VALUES.LOOKUP_NAME','CURRENCY')
                      ->get('');
    return $query->result();                                           
  }
  
	function get_currencies(){
    $query = $this->db->select('CODE,VALUE,DESCRIPTION')
                      ->from('REF_VALUES')
                      ->where('LOOKUP_NAME','CURRENCY')
                      ->get('');
    return $query->result();
  }
    
  function get_default_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.DEFAULT_REST=1 AND USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    $output = ($this->db->affected_rows()>0)?$query->row():"NONE";
    return $output;
  } 
  
  function get_assigned_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.REST_ID, RESTAURANTS.NAME AS NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    return $query->result();
  } 
  
  function get_users_rest($user_id){                         
    $query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.USER_ID = '.$user_id.'
                              ');
    return $query->result();
  }
  
  function get_role_name($role_id){
    $query = $this->db->select('NAME')
                      ->from('ROLES')
                      ->where('ID',$role_id)
                      ->limit(1)
                      ->get('');
    return $query->row()->NAME;
  }
  
  function get_roles(){         
		$session_data = $this->session->userdata('logged_in');  
		$role = $session_data['role'];   
		if($role>1){
      $query = $this->db->where('ID > 2');
    }
    $query = $this->db->select('ID,NAME')
                      ->from('ROLES')
                      ->get('');
    return $query->result();
  }  
   
	function get_country($country_code,$set=1){ 
    if (strlen($country_code)>2){
      return $country_code." <span style='color:#dd1144 !important;'><i>(please select)</i></span>";
    } else {   
      $query = $this->db->select('CODE AS COUNTRY_CODE, VALUE AS COUNTRY_NAME')
                        ->from('REF_VALUES')
                        ->where('LOOKUP_NAME','COUNTRY')  
                        ->where('CODE',$country_code)  
                        ->limit(1)
                        ->get('');
      if($set==1){               
        return $query->row()->COUNTRY_CODE;
      } else {             
        return $query->row()->COUNTRY_NAME;
      }   
    }   
  } 
  
	function get_countries(){    
    $this->db->where('LOOKUP_NAME','COUNTRY');   
    $this->db->order_by("VALUE","ASC");
    $query = $this->db->get('REF_VALUES');
    return $query->result();
  }
  
	function get_status(){  
    $this->db->where('LOOKUP_NAME','STATUS');
    $query = $this->db->get('REF_VALUES');
    return $query->result();
  }
  
  function set_status($stat){
    if($stat==1){
      $output = "Active";
    } else {
      $output = "<span style='color:#dd1144 !important;'>Inactive</span>";
    }
  } 
   
	function new_restaurant($NAME,$TELEPHONE,$FAX,$ADDRESS_LINE_1,$ADDRESS_LINE_2,$CITY,$POSTAL_CODE,$COUNTRY,$GEOLOC,$EMAIL_ADDRESS,$CURRENCY,$NPWP,$CUTOFF_TIME,$SERVICE_CHARGE,$TAKEOUT_SERVICE_CHARGE,$LOGO_URL){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query1 = $this->db->query('INSERT INTO RESTAURANTS
      (NAME,TELEPHONE,FAX,ADDRESS_LINE_1,ADDRESS_LINE_2,CITY,POSTAL_CODE,COUNTRY,GEOLOC,EMAIL_ADDRESS,CURRENCY,NPWP,CUTOFF_TIME,SERVICE_CHARGE,TAKEOUT_SERVICE_CHARGE,LOGO_URL,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ("'.$NAME.'","'.$TELEPHONE.'","'.$FAX.'","'.$ADDRESS_LINE_1.'","'.$ADDRESS_LINE_2.'","'.$CITY.'","'.$POSTAL_CODE.'","'.$COUNTRY.'","'.$GEOLOC.'","'.$EMAIL_ADDRESS.'","'.$CURRENCY.'","'.$NPWP.'","'.$CUTOFF_TIME.'",'.$SERVICE_CHARGE.','.$TAKEOUT_SERVICE_CHARGE.',"'.$LOGO_URL.'",'.$id.',NOW(),'.$id.',NOW());');
    $REST_ID = $this->setting->get_restid_bymail($EMAIL_ADDRESS);
    $config = $this->config->config;
    $admin_users = $this->setting->get_admin_users($config['admin_id']);
    foreach($admin_users as $row){   
      $this->setting->assigntoadmin($row->ID,$REST_ID);
    }
  } 
  
	function get_restid_bymail($imel){  
    $query = $this->db->select('ID')
                      ->from('RESTAURANTS')
                      ->where('EMAIL_ADDRESS',$imel)
                      ->limit(1)
                      ->get('');
    return $query->row()->ID;
  }
  
	function get_admin_users($arole){  
    $query = $this->db->select('ID')
                      ->from('USERS')
                      ->where('ROLE_ID',$arole)
                      ->get('');
    return $query->result();
  }
  
  function assigntoadmin($USER_ID,$REST_ID){       
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
    $query1 = $this->db->query('INSERT INTO USERS_RESTAURANTS
      (USER_ID,REST_ID,DEFAULT_REST,CREATED_BY,CREATED_DATE,LAST_UPDATED_BY,LAST_UPDATED_DATE) 
      VALUES 
      ('.$USER_ID.','.$REST_ID.',0,'.$id.',NOW(),'.$id.',NOW());');
  }  
  
  
	function update_logo($pic_url,$rest_id){ 
	  date_default_timezone_set('Asia/Jakarta');
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id']; 
		$dt = date('Y-m-d H:i:s');
	  $data = array(
               'LOGO_URL' => $pic_url,
               'LAST_UPDATED_BY' => $id,
               'LAST_UPDATED_DATE' => $dt,
            ); 
		$this->db->where('ID',$rest_id);
    $query = $this->db->update('RESTAURANTS',$data);
	}
  
  function gettyimg($id){ 
    $iddt = strval(date('Ym')).$id.strval(date('dH'));
    $num2c = array(
                "1" => "q",
                "2" => "w",
                "3" => "e",
                "4" => "r",
                "5" => "t",
                "6" => "y",
                "7" => "u",
                "8" => "i",
                "9" => "o",
                "0" => "p"
            );
    $gembok = "";
    for($i=0;$i<strlen($iddt);$i++){  
      $gembok .= $num2c[$iddt[$i]];
    }  
    return $gembok;
  }
  
}