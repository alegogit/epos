<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Forgot_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function mail_avail($email) {
        $this->db->where('EMAIL_ADDRESS', $email); 
        $this->db->limit(1);
         
        //get query and processing
        $query = $this->db->get('USERS');
        if($query->num_rows() == 1){ 
            return $query->result(); //if data is true
        }	else {
            return false; //if data is wrong
        }
    }
}