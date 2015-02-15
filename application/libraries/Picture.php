<?php 
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  class Picture { 
    function gettyimg($id){                            
      date_default_timezone_set('Asia/Jakarta');
  		$id = strval($id);
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
?>