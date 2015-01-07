<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Reset_model extends CI_Model {
 
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
    
    function epos_encrypt($text, $salt = "vsdfkjheret3453fdgd"){
      return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }
    // This function will be used to decrypt data.
    function epos_decrypt($text, $salt = "vsdfkjheret3453fdgd")
    {
      return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }
}