<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Reset_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
 
    function get_user_id($user) {
        $query = $this->db->select('ID')
                          ->from('USERS')
                          ->where('USERNAME', $user) 
                          ->limit(1)
                          ->get('');
        if($query->num_rows() == 1){ 
            return $query->row()->ID; //if data is true
        }	else {
            return false; //if data is wrong
        }
    }
    
    function change_password($id,$pass){
  	  date_default_timezone_set('Asia/Jakarta');
  		$dt = date('Y-m-d H:i:s');
  	  $data = array(
                 'PASSWORD' => $pass,
                 'LAST_UPDATED_BY' => $id,
                 'LAST_UPDATED_DATE' => $dt,
              ); 
  		$this->db->where('ID',$id);
      $query = $this->db->update('USERS',$data);
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