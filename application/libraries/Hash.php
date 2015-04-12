<?php 
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Hash { 
    function epos_encrypt($text, $salt = "vsdfkjheret3453fdgd"){
      return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }
    // This function will be used to decrypt data.
    function epos_decrypt($text, $salt = "vsdfkjheret3453fdgd")
    {
      return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }
  }
?>