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
  
}