<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  	class Cookies { 
    
    	function clearAll(){ 
        if (isset($_SERVER['HTTP_COOKIE'])) {
          $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
          foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
          }
        }
        return true;
    	}
      
    }
?>