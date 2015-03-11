<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync_model extends CI_Model {
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
	
  function get_default_rest(){   
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];                      
  	$query = $this->db->query('SELECT USERS_RESTAURANTS.*, RESTAURANTS.NAME AS REST_NAME
                              FROM USERS_RESTAURANTS
                              JOIN RESTAURANTS ON USERS_RESTAURANTS.REST_ID = RESTAURANTS.ID
                              WHERE USERS_RESTAURANTS.DEFAULT_REST=1 AND USERS_RESTAURANTS.USER_ID = '.$id.'
							  LIMIT 1;');
    	//$output = ($this->db->affected_rows()>0)?$query->row():"NONE";
    	//return $output;
    	return $query->row();
  	}
    
	function get_sync_history($rest_id){
    	$query = $this->db->select('*')
                      ->from('DEVICES')
                      ->where('REST_ID',$rest_id)
                      ->get('');
    	return $query->result();
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
  
  function send_notification($registatoin_ids, $message) {
    $config = $this->config->config;
    $url = $config['notif_url'];       

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => array("message" => array($message)),
        );

        $headers = array(
            'Authorization: key=' . $config['google_api_key'],
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        curl_close($ch);
        return 'sent: '.json_encode($fields).'<br>receive: '.$result;
    }
	
	function get_updated_records($table,$last_sync){
    	$query = $this->db->select('ID')
	                      ->from($table)
	                      ->where('LAST_UPDATED_DATE > "'.$last_sync.'"')
	                      ->get('');
    	//return $query->row()->ID;
    	return $query->result();
	}
	
	function get_last_sync(){
    	$query = $this->db->get('LAST_SYNC')
                      ->from('DEVICES')
                      ->get('');
    	return $query->result();
	}
}